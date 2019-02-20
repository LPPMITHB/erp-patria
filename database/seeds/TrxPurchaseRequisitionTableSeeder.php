<?php

use Illuminate\Database\Seeder;

class TrxPurchaseRequisitionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_purchase_requisition')->delete();
        
        \DB::table('trx_purchase_requisition')->insert(array (
            0 => 
            array (
                'id' => 1,
                'number' => 'PR-1900001',
                'type' => 1,
                'project_id' => 2,
                'bom_id' => NULL, // 4
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 2,
                'description' => 'AUTO PR FOR PRO2-DUMMY2',
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => '2019-01-15 09:57:54',
                'updated_at' => '2019-01-15 09:57:54',
            ),
            1 => 
            array (
                'id' => 2,
                'number' => 'PR-1900002',
                'type' => 1,
                'project_id' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
                'description' => 'PR DUMMY 1',
                'status' => 1,
                'branch_id' => 2,
                'user_id' => 1,
                'created_at' => '2019-01-17 04:30:38',
                'updated_at' => '2019-01-17 04:30:38',
            ),
            2 => 
            array (
                'id' => 3,
                'number' => 'PR-1900003',
                'type' => 2,
                'project_id' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
                'description' => 'PR DUMMY 2 (RESOURCE)',
                'status' => 1,
                'branch_id' => 2,
                'user_id' => 1,
                'created_at' => '2019-01-17 04:31:13',
                'updated_at' => '2019-01-17 04:31:13',
            ),
            3 => 
            array (
                'id' => 4,
                'number' => 'PR-1900004',
                'type' => 1,
                'project_id' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
                'description' => 'PR DUMMY 3 -> PO',
                'status' => 0,
                'branch_id' => 2,
                'user_id' => 1,
                'created_at' => '2019-01-17 04:33:59',
                'updated_at' => '2019-01-17 06:50:05',
            ),
            4 => 
            array (
                'id' => 5,
                'number' => 'PR-1900005',
                'type' => 2,
                'project_id' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
                'description' => 'PR DUMMY 4 -> PO',
                'status' => 7,
                'branch_id' => 2,
                'user_id' => 1,
                'created_at' => '2019-01-17 04:34:34',
                'updated_at' => '2019-01-17 04:35:44',
            ),
            5 => 
            array (
                'id' => 6,
                'number' => 'PR-1900006',
                'type' => 1,
                'project_id' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 2,
                'description' => 'PR DUMMY PAMI 1',
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => '2019-01-17 04:40:37',
                'updated_at' => '2019-01-17 04:40:37',
            ),
            6 => 
            array (
                'id' => 7,
                'number' => 'PR-1900007',
                'type' => 2,
                'project_id' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 2,
                'description' => 'PR DUMMY PAMI 2 (RESOURCE)',
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => '2019-01-17 04:41:15',
                'updated_at' => '2019-01-17 04:41:15',
            ),
            7 => 
            array (
                'id' => 8,
                'number' => 'PR-1900008',
                'type' => 1,
                'project_id' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 2,
                'description' => 'PR DUMMY PAMI 3 -> PO',
                'status' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => '2019-01-17 04:42:14',
                'updated_at' => '2019-01-17 04:44:06',
            ),
            8 => 
            array (
                'id' => 9,
                'number' => 'PR-1900009',
                'type' => 2,
                'project_id' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 2,
                'description' => 'PR DUMMY PAMI 4 -> PO (RESOURCE)',
                'status' => 7,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => '2019-01-17 04:42:47',
                'updated_at' => '2019-01-17 04:44:29',
            ),
            9 => 
            array (
                'id' => 10,
                'number' => 'PR-1900010',
                'type' => 1,
                'project_id' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
                'description' => 'PR DUMMY 6',
                'status' => 2,
                'branch_id' => 2,
                'user_id' => 1,
                'created_at' => '2019-01-17 06:51:04',
                'updated_at' => '2019-01-17 06:51:14',
            ),
            10 => 
            array (
                'id' => 11,
                'number' => 'PR-1900011',
                'type' => 2,
                'project_id' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
                'description' => 'PR DUMMY 5 (RESOURCE)',
                'status' => 2,
                'branch_id' => 2,
                'user_id' => 1,
                'created_at' => '2019-01-17 06:52:06',
                'updated_at' => '2019-01-17 06:52:12',
            ),
            11 => 
            array (
                'id' => 12,
                'number' => 'PR-1900012',
                'type' => 1,
                'project_id' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
                'description' => 'PR DUMMY  7',
                'status' => 0,
                'branch_id' => 2,
                'user_id' => 1,
                'created_at' => '2019-01-17 06:53:05',
                'updated_at' => '2019-01-17 06:55:05',
            ),
            12 => 
            array (
                'id' => 13,
                'number' => 'PR-1900013',
                'type' => 2,
                'project_id' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
                'description' => 'PR DUMMY 8 (RESOURCE)',
                'status' => 0,
                'branch_id' => 2,
                'user_id' => 1,
                'created_at' => '2019-01-17 06:53:57',
                'updated_at' => '2019-01-17 06:55:38',
            ),
            13 => 
            array (
                'id' => 14,
                'number' => 'PR-1900014',
                'type' => 1,
                'project_id' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 2,
                'description' => 'PR DUMMY PAMI 5',
                'status' => 2,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => '2019-01-17 06:58:29',
                'updated_at' => '2019-01-17 06:59:23',
            ),
            14 => 
            array (
                'id' => 15,
                'number' => 'PR-1900015',
                'type' => 2,
                'project_id' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 2,
                'description' => 'PR DUMMY PAMI 6 (RESOURCE)',
                'status' => 2,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => '2019-01-17 06:59:14',
                'updated_at' => '2019-01-17 06:59:27',
            ),
            15 => 
            array (
                'id' => 16,
                'number' => 'PR-1900016',
                'type' => 1,
                'project_id' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 2,
                'description' => 'PR DUMMY PAMI 7',
                'status' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => '2019-01-17 07:00:13',
                'updated_at' => '2019-01-17 07:01:56',
            ),
            16 => 
            array (
                'id' => 17,
                'number' => 'PR-1900017',
                'type' => 2,
                'project_id' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 2,
                'description' => 'PR DUMMY PAMI 8 (RESOURCE)',
                'status' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => '2019-01-17 07:00:58',
                'updated_at' => '2019-01-17 07:02:17',
            ),
        ));
        
        
    }
}