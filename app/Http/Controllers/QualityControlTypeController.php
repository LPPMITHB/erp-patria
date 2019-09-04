<?php

namespace App\Http\Controllers;


use App\Models\QualityControlType;
use App\Models\QualityControlTypeDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Auth;
use DB;

class QualityControlTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $qct_type = QualityControlType::get()->jsonSerialize();
        return view('qulity_control_type.index', compact('qct_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $route = $request->route()->getPrefix();
        return view('qulity_control_type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $data = json_decode($request->datas);
        DB::beginTransaction();

        try {
            $qcType = new QualityControlType;
            $qcType->code = "DOCUMENT" . strtotime("now") . "QC" . Auth::user()->branch->id;
            $qcType->name = $data->name;
            $qcType->description = $data->description;
            $qcType->user_id = Auth::user()->id;
            $qcType->branch_id = Auth::user()->branch->id;

            if ($qcType->save()) {
                foreach ($data->task as $qctask) {
                    $qcTypeDetail = new QualityControlTypeDetail;
                    $qcTypeDetail->qctype_id = $qcType->id;
                    $qcTypeDetail->name = $qctask->name;
                    $qcTypeDetail->description = $qctask->description;
                    $qcTypeDetail->save();
                }
            }
            DB::commit();
            return redirect()->route('qc_type.show', $qcType->id)->with('success', 'Success Created New Quality Control Type!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('qc_type.create')->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $qcType = QualityControlType::findOrFail($id);
        $qcTypeDetail = QualityControlTypeDetail::where(['qctype_id'=>$id])->get()->jsonSerialize();
        return view('qulity_control_type.show', compact('qcType', 'qcTypeDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $route = $request->route()->getPrefix();
        $qcType = QualityControlType::findOrFail($id);
        $qcTypeDetail = QualityControlTypeDetail::where(['qctype_id' => $id])->get()->jsonSerialize();
        return view('qulity_control_type.edit', compact('qcType', 'qcTypeDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    public function updateDetail(Request $request, $id)
    {
       $data = $request->datas;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
