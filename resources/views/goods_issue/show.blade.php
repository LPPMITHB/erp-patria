@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Goods Issue » '.$modelGI->number,
        'items' => [
            'Dashboard' => route('index'),
            'View Goods Issue' => route('purchase_order.show',$modelGI->id),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-blue">
            <div class="row">
                <div class="col-sm-3 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">GI Number</span>
                            <span class="info-box-number">{{ $modelGI->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-4">
                            Ship Name
                        </div>
                        <div class="col-md-8">
                            : <b> {{ isset($modelGI->materialRequisition) ? $modelGI->materialRequisition->project->name : '-'}} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            PO Code
                        </div>
                        <div class="col-md-8">
                            : <b> {{ isset($modelGI->materialRequisition) ? $modelGI->materialRequisition->number : '-' }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Type
                        </div>
                        <div class="col-md-8">
                            @if($modelGI->type == 0)
                            : <b> Manual </b>
                            @elseif($modelGI->type == 1)
                            : <b> Automatic </b>
                            @else
                            : <b> Material Write Off </b>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-5">
                                Status
                            </div>
                            @if($modelGI->status == 1)
                            <div class="col-xs-7 col-md-7">
                                : <b>OPEN</b>
                            </div>
                        @elseif($modelGI->status == 2)
                            <div class="col-xs-7 col-md-7">
                                : <b>APPROVE</b>
                            </div>
                        @elseif($modelGI->status == 3)
                            <div class="col-xs-7 col-md-7">
                                : <b>NEEDS REVISION</b>
                            </div>
                        @elseif($modelGI->status == 4)
                            <div class="col-xs-7 col-md-7">
                                : <b>REJECTED</b>
                            </div>
                        @elseif($modelGI->status == 0)
                            <div class="col-xs-7 col-md-7">
                                : <b>ORDERED</b>
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                                Description
                            </div>
                            <div class="col-md-7">
                                : <b> {{ $modelGI->description }} </b>
                            </div>
                    </div>
                </div>
            </div>
            <div class="box-body p-t-0 p-b-0">
                <table class="table table-bordered showTable" id="gi-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="40%">Material Name</th>
                            <th width="25%">Quantity</th>
                            <th width="30%">Storage Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modelGID as $GID)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $GID->material->name }}</td>
                            <td>{{ number_format($GID->quantity) }}</td>
                            <td>{{ $GID->storageLocation->name }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($approve)
                    <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                        <a class="btn btn-primary pull-right m-l-10" href="{{ route('goods_issue.approval', ['id'=>$modelGI->id,'status'=>'approve']) }}">APPROVE</a>
                        {{-- <a class="btn btn-danger pull-right m-l-10 p-r-10" href="{{ route('goods_issue.approval', ['id'=>$modelGI->id,'status'=>'need-revision']) }}">REVISE</a> --}}
                        <a class="btn btn-danger pull-right p-r-10" href="{{ route('goods_issue.approval', ['id'=>$modelGI->id,'status'=>'reject']) }}">REJECT</a>
                    </div>
                @endif
            </div> <!-- /.box-body -->
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('#gi-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').remove();
            }
        });
    });
</script>
@endpush
