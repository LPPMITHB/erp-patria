@extends('layouts.main')

@section('content-header')
<h1>Project Dashboard</h1>
@endsection

@section('content')
@foreach ($modelProject as $project)

  <div class="row">
      
    <div class="col-lg-12 col-xs-12">
      <!-- small box -->
      @if(date("Y-m-d") > $project->planned_end_date && $project->progress != 100)
      <div class="small-box bg-red">
      @elseif(date("Y-m-d") == $project->planned_end_date  && $project->progress != 100)
      <div class="small-box bg-yellow">
      @else
      <div class="small-box bg-aqua">
      @endif
        <div class="inner">
          <div class="row">
            <div class="col-md-2">
                <h4>Project Code</h4>
            </div>
            <div class="col-md-4">
                <h4> : {{$project->code}}</h4>                
            </div>
            <div class="col-md-2">
                <h4>Progress </h4>
            </div>
            <div class="col-md-4">
                <h4> : {{$project->progress}} %</h4>  
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
                <h4>Ship</h4>
            </div>
            <div class="col-md-4">
                <h4> : {{$project->ship->name}}</h4>                
            </div>
            <div class="col-md-2">
                <h4>Days Left </h4>
            </div>
            <div class="col-md-4">
                @php
                  $earlier = new DateTime(date("Y-m-d"));
                  $later = new DateTime($project->planned_end_date);

                  $datediff = $later->diff($earlier)->format("%a");
                  if($later<$earlier){
                    $datediff = "- ".$datediff;
                  }
                @endphp
                <h4> : {{$datediff}} Days</h4>                
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
                <h4>Customer</h4>
            </div>
            <div class="col-md-4 tdEllipsis" data-container="body" data-toggle="tooltip" data-placement="bottom" title="{{$project->customer->name}}">
                <h4> : {{$project->customer->name}}</h4>                
            </div>
            <div class="col-md-2">
                <h4>Cost Absorption </h4>
            </div>
            <div class="col-md-4">
                <h4> : Rp {{$project->id}},899,900,000 / Rp 50,600,700,000</h4>                
            </div>
          </div>
          <br>
        </div>
        <div class="icon">
          <i class="fa fa-ship"></i>
          
        </div>
        <a href="{{ route('project.show',['id'=>$project->id]) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>
@endforeach






{{-- <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="ion ion-alert-circled"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Projects Need Attention</span>
          <span class="info-box-number">9</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="ion ion-clipboard"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Purchase Orders Pending</span>
          <span class="info-box-number">123</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-phone"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Class RFI Pending</span>
          <span class="info-box-number">3</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-blue"><i class="fa fa-home"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Yard Occupancy</span>
          <span class="info-box-number">90<small>%</small></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Actual Cost Vs. Planned Cost</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <div class="btn-group">
              <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-wrench"></i></button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
              </ul>
            </div>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="">
          <div class="row">
            <div class="col-md-12">
              <div class="chart">
                <!-- Sales Chart Canvas -->
                <canvas id="salesChart" width="703" height="200"></canvas>
              </div>
              <!-- /.chart-responsive -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- ./box-body -->
        <div class="box-footer" style="">
          <div class="row">
            <div class="col-sm-3 col-xs-6">
              <div class="description-block border-right">
                <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                <h5 class="description-header">$35,210.43</h5>
                <span class="description-text">TOTAL REVENUE</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-xs-6">
              <div class="description-block border-right">
                <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                <h5 class="description-header">$10,390.90</h5>
                <span class="description-text">TOTAL COST</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-xs-6">
              <div class="description-block border-right">
                <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                <h5 class="description-header">$24,813.53</h5>
                <span class="description-text">TOTAL PROFIT</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-xs-6">
              <div class="description-block">
                <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                <h5 class="description-header">1200</h5>
                <span class="description-text">GOAL COMPLETIONS</span>
              </div>
              <!-- /.description-block -->
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div> --}}

  
@endsection

@push('script')
<script>
</script>
@endpush