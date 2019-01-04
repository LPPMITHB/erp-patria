<?php

use Illuminate\Database\Seeder;
use App\Models\Menu; 

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        DB::table('menus')->insert([
            'level' => 1,
            'name' => 'Dashboard',
            'icon' => 'fa-dashboard',
            'route_name' => 'index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 1,
            'name' => 'Ship Building',
            'icon' => 'fa-ship',
            'is_active' => true,
            'roles' => 'ADMIN,PMP',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $building =  Menu::where('name','Ship Building')->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Project Management',
            'icon' => 'fa-calendar',
            'is_active' => true,
            'roles' => 'ADMIN,PMP',
            'menu_id'=> $building,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $projectManagementBuilding =  Menu::where('name','Project Management')->where('menu_id', $building)->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Manage Projects',
            'icon' => 'fa-calendar',
            'route_name'=> 'project.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP',
            'menu_id'=> $projectManagementBuilding,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Confirm Activity',
            'icon' => 'fa-clock-o',
            'route_name'=> 'activity.indexConfirm',
            'is_active' => true,
            'roles' => 'ADMIN,PMP',
            'menu_id'=> $projectManagementBuilding,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'WBS & Estimator Configuration',
            'icon' => 'fa-clock-o',
            'route_name'=> 'project.selectProjectConfig',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=> $projectManagementBuilding,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
        
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Bill Of Material',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PMP',
            'menu_id'=> $building,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $bom =  Menu::where('name','Bill Of Material')->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Manage BOM',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'bom.indexProject',
            'is_active' => true,
            'roles' => 'ADMIN,PMP',
            'menu_id'=> $bom,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

             DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View BOM',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'bom.selectProject',
            'is_active' => true,
            'roles' => 'ADMIN,PMP',
            'menu_id'=> $bom,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Cost Plan',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PMP',
            'menu_id'=> $building,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $costPlan =  Menu::where('name','Cost Plan')->select('id')->first()->id;
        // DB::table('menus')->insert([
        //     'level' => 3,
        //     'name' => 'Create RAP',
        //     'icon' => 'fa-file-text-o',
        //     'route_name'=> 'rap.selectProject',
        //     'is_active' => true,
        //     'roles' => 'ADMIN',
        //     'menu_id'=>$costPlan,
        //     'created_at' => date('Y-m-d'),
        //     'updated_at' => date('Y-m-d')
        // ]);
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Manage RAP',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'rap.indexSelectProject',
            'is_active' => true,
            'roles' => 'ADMIN,PMP',
            'menu_id'=>$costPlan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);  

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Create Other Cost',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'rap.selectProjectCost',
            'is_active' => true,
            'roles' => 'ADMIN,PMP',
            'menu_id'=>$costPlan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Input Actual Other Cost',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'rap.selectProjectActualOtherCost',
            'is_active' => true,
            'roles' => 'ADMIN,PMP',
            'menu_id'=>$costPlan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // DB::table('menus')->insert([
        //     'level' => 3,
        //     'name' => 'Assign Cost',
        //     'icon' => 'fa-file-text-o',
        //     'route_name'=> 'rap.selectProjectAssignCost',
        //     'is_active' => true,
        //     'roles' => 'ADMIN',
        //     'menu_id'=>$costPlan,
        //     'created_at' => date('Y-m-d'),
        //     'updated_at' => date('Y-m-d')
        // ]);


        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View Planned Cost',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'rap.selectProjectViewCost',
            'is_active' => true,
            'roles' => 'ADMIN,PMP',
            'menu_id'=>$costPlan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View Remaining Material',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'rap.selectProjectViewRM',
            'is_active' => true,
            'roles' => 'ADMIN,PMP',
            'menu_id'=>$costPlan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);


        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Material Management',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=> $building,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $materialManagement =  Menu::where('name','Material Management')->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Purchase Requisition',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$materialManagement,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);


        $purchaseRequisition =  Menu::where('name','Purchase Requisition')->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Create PR',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'purchase_requisition.create',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$purchaseRequisition,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Approve PR',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'purchase_requisition.indexApprove',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$purchaseRequisition,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View & Edit PR',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'purchase_requisition.index',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$purchaseRequisition,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

         DB::table('menus')->insert([
            'level' => 3,
            'name' => 'PR Consolidation',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'purchase_requisition.indexConsolidation',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$purchaseRequisition,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Purchase Order',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$materialManagement,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);


        $purchaseOrder =  Menu::where('name','Purchase Order')->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Create PO',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'purchase_order.selectPR',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$purchaseOrder,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // DB::table('menus')->insert([
        //     'level' => 3,
        //     'name' => 'Create PO Resource',
        //     'icon' => 'fa-file-text-o',
        //     'route_name'=> 'purchase_order.createPOResource',
        //     'is_active' => true,
        //     'roles' => 'ADMIN',
        //     'menu_id'=>$purchaseOrder,
        //     'created_at' => date('Y-m-d'),
        //     'updated_at' => date('Y-m-d')
        // ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Approve PO',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'purchase_order.indexApprove',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$purchaseOrder,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View & Edit PO',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'purchase_order.index',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$purchaseOrder,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);


        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Goods Receipt',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$materialManagement,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);


        $goodsReceipt =  Menu::where('name','Goods Receipt')->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Create GR',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'goods_receipt.createGrWithRef',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$goodsReceipt,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Create GR without reference',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'goods_receipt.createGrWithoutRef',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$goodsReceipt,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View GR',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'goods_receipt.index',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$goodsReceipt,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);


        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Material Requisition',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$materialManagement,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);


        $materialRequisition =  Menu::where('name','Material Requisition')->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Create MR',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'material_requisition.create',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$materialRequisition,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Approve MR',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'material_requisition.indexApprove',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$materialRequisition,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View & Edit MR',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'material_requisition.index',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$materialRequisition,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Goods Issue',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$materialManagement,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);


        $goodsIssue =  Menu::where('name','Goods Issue')->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Create GI with Reference',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'goods_issue.createGiWithRef',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$goodsIssue,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // DB::table('menus')->insert([
        //     'level' => 3,
        //     'name' => 'Create GI without Reference',
        //     'icon' => 'fa-file-text-o',
        //     'route_name'=> 'goods_issue.createGiWithoutRef',
        //     'is_active' => true,
        //     'roles' => 'ADMIN',
        //     'menu_id'=>$goodsIssue,
        //     'created_at' => date('Y-m-d'),
        //     'updated_at' => date('Y-m-d')
        // ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View GI',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'goods_issue.index',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$goodsIssue,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);


         DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Physical Inventory',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$materialManagement,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);


        $physicalInventory =  Menu::where('name','Physical Inventory')->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Snapshot',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'physical_inventory.indexSnapshot',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$physicalInventory,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);


        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Count Stock',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'physical_inventory.indexCountStock',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$physicalInventory,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);


        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Adjust Stock',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'physical_inventory.indexAdjustStock',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$physicalInventory,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);


        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Stock Management',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'stock_management.index',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$materialManagement,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Material Write Off',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'material_write_off.create',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$materialManagement,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Goods Movement',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'goods_movement.index',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$materialManagement,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Resource Management',
            'icon' => 'fa-database',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=> $building,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
        
        $resourcemanagement = Menu::where('name','Resource Management')->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Manage Resource',
            'icon' => 'fa-wrench',
            'route_name'=> 'resource.index',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=> $resourcemanagement,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Assign Resource',
            'icon' => 'fa-wrench',
            'route_name'=> 'resource.assignResource',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=> $resourcemanagement,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Production Planning & Execution',
            'icon' => 'fa-database',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=> $building,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $PPE =  Menu::where('name','Production Planning & Execution')->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Create Production Order',
            'icon' => 'fa-wrench',
            'route_name'=> 'production_order.selectProject',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$PPE,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Release Production Order',
            'icon' => 'fa-wrench',
            'route_name'=> 'production_order.selectProjectRelease',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$PPE,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Confirm Production Order',
            'icon' => 'fa-wrench',
            'route_name'=> 'production_order.selectProjectConfirm',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$PPE,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Production Order Actual Cost Report',
            'icon' => 'fa-wrench',
            'route_name'=> 'production_order.selectProjectReport',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$PPE,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Yard Plan',
            'icon' => 'fa-wrench',
            'route_name'=> 'yard_plan.index',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$PPE,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 1,
            'name' => 'Ship Repair',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $repair =  Menu::where('name','Ship Repair')->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Project Management',
            'icon' => 'fa-calendar',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id'=> $repair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $projectManagementRepair =  Menu::where('name','Project Management')->where('menu_id', $repair)->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Manage Projects',
            'icon' => 'fa-calendar',
            'route_name'=> 'project_repair.index',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id'=> $projectManagementRepair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Confirm Activity',
            'icon' => 'fa-clock-o',
            'route_name'=> 'activity_repair.indexConfirm',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id'=> $projectManagementRepair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'BOM / BOS',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id'=> $repair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $bomRepair =  Menu::where('name','BOM / BOS')->where('menu_id',$repair)->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Manage BOM / BOS',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'bom_repair.indexProject',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id'=> $bomRepair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View BOM / BOS',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'bom_repair.selectProject',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id'=> $bomRepair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Cost Plan',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id'=> $repair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $costPlan =  Menu::where('name','Cost Plan')->where('menu_id',$repair)->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Manage RAP',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'rap_repair.indexSelectProject',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id'=>$costPlan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);  

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Create Other Cost',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'rap_repair.selectProjectCost',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id'=>$costPlan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Input Actual Other Cost',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'rap_repair.selectProjectActualOtherCost',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id'=>$costPlan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View Planned Cost',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'rap_repair.selectProjectViewCost',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id'=>$costPlan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View Remaining Material',
            'icon' => 'fa-file-text-o',
            'route_name'=> 'rap_repair.selectProjectViewRM',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id'=>$costPlan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 1,
            'name' => 'Trading',
            'icon' => 'fa-archive',
            'is_active' => true,
            'roles' => 'ADMIN',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 1,
            'name' => 'Master Data',
            'icon' => 'fa-database',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);


        $masterData =  Menu::where('name','Master Data')->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Branch',
            'icon' => 'fa-wrench',
            'route_name'=> 'branch.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id'=>$masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Business Unit',
            'icon' => 'fa-wrench',
            'route_name'=> 'business_unit.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id'=>$masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Company',
            'icon' => 'fa-wrench',
            'route_name'=> 'company.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id'=>$masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Customer',
            'icon' => 'fa-wrench',
            'route_name'=> 'customer.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id'=>$masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Material',
            'icon' => 'fa-wrench',
            'route_name'=> 'material.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Service',
            'icon' => 'fa-wrench',
            'route_name'=> 'service.index',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Ship',
            'icon' => 'fa-wrench',
            'route_name'=> 'ship.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id'=>$masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Storage Location',
            'icon' => 'fa-wrench',
            'route_name'=> 'storage_location.index',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Unit Of Measurement',
            'icon' => 'fa-wrench',
            'route_name'=> 'unit_of_measurement.index',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id' => $masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Vendor',
            'icon' => 'fa-wrench',
            'route_name'=> 'vendor.index',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id' => $masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);


        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Warehouse',
            'icon' => 'fa-wrench',
            'route_name'=> 'warehouse.index',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id' => $masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Yard',
            'icon' => 'fa-wrench',
            'route_name'=> 'yard.index',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id' => $masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('menus')->insert([
            'level' => 1,
            'name' => 'Configuration',
            'icon' => 'fa-database',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $configuration =  Menu::where('name','Configuration')->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Menus',
            'icon' => 'fa-wrench',
            'route_name'=> 'menus.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id'=>$configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Appearance',
            'icon' => 'fa-wrench',
            'route_name'=> 'appearance.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id'=>$configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Currencies',
            'icon' => 'fa-wrench',
            'route_name'=> 'currencies.index',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id'=>$configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Change Default Password',
            'icon' => 'fa-wrench',
            'route_name'=> 'user.changeDefaultPassword',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id'=>$configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 1,
            'name' => 'User Management',
            'icon' => 'fa-users',
            'route_name'=> 'user.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 1,
            'name' => 'Role Management',
            'icon' => 'fa-user-secret',
            'route_name'=> 'role.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 1,
            'name' => 'Permission Management',
            'icon' => 'fa-ban',
            'route_name'=> 'permission.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
    }
}

