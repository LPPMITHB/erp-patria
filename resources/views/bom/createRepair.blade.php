@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Manage BOM / BOS',
        'items' => [
            'Dashboard' => route('index'),
            'Select Project' => route('bom_repair.indexProject'),
            'Select WBS' => route('bom_repair.selectWBS',$project->id),
            'Manage BOM/BOS' => '',
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body no-padding p-b-10">
                <form id="create-bom" class="form-horizontal" method="POST" action="{{ route('bom_repair.store') }}">
                @csrf
                    @verbatim
                    <div id="bom">
                        <div class="box-header p-b-0">
                            <div class="col-xs-12 col-md-4">
                                <div class="col-sm-12 no-padding"><b>Project Information</b></div>
        
                                <div class="col-xs-4 no-padding">Project Code</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(project.number)"><b>: {{project.number}}</b></div>
                                
                                <div class="col-xs-4 no-padding">Ship Name</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(project.name)"><b>: {{project.name}}</b></div>
        
                                <div class="col-xs-4 no-padding">Ship Type</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(project.ship.type)"><b>: {{project.ship.type}}</b></div>
        
                                <div class="col-xs-4 no-padding">Customer</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(project.customer.name)"><b>: {{project.customer.name}}</b></div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                            
                                <div class="col-xs-4 no-padding">Code</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.code)"><b>: {{wbs.code}}</b></div>
                                
                                <div class="col-xs-4 no-padding">Name</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.number)"><b>: {{wbs.number}}</b></div>
        
                                <div class="col-xs-4 no-padding">Description</div>
                                <div v-if="wbs.description != ''" class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.description)"><b>: {{wbs.description}}</b></div>
                                <div v-else class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.description)"><b>: -</b></div>
        
                                <div class="col-xs-4 no-padding">Deliverable</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.deliverables)"><b>: {{wbs.deliverables}}</b></div>
        
                                <div class="col-xs-4 no-padding">Progress</div>
                                <div class="col-xs-8 no-padding tdEllipsis" v-tooltip:top="tooltipText(wbs.progress)"><b>: {{wbs.progress}}%</b></div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="col-xs-12 no-padding"><b>BOM Description</b></div>
                                <div class="col-xs-12 no-padding">
                                    <textarea class="form-control" rows="3" v-model="submittedForm.description"></textarea>  
                                </div>
                            </div>
                            
                        </div> <!-- /.box-header -->
                        <div class="col-md-12 p-t-20">
                            <table class="table table-bordered tableFixed">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Type</th>
                                        <th width="30%">Material / Service</th>
                                        <th width="30%">Description</th>
                                        <th width="10%">Quantity</th>
                                        <th width="10%" ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in dataTable">
                                        <td class="tdEllipsis">{{ index + 1 }}</td>
                                        <td class="tdEllipsis">{{ data.type }}</td>
                                        <td class="tdEllipsis" v-if="data.type == 'Material'">{{ data.material_code }} - {{ data.material_name }}</td>
                                        <td class="tdEllipsis" v-else-if="data.type == 'Service'">{{ data.service_code }} - {{ data.service_name }}</td>
                                        <td class="tdEllipsis">{{ data.description }}</td>
                                        <td class="tdEllipsis">{{ data.quantity }}</td>
                                        <td class="tdEllipsis p-l-5" align="center">
                                            <a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(data,index)">
                                                EDIT
                                            </a>
                                            <a href="#" @click="removeRow(data.material_id,data.type)" class="btn btn-danger btn-xs">
                                                <div class="btn-group">DELETE</div>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{newIndex}}</td>
                                        <td class="no-padding">
                                            <selectize id="type" v-model="input.type" :settings="typeSettings">
                                                <option v-for="(type, index) in types" :value="type">{{ type }}</option>
                                            </selectize>    
                                        </td>
                                        <td class="no-padding" v-if="input.type == ''">
                                            <input class="form-control" type="text" disabled placeholder="Please select type first">  
                                        </td>
                                        <td class="no-padding" v-else-if="input.type == 'Material'">
                                            <selectize id="material" v-model="input.material_id" :settings="materialSettings">
                                                <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.name }}</option>
                                            </selectize>    
                                        </td>
                                        <td class="no-padding" v-else-if="input.type == 'Service'">
                                            <selectize id="service" v-model="input.service_id" :settings="serviceSettings">
                                                <option v-for="(service, index) in services" :value="service.id">{{ service.code }} - {{ service.name }}</option>
                                            </selectize>    
                                        </td>
                                        <td class="no-padding"><input class="form-control" type="text" :value="input.description" disabled></td>
                                        <td class="no-padding"><input class="form-control" type="text" v-model="input.quantity"></td>
                                        <td class="p-l-0" align="center"><a @click.prevent="submitToTable()" :disabled="inputOk" class="btn btn-primary btn-xs" href="#">
                                            <div class="btn-group">
                                                ADD
                                            </div></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <button id="process" @click.prevent="submitForm()" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
                        </div>
                        <div class="modal fade" id="edit_item">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title" v-show="editInput.type == 'Material'">Edit Material</h4>
                                        <h4 class="modal-title" v-show="editInput.type == 'Service'">Edit Service</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12" v-show="editInput.type == 'Material'">
                                                <label for="type" class="control-label">Material</label>
                                                <selectize id="edit_modal" v-model="editInput.material_id" :settings="materialSettings">
                                                    <option v-for="(material, index) in materials_modal" :value="material.id">{{ material.code }} - {{ material.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12" v-show="editInput.type == 'Service'">
                                                <label for="type" class="control-label">Service</label>
                                                <selectize id="edit_modal" v-model="editInput.service_id" :settings="serviceSettings">
                                                    <option v-for="(service, index) in services_modal" :value="service.id">{{ service.code }} - {{ service.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="quantity" class="control-label">Quantity</label>
                                                <input type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" v-show="editInput.type == 'Material'">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update(editInput.old_material_id, editInput.material_id)">SAVE</button>
                                    </div>
                                    <div class="modal-footer" v-show="editInput.type == 'Service'">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update(editInput.old_service_id, editInput.service_id)">SAVE</button>
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
        submit: "ok",
        types : ['Material','Service'],
        project : @json($project),
        materials : @json($materials),
        services : @json($services),
        wbs : @json($wbs),
        newIndex : 0, 
        submittedForm :{
            project_id : "",
            wbs_id : "",
            description : ""
        },
        input : {
            material_id : "",
            service_id : "",
            material_name : "",
            material_code : "",
            description : "",
            quantity : "",
            quantityInt : 0,
            type : "",
        },
        editInput : {
            old_material_id : "",
            old_service_id : "",
            service_id : "",
            material_id : "",
            material_code : "",
            material_name : "",
            service_code : "",
            service_name : "",
            quantity : "",
            quantityInt : 0,
        },
        dataTable : [],
        materialSettings: {
            placeholder: 'Please Select Material'
        },
        serviceSettings: {
            placeholder: 'Please Select Service'
        },
        typeSettings: {
            placeholder: 'Please Select Type'
        },
        material_id:[],
        material_id_modal:[],
        materials_modal :[],
        service_id:[],
        service_id_modal:[],
        services_modal :[],
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

                var string_newValue = this.input.quantityInt+"";
                this.input.quantityInt = parseInt(string_newValue.replace(/,/g , ''));
                if(this.input.type == ""){
                    isOk = true;
                }else{
                    if(this.input.type == "Material"){
                        if(this.input.material_id == "" || this.input.material_name == "" || this.input.description == "" || this.input.quantity == "" || this.input.quantityInt < 1){
                            isOk = true;
                        }
                    }else if(this.input.type == "Service"){
                        if(this.input.service_id == "" || this.input.service_name == "" || this.input.description == "" || this.input.quantity == "" || this.input.quantityInt < 1){
                            isOk = true;
                        }
                    }
                }
                return isOk;
            },
            createOk: function(){
                let isOk = false;

                if(this.dataTable.length < 1 || this.submit == ""){
                    isOk = true;
                }
                return isOk;
            },
            updateOk: function(){
                let isOk = false;

                var string_newValue = this.editInput.quantityInt+"";
                this.editInput.quantityInt = parseInt(string_newValue.replace(/,/g , ''));
                if(this.editInput.type == "Material"){
                    if(this.editInput.material_id == "" || this.editInput.quantityInt == ""){
                        isOk = true;
                    }
                }else if(this.editInput.type == "Service"){
                    if(this.editInput.service_id == "" || this.editInput.quantityInt == ""){
                        isOk = true;
                    }
                }
                return isOk;
            }
        },
        methods: {
            tooltipText: function(text) {
                return text
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
            getNewServices(jsonServiceId){
                window.axios.get('/api/getServicesBOM/'+jsonServiceId).then(({ data }) => {
                    this.services = data;
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
            getNewModalServices(jsonServiceId){
                window.axios.get('/api/getServicesBOM/'+jsonServiceId).then(({ data }) => {
                    this.services_modal = data;
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
                this.editInput.quantity = data.quantity;
                this.editInput.quantityInt = data.quantityInt;
                this.editInput.wbs_id = data.wbs_id;
                this.editInput.wbs_number = data.wbs_number;
                this.editInput.index = index;
                this.editInput.type = data.type;

                if(data.type == "Material"){
                    this.editInput.material_id = data.material_id;
                    this.editInput.old_material_id = data.material_id;
                    this.editInput.material_code = data.material_code;
                    this.editInput.material_name = data.material_name;

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
                }else if(data.type == "Service"){
                    this.editInput.service_id = data.service_id;
                    this.editInput.old_service_id = data.service_id;
                    this.editInput.service_code = data.service_code;
                    this.editInput.service_name = data.service_name;

                    var service_id = JSON.stringify(this.service_id);
                    service_id = JSON.parse(service_id);
                    
                    this.service_id_modal = service_id;
                    this.service_id_modal.forEach(id => {
                        if(id == data.service_id){
                            var index = this.service_id_modal.indexOf(id);
                            this.service_id_modal.splice(index, 1);
                        }
                    });
                    var jsonServiceId = JSON.stringify(this.service_id_modal);
                    this.getNewModalServices(jsonServiceId);
                }
            },
            submitForm(){
                this.submit = "";
                this.submittedForm.materials = this.dataTable;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            submitToTable(){
                if(this.input.type == "Material"){
                    if(this.input.material_id != "" && this.input.material_name != "" && this.input.description != "" && this.input.quantity != "" && this.input.quantityInt > 0){
                        var data = JSON.stringify(this.input);
                        data = JSON.parse(data);
                        this.dataTable.push(data);

                        this.material_id.push(data.material_id); //ini buat nambahin material_id terpilih

                        var jsonMaterialId = JSON.stringify(this.material_id);
                        this.getNewMaterials(jsonMaterialId);             

                        this.newIndex = this.dataTable.length + 1;  

                        this.input.description = "";
                        this.input.type = "";
                        this.input.material_id = "";
                        this.input.material_code = "";
                        this.input.material_name = "";
                        this.input.quantity = "";
                        this.input.quantityInt = 0;
                    }
                }else if(this.input.type == "Service"){
                    if(this.input.service_id != "" && this.input.service_name != "" && this.input.description != "" && this.input.quantity != "" && this.input.quantityInt > 0){
                        var data = JSON.stringify(this.input);
                        data = JSON.parse(data);
                        this.dataTable.push(data);

                        this.service_id.push(data.service_id); //ini buat nambahin service_id terpilih

                        var jsonServiceId = JSON.stringify(this.service_id);
                        this.getNewServices(jsonServiceId);             

                        this.newIndex = this.dataTable.length + 1;  

                        this.input.description = "";
                        this.input.type = "";
                        this.input.service_id = "";
                        this.input.service_code = "";
                        this.input.service_name = "";
                        this.input.quantity = "";
                        this.input.quantityInt = 0;
                    }
                }
            },
            removeRow: function(dataId,type) {
                if(type == "Material"){
                    var index_materialId = "";
                    var index_dataTable = "";

                    this.material_id.forEach(id => {
                        if(id == dataId){
                            index_materialId = this.material_id.indexOf(id);
                        }
                    });
                    for (var i in this.dataTable) { 
                        if(this.dataTable[i].material_id == dataId){
                            index_dataTable = i;
                        }
                    }

                    this.dataTable.splice(index_dataTable, 1);
                    this.material_id.splice(index_materialId, 1);
                    this.newIndex = this.dataTable.length + 1;

                    var jsonMaterialId = JSON.stringify(this.material_id);
                    this.getNewMaterials(jsonMaterialId);
                }else if(type == "Service"){
                    var index_serviceId = "";
                    var index_dataTable = "";

                    this.service_id.forEach(id => {
                        if(id == dataId){
                            index_serviceId = this.service_id.indexOf(id);
                        }
                    });
                    for (var i in this.dataTable) { 
                        if(this.dataTable[i].material_id == dataId){
                            index_dataTable = i;
                        }
                    }

                    this.dataTable.splice(index_dataTable, 1);
                    this.service_id.splice(index_serviceId, 1);
                    this.newIndex = this.dataTable.length + 1;

                    var jsonServiceId = JSON.stringify(this.service_id);
                    this.getNewServices(jsonServiceId);
                }
            },
            update(old_data_id, new_data_id){
                if(this.editInput.type == "Material"){
                    this.dataTable.forEach(material => {
                        if(material.material_id == old_data_id){
                            var material = this.dataTable[this.editInput.index];
                            material.quantityInt = this.editInput.quantityInt;
                            material.quantity = this.editInput.quantity;
                            material.material_id = new_data_id;
                            material.wbs_id = this.editInput.wbs_id;

                            window.axios.get('/api/getMaterialBOM/'+new_data_id).then(({ data }) => {
                                material.material_name = data.name;
                                material.material_code = data.code;
                                material.description = data.description;

                                this.material_id.forEach(id => {
                                    if(id == old_data_id){
                                        var index = this.material_id.indexOf(id);
                                        this.material_id.splice(index, 1);
                                    }
                                });
                                this.material_id.push(new_data_id);

                                var jsonMaterialId = JSON.stringify(this.material_id);
                                this.getNewMaterials(jsonMaterialId);

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
                    this.editInput.material_id = '';
                    this.editInput.old_material_id = '';
                    this.editInput.material_code = '';
                    this.editInput.material_name = '';
                }else if(this.editInput.type == "Service"){
                    this.dataTable.forEach(service => {
                        if(service.service_id == old_data_id){
                            var service = this.dataTable[this.editInput.index];
                            service.quantityInt = this.editInput.quantityInt;
                            service.quantity = this.editInput.quantity;
                            service.service_id = new_data_id;
                            service.wbs_id = this.editInput.wbs_id;

                            window.axios.get('/api/getServiceBOM/'+new_data_id).then(({ data }) => {
                                service.service_name = data.name;
                                service.service_code = data.code;
                                service.description = data.description;

                                this.service_id.forEach(id => {
                                    if(id == old_data_id){
                                        var index = this.service_id.indexOf(id);
                                        this.service_id.splice(index, 1);
                                    }
                                });
                                this.service_id.push(new_data_id);

                                var jsonServiceId = JSON.stringify(this.service_id);
                                this.getNewServices(jsonServiceId);

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
                    this.editInput.service_id = '';
                    this.editInput.old_service_id = '';
                    this.editInput.service_code = '';
                    this.editInput.service_name = '';
                }
            },
        },
        watch: {
            'input.material_id': function(newValue){
                if(newValue != ""){
                    window.axios.get('/api/getMaterialBOM/'+newValue).then(({ data }) => {
                        if(data.description == "" || data.description == null){
                            this.input.description = '-';
                        }else{
                            this.input.description = data.description;

                        }
                        this.input.material_name = data.name;
                        this.input.material_code = data.code;
                    });
                }
            },
            'input.service_id': function(newValue){
                if(newValue != ""){
                    window.axios.get('/api/getServiceBOM/'+newValue).then(({ data }) => {
                        if(data.description == "" || data.description == null){
                            this.input.description = '-';
                        }else{
                            this.input.description = data.description;
                        }
                        this.input.service_name = data.name;
                        this.input.service_code = data.code;
                    });
                }
            },
            'input.quantity': function(newValue){
                this.input.quantityInt = newValue;
                this.input.quantity = (this.input.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
            },
            'editInput.quantity': function(newValue){
                this.editInput.quantityInt = newValue;
                this.editInput.quantity = (this.editInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
            },
            'input.type' : function(newValue){
                this.input.material_id = "";
                this.input.material_name = "";
                this.input.description = "";
            }
        },
        created: function() {
            this.submittedForm.project_id = this.project.id;
            this.submittedForm.wbs_id = this.wbs.id;          

            this.newIndex = this.dataTable.length + 1;
        }
    });
       
</script>
@endpush
