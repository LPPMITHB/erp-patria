<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\YardPlan;
use App\Models\Yard;
use App\Models\Project;
use DB;
use Auth;

class YardPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $yardPlan = YardPlan::with('yard')->with('project')->get();
        $modelYard = Yard::all();
        $modelProject = Project::all();

        return view ('yard_plan.create', compact('yardPlan','modelYard','modelProject'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datas = json_decode($request->datas);
        DB::beginTransaction();
        try {
            $yardPlan = new YardPlan;
            $yardPlan->yard_id = $datas->yard_id;
            $yardPlan->planned_start_date= $datas->planned_start_date;
            $yardPlan->planned_end_date= $datas->planned_end_date;
            $yardPlan->description = $datas->description;
            $yardPlan->project_id = $datas->project_id;
            $yardPlan->wbs_id = $datas->wbs_id;
            $yardPlan->branch_id = Auth::user()->branch->id;
            $yardPlan->user_id = Auth::user()->id;
            $yardPlan->save();
            
            DB::commit();
            return redirect()->route('yard_plan.index')->with('success', 'Yard Plan Created');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('yard_plan.index')->with('error', $e->getMessage());
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    
    public function confirmActual(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $yardPlan = YardPlan::find($id);
            $yardPlan->actual_start_date = $request->actual_start_date;
            $yardPlan->actual_end_date = $request->actual_end_date;
            $yardPlan->save();
            
            DB::commit();
            return redirect()->route('yard_plan.index')->with('success', 'Yard Plan Updated');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('yard_plan.index')->with('error', $e->getMessage());
        }
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

    //API
    public function getWbsAPI($id){
        $modelProject = Project::findOrFail($id);
        $wbss = $modelProject->wbss;
        
        return response($wbss->jsonSerialize(), Response::HTTP_OK);
    }
}
