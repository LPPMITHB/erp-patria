@extends('layouts.main')
@section('content-header')
@if($modelPR->type == 1)
    @php($type = "Material")
@else
    @php($type = "Resource")
@endif
@if($route == "/purchase_requisition")
    @breadcrumb(
        [
            'title' => 'Edit Purchase Requisition » '.$modelPR->number.' - '.$type,
            'items' => [
                'Dashboard' => route('index'),
                'View All Purchase Requisitions' => route('purchase_requisition.index'),
                'Edit Purchase Requisition' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/purchase_requisition_repair")
    @breadcrumb(
        [
            'title' => 'Edit Purchase Requisition » '.$modelPR->number.' - '.$type,
            'items' => [
                'Dashboard' => route('index'),
                'View All Purchase Requisitions' => route('purchase_requisition_repair.index'),
                'Edit Purchase Requisition' => '',
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                @if($route == "/purchase_requisition")
                    <form id="edit-pr" class="form-horizontal" method="POST" action="{{ route('purchase_requisition.update',['id'=>$modelPR->id]) }}">
                @elseif($route == "/purchase_requisition_repair")
                    <form id="edit-pr" class="form-horizontal" method="POST" action="{{ route('purchase_requisition_repair.update',['id'=>$modelPR->id]) }}">
                @endif
                <input type="hidden" name="_method" value="PATCH">
                @csrf
                    @verbatim
                    <div id="pr">
                        <div class="box-header no-padding">
                            <div class="col-xs-12 col-md-4 p-r-0">
                                <div class="col-sm-12 p-l-0">
                                    <label for="">PR Description</label>
                                </div>
                                <div class="col-sm-12 p-l-0">
                                    <textarea class="form-control" rows="3" v-model="modelPR.description"></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="col-sm-12 p-l-0">
                                    <label for="">Required Date</label>
                                </div>
                                <div class="col-sm-12 p-l-0">
                                    <input v-model="required_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="required_date" id="required_date" placeholder="Set Default Required Date">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4" v-if="modelPR.status == 3">
                                <div class="col-sm-12 p-l-0">
                                    <label for="">Revision Description</label>
                                </div>
                                <div class="col-sm-12 p-l-0">
                                    <textarea class="form-control" rows="3" v-model="modelPR.revision_description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col sm-12 p-l-15 p-r-10 p-t-10 p-r-15">
                                <table class="table table-bordered tableFixed">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <template v-if="modelPR.type == 1">
                                                <th style="width: 25%">Material Number</th>
                                                <th style="width: 25%">Material Description</th>
                                            </template>
                                            <template v-else-if="modelPR.type == 2">
                                                <th style="width: 25%">Resource Number</th>
                                                <th style="width: 25%">Resource Description</th>
                                            </template>
                                            <th style="width: 9%">Quantity</th>
                                            <th style="width: 8%">Unit</th>
                                            <th style="width: 15%">Project Number</th>
                                            <th style="width: 13%">Required Date</th>
                                            <th style="width: 15%">Alocation</th>
                                            <th style="width: 13%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(data,index) in dataMaterial">
                                            <td>{{ index + 1 }}</td>
                                            <template v-if="modelPR.type == 1">
                                                <td class="tdEllipsis">{{ data.material_code }}</td>
                                                <td class="tdEllipsis">{{ data.material_name }}</td>
                                            </template>
                                            <template v-else-if="modelPR.type == 2">
                                                <td class="tdEllipsis">{{ data.resource_code }}</td>
                                                <td class="tdEllipsis">{{ data.resource_name }}</td>
                                            </template>
                                            <td class="tdEllipsis">{{ data.quantity }}</td>
                                            <td class="tdEllipsis">{{ data.unit }}</td>
                                            <td class="tdEllipsis">{{ data.project_number }}</td>
                                            <td class="tdEllipsis">{{ data.required_date }}</td>
                                            <td class="tdEllipsis">{{ data.alocation }}</td>
                                            <td class="p-l-0 textCenter">
                                                <a v-if="modelPR.type == 1" class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(data,index)">
                                                    EDIT
                                                </a>
                                                <a v-else class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_resource" @click="openEditModal(data,index)">
                                                    EDIT
                                                </a>
                                                <a v-show="data.prd_id != null" href="#" @click="removeRowDb(index,data.id)" class="btn btn-danger btn-xs">
                                                    DELETE
                                                </a>
                                                <a v-show="data.prd_id == null" href="#" @click="removeRow(index)" class="btn btn-danger btn-xs">
                                                    DELETE
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="p-l-10">{{newIndex}}</td>
                                            <td v-show="modelPR.type == 1" class="no-padding textLeft" colspan="2">
                                                <selectize v-model="dataInput.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                </selectize>
                                            </td>
                                            <td v-show="modelPR.type == 2" class="no-padding textLeft" colspan="2">
                                                <selectize v-model="dataInput.resource_id" :settings="resourceSettings">
                                                    <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                                </selectize>
                                            </td>
                                            <td class="no-padding ">
                                                <input class="form-control width100" v-model="dataInput.quantity" placeholder="Please Input Quantity">
                                            </td>
                                            <td class="no-padding ">
                                                <input class="form-control width100" v-model="dataInput.unit" disabled>
                                            </td>
                                            <td class="p-l-0 textLeft">
                                                <selectize v-model="dataInput.project_id" :settings="projectSettings">
                                                    <option v-for="(project, index) in projects" :value="project.id">{{ project.number }}</option>
                                                </selectize>  
                                            </td>
                                            <td class="no-padding p-l-0 textLeft">
                                                <input v-model="dataInput.required_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="input_required_date" id="input_required_date" placeholder="Required Date">  
                                            </td>
                                            <td class="no-padding textLeft">
                                                <selectize v-model="dataInput.alocation" :settings="alocationSettings" :disabled="resourceOk">
                                                    <option value="Consumption">Consumption</option>
                                                    <option value="Stock">Stock</option>
                                                </selectize>
                                            </td>
                                            <td class="no-padding textCenter">
                                                <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 p-r-0 p-t-10">
                            <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="allOk">SAVE</button>
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
                                                <selectize v-model="editInput.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.description }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="quantity" class="control-label">Quantity</label>
                                                <input type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="unit" class="control-label">Unit</label>
                                                <input type="text" id="unit" v-model="editInput.unit" class="form-control" disabled>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="type" class="control-label">Project Number</label>
                                                <selectize v-model="editInput.project_id" :settings="projectSettings">
                                                    <option v-for="(project, index) in projects" :value="project.id">{{ project.number }}</option>
                                                </selectize> 
                                            </div>
                                            <div class="col-sm-12"> 
                                                <label for="type" class="control-label">Required Date</label>
                                                <input v-model="editInput.required_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="edit_required_date" id="edit_required_date" placeholder="Required Date">  
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="alocation" class="control-label">Alocation</label>
                                                <selectize v-model="editInput.alocation" :settings="alocationSettings">
                                                    <option value="Consumption">Consumption</option>
                                                    <option value="Stock">Stock</option>
                                                </selectize>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update()">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="edit_resource">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">Edit Resource</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="type" class="control-label">Resource</label>
                                                <selectize id="edit_modal" v-model="editInput.resource_id" :settings="resourceSettings">
                                                    <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="quantity" class="control-label">Quantity</label>
                                                <input type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity">
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="type" class="control-label">Project Number</label>
                                                <selectize v-model="editInput.project_id" :settings="projectSettings">
                                                    <option v-for="(project, index) in projects" :value="project.id">{{ project.number }}</option>
                                                </selectize> 
                                            </div>
                                            <div class="col-sm-12"> 
                                                <label for="type" class="control-label">Required Date</label>
                                                <input v-model="editInput.required_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="edit_required_date" id="edit_required_date" placeholder="Required Date">  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update()">SAVE</button>
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
    const form = document.querySelector('form#edit-pr');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        newIndex : "",
        resource : "",
        modelPR : @json($modelPR),
        modelPRD : @json($modelPRD),
        dataMaterial : [],
        materials : @json($materials),
        resources : @json($resources),
        projects : @json($modelProject),
        projectSettings: {
            placeholder: 'Please Select Project'
        },
        materialSettings: {
            placeholder: 'Please Select Material'
        },
        resourceSettings: {
            placeholder: 'Please Select Resource'
        },
        nullSettings:{
            placeholder: '-'
        },
        alocationSettings: {
            placeholder: 'Please Select Alocation'
        },
        dataInput : {
            prd_id :null,
            material_id :"",
            material_code : "",
            material_name : "",
            resource_id :"",
            resource_code : "",
            resource_name : "",
            quantity : "",
            unit : "",
            project_id : "",
            project_number : "-",
            required_date : "",
            alocation : "Stock",
        },
        editInput : {
            material_id :"",
            material_code : "",
            material_name : "",
            resource_id :"",
            resource_code : "",
            resource_name : "",
            quantity : "",
            unit : "",
            project_id : "",
            project_number : "-",
            required_date : "",
            alocation : "",
        },
        material_id:[],
        required_date : "",
        submittedForm : {},
        deletedId : []
    }

    var vm = new Vue({
        el : '#pr',
        data : data,
        mounted(){
            $('.datepicker').datepicker({
                autoclose : true,
                format: 'dd-mm-yyyy',
            });
            $("#required_date").datepicker().on(
                "changeDate", () => {
                    this.required_date = $('#required_date').val();
                }
            );
            $("#input_required_date").datepicker().on(
                "changeDate", () => {
                    this.dataInput.required_date = $('#input_required_date').val();
                }
            );
            $("#edit_required_date").datepicker().on(
                "changeDate", () => {
                    this.editInput.required_date = $('#edit_required_date').val();
                }
            );
        },
        computed : {
            resourceOk: function(){
                let isOk = false;
                
                if(this.resource == "ok"){
                    isOk = true;
                    this.dataInput.alocation = "";
                }

                return isOk;
            },
            dataOk: function(){
                let isOk = false;
                
                if(this.dataMaterial.length > 0){
                    isOk = true;
                }

                return isOk;
            },
            allOk: function(){
                let isOk = false;
                
                if(this.dataMaterial.length < 1){
                    isOk = true;
                }

                return isOk;
            },
            createOk: function(){
                let isOk = false;

                var quantityInt = parseInt((this.dataInput.quantity+"").replace(/,/g , ''));
                if(this.modelPR.type == 1){
                    if(this.dataInput.material_id == "" || quantityInt < 1 || this.dataInput.quantity == "" || this.dataInput.alocation == ""){
                        isOk = true;
                    }
                }else if(this.modelPR.type == 2){
                    if(this.dataInput.resource_id == "" || quantityInt < 1 || this.dataInput.quantity == ""){
                        isOk = true;
                    }
                }
                return isOk;
            },
            updateOk: function(){
                let isOk = false;

                var quantityInt = parseInt((this.editInput.quantity+"").replace(/,/g , ''));
                if(this.modelPR.type == 1){
                    if(this.editInput.material_id == "" || quantityInt < 1 || this.editInput.quantity == "" || this.editInput.alocation == ""){
                        isOk = true;
                    }
                }else if(this.modelPR.type == 2){
                    if(this.editInput.resource_id == "" || quantityInt < 1 || this.editInput.quantity == ""){
                        isOk = true;
                    }
                }
                return isOk;
            },
        },
        methods : {
            clearData(){
                this.dataInput.material_id = "";
                this.dataInput.material_code = "";
                this.dataInput.material_name = "";
                this.dataInput.resource_id = "";
                this.dataInput.resource_code = "";
                this.dataInput.resource_name = "";
                this.dataInput.quantity = "";
                this.dataInput.unit = "";
                this.dataInput.project_id = "";
                this.dataInput.project_number = "-";
                this.dataInput.required_date = "";
                this.dataInput.alocation = "Stock";

                this.newIndex = Object.keys(this.dataMaterial).length+1;
            },
            submitForm(){
                this.dataMaterial.forEach(prd => {
                    prd.quantity = parseInt((prd.quantity+"").replace(/,/g , ''));
                });

                this.submittedForm.datas = this.dataMaterial;  
                this.submittedForm.description = this.modelPR.description;
                this.submittedForm.deletedId = this.deletedId;
                this.submittedForm.pr_id = this.modelPR.id;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            update(){
                $('div.overlay').show();
                var data = this.dataMaterial[this.editInput.index];

                data.material_id = this.editInput.material_id;
                data.material_name = this.editInput.material_name;
                data.material_code = this.editInput.material_code;
                data.resource_id = this.editInput.resource_id;
                data.resource_code = this.editInput.resource_code;
                data.resource_name = this.editInput.resource_name;
                data.quantity = this.editInput.quantity 
                data.unit = this.editInput.unit 
                data.project_id = this.editInput.project_id 
                data.project_number = this.editInput.project_number 
                data.required_date = this.editInput.required_date 
                data.alocation = this.editInput.alocation 
                
                if(this.modelPR.type == 1){
                    var type = "Material";
                }else if(this.modelPR.type == 2){
                    var type = "Resource";
                }
                iziToast.success({
                    title: type+' Updated !',
                    position: 'topRight',
                    displayMode: 'replace'
                });

                $('div.overlay').hide();
            },
            openEditModal(data,index){
                this.editInput.material_id = data.material_id;
                this.editInput.material_code = data.material_code;
                this.editInput.material_name = data.material_name;
                this.editInput.resource_id = data.resource_id;
                this.editInput.resource_code = data.resource_code;
                this.editInput.resource_name = data.resource_name;
                this.editInput.quantity = data.quantity;
                this.editInput.unit = data.unit;
                this.editInput.project_id = data.project_id;
                this.editInput.project_number = data.project_number;
                this.editInput.required_date = data.required_date;
                this.editInput.alocation = data.alocation;
                this.editInput.index = index;                
            },
            add(){
                $('div.overlay').show();
                var data = JSON.stringify(this.dataInput);
                data = JSON.parse(data);

                this.dataMaterial.push(data);

                this.clearData();
                $('div.overlay').hide();
            },
            removeRow(index){
                this.dataMaterial.splice(index, 1);
                
                this.newIndex = this.dataMaterial.length + 1;
            },
            removeRowDb(index,id){
                this.dataMaterial.splice(index, 1);
                this.deletedId.push(id);

                this.newIndex = this.dataMaterial.length + 1;
            }
        },
        watch : {
            'dataInput.quantity': function(newValue){
                this.dataInput.quantity = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            'editInput.quantity': function(newValue){
                this.editInput.quantity = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            'required_date': function(newValue){
                this.dataMaterial.forEach(data =>{
                    if(newValue != ''){
                        data.required_date = newValue;
                    }
                })
            },
            'dataInput.material_id': function(newValue){
                if(newValue != "" && newValue != null){
                    window.axios.get('/api/getMaterialPR/'+newValue).then(({ data }) => {
                        this.dataInput.material_name = data.description;
                        this.dataInput.material_code = data.code;
                        this.dataInput.unit = data.uom.unit;
                    });
                }else{
                    this.dataInput.material_name = "";
                    this.dataInput.material_code = "";
                    this.dataInput.unit = "";
                }
            },
            'dataInput.resource_id': function(newValue){
                if(newValue != "" && newValue != null){
                    window.axios.get('/api/getResourcePR/'+newValue).then(({ data }) => {
                        this.dataInput.resource_name = data.name;
                        this.dataInput.resource_code = data.code;
                        this.dataInput.unit = "-";
                    });
                }else{
                    this.dataInput.resource_name = "";
                    this.dataInput.resource_code = "";
                    this.dataInput.unit = "";
                }
            },
            'dataInput.project_id': function(newValue){
                if(newValue != "" && newValue != null){
                    window.axios.get('/api/getProjectPR/'+newValue).then(({ data }) => {
                        this.dataInput.project_number = data.number;
                    });
                }else{
                    this.dataInput.project_number = "-";
                }
            },
            'editInput.material_id': function(newValue){
                if(newValue != "" && newValue != null){
                    window.axios.get('/api/getMaterialPR/'+newValue).then(({ data }) => {
                        this.editInput.material_name = data.description;
                        this.editInput.material_code = data.code;
                        this.editInput.unit = data.uom.unit;
                    });
                }else{
                    this.editInput.material_name = "";
                    this.editInput.material_code = "";
                    this.editInput.unit = "";
                }
            },
            'editInput.resource_id': function(newValue){
                if(newValue != "" && newValue != null){
                    window.axios.get('/api/getResourcePR/'+newValue).then(({ data }) => {
                        this.editInput.resource_name = data.name;
                        this.editInput.resource_code = data.code;
                        this.editInput.unit = "-";
                    });
                }else{
                    this.editInput.resource_name = "";
                    this.editInput.resource_code = "";
                    this.editInput.unit = "";
                }
            },
            'editInput.project_id': function(newValue){
                if(newValue != "" && newValue != null){
                    window.axios.get('/api/getProjectPR/'+newValue).then(({ data }) => {
                        this.editInput.project_number = data.number;
                    });
                }else{
                    this.editInput.project_number = "-";
                }
            }
        },
        created: function() {
            var data = this.modelPRD;
            data.forEach(prd => {
                if(prd.required_date != null && prd.required_date != ''){
                    var date = prd.required_date;
                    prd.required_date = date.split("-").reverse().join("-");
                }
                prd.quantity = (prd.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                
                prd.prd_id = prd.id;

                this.dataMaterial.push(prd);
            });

            if(this.modelPR.type == 1){
                this.resource = "";
            }else if(this.modelPR.type == 2){
                this.resource = "ok";
            }

            this.clearData();
        },
    });
</script>
@endpush
