@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'View Stocks Management',
        'items' => [
            'Dashboard' => route('index'),
            'View Stocks Management' => route('stock_management.index'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <form id="view-stock" class="form-horizontal">
                @csrf
                    @verbatim
                    <div id="stockmanagement">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-12 p-l-20">
                                        <label for="">Warehouse</label>
                                        <selectize v-model="warehouse_id" :settings="warehouseSettings">
                                            <option v-for="(warehouse, index) in warehouses" :value="warehouse.id">{{warehouse.name}}</option>
                                        </selectize>  
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 p-l-20">
                                        <label for="">Storage Location</label>
                                        <selectize v-model="sloc_id" :settings="slocSettings">
                                            <option v-for="(storageLocation, index) in storageLocations" :value="storageLocation.id">{{storageLocation.name}}</option>
                                        </selectize>  
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row p-l-15">
                                    <label for="">Stock Information</label>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">Total Inventory Value</div>
                                    <div class="col-sm-7">: {{stockValue}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">Total Inventory Quantity</div>
                                    <div class="col-sm-7">: {{stockQuantity}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">Total Reserved Quantity</div>
                                    <div class="col-sm-7">: {{reservedStockQuantity}}</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <template v-if='warehouse_id !=""'>
                                    <div class="row p-l-15">
                                        <label for="">Warehouse Information</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">Total Inventory Value</div>
                                        <div class="col-sm-7">: {{warehouseValue}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">Total Inventory Quantity</div>
                                        <div class="col-sm-7">: {{warehouseQuantity}}</div>
                                    </div>
                                </template>

                                <template v-if='sloc_id !=""'>
                                    <div class="row p-l-15">
                                        <label for="">Storage Location Information</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">Total Inventory Value</div>
                                        <div class="col-sm-7">: {{slocValue}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">Total Inventory Quantity</div>
                                        <div class="col-sm-7">: {{slocQuantity}}</div>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="row">
                            <template v-if="warehouse_id == ''">
                                <div class="col sm-12 p-l-10 p-r-10 p-t-10">
                                    <table class="table table-bordered showTable" style="border-collapse:collapse;">
                                        <thead>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 45%">Material</th>
                                            <th style="width: 10%">Quantity</th>
                                            <th style="width: 10%">Reserved</th>
                                            <th style="width: 15%">Total Value</th>
                                            <th style="width: 10%">Aging</th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(stock,index) in stocks">
                                                <td>{{ index + 1 }}</td>
                                                <td class="tdEllipsis">{{ stock.material.code }} - {{ stock.material.name }}</td>
                                                <td class="tdEllipsis">{{ stock.quantity }}</td>
                                                <td class="tdEllipsis">{{ stock.reserved }}</td>
                                                <td class="tdEllipsis">Rp {{ (stock.material.cost_standard_price * stock.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                                <td class="tdEllipsis">{{ stock.quantity + stock.reserved }} Days</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </template>
                            <template v-if="warehouse_id > 0">
                                <div class="col sm-12 p-l-10 p-r-10 p-t-10">
                                    <table class="table table-bordered showTable" style="border-collapse:collapse;">
                                        <thead>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 45%">Material</th>
                                            <th style="width: 10%">Quantity</th>
                                            <th style="width: 15%">Total Value</th>
                                            <th style="width: 10%">Aging</th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(selectedDetail,index) in selectedSlocDetail">
                                                <td>{{ index + 1 }}</td>
                                                <td class="tdEllipsis">{{ selectedDetail.material.code }} - {{ selectedDetail.material.name }}</td>
                                                <td class="tdEllipsis">{{ selectedDetail.quantity }}</td>
                                                <td class="tdEllipsis">Rp {{ (selectedDetail.material.cost_standard_price * selectedDetail.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                                <td class="tdEllipsis">{{ selectedDetail.quantity + 0 }} Days</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </template>
                        </div>
                    </div>
                    @endverbatim
                </form>
            </div>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    const form = document.querySelector('form#view-stock');

    var data = {
        materials : @json($materials),
        warehouses : @json($warehouses),
        storageLocations : "",
        sloc_id : "",
        warehouse_id : "",
        selectedSloc : [],
        selectedSlocDetail : [],
        slocSettings: {
            placeholder: 'Please Select Storage Location'
        },
        warehouseSettings: {
            placeholder: 'Please Select Warehouse'
        },
        stocks: "",
        stockValue : "",
        stockQuantity : "",
        reservedStockQuantity : "",
        warehouseValue : "",
        warehouseQuantity : "",
        slocValue : "",
        slocQuantity : "",
    }

    var vm = new Vue({
        el : '#stockmanagement',
        data : data,
        watch : {
            'sloc_id' : function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getSlocSM/'+newValue).then(({ data }) => {
                        this.selectedSloc.push(data.sloc);
                        this.selectedSlocDetail = data.slocDetail;
                        this.slocValue = "Rp "+data.slocValue;
                        this.slocQuantity = data.slocQuantity;

                        var data = this.selectedSlocDetail;
                        data.forEach(slocDetail => {
                            slocDetail.quantity = (slocDetail.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
                        });
                        $('div.overlay').hide();
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again.. '+error,
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        $('div.overlay').hide();
                    })
                }else{
                    this.selectedSloc = [];
                    $('div.overlay').show();
                    window.axios.get('/api/getWarehouseStockSM/'+this.warehouse_id).then(({ data }) => {   
                        this.selectedSlocDetail = data;

                        var data = this.selectedSlocDetail;
                        data.forEach(slocDetail => {
                            slocDetail.quantity = (slocDetail.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
                        });
                        $('div.overlay').hide();
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again.. '+error,
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        $('div.overlay').hide();
                    })
                }
            },
            warehouse_id : function (newValue){
                this.sloc_id = "";
                $('div.overlay').show();
                if(this.sloc_id == "" && this.warehouse_id != ""){
                    window.axios.get('/api/getWarehouseStockSM/'+newValue).then(({ data }) => {   
                        this.selectedSlocDetail = data;

                        var data = this.selectedSlocDetail;
                        data.forEach(slocDetail => {
                            slocDetail.quantity = (slocDetail.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
                        });
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again.. '+error,
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        $('div.overlay').hide();
                    })
                    window.axios.get('/api/getWarehouseInfoSM/'+newValue).then(({ data }) => {
                        this.storageLocations = data.sloc;
                        this.warehouseValue = "Rp "+data.warehouseValue;
                        this.warehouseQuantity = data.warehouseQuantity;
                        $('div.overlay').hide();
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again.. '+error,
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        $('div.overlay').hide();
                    })
                }else{
                    this.storageLocations = "";
                    $('div.overlay').hide();
                }
            }
        },
        created: function(){
            window.axios.get('/api/getStockInfoSM/').then(({ data }) => {
                    this.stocks = data.stocks;
                    this.stockValue = "Rp "+data.stockValue;
                    this.stockQuantity = data.stockQuantity;
                    this.reservedStockQuantity = data.reservedStockQuantity;

                    $('div.overlay').hide();
            })
            .catch((error) => {
                iziToast.warning({
                    title: 'Please Try Again.. '+error,
                    position: 'topRight',
                    displayMode: 'replace'
                });
                $('div.overlay').hide();
            })
        }
    });
</script>
@endpush
