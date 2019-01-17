<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use App\Models\Resource;
use App\Models\ResourceDetail;
use App\Models\Project;
use App\Models\WBS;
use App\Models\Uom;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Configuration;
use App\Models\GoodsReceipt;
use App\Models\GoodsReceiptDetail;
use DateTime;
use Auth;
use DB;

class ResourceController extends Controller
{
    protected $GR;

    public function __construct(GoodsReceiptController $GR)
    {
        $this->GR = $GR;
    }

    public function index()
    {
        $resources = Resource::all();

        return view('resource.index', compact('resources'));
    }

    public function assignResource()
    {
        $resources = Resource::all();
        $projects = Project::where('status',1)->get();
        $assignresource = ResourceDetail::with('project','resource','wbs')->get();

        return view('resource.assignResource', compact('resources','projects','assignresource'));
    }

    public function create()
    {
        $resource = new Resource;
        $resource_code = self::generateResourceCode();

        return view('resource.create', compact('resource', 'resource_code','uoms','vendors','resource_category'));
    }

    public function store(Request $request)
    {
        $data = json_decode($request->datas);

        DB::beginTransaction();
        try {
            $resource = new Resource;
            $resource->code = strtoupper($data->code);
            $resource->name = ucwords($data->name);
            $resource->description = $data->description;
            $resource->user_id = Auth::user()->id;
            $resource->branch_id = Auth::user()->branch->id;
            $resource->save();

            DB::commit();
            return redirect()->route('resource.show',$resource->id)->with('success', 'Success Created New Resource!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('resource.create')->with('error', $e->getMessage());
        }
    }

    public function selectPO(Request $request)
    {
        $route = $request->route()->getPrefix();
        $modelPOs = PurchaseOrder::where('status',2)->get();

        foreach($modelPOs as $key => $PO){
            if($PO->purchaseRequisition->type != 2){
                $modelPOs->forget($key);
            }
        }
        
        return view('resource.selectPO', compact('modelPOs','route'));
    }

    public function createGR(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $resource_categories = Configuration::get('resource_category');
        $depreciation_methods = Configuration::get('depreciation_methods');
        $modelPO = PurchaseOrder::where('id',$id)->with('vendor')->first();
        $modelPODs = PurchaseOrderDetail::where('purchase_order_id',$modelPO->id)->whereColumn('received','!=','quantity')->get();
        $uom = Uom::all();
        $datas = Collection::make();

        foreach($modelPODs as $POD){
            $quantity = $POD->quantity - $POD->received;
            for ($i=0; $i < $quantity; $i++) { 
                $datas->push([
                    "pod_id" => $POD->id,
                    "resource_id" => $POD->resource->id, 
                    "resource_code" => $POD->resource->code,
                    "resource_name" => $POD->resource->name,
                    "quantity" => 1,
                    "status" => "Detail Not Complete",
                ]);
            }
        }
        return view('resource.createGR', compact('modelPO','datas','resource_categories','uom','depreciation_methods','route'));
    }

    public function storeGR(Request $request){
        $route = $request->route()->getPrefix();
        $datas = json_decode($request->datas);
        $gr_number = $this->GR->generateGRNumber();
        DB::beginTransaction();
        try {
            $GR = new GoodsReceipt;
            $GR->number = $gr_number;
            $GR->purchase_order_id = $datas->po_id;
            $GR->description = $datas->description;
            $GR->branch_id = Auth::user()->branch->id;
            $GR->user_id = Auth::user()->id;
            $GR->save();

            foreach($datas->resources as $data){
                $RD = new ResourceDetail;
                $RD->code = $data->code;
                $RD->resource_id = $data->resource_id;
                $RD->category_id = $data->category_id;
                $RD->description = $data->description;
                if($data->category_id == 0){
                    $RD->sub_con_address = $data->sub_con_address;
                    $RD->sub_con_phone = $data->sub_con_phone;
                    $RD->sub_con_competency = $data->sub_con_competency;
                }elseif($data->category_id == 1){
                    $RD->others_name = $data->name;
                }elseif($data->category_id == 2){
                    $RD->brand = $data->brand;
                    $RD->performance = ($data->performance != '') ? $data->performance : null;
                    $RD->performance_uom_id = ($data->performance_uom_id != '') ? $data->performance_uom_id : null;
                }elseif($data->category_id == 3){
                    $RD->brand = $data->brand;
                    $RD->depreciation_method = $data->depreciation_method;
                    $RD->manufactured_date = ($data->manufactured_date != '') ? $data->manufactured_date : null;
                    $RD->purchasing_date = ($data->purchasing_date != '') ? $data->purchasing_date : null;
                    $RD->purchasing_price = ($data->purchasing_price != '') ? $data->purchasing_price : null;
                    $RD->lifetime = ($data->lifetime != '') ? $data->lifetime : null;
                    $RD->lifetime_uom_id = ($data->lifetime_uom_id != '') ? $data->lifetime_uom_id : null;
                    $RD->cost_per_hour = ($data->cost_per_hour != '') ? $data->cost_per_hour : null;
                    $RD->performance = ($data->performance != '') ? $data->performance : null;
                    $RD->performance_uom_id = ($data->performance_uom_id != '') ? $data->performance_uom_id : null;
                }
                $RD->save();

                $GRD = new GoodsReceiptDetail;
                $GRD->goods_receipt_id = $GR->id;
                $GRD->quantity = 1;
                $GRD->resource_detail_id = $RD->id;
                $GRD->save();

                $this->GR->updatePOD($data->pod_id,1);
            }
            $this->GR->checkStatusPO($datas->po_id);
            DB::commit();
            if($route == "/resource"){
                return redirect()->route('resource.showGR',$GR->id)->with('success', 'Goods Receipt Created');
            }elseif($route == "/resource_repair"){
                return redirect()->route('resource_repair.showGR',$GR->id)->with('success', 'Goods Receipt Created');
            }
        } catch (\Exception $e) {
            DB::rollback();
            if($route == "/resource"){
                return redirect()->route('resource.selectPO',$datas->po_id)->with('error', $e->getMessage());
            }elseif($route == "/resource_repair"){
                return redirect()->route('resource_repair.selectPO',$datas->po_id)->with('error', $e->getMessage());
            }
        }
    }

    public function showGR(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $modelGR = GoodsReceipt::findOrFail($id);
        $modelGRD = $modelGR->GoodsReceiptDetails ;

        if($modelGRD[0]->material_id != ''){
            // return view('goods_receipt.show', compact('modelGR','modelGRD','route'));
        }elseif($modelGRD[0]->resource_detail_id != ''){
            return view('resource.showGR', compact('modelGR','modelGRD','route'));
        }
    }

    public function issueResource(Request $request)
    {
        $route = $request->route()->getPrefix();
        
        return view('resource.issue', compact('route'));
    }

    public function storeResourceDetail(Request $request, $wbs_id)
    {
        $data = $request->json()->all();
        DB::beginTransaction();
        try {
            $wbs = WBS::find($wbs_id);
            $resourceDetailWbs = $wbs->resourceDetails;
            if(count($resourceDetailWbs)>0){
                foreach ($resourceDetailWbs as $resourceDetail) {
                    $resourceDetail->delete();
                }
            }

            $categoryFromResource = [];
            foreach($data['dataResources'] as $detail){
                
                $resource = Resource::find($detail['resource_id']);
                array_push($categoryFromResource, $resource->category->id);

                $resourceDetail = new ResourceDetail;
                $resourceDetail->resource_id = $detail['resource_id'];
                $resourceDetail->project_id = $wbs->project->id;
                $resourceDetail->wbs_id = $wbs->id;
                $resourceDetail->category_id = $resource->category->id;
                $resourceDetail->quantity = $detail['quantityInt'];
                $resourceDetail->save();
            }

            array_unique($categoryFromResource);

            foreach($data['selected_resource_category'] as $category){
                if(in_array($category, $categoryFromResource) != true){
                    $resourceDetail = new ResourceDetail;
                    $resourceDetail->project_id = $wbs->project->id;
                    $resourceDetail->wbs_id = $wbs->id;
                    $resourceDetail->category_id = $category;
                    $resourceDetail->save();
                }
            }


            DB::commit();
            return response(["response"=>"Success to assign resource "],Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function show($id)
    {
        $resource = Resource::findOrFail($id);
        $modelPOD = PurchaseOrderDetail::where('resource_id',$id)->get();
        
        return view('resource.show', compact('resource','modelPOD'));
    }

    public function edit($id)
    {
        $resource = Resource::findOrFail($id);

        return view('resource.edit', compact('resource','uoms','resource_code','vendors','resource_category'));
    }

    public function update(Request $request, $id)
    {
        $data = json_decode($request->datas);

        DB::beginTransaction();
        try {
            $resource = Resource::find($id);
            $resource->code = strtoupper($data->code);
            $resource->name = ucwords($data->name);
            $resource->description = $data->description;
            $resource->update();

            DB::commit();
            return redirect()->route('resource.show',$resource->id)->with('success', 'Resource Updated Succesfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('resource.update',$resource->id)->with('error', $e->getMessage());
        }
    }

    public function updateAssignResource (Request $request, $id)
    {
        $data = $request->json()->all();
        $resource_ref = ResourceDetail::find($id);

        DB::beginTransaction();
        try {
            $resource_ref->resource_id = $data['resource_id'];
            $resource_ref->project_id = $data['project_id'];
            $resource_ref->wbs_id = $data['wbs_id'];
            $resource_ref->category_id = $data['category_id'];
            $resource_ref->quantity = $data['quantity'];

            if(!$resource_ref->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to Update WBS ".$resource_ref->code],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function storeAssignResource(Request $request)
    {
        $data = $request->json()->all();
   
        DB::beginTransaction();
        try {
            $resource = new ResourceDetail;
            $resource->resource_id = $data['resource_id'];
            $resource->project_id = $data['project_id'];
            $resource->wbs_id = $data['wbs_id'];
            $resource->category_id = $data['category_id'];
            $resource->quantity = $data['quantity'];
            

            if(!$resource->save()){
                return response(["error"=>"Failed to save, please try again!"],Response::HTTP_OK);
            }else{
                DB::commit();
                return response(["response"=>"Success to assign resource"],Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            DB::rollback();
                return response(["error"=> $e->getMessage()],Response::HTTP_OK);
        }
    }

    public function generateResourceCode(){
        $code = 'RSC';
        $modelResource = Resource::orderBy('code', 'desc')->first();
        
        $number = 1;
		if(isset($modelResource)){
            $number += intval(substr($modelResource->code, -4));
		}

        $resource_code = $code.''.sprintf('%04d', $number);
		return $resource_code;
    }

    public function getResourceAssignApi($id){
        $resource = Resource::where('id',$id)->with('uom')->first()->jsonSerialize();

        return response($resource, Response::HTTP_OK);
    }
    
    
    public function getWbsAssignResourceApi($id){
        $wbs = WBS::where('project_id',$id)->get()->jsonSerialize();

        return response($wbs, Response::HTTP_OK);
    }

    public function getWbsNameAssignResourceApi($id){

        return response(WBS::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);

    }

    public function getResourceNameAssignResourceApi($id){

        return response(Resource::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);

    }

    public function getProjectNameAssignResourceApi($id){

        return response(Project::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);

    }
    
    public function getCategoryARApi($id){

        return response(Resource::findOrFail($id)->jsonSerialize(), Response::HTTP_OK);

    }

    public function getResourceDetailApi(){
        $resourcedetail = ResourceDetail::with('project','resource','wbs')->get()->jsonSerialize();
        return response($resourcedetail, Response::HTTP_OK);
    }
    
    public function generateCodeAPI($data){
        $data = json_decode($data);
        $number = 1;
        $code = $data[0].'-'.$data[1].'-';

        $modelRD = ResourceDetail::orderBy('code','desc')->where('code','like',$code.'%')->first();
        if($modelRD){
            $number += intval(substr($modelRD->code,19));
        }
        $code = $data[0].'-'.$data[1].'-'.$number;

        return response($code, Response::HTTP_OK);
    }
}
