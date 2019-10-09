<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Models\Vendor;
use App\Models\Configuration;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Branch;
use App\Models\Project;
use App\Models\Resource;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionDetail;
use App\Models\PurchasingInfoRecord;
use App\Models\GoodsReceipt;
use App\Models\GoodsReceiptDetail;
use App\Models\Material;
use DateTime;
use Auth;
use DB;
use App\Providers\numberConverter;
use Illuminate\Support\Carbon;

class PurchaseOrderController extends Controller
{
    public function cancel(Request $request, $id)
    {
        $route = $request->route()->getPrefix();

        DB::beginTransaction();
        try {
            $modelPO = PurchaseOrder::find($id);
            $modelPO->status = 8;
            $modelPO->update();

            DB::commit();
            if ($route == "/purchase_order") {
                return redirect()->route('purchase_order.show', $id)->with('success', 'Purchase Order Canceled');
            } elseif ($route == "/purchase_order_repair") {
                return redirect()->route('purchase_order_repair.show', $id)->with('success', 'Purchase Order Canceled');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if ($route == "/purchase_order") {
                return redirect()->route('purchase_order.show', $id)->with('error', $e->getMessage());
            } elseif ($route == "/purchase_order_repair") {
                return redirect()->route('purchase_order_repair.show', $id)->with('error', $e->getMessage());
            }
        }
    }

    public function cancelApproval(Request $request, $id)
    {
        $route = $request->route()->getPrefix();

        DB::beginTransaction();
        try {
            $modelPO = PurchaseOrder::find($id);
            $modelPO->status = 1;
            $modelPO->approved_by = null;
            $modelPO->approval_date = null;
            $modelPO->update();

            DB::commit();
            if ($route == "/purchase_order") {
                return redirect()->route('purchase_order.show', $id)->with('success', 'Approval Canceled');
            } elseif ($route == "/purchase_order_repair") {
                return redirect()->route('purchase_order_repair.show', $id)->with('success', 'Approval Canceled');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if ($route == "/purchase_order") {
                return redirect()->route('purchase_order.show', $id)->with('error', $e->getMessage());
            } elseif ($route == "/purchase_order_repair") {
                return redirect()->route('purchase_order_repair.show', $id)->with('error', $e->getMessage());
            }
        }
    }

    public function selectPR(Request $request)
    {
        $route = $request->route()->getPrefix();
        if ($route == "/purchase_order") {
            $modelPRs = PurchaseRequisition::whereIn('status', [2, 7])->where('business_unit_id', 1)->get();
        } elseif ($route == "/purchase_order_repair") {
            $modelPRs = PurchaseRequisition::whereIn('status', [2, 7])->where('business_unit_id', 2)->get();
        }
        return view('purchase_order.selectPR', compact('modelPRs', 'route'));
    }

    public function index(Request $request)
    {
        $route = $request->route()->getPrefix();
        if ($route == "/purchase_order") {
            $modelPRs = PurchaseRequisition::where('business_unit_id', 1)->pluck('id')->toArray();
        } elseif ($route == "/purchase_order_repair") {
            $modelPRs = PurchaseRequisition::where('business_unit_id', 2)->pluck('id')->toArray();
        }
        $modelPOs = PurchaseOrder::whereIn('purchase_requisition_id', $modelPRs)->get();
        return view('purchase_order.index', compact('modelPOs', 'route'));
    }

    public function indexApprove(Request $request)
    {
        $route = $request->route()->getPrefix();
        if ($route == "/purchase_order") {
            $modelPRs = PurchaseRequisition::where('business_unit_id', 1)->pluck('id')->toArray();
        } elseif ($route == "/purchase_order_repair") {
            $modelPRs = PurchaseRequisition::where('business_unit_id', 2)->pluck('id')->toArray();
        }
        $modelPOs = PurchaseOrder::whereIn('status', [1, 4])->whereIn('purchase_requisition_id', $modelPRs)->get();

        return view('purchase_order.indexApprove', compact('modelPOs', 'route'));
    }

    public function create(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        $isPami = false;
        $business_ids = Auth::user()->business_unit_id;
        //mendeteksi bahwa user adalah pami
        if (in_array("2", json_decode($business_ids))) {
            $isPami = true;
        }
        $currencies = Configuration::get('currencies');
        foreach ($currencies as $key => $currency) {
            if ($currency->status == 0) {
                array_splice($currencies, $key, 1);
            }
        }
        $modelPR = PurchaseRequisition::where('id', $datas->id)->with('project')->first();
        $modelPRD = PurchaseRequisitionDetail::whereIn('id', $datas->checkedPRD)->with('material', 'project', 'resource', 'material.uom', 'wbs')->get();
        $materials = Material::all();
        foreach ($modelPRD as $key => $PRD) {
            if ($PRD->reserved >= $PRD->quantity) {
                $modelPRD->forget($key);
            } else {
                if ($PRD->purchaseRequisition->type == 1) {
                    $PRD['discount'] = 0;
                    $PRD['old_price'] = $PRD->material->cost_standard_price;
                    $PRD['remark'] = $PRD->remark;
                } elseif ($PRD->purchaseRequisition->type == 2) {
                    $PRD['discount'] = 0;
                    $PRD['old_price'] = $PRD->resource->cost_standard_price;
                    $PRD['remark'] = $PRD->remark;
                } elseif ($PRD->purchaseRequisition->type == 3) {
                    $PRD['discount'] = 0;
                    $PRD['old_price'] = 0;
                    $PRD['price'] = 0;
                    $PRD['remark'] = $PRD->remark;
                }
            }
        }
        $payment_terms = Configuration::get('payment_terms');
        $delivery_terms = Configuration::get('delivery_terms');
        $projects = Project::where('status', 1)->get();

        return view('purchase_order.create', compact('modelPR', 'modelPRD', 'currencies', 'route', 'materials', 'payment_terms', 'delivery_terms', 'projects', 'isPami'));
    }

    public function selectPRD(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelPR = PurchaseRequisition::findOrFail($id);
        if ($modelPR->type != 3) {
            $modelPRD = PurchaseRequisitionDetail::where('purchase_requisition_id', $modelPR->id)->with('material', 'project', 'resource', 'material.uom')->get();
        } else {
            $modelPRD = PurchaseRequisitionDetail::where('purchase_requisition_id', $modelPR->id)->with('activityDetail.serviceDetail.service', 'activityDetail.serviceDetail', 'project', 'wbs', 'vendor')->get();
        }
        foreach ($modelPRD as $key => $PRD) {
            if ($PRD->reserved >= $PRD->quantity) {
                $modelPRD->forget($key);
            }
        }
        $modelPRD = $modelPRD->values();
        $modelPRD->all();
        return view('purchase_order.selectPRD', compact('modelPR', 'modelPRD', 'route'));
    }

    public function store(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        $po_number = $this->generatePONumber();
        $value = "";
        $valueCurrency = Configuration::get('currencies');
        foreach ($valueCurrency as $data) {
            if ($data->id == $datas->currency) {
                $value = $data->value;
            }
        }

        DB::beginTransaction();
        try {
            $PO = new PurchaseOrder;
            $PO->number = $po_number;
            $PO->purchase_requisition_id = $datas->pr_id;
            $PO->vendor_id = $datas->vendor_id;

            if ($datas->tax == "") {
                $PO->tax = 0;
            } else {
                $PO->tax = $datas->tax;
            }
            if ($datas->estimated_freight == "") {
                $PO->estimated_freight = 0;
            } else {
                $PO->estimated_freight = $datas->estimated_freight * $value;
            }
            $PO->delivery_term = ($datas->delivery_term != "") ? $datas->delivery_term : null;
            $PO->payment_term = ($datas->payment_term != "") ? $datas->payment_term : null;
            $PO->project_id = ($datas->project_id != "") ? $datas->project_id : null;
            $PO->value = $value;
            $PO->description = $datas->description;
            if ($datas->type == 3) {

                $delivery_date_subcon = DateTime::createFromFormat('d-m-Y', $datas->delivery_date_subcon);
                if ($delivery_date_subcon) {
                    $delivery_date_subcon = $delivery_date_subcon->format('Y-m-d');
                } else {
                    $delivery_date_subcon = null;
                }
                $PO->delivery_date = $delivery_date_subcon;
            }
            $PO->status = 1;
            $PO->user_id = Auth::user()->id;
            $PO->branch_id = Auth::user()->branch->id;
            $PO->currency = $datas->currency;
            $PO->save();

            $status = 0;
            $total_price = 0;
            foreach ($datas->PRD as $data) {
                $POD = new PurchaseOrderDetail;
                $POD->purchase_order_id = $PO->id;
                $POD->purchase_requisition_detail_id = $data->id;
                if ($datas->type != 3) {
                    $POD->quantity = $data->quantity;
                } elseif ($datas->type == 3) {
                    $POD->quantity = 1;
                }
                if ($datas->type == 1) {
                    $POD->material_id = $data->material_id;
                    $POD->total_price = $data->material->cost_standard_price * $value * $data->quantity;
                } elseif ($datas->type == 2) {
                    $POD->resource_id = $data->resource_id;
                    $POD->total_price = $data->resource->cost_standard_price * $value * $data->quantity;
                } else {
                    $POD->job_order = $data->job_order;
                    $POD->total_price = $data->price * $value;
                }
                $POD->discount = $data->discount;
                $POD->project_id = $data->project_id;
                $POD->remark = $data->remark;
                if ($datas->type != 3) {
                    $delivery_date = DateTime::createFromFormat('d-m-Y', $data->required_date);
                    if ($delivery_date) {
                        $delivery_date = $delivery_date->format('Y-m-d');
                    } else {
                        $delivery_date = null;
                    }
                    $POD->delivery_date = $delivery_date;
                }
                $POD->save();

                $statusPR = $this->updatePR($data->id, $data->quantity);
                if ($statusPR === true) {
                    $status = 1;
                }
                $total_price += $POD->total_price;
            }

            $modelPR = PurchaseRequisition::where('id', $datas->pr_id)->with('purchaseRequisitionDetails')->first();
            foreach ($modelPR->purchaseRequisitionDetails as $modelPRD) {
                if ($modelPRD->reserved < $modelPRD->quantity) {
                    $status = 1;
                }
            }
            $PO->total_price = $total_price;
            //Pertambahan Pajak PPN dan Pajak PPH
            $business_ids = Auth::user()->business_unit_id;
            //input untuk user pami dan mengabaikan untuk user pmp
            if (in_array("2", json_decode($business_ids))) {
                $PO->pajak_pertambahan_nilai = $datas->pajak_pertambahan_nilai;
                $PO->pajak_penghasilan = $datas->pajak_penghasilan;
                $PO->tax = "0";
            } else {
                $PO->pajak_pertambahan_nilai = "0";
                $PO->pajak_penghasilan = "0";
                if ($datas->tax == "") {
                    $PO->tax = 0;
                } else {
                    $PO->tax = $datas->tax;
                }
            }

            $PO->save();
            $this->checkStatusPr($datas->pr_id, $status);
            DB::commit();
            if ($route == "/purchase_order") {
                return redirect()->route('purchase_order.show', $PO->id)->with('success', 'Purchase Order Created');
            } elseif ($route == "/purchase_order_repair") {
                return redirect()->route('purchase_order_repair.show', $PO->id)->with('success', 'Purchase Order Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if ($route == "/purchase_order") {
                return redirect()->route('purchase_order.selectPRD', $datas->pr_id)->with('error', $e->getMessage());
            } elseif ($route == "/purchase_order_repair") {
                return redirect()->route('purchase_order_repair.selectPRD', $datas->pr_id)->with('error', $e->getMessage());
            }
        }
    }

    public function show(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelPO = PurchaseOrder::findOrFail($id);
        if ($modelPO->status == 1) {
            $statusPO = 'OPEN';
        } elseif ($modelPO->status == 2) {
            $statusPO = 'APPROVED';
        } elseif ($modelPO->status == 3) {
            $statusPO = 'NEEDS REVISION';
        } elseif ($modelPO->status == 4) {
            $statusPO = 'REVISED';
        } elseif ($modelPO->status == 5) {
            $statusPO = 'REJECTED';
        } elseif ($modelPO->status == 0 || $modelPO->status == 7) {
            $statusPO = 'RECEIVED';
        } elseif ($modelPO->status == 8) {
            $statusPO = 'CANCELED';
        }

        $datas = Collection::make();
        $total_discount = 0;
        $unit = "";
        $unitCurrency = Configuration::get('currencies');
        foreach ($unitCurrency as $data) {
            if ($data->id == $modelPO->currency) {
                $unit = $data->unit;
            }
        }
        $dterm_name = "";
        $deliveryTerms = Configuration::get('delivery_terms');
        foreach ($deliveryTerms as $data) {
            if ($data->id == $modelPO->delivery_term) {
                $dterm_name = $data->name;
            }
        }

        if ($modelPO->purchaseRequisition->type == 1) {
            foreach ($modelPO->purchaseOrderDetails as $POD) {
                if (count($datas) > 0) {
                    $status = 0;
                    foreach ($datas as $key => $data) {
                        if ($data['material_code'] == $POD->material->code) {
                            $quantity = $data['quantity'] + $POD->quantity;
                            $sub_total = $data['sub_total'] + $POD->total_price;

                            $datas->push([
                                "id" => $POD->id,
                                "material_code" => $POD->material->code,
                                "material_name" => $POD->material->description,
                                "quantity" => $quantity,
                                "discount" => $POD->discount,
                                "price" => $POD->total_price / $POD->quantity,
                                "sub_total" => $sub_total,
                                "remark" => $POD->remark,
                                "unit" => $POD->material->uom->unit,
                                "delivery_date" => $POD->delivery_date,
                            ]);
                            $status = 1;
                            $datas->forget($key);
                        }
                    }
                    if ($status == 0) {
                        $total_discount += $POD->total_price * ($POD->discount / 100);
                        $datas->push([
                            "id" => $POD->id,
                            "material_code" => $POD->material->code,
                            "material_name" => $POD->material->description,
                            "quantity" => $POD->quantity,
                            "discount" => $POD->discount,
                            "price" => $POD->total_price / $POD->quantity,
                            "sub_total" => $POD->total_price,
                            "remark" => $POD->remark,
                            "unit" => $POD->material->uom->unit,
                            "delivery_date" => $POD->delivery_date,
                        ]);
                    }
                } else {
                    $total_discount += $POD->total_price * ($POD->discount / 100);
                    $datas->push([
                        "id" => $POD->id,
                        "material_code" => $POD->material->code,
                        "material_name" => $POD->material->description,
                        "quantity" => $POD->quantity,
                        "discount" => $POD->discount,
                        "price" => $POD->total_price / $POD->quantity,
                        "sub_total" => $POD->total_price,
                        "remark" => $POD->remark,
                        "unit" => $POD->material->uom->unit,
                        "delivery_date" => $POD->delivery_date,
                    ]);
                }
            }
        } elseif ($modelPO->purchaseRequisition->type == 2) {
            $count = 0;
            foreach ($modelPO->purchaseOrderDetails as $POD) {
                if (count($datas) > 0) {
                    $status = 0;
                    foreach ($datas as $key => $data) {
                        if ($data['resource_code'] == $POD->resource->code) {
                            $quantity = $data['quantity'] + $POD->quantity;
                            $sub_total = $data['sub_total'] + $POD->total_price;

                            $datas->push([
                                "id" => $POD->id,
                                "resource_code" => $POD->resource->code,
                                "resource_name" => $POD->resource->name,
                                "quantity" => $quantity,
                                "discount" => $POD->discount,
                                "price" => $POD->total_price / $POD->quantity,
                                "sub_total" => $sub_total,
                                "remark" => $POD->remark,
                                "unit" => '-',
                                "delivery_date" => $POD->delivery_date,
                            ]);
                            $status = 1;
                            $datas->forget($key);
                        }
                    }
                    if ($status == 0) {
                        $total_discount += $POD->total_price * ($POD->discount / 100);
                        $datas->push([
                            "id" => $POD->id,
                            "resource_code" => $POD->resource->code,
                            "resource_name" => $POD->resource->name,
                            "quantity" => $POD->quantity,
                            "discount" => $POD->discount,
                            "price" => $POD->total_price / $POD->quantity,
                            "sub_total" => $POD->total_price,
                            "remark" => $POD->remark,
                            "unit" => '-',
                            "delivery_date" => $POD->delivery_date,
                        ]);
                    }
                } else {
                    $total_discount += $POD->total_price * ($POD->discount / 100);
                    $datas->push([
                        "id" => $POD->id,
                        "resource_code" => $POD->resource->code,
                        "resource_name" => $POD->resource->name,
                        "quantity" => $POD->quantity,
                        "discount" => $POD->discount,
                        "price" => $POD->total_price / $POD->quantity,
                        "sub_total" => $POD->total_price,
                        "remark" => $POD->remark,
                        "unit" => '-',
                        "delivery_date" => $POD->delivery_date,
                    ]);
                }
            }
        } else {
            foreach ($modelPO->purchaseOrderDetails as $POD) {
                if (count($datas) > 0) {
                    $status = 0;
                    foreach ($datas as $key => $data) {
                        if ($data['service_code'] == $POD->activityDetail->serviceDetail->service->name) {
                            $quantity = $data['quantity'] + $POD->quantity;
                            $sub_total = $data['sub_total'] + $POD->total_price;

                            $datas->push([
                                "id" => $POD->id,
                                "job_order" => $POD->job_order,
                                "quantity" => $quantity,
                                "discount" => $POD->discount,
                                "price" => $POD->total_price / $POD->quantity,
                                "sub_total" => $sub_total,
                                "remark" => $POD->remark,
                            ]);
                            $status = 1;
                            $datas->forget($key);
                        }
                    }
                    if ($status == 0) {
                        $total_discount += $POD->total_price * ($POD->discount / 100);
                        $datas->push([
                            "id" => $POD->id,
                            "job_order" => $POD->job_order,
                            "quantity" => $POD->quantity,
                            "discount" => $POD->discount,
                            "price" => $POD->total_price / $POD->quantity,
                            "sub_total" => $POD->total_price,
                            "remark" => $POD->remark,
                        ]);
                    }
                } else {
                    $total_discount += $POD->total_price * ($POD->discount / 100);
                    $datas->push([
                        "id" => $POD->id,
                        "job_order" => $POD->job_order,
                        "quantity" => $POD->quantity,
                        "discount" => $POD->discount,
                        "price" => $POD->total_price / $POD->quantity,
                        "sub_total" => $POD->total_price,
                        "remark" => $POD->remark,
                    ]);
                }
            }
        }
        $tax = ($datas->sum('sub_total') - $total_discount) * ($modelPO->tax / 100);

        $gr = true;
        $modelGR = GoodsReceipt::where('purchase_order_id', $modelPO->id)->get();
        if (count($modelGR) > 0 || $modelPO->status != 2) {
            $gr = false;
        }
        return view('purchase_order.show', compact('modelPO', 'unit', 'route', 'datas', 'total_discount', 'tax', 'statusPO', 'dterm_name', 'gr'));
    }

    public function showApprove(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelPO = PurchaseOrder::findOrFail($id);
        if ($modelPO->status == 1) {
            $statusPO = 'OPEN';
        } elseif ($modelPO->status == 2) {
            $statusPO = 'APPROVED';
        } elseif ($modelPO->status == 3) {
            $statusPO = 'NEEDS REVISION';
        } elseif ($modelPO->status == 4) {
            $statusPO = 'REVISED';
        } elseif ($modelPO->status == 5) {
            $statusPO = 'REJECTED';
        } elseif ($modelPO->status == 0 || $modelPO->status == 7) {
            $statusPO = 'RECEIVED';
        }

        $datas = Collection::make();
        $total_discount = 0;
        $unit = "";
        $unitCurrency = Configuration::get('currencies');
        foreach ($unitCurrency as $data) {
            if ($data->id == $modelPO->currency) {
                $unit = $data->unit;
            }
        }

        if ($modelPO->purchaseRequisition->type == 1) {
            foreach ($modelPO->purchaseOrderDetails as $POD) {
                if (count($datas) > 0) {
                    $status = 0;
                    foreach ($datas as $key => $data) {
                        if ($data['material_code'] == $POD->material->code) {
                            $quantity = $data['quantity'] + $POD->quantity;
                            $sub_total = $data['sub_total'] + $POD->total_price;

                            $datas->push([
                                "id" => $POD->id,
                                "material_code" => $POD->material->code,
                                "material_name" => $POD->material->description,
                                "quantity" => $quantity,
                                "discount" => $POD->discount,
                                "price" => $POD->total_price / $POD->quantity,
                                "sub_total" => $sub_total,
                                "remark" => $POD->remark,
                                "unit" => $POD->material->uom->unit,
                                "delivery_date" => $POD->delivery_date,
                            ]);
                            $status = 1;
                            $datas->forget($key);
                        }
                    }
                    if ($status == 0) {
                        $total_discount += $POD->total_price * ($POD->discount / 100);
                        $datas->push([
                            "id" => $POD->id,
                            "material_code" => $POD->material->code,
                            "material_name" => $POD->material->description,
                            "quantity" => $POD->quantity,
                            "discount" => $POD->discount,
                            "price" => $POD->total_price / $POD->quantity,
                            "sub_total" => $POD->total_price,
                            "remark" => $POD->remark,
                            "unit" => $POD->material->uom->unit,
                            "delivery_date" => $POD->delivery_date,
                        ]);
                    }
                } else {
                    $total_discount += $POD->total_price * ($POD->discount / 100);
                    $datas->push([
                        "id" => $POD->id,
                        "material_code" => $POD->material->code,
                        "material_name" => $POD->material->description,
                        "quantity" => $POD->quantity,
                        "discount" => $POD->discount,
                        "price" => $POD->total_price / $POD->quantity,
                        "sub_total" => $POD->total_price,
                        "remark" => $POD->remark,
                        "unit" => $POD->material->uom->unit,
                        "delivery_date" => $POD->delivery_date,
                    ]);
                }
            }
        } elseif ($modelPO->purchaseRequisition->type == 2) {
            foreach ($modelPO->purchaseOrderDetails as $POD) {
                if (count($datas) > 0) {
                    $status = 0;
                    foreach ($datas as $key => $data) {
                        if ($data['resource_code'] == $POD->resource->code) {
                            $quantity = $data['quantity'] + $POD->quantity;
                            $sub_total = $data['sub_total'] + $POD->total_price;

                            $datas->push([
                                "id" => $POD->id,
                                "resource_code" => $POD->resource->code,
                                "resource_name" => $POD->resource->name,
                                "quantity" => $quantity,
                                "discount" => $POD->discount,
                                "price" => $POD->total_price / $POD->quantity,
                                "sub_total" => $sub_total,
                                "remark" => $POD->remark,
                                "unit" => '-',
                                "delivery_date" => $POD->delivery_date,
                            ]);
                            $status = 1;
                            $datas->forget($key);
                        }
                    }
                    if ($status == 0) {
                        $total_discount += $POD->total_price * ($POD->discount / 100);
                        $datas->push([
                            "id" => $POD->id,
                            "resource_code" => $POD->resource->code,
                            "resource_name" => $POD->resource->name,
                            "quantity" => $POD->quantity,
                            "discount" => $POD->discount,
                            "price" => $POD->total_price / $POD->quantity,
                            "sub_total" => $POD->total_price,
                            "remark" => $POD->remark,
                            "unit" => '-',
                            "delivery_date" => $POD->delivery_date,
                        ]);
                    }
                } else {
                    $total_discount += $POD->total_price * ($POD->discount / 100);
                    $datas->push([
                        "id" => $POD->id,
                        "resource_code" => $POD->resource->code,
                        "resource_name" => $POD->resource->name,
                        "quantity" => $POD->quantity,
                        "discount" => $POD->discount,
                        "price" => $POD->total_price / $POD->quantity,
                        "sub_total" => $POD->total_price,
                        "remark" => $POD->remark,
                        "unit" => '-',
                        "delivery_date" => $POD->delivery_date,
                    ]);
                }
            }
        } else {
            foreach ($modelPO->purchaseOrderDetails as $POD) {
                if (count($datas) > 0) {
                    $status = 0;
                    foreach ($datas as $key => $data) {
                        if ($data['service_code'] == $POD->activityDetail->serviceDetail->service->name) {
                            $quantity = $data['quantity'] + $POD->quantity;
                            $sub_total = $data['sub_total'] + $POD->total_price;

                            $datas->push([
                                "id" => $POD->id,
                                "service_code" => $POD->activityDetail->serviceDetail->service->name,
                                "service_name" => $POD->activityDetail->serviceDetail->name,
                                "quantity" => $quantity,
                                "discount" => $POD->discount,
                                "price" => $POD->total_price / $POD->quantity,
                                "sub_total" => $sub_total,
                                "remark" => $POD->remark,
                                "unit" => $POD->activityDetail->serviceDetail->uom->unit,
                            ]);
                            $status = 1;
                            $datas->forget($key);
                        }
                    }
                    if ($status == 0) {
                        $total_discount += $POD->total_price * ($POD->discount / 100);
                        $datas->push([
                            "id" => $POD->id,
                            "service_code" => $POD->activityDetail->serviceDetail->service->name,
                            "service_name" => $POD->activityDetail->serviceDetail->name,
                            "quantity" => $POD->quantity,
                            "discount" => $POD->discount,
                            "price" => $POD->total_price / $POD->quantity,
                            "sub_total" => $POD->total_price,
                            "remark" => $POD->remark,
                            "unit" => $POD->activityDetail->serviceDetail->uom->unit,
                        ]);
                    }
                } else {

                    $total_discount += $POD->total_price * ($POD->discount / 100);
                    $datas->push([
                        "id" => $POD->id,
                        "job_order" => $POD->job_order,
                        "quantity" => $POD->quantity,
                        "discount" => $POD->discount,
                        "price" => $POD->total_price / $POD->quantity,
                        "sub_total" => $POD->total_price,
                        "remark" => $POD->remark,
                    ]);
                }
            }
        }
        $tax = ($datas->sum('sub_total') - $total_discount) * ($modelPO->tax / 100);
        return view('purchase_order.showApprove', compact('modelPO', 'route', 'datas', 'total_discount', 'tax', 'unit', 'statusPO'));
    }

    public function edit(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelPO = PurchaseOrder::where('id', $id)->with('purchaseRequisition')->first();
        $modelPOD = PurchaseOrderDetail::where('purchase_order_id', $id)->with('material',
        'purchaseRequisitionDetail.wbs',
        'purchaseRequisitionDetail.project',
        'wbs',
        'resource',
        'material.uom',
        'purchaseRequisitionDetail.purchaseRequisition' 
        // 'pro_wbs_material',
        // 'pro_wbs_material.areaUom',
        // 'pro_wbs_material.serviceDetail',
        // 'pro_wbs_material.serviceDetail.service'
        )->get();
        foreach ($modelPOD as $POD) {
            $POD['old_price'] = $POD->total_price / $POD->quantity;
        }
        $currencies = Configuration::get('currencies');

        $payment_terms = Configuration::get('payment_terms');
        $delivery_terms = Configuration::get('delivery_terms');
        $projects = Project::where('status', 1)->get();

        return view('purchase_order.edit', compact('modelPO', 'modelPOD', 'projects', 'route', 'currencies', 'payment_terms', 'delivery_terms'));
    }

    public function update(Request $request)
    {
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        $value = "";
        $valueCurrency = Configuration::get('currencies');
        foreach ($valueCurrency as $data) {
            if ($data->id == $datas->modelPO->currency) {
                $value = $data->value;
            }
        }

        DB::beginTransaction();
        try {
            $PO = PurchaseOrder::findOrFail($datas->modelPO->id);
            $status = 0;
            $total_price = 0;
            if ($datas->modelPO->currency != $PO->currency) {
                $PO->value = $value;
            }
            foreach ($datas->PODetail as $data) {
                $POD = PurchaseOrderDetail::findOrFail($data->id);
                $diff = $data->quantity - $POD->quantity;
                $POD->quantity = $data->quantity;
                $POD->total_price = $data->quantity * ($data->total_price * $PO->value);
                $POD->remark = $data->remark;
                if ($datas->modelPO->purchase_requisition->type != 3) {
                    $delivery_date = DateTime::createFromFormat('d-m-Y', $data->delivery_date);
                    if ($delivery_date) {
                        $delivery_date = $delivery_date->format('Y-m-d');
                    } else {
                        $delivery_date = null;
                    }
                    $POD->delivery_date = $delivery_date;
                }
                $POD->discount = $data->discount;
                $POD->save();

                $statusPR = $this->updatePR($data->purchase_requisition_detail_id, $diff);
                if ($statusPR === true) {
                    $status = 1;
                }
                $total_price += $POD->total_price;
            }
            $PO->vendor_id = $datas->modelPO->vendor_id;
            $PO->description = $datas->modelPO->description;
            $PO->tax = $datas->modelPO->tax;
            if ($datas->modelPO->estimated_freight == "") {
                $PO->estimated_freight = 0;
            } else {
                $PO->estimated_freight = $datas->modelPO->estimated_freight * $value;
            }
            $PO->delivery_term = ($datas->modelPO->delivery_term != "") ? $datas->modelPO->delivery_term : null;
            $PO->payment_term = ($datas->modelPO->payment_term != "") ? $datas->modelPO->payment_term : null;
            $PO->project_id = ($datas->modelPO->project_id != "") ? $datas->modelPO->project_id : null;
            if ($datas->type == 3) {
                $delivery_date_subcon = DateTime::createFromFormat('d-m-Y', $datas->delivery_date_subcon);
                if ($delivery_date_subcon) {
                    $delivery_date_subcon = $delivery_date_subcon->format('Y-m-d');
                } else {
                    $delivery_date_subcon = null;
                }
                $PO->delivery_date = $delivery_date_subcon;
            }

            if ($datas->modelPO->currency != $PO->currency) {
                $PO->value = $value;
            }
            $PO->currency = $datas->modelPO->currency;

            $PO->total_price = $total_price;
            if ($PO->status == 3) {
                $PO->status = 4;
            }
            $PO->save();

            $this->checkStatusPr($datas->modelPO->purchase_requisition_id, $status);
            DB::commit();
            if ($route == "/purchase_order") {
                return redirect()->route('purchase_order.show', $PO->id)->with('success', 'Purchase Order Updated');
            } elseif ($route == "/purchase_order_repair") {
                return redirect()->route('purchase_order_repair.show', $PO->id)->with('success', 'Purchase Order Updated');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if ($route == "/purchase_order") {
                return redirect()->route('purchase_order.index')->with('error', $e->getMessage() . json_encode($datas));
            } elseif ($route == "/purchase_order_repair") {
                return redirect()->route('purchase_order_repair.index')->with('error', $e->getMessage());
            }
        }
    }

    public function destroy($id)
    {
        //
    }

    public function approval(Request $request)
    {
        $datas = json_decode($request->datas);
        $route = $request->route()->getPrefix();
        DB::beginTransaction();

        $modelPOD = PurchaseOrderDetail::where(['purchase_order_id' => $datas->po_id])->get();
        foreach ($modelPOD as $material) {
            $modelMaterial = Material::findOrFail($material->material_id);
        }
        try {
            $modelPO = PurchaseOrder::findOrFail($datas->po_id);
            if ($datas->status == "approve") {
                /**
                 * Fungsi untuk Standard Price
                 */
                $modelPOD = PurchaseOrderDetail::where(['purchase_order_id' => $datas->po_id])->get();
                foreach ($modelPOD as $material) {
                    $modelMaterial = Material::findOrFail($material->material_id);
                    $materialJson = json_decode($modelMaterial->cost_standard_price_config);
                    $materialID = $material->material_id;
                    $range = $materialJson->range;
                    if ($materialJson->id == 1) {
                        //fixed price nothing
                    } else if ($materialJson->id == 2) {
                        //last price
                        $modelMaterial->cost_standard_price = ($material->total_price / $material->qunatity);
                        $modelMaterial->update();
                    } else if ($materialJson->id == 3) {
                        //fifo price do nothing

                        //belum dibuat Goods Issue
                    } else if ($materialJson->id == 4) {
                        //average
                        $countLooping = 0;
                        $totalData = 0;
                        $totalPrice = 0;
                        $dataPO = PurchaseOrder::with([
                            'purchaseOrderDetails' =>
                            function ($query) use ($materialID) {
                                $query->where('material_id', $materialID)->get();
                            }
                        ])->where('status', '0')->orWhere('status', '2')->orderBy('approval_date', 'DESC')->get();

                        foreach ($dataPO as $dataPOS) {
                            $countLooping = $countLooping + 1;
                            foreach ($dataPOS->purchaseOrderDetails as $dataPODS) {
                                $totalData = $totalData + 1;
                                $totalPrice = $totalPrice + ($dataPODS->total_price / ($dataPODS->qunatity == 0 || $dataPODS->qunatity == null) ? 1 : $dataPODS->qunatity);
                            }
                            if ($countLooping >= $range) {
                                $totalPrice = $totalPrice / $totalData;
                                break;
                            }
                        }
                        $modelMaterial->cost_standard_price = $totalPrice;
                        $modelMaterial->update();
                    }
                }

                /**
                 * End Fungsi untuk Standard Price
                 */
                $modelPO->status = 2;

                $modelPO->revision_description = "-";
                $modelPO->approved_by = Auth::user()->id;
                $modelPO->approval_date = Carbon::now();
                $modelPO->update();
                $this->generatePIR($modelPO);
                DB::commit();
                if ($route == "/purchase_order") {
                    return redirect()->route('purchase_order.show', $datas->po_id)->with('success', 'Purchase Order Approved');
                } elseif ($route == "/purchase_order_repair") {
                    return redirect()->route('purchase_order_repair.show', $datas->po_id)->with('success', 'Purchase Order Approved');
                }
            } elseif ($datas->status == "need-revision") {
                $modelPO->status = 3;
                $modelPO->revision_description = $datas->desc;
                $modelPO->approved_by = Auth::user()->id;
                $modelPO->update();
                DB::commit();
                if ($route == "/purchase_order") {
                    return redirect()->route('purchase_order.show', $datas->po_id)->with('success', 'Purchase Order Need Revision');
                } elseif ($route == "/purchase_order_repair") {
                    return redirect()->route('purchase_order_repair.show', $datas->po_id)->with('success', 'Purchase Order Need Revision');
                }
            } elseif ($datas->status == "reject") {
                $modelPO->status = 5;
                $modelPO->revision_description = $datas->desc;
                $modelPO->approved_by = Auth::user()->id;
                $modelPO->approval_date = Carbon::now();
                $modelPO->update();
                DB::commit();
                if ($route == "/purchase_order") {
                    return redirect()->route('purchase_order.show', $datas->po_id)->with('success', 'Purchase Order Rejected');
                } elseif ($route == "/purchase_order_repair") {
                    return redirect()->route('purchase_order_repair.show', $datas->po_id)->with('success', 'Purchase Order Rejected');
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('purchase_order.show', $datas->po_id)->with('error', $e->getMessage());
        }
    }


    public function generatePIR($modelPO)
    {
        foreach ($modelPO->purchaseOrderDetails as $POD) {
            $PIR = new PurchasingInfoRecord;
            $PIR->purchase_order_id = $modelPO->id;
            $PIR->purchase_order_detail_id = $POD->id;
            $PIR->material_id = $POD->material_id;
            $PIR->resource_id = $POD->resource_id;
            $PIR->vendor_id = $modelPO->vendor_id;
            $PIR->quantity = $POD->quantity;
            if ($POD->quantity != 0) {
                $PIR->price = $POD->total_price / $POD->quantity;
            } else {
                $PIR->price = 0;
            }
            $PIR->save();
        }
    }

    public function printPdf($id, Request $request)
    {
        $branch = Auth::user()->branch;
        $modelPO = PurchaseOrder::find($id);
        $projectName = PurchaseRequisitionDetail::where('purchase_requisition_id', $modelPO->purchase_requisition_id)->first();
        $discount = 0;
        $tax = 0;
        $freight = 0;
        foreach ($modelPO->purchaseOrderDetails as $POD) {
            if ($POD->quantity > 0) {
                $discount += $POD->total_price * (($POD->discount) / 100);
                $tax += $POD->total_price * (($POD->tax) / 100);
                $freight += $POD->estimated_freight;
            }
        }
        // print_r($modelPO);exit();
        $total_price = $modelPO->total_price - $discount + $tax + $freight;
        $words = numberConverter::longform($total_price);
        $route = $request->route()->getPrefix();
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        if ($modelPO->purchaseRequisition->type != 3) {
            $pdf->loadView('purchase_order.pdf', ['modelPO' => $modelPO, 'words' => $words, 'branch' => $branch, 'route' => $route]);

            $now = date("Y_m_d_H_i_s");
            return $pdf->stream('Purchase_Order_' . $now . '.pdf');
        } else {
            $pdf->loadView('purchase_order.pdf_PO_subcon', ['modelPO' => $modelPO, 'words' => $words, 'branch' => $branch, 'route' => $route, 'projectName' => $projectName]);

            $now = date("Y_m_d_H_i_s");
            return $pdf->stream('Purchase_Order_Subcon' . $now . '.pdf');
        }
    }

    public function printPdfJobOrder($id, Request $request)
    {
        // comment
        $branch = Auth::user()->branch;
        $modelPO = PurchaseOrder::find($id);
        $projectName = PurchaseRequisitionDetail::where('purchase_requisition_id', $modelPO->purchase_requisition_id)->first();
        // $discount = 0;
        // $tax = 0;
        // $freight = 0;
        // foreach($modelPO->purchaseOrderDetails as $POD){
        //     if($POD->quantity > 0){
        //         $discount += $POD->total_price * (($POD->discount)/100);
        //         $tax += $POD->total_price * (($POD->tax)/100);
        //         $freight += $POD->estimated_freight;
        //     }
        // }
        // print_r($POD);exit();
        // $total_price = $modelPO->total_price - $discount + $tax + $freight;
        // $words = numberConverter::longform($total_price);
        $route = $request->route()->getPrefix();
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        if ($modelPO->purchaseRequisition->type == 3) {
            $pdf->loadView('purchase_order.pdf_JO_subcon', ['modelPO' => $modelPO, 'branch' => $branch, 'route' => $route, 'projectName' => $projectName]);

            $now = date("Y_m_d_H_i_s");
            return $pdf->stream('Job_Order_' . $now . '.pdf');
        }
    }

    // function
    public function generatePONumber()
    {
        $modelPO = PurchaseOrder::orderBy('created_at', 'desc')->first();
        $yearNow = date('y');

        $number = 1;
        if (isset($modelPO)) {
            $yearDoc = substr($modelPO->number, 3, 2);
            if ($yearNow == $yearDoc) {
                $number += intval(substr($modelPO->number, -5));
            }
        }

        $year = date($yearNow . '00000');
        $year = intval($year);

        $po_number = $year + $number;
        $po_number = 'PO-' . $po_number;

        return $po_number;
    }

    public function updatePR($prd_id, $quantity)
    {
        $modelPRD = PurchaseRequisitionDetail::findOrFail($prd_id);

        if ($modelPRD) {
            $modelPRD->reserved += $quantity;
            $modelPRD->save();
        }
        if ($modelPRD->reserved < $modelPRD->quantity) {
            return true;
        }
    }

    public function checkStatusPr($pr_id, $status)
    {
        $modelPR = PurchaseRequisition::findOrFail($pr_id);
        if ($status == 0) {
            $modelPR->status = 0;
        } else {
            $modelPR->status = 7;
        }
        $modelPR->save();
    }

    public function getVendorAPI()
    {
        $vendor = Vendor::where('status', 1)->select('id', 'name', 'code', 'delivery_term', 'payment_term')->get()->jsonSerialize();

        return response($vendor, Response::HTTP_OK);
    }

    public function getResourceAPI($id)
    {
        $resource = Resource::where('id', $id)->with('uom')->first()->jsonSerialize();

        return response($resource, Response::HTTP_OK);
    }

    public function getVendorListAPI($id)
    {
        $PIRs = PurchasingInfoRecord::where('material_id', $id)->get();

        $datas = Collection::make();
        foreach ($PIRs as $PIR) {
            if (count($datas) > 0) {
                $status = true;
                foreach ($datas as $key => $data) {
                    if ($data['vendor_id'] == $PIR->vendor_id) {
                        if ($data['created_at'] > $PIR->created_at) {
                            $datas->push([
                                "vendor_id" => $PIR->vendor->id,
                                "vendor_code" => $PIR->vendor->code,
                                "vendor_name" => $PIR->vendor->name,
                                "count" => $data['count'] + 1,
                                "created_at" => $PIR->created_at,
                                "price" => $PIR->price,
                            ]);
                        } else {
                            $datas->push([
                                "vendor_id" => $PIR->vendor->id,
                                "vendor_code" => $PIR->vendor->code,
                                "vendor_name" => $PIR->vendor->name,
                                "count" => $data['count'] + 1,
                                "created_at" => $data['created_at'],
                                "price" => $data['price'],
                            ]);
                        }
                        $status = false;
                        $datas->forget($key);
                    }
                }
                if ($status) {
                    $datas->push([
                        "vendor_id" => $PIR->vendor->id,
                        "vendor_code" => $PIR->vendor->code,
                        "vendor_name" => $PIR->vendor->name,
                        "count" => 1,
                        "created_at" => $PIR->created_at,
                        "price" => $PIR->price,
                    ]);
                }
            } else {
                $datas->push([
                    "vendor_id" => $PIR->vendor->id,
                    "vendor_code" => $PIR->vendor->code,
                    "vendor_name" => $PIR->vendor->name,
                    "count" => 1,
                    "created_at" => $PIR->created_at,
                    "price" => $PIR->price,
                ]);
            }
        }
        $datas = $datas->sortByDesc('count');
        $datas = $datas->values();

        return response($datas, Response::HTTP_OK);
    }
    public function getVendorDetailAPI($id){
        $vendor = Vendor::where('id', $id)->first();
        return response($vendor, Response::HTTP_OK);
    }
}
