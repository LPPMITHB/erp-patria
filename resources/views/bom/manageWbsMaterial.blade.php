@extends('layouts.main')
@section('content-header')
    @breadcrumb(
        [
            'title' => 'Manage WBS\'s Materials and Services',
            'subtitle' => '',
            'items' => [
                'Dashboard' => route('index'),
                $wbs->number => route('bom_repair.selectWBSManage', $wbs->project_id),
                'Manage WBS\'s Materials and Services' => '',
            ]
        ]
    )
    @endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 p-b-50">
        <div class="box">
            <div class="box-body no-padding p-b-10">
                @if ($edit)
                    <form id="create-bom" class="form-horizontal" method="POST" action="{{ route('bom_repair.updateWbsMaterial') }}">
                    <input type="hidden" name="_method" value="PATCH">
                @else
                    <form id="create-bom" class="form-horizontal" method="POST" action="{{ route('bom_repair.storeWbsMaterial') }}">
                @endif
                @csrf
                    @verbatim
                    <div id="bom">
                        <div class="box-header p-b-0">
                            <div class="col-xs-12 col-md-4">
                                <div class="col-sm-12 no-padding"><b>Project Standard Information</b></div>
        
                                <div class="col-xs-4 no-padding">Name</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(project.name)"><b>: {{project.name}}</b></div>

                                <div class="col-xs-4 no-padding">Description</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(project.number)"><b>: {{project.description}}</b></div>
        
                                <div class="col-xs-4 no-padding">Ship Type</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(project.ship.type)"><b>: {{project.ship.type}}</b></div>
                            </div>
                            
                            <div class="col-xs-12 col-md-4">
                                <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                                
                                <div class="col-xs-4 no-padding">Number</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.number)"><b>: {{wbs.number}}</b></div>
        
                                <div class="col-xs-4 no-padding">Description</div>
                                <div v-if="wbs.description != ''" class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.description)"><b>: {{wbs.description}}</b></div>
                                <div v-else class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.description)"><b>: -</b></div>
        
                                <div class="col-xs-4 no-padding">Deliverable</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="(wbs.deliverables)"><b>: {{wbs.deliverables}}</b></div>
                            </div>

                            <div class="col-xs-12 col-md-4">                                
                                <div class="col-xs-4 no-padding">Service</div>
                                <selectize id="service" name="service_id" v-model="submittedForm.service_id" :settings="service_settings">
                                    <option v-if="service.ship_id == null" v-for="(service, index) in services" :value="service.id">{{ service.code }} -
                                        {{ service.name }} [General]</option>
                                    <option v-if="service.ship_id != null" v-for="(service, index) in services" :value="service.id">{{ service.code }} -
                                        {{ service.name }} [{{service.ship.type}}]</option>
                                </selectize>

                                <div class="col-xs-4 no-padding">Service Detail</div>        
                                <div class="row">
                                    <div v-show="submittedForm.service_id == ''" class="col-sm-12">
                                        <selectize disabled :settings="empty_service_settings">
                                        </selectize>
                                    </div>
                                    <div v-show="submittedForm.selected_service.length == 0 && submittedForm.service_id != ''" class="col-sm-12">
                                        <selectize disabled :settings="empty_service_detail_settings">
                                        </selectize>
                                    </div>
                                    <div class="col-sm-12" v-show="submittedForm.selected_service.length > 0">
                                        <selectize id="service_detail" name="service_detail_id" v-model="submittedForm.service_detail_id"
                                            :settings="service_detail_settings">
                                            <option v-for="(service_detail, index) in submittedForm.selected_service" :value="service_detail.id">
                                                {{ service_detail.name }} - {{ service_detail.description }}</option>
                                        </selectize>
                                    </div>
                                </div>

                                <div class="col-xs-4 no-padding">Vendor</div>
                                <selectize id="vendor" name="vendor_id" v-model="submittedForm.vendor_id" :settings="vendor_settings">
                                    <option v-for="(vendor, index) in vendors" :value="vendor.id">{{ vendor.code }} - {{ vendor.name }}</option>
                                </selectize>
                            </div>
                        </div> <!-- /.box-header -->
                        <div class="col-md-12 p-t-5">
                            <table class="table table-bordered tableFixed m-b-0 tablePagingVue">
                                <thead>
                                    <tr>
                                        <th width="30px">No</th>
                                        <th width="25%">Material Number</th>
                                        <th width="28%">Material Description</th>
                                        <th width="10%">Quantity</th>
                                        <th width="12%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(material, index) in materialTable">
                                        <td>{{ index + 1 }}</td>
                                        <td :id="material.material_code" class="tdEllipsis" data-container="body" v-tooltip:top="tooltipCode(material.material_code)">{{ material.material_code}}</td>
                                        <td :id="material.material_name" class="tdEllipsis" data-container="body" v-tooltip:top="tooltipDesc(material.material_name)">{{ material.material_name }}</td>
                                        <td>{{ material.quantity }}</td>
                                        <td class="p-l-5" align="center">
                                            <a class="btn btn-primary btn-xs" href="#edit_item" @click="openEditModal(material,index)">
                                                EDIT
                                            </a>
                                            <a href="#" @click="removeRow(material)" class="btn btn-danger btn-xs">
                                                <div class="btn-group">DELETE</div>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>{{newIndex}}</td>
                                        <td colspan="2" class="no-padding">
                                            <selectize class="selectizeFull" id="material" v-model="input.material_id" :settings="materialSettings">
                                                <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                            </selectize>    
                                        </td>
                                        <td class="no-padding"><input class="form-control" type="text" v-model="input.quantity" :disabled="materialOk"></td>
                                        <td class="p-l-0" align="center"><a @click.prevent="submitToTable()" :disabled="inputOk" class="btn btn-primary btn-xs" href="#">
                                            <div class="btn-group">
                                                ADD
                                            </div></a>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-12 p-t-5">
                            <button v-if="submittedForm.edit" id="process" @click.prevent="submitForm()" class="btn btn-primary pull-right" :disabled="createOk">SAVE</button>
                            <button v-else id="process" @click.prevent="submitForm()" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
                        </div>
                        <div class="modal fade" id="edit_item">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">Edit Material</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="type" class="control-label">Material</label>
                                                <selectize id="edit_modal" v-model="editInput.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in materials_modal" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="quantity" class="control-label">Quantity</label>
                                                <input type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity" :disabled="editMaterialOk">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="quantity" class="control-label">Unit</label>
                                                <input type="text" id="quantity" v-model="editInput.unit" class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update(editInput.old_material_id, editInput.material_id)">SAVE</button>
                                    </div>
                                </div>
                            </div>
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
    const form = document.querySelector('form#create-bom');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        project : @json($project),
        materials : @json($materials),
        wbs : @json($wbs),
        services : @json($services),
        vendors : @json($vendors),
        newIndex : 0, 
        submittedForm :{
            project_id : @json($project->id),
            wbs_id : @json($wbs->id),
            edit : @json($edit),
            deleted_id : [],

            service_id: "",
            service_detail_id: "",
            selected_service : "",
            vendor_id : "",
            area :"",
            area_uom_id : "",
        },
        input : {
            material_id : "",
            material_name : "",
            material_code : "",
            quantity : "",
            unit : "",
            is_decimal : "",
            material_ok : ""
        },
        editInput : {
            old_material_id : "",
            material_id : "",
            material_code : "",
            material_name : "",
            quantity : "",
            unit : "",
            is_decimal : "",
            material_ok : ""
        },
        materialTable : @json($existing_data),
        materialSettings: {
            placeholder: 'Please Select Material'
        },
        material_id:@json($material_ids),
        material_id_modal:[],
        materials_modal :[],

        service_settings : {
            placeholder: 'Service'
        },
        vendor_settings : {
            placeholder: 'Vendor'
        },
        empty_service_settings:{
            placeholder: 'Please select service first!'
        },
        empty_service_detail_settings:{
            placeholder: 'Service doesn\'t have service detail!'
        },
        service_detail_settings:{
            placeholder: 'Service Detail'
        },
    }

    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })

    var vm = new Vue({
        el : '#bom',
        data : data,
        computed:{
            inputOk: function(){
                let isOk = false;

                if(this.input.material_id == "" || this.input.quantity == ""){
                    isOk = true;
                }
                return isOk;
            },
            createOk: function(){
                let isOk = false;

                if(this.materialTable.length < 1){
                    isOk = true;
                }
                return isOk;
            },
            updateOk: function(){
                let isOk = false;

                if(this.editInput.material_id == "" || this.editInput.quantity == ""){
                    isOk = true;
                }

                return isOk;
            },
            materialOk : function(){
                let isOk = false;

                if(this.input.material_ok == ""){
                    isOk = true;
                }

                return isOk;
            },
            editMaterialOk : function(){
                let isOk = false;

                if(this.editInput.material_ok == ""){
                    isOk = true;
                }

                return isOk;
            }
        },
        methods: {
            refreshTooltip: function(code,description){
                Vue.directive('tooltip', function(el, binding){
                    if(el.id == code){
                        $(el).tooltip('destroy');
                        $(el).tooltip({
                            title: el.id,
                            placement: binding.arg,
                            trigger: 'hover'             
                        })
                    }else if(el.id == description){
                        $(el).tooltip('destroy');
                        $(el).tooltip({
                            title: el.id,
                            placement: binding.arg,
                            trigger: 'hover'             
                        })
                    }
                })
            },
            tooltipCode: function(code) {
                return code;
            },
            tooltipDesc: function(desc) {
                return desc;
            },
            getNewMaterials(jsonMaterialId){
                window.axios.get('/api/getMaterialsBOM/'+jsonMaterialId).then(({ data }) => {
                    this.materials = data;
                    $('div.overlay').hide();
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                })
            },
            getNewModalMaterials(jsonMaterialId){
                window.axios.get('/api/getMaterialsBOM/'+jsonMaterialId).then(({ data }) => {
                    this.materials_modal = data;
                    $('#edit_item').modal();
                    $('div.overlay').hide();
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                })
            },
            openEditModal(data,index){
                $('div.overlay').show();
                this.editInput.material_id = data.material_id;
                this.editInput.old_material_id = data.material_id;
                this.editInput.material_code = data.material_code;
                this.editInput.material_name = data.material_name;
                this.editInput.quantity = data.quantity;
                this.editInput.wbs_id = data.wbs_id;
                this.editInput.wbs_number = data.wbs_number;
                this.editInput.index = index;
                this.editInput.unit = data.unit;
                this.editInput.is_decimal = data.is_decimal;

                var material_id = JSON.stringify(this.material_id);
                material_id = JSON.parse(material_id);
                
                this.material_id_modal = material_id;
                this.material_id_modal.forEach(id => {
                    if(id == data.material_id){
                        var index = this.material_id_modal.indexOf(id);
                        this.material_id_modal.splice(index, 1);
                    }
                });
                var jsonMaterialId = JSON.stringify(this.material_id_modal);
                this.getNewModalMaterials(jsonMaterialId);
            },
            submitForm(){
                $('div.overlay').show();
                this.materialTable.forEach(data=>{
                    data.quantity = (data.quantity+"").replace(/,/g , '');
                })
                this.submittedForm.materials = this.materialTable;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            submitToTable(){
                if(this.input.material_id != "" && this.input.material_name != "" && this.input.quantity != ""){
                    $('div.overlay').show();

                    var data = JSON.stringify(this.input);
                    data = JSON.parse(data);
                    this.materialTable.push(data);

                    this.material_id.push(data.material_id); //ini buat nambahin material_id terpilih

                    var jsonMaterialId = JSON.stringify(this.material_id);
                    this.getNewMaterials(jsonMaterialId);             

                    this.newIndex = this.materialTable.length + 1;  

                    // refresh tooltip
                    let datas = [];
                    datas.push(this.input.material_code,this.input.material_name);
                    datas = JSON.stringify(datas);
                    datas = JSON.parse(datas);
                    this.refreshTooltip(datas[0],datas[1]);

                    this.input.material_id = "";
                    this.input.material_code = "";
                    this.input.material_name = "";
                    this.input.quantity = "";
                    this.input.unit = "";
                    this.input.quantityInt = 0;
                }
            },
            removeRow: function(material) {
                $('div.overlay').show();
                var index_materialId = "";
                var index_materialTable = "";
                if(typeof material.id !== 'undefined'){
                    this.submittedForm.deleted_id.push(material.id);
                }
                
                this.material_id.forEach(id => {
                    if(id == material.material_id){
                        index_materialId = this.material_id.indexOf(id);
                    }
                });
                for (var i in this.materialTable) { 
                    if(this.materialTable[i].material_id == material.material_id){
                        index_materialTable = i;
                    }
                }

                this.materialTable.splice(index_materialTable, 1);
                this.material_id.splice(index_materialId, 1);
                this.newIndex = this.materialTable.length + 1;

                var jsonMaterialId = JSON.stringify(this.material_id);
                this.getNewMaterials(jsonMaterialId);
            },
            update(old_material_id, new_material_id){
                this.materialTable.forEach(material => {
                    if(material.material_id == old_material_id){
                        var material = this.materialTable[this.editInput.index];
                        material.quantityInt = this.editInput.quantityInt;
                        material.quantity = this.editInput.quantity;
                        material.unit = this.editInput.unit;
                        material.material_id = new_material_id;
                        material.wbs_id = this.editInput.wbs_id;

                        var elemCode = document.getElementById(material.material_code);
                        var elemDesc = document.getElementById(material.material_name);

                        window.axios.get('/api/getMaterialBOM/'+new_material_id).then(({ data }) => {
                            material.material_name = data.description;
                            material.material_code = data.code;

                            this.material_id.forEach(id => {
                                if(id == old_material_id){
                                    var index = this.material_id.indexOf(id);
                                    this.material_id.splice(index, 1);
                                }
                            });
                            this.material_id.push(new_material_id);

                            var jsonMaterialId = JSON.stringify(this.material_id);
                            this.getNewMaterials(jsonMaterialId);

                            // refresh tooltip
                            elemCode.id = data.code;
                            elemDesc.id = data.description;
                            this.refreshTooltip(elemCode.id,elemDesc.id);

                            $('div.overlay').hide();
                        })
                        .catch((error) => {
                            iziToast.warning({
                                title: 'Please Try Again..',
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                            $('div.overlay').hide();
                        })
                    }
                });
            },
        },
        watch: {
            'input.material_id': function(newValue){
                this.input.quantity = "";
                if(newValue != ""){
                    this.input.material_ok = "ok";
                    window.axios.get('/api/getMaterialBOM/'+newValue).then(({ data }) => {
                        this.input.material_name = data.description;
                        this.input.material_code = data.code;
                        this.input.unit = data.uom.unit;
                        this.input.is_decimal = data.uom.is_decimal;
                    });
                }else{
                    this.input.material_name = "";
                    this.input.material_code = "";
                    this.input.unit = "";
                    this.input.is_decimal = "";
                    this.input.material_ok = "";
                }
            },
            'editInput.material_id': function(newValue){
                if(newValue != this.editInput.old_material_id){
                    this.editInput.quantity = "";
                }
                if(newValue != ""){
                    this.editInput.material_ok = "ok";
                    window.axios.get('/api/getMaterialBOM/'+newValue).then(({ data }) => {
                        this.editInput.material_name = data.description;
                        this.editInput.material_code = data.code;
                        this.editInput.unit = data.uom.unit;
                        this.editInput.is_decimal = data.uom.is_decimal;
                    });
                }else{
                    this.editInput.material_name = "";
                    this.editInput.material_code = "";
                    this.editInput.unit = "";
                    this.editInput.is_decimal = "";
                    this.editInput.material_ok = "";
                }
            },
            'input.quantity': function(newValue){
                var is_decimal = this.input.is_decimal;
                if(is_decimal == 0){
                    this.input.quantity = (this.input.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                }else{
                    var decimal = newValue.replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            this.input.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            this.input.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        this.input.quantity = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }
            },
            'editInput.quantity': function(newValue){
                var is_decimal = this.editInput.is_decimal;
                if(is_decimal == 0){
                    this.editInput.quantity = (this.editInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                }else{
                    var decimal = (newValue+"").replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            this.editInput.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            this.editInput.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        this.editInput.quantity = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }  
            },
            'submittedForm.service_id': function(newValue) {
                if(newValue != ""){
                    this.submittedForm.service_detail_id = "";
                    this.services.forEach(service => {
                        if(service.id == newValue){
                            this.submittedForm.selected_service = service.service_details;
                        }
                    });
                }else{
                    this.submittedForm.selected_service = "";
                    this.submittedForm.service_detail_id = "";
                }
            },
            'submittedForm.service_detail_id' : function(newValue){
                if(newValue != ""){
                    this.submittedForm.selected_service.forEach(service_detail => {
                        if(service_detail.id == newValue){
                            this.submittedForm.area_uom_id = service_detail.uom_id;
                        }
                    });
                }else{
                    this.submittedForm.area_uom_id = "";
                }
            },
        },
        created: function() {
            this.newIndex = this.materialTable.length + 1;
            var jsonMaterialId = JSON.stringify(this.material_id);
            this.getNewMaterials(jsonMaterialId);        
        }
    });
       
</script>
@endpush