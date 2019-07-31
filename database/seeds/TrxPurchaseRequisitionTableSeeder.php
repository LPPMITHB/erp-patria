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
                'id' => 2,
                'number' => 'PR-1900002',
                'required_date' => '2019-03-01',
                'type' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
                'description' => 'PR DUMMY PMP 1',
                'revision_description' => NULL,
                'status' => 1,
                'branch_id' => 2,
                'user_id' => 1,
                'approved_by' => NULL,
                'approval_date' => NULL,
                'created_at' => '2019-01-17 04:30:38',
                'updated_at' => '2019-01-17 04:30:38',
            ),
            1 => 
            array (
                'id' => 3,
                'number' => 'PR-1900003',
                'required_date' => '2019-03-01',
                'type' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
            'description' => 'PR DUMMY PMP 2 (RESOURCE)',
                'revision_description' => NULL,
                'status' => 1,
                'branch_id' => 2,
                'user_id' => 1,
                'approved_by' => NULL,
                'approval_date' => NULL,
                'created_at' => '2019-01-17 04:31:13',
                'updated_at' => '2019-01-17 04:31:13',
            ),
            2 => 
            array (
                'id' => 4,
                'number' => 'PR-1900004',
                'required_date' => '2019-03-01',
                'type' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
                'description' => 'PR DUMMY PMP 3 -> PO',
                'revision_description' => NULL,
                'status' => 0,
                'branch_id' => 2,
                'user_id' => 1,
                'approved_by' => 2,
                'approval_date' => NULL,
                'created_at' => '2019-01-17 04:33:59',
                'updated_at' => '2019-01-17 06:50:05',
            ),
            3 => 
            array (
                'id' => 5,
                'number' => 'PR-1900005',
                'required_date' => '2019-03-01',
                'type' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
                'description' => 'PR DUMMY PMP 4 -> PO',
                'revision_description' => NULL,
                'status' => 7,
                'branch_id' => 2,
                'user_id' => 1,
                'approved_by' => 2,
                'approval_date' => NULL,
                'created_at' => '2019-01-17 04:34:34',
                'updated_at' => '2019-01-17 04:35:44',
            ),
            4 => 
            array (
                'id' => 6,
                'number' => 'PR-1900006',
                'required_date' => '2019-03-01',
                'type' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 2,
                'description' => 'PR DUMMY PAMI 1',
                'revision_description' => NULL,
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 1,
                'approved_by' => NULL,
                'approval_date' => NULL,
                'created_at' => '2019-01-17 04:40:37',
                'updated_at' => '2019-01-17 04:40:37',
            ),
            5 => 
            array (
                'id' => 7,
                'number' => 'PR-1900007',
                'required_date' => '2019-03-01',
                'type' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 2,
            'description' => 'PR DUMMY PAMI 2 (RESOURCE)',
                'revision_description' => NULL,
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 1,
                'approved_by' => NULL,
                'approval_date' => NULL,
                'created_at' => '2019-01-17 04:41:15',
                'updated_at' => '2019-01-17 04:41:15',
            ),
            6 => 
            array (
                'id' => 8,
                'number' => 'PR-1900008',
                'required_date' => '2019-03-01',
                'type' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 2,
                'description' => 'PR DUMMY PAMI 3 -> PO',
                'revision_description' => NULL,
                'status' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'approved_by' => 3,
                'approval_date' => NULL,
                'created_at' => '2019-01-17 04:42:14',
                'updated_at' => '2019-01-17 04:44:06',
            ),
            7 => 
            array (
                'id' => 9,
                'number' => 'PR-1900009',
                'required_date' => '2019-03-01',
                'type' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 2,
            'description' => 'PR DUMMY PAMI 4 -> PO (RESOURCE)',
                'revision_description' => NULL,
                'status' => 7,
                'branch_id' => 1,
                'user_id' => 1,
                'approved_by' => 3,
                'approval_date' => NULL,
                'created_at' => '2019-01-17 04:42:47',
                'updated_at' => '2019-01-17 04:44:29',
            ),
            8 => 
            array (
                'id' => 10,
                'number' => 'PR-1900010',
                'required_date' => '2019-03-01',
                'type' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
                'description' => 'PR DUMMY PMP 5',
                'revision_description' => NULL,
                'status' => 2,
                'branch_id' => 2,
                'user_id' => 1,
                'approved_by' => 2,
                'approval_date' => NULL,
                'created_at' => '2019-01-17 06:51:04',
                'updated_at' => '2019-01-17 06:51:14',
            ),
            9 => 
            array (
                'id' => 11,
                'number' => 'PR-1900011',
                'required_date' => '2019-03-01',
                'type' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
            'description' => 'PR DUMMY PMP 6 (RESOURCE)',
                'revision_description' => NULL,
                'status' => 2,
                'branch_id' => 2,
                'user_id' => 1,
                'approved_by' => 2,
                'approval_date' => NULL,
                'created_at' => '2019-01-17 06:52:06',
                'updated_at' => '2019-01-17 06:52:12',
            ),
            10 => 
            array (
                'id' => 12,
                'number' => 'PR-1900012',
                'required_date' => '2019-03-01',
                'type' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
                'description' => 'PR DUMMY PMP 7',
                'revision_description' => NULL,
                'status' => 0,
                'branch_id' => 2,
                'user_id' => 1,
                'approved_by' => 2,
                'approval_date' => NULL,
                'created_at' => '2019-01-17 06:53:05',
                'updated_at' => '2019-01-17 06:55:05',
            ),
            11 => 
            array (
                'id' => 13,
                'number' => 'PR-1900013',
                'required_date' => '2019-03-01',
                'type' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
            'description' => 'PR DUMMY PMP 8 (RESOURCE)',
                'revision_description' => NULL,
                'status' => 0,
                'branch_id' => 2,
                'user_id' => 1,
                'approved_by' => 2,
                'approval_date' => NULL,
                'created_at' => '2019-01-17 06:53:57',
                'updated_at' => '2019-01-17 06:55:38',
            ),
            12 => 
            array (
                'id' => 14,
                'number' => 'PR-1900014',
                'required_date' => '2019-03-01',
                'type' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 2,
                'description' => 'PR DUMMY PAMI 5',
                'revision_description' => NULL,
                'status' => 2,
                'branch_id' => 1,
                'user_id' => 1,
                'approved_by' => 3,
                'approval_date' => NULL,
                'created_at' => '2019-01-17 06:58:29',
                'updated_at' => '2019-01-17 06:59:23',
            ),
            13 => 
            array (
                'id' => 15,
                'number' => 'PR-1900015',
                'required_date' => '2019-03-01',
                'type' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 2,
            'description' => 'PR DUMMY PAMI 6 (RESOURCE)',
                'revision_description' => NULL,
                'status' => 2,
                'branch_id' => 1,
                'user_id' => 1,
                'approved_by' => 3,
                'approval_date' => NULL,
                'created_at' => '2019-01-17 06:59:14',
                'updated_at' => '2019-01-17 06:59:27',
            ),
            14 => 
            array (
                'id' => 16,
                'number' => 'PR-1900016',
                'required_date' => '2019-03-01',
                'type' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 2,
                'description' => 'PR DUMMY PAMI 7',
                'revision_description' => NULL,
                'status' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'approved_by' => 3,
                'approval_date' => NULL,
                'created_at' => '2019-01-17 07:00:13',
                'updated_at' => '2019-01-17 07:01:56',
            ),
            15 => 
            array (
                'id' => 17,
                'number' => 'PR-1900017',
                'required_date' => '2019-03-01',
                'type' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 2,
            'description' => 'PR DUMMY PAMI 8 (RESOURCE)',
                'revision_description' => NULL,
                'status' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'approved_by' => 3,
                'approval_date' => NULL,
                'created_at' => '2019-01-17 07:00:58',
                'updated_at' => '2019-01-17 07:02:17',
            ),
            16 => 
            array (
                'id' => 18,
                'number' => 'PR-1900018',
                'required_date' => NULL,
                'type' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
                'description' => 'PR DUMMY PIR 1',
                'revision_description' => '',
                'status' => 0,
                'branch_id' => 1,
                'user_id' => 2,
                'approved_by' => 2,
                'approval_date' => NULL,
                'created_at' => '2019-03-08 17:45:18',
                'updated_at' => '2019-03-08 17:49:53',
            ),
            17 => 
            array (
                'id' => 19,
                'number' => 'PR-1900019',
                'required_date' => NULL,
                'type' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
                'description' => 'PR DUMMY PIR 2',
                'revision_description' => '',
                'status' => 0,
                'branch_id' => 1,
                'user_id' => 2,
                'approved_by' => 2,
                'approval_date' => NULL,
                'created_at' => '2019-03-08 17:47:11',
                'updated_at' => '2019-03-08 17:52:26',
            ),
            18 => 
            array (
                'id' => 20,
                'number' => 'PR-1900020',
                'required_date' => NULL,
                'type' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 2,
                'description' => 'PR DUMMY PIR PAMI 1',
                'revision_description' => '',
                'status' => 0,
                'branch_id' => 2,
                'user_id' => 3,
                'approved_by' => 3,
                'approval_date' => NULL,
                'created_at' => '2019-03-08 17:54:58',
                'updated_at' => '2019-03-08 17:57:17',
            ),
            19 => 
            array (
                'id' => 21,
                'number' => 'PR-1900021',
                'required_date' => NULL,
                'type' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 2,
                'description' => 'PR DUMMY PIR PAMI 2',
                'revision_description' => '',
                'status' => 0,
                'branch_id' => 2,
                'user_id' => 3,
                'approved_by' => 3,
                'approval_date' => NULL,
                'created_at' => '2019-03-08 17:55:37',
                'updated_at' => '2019-03-08 17:58:31',
            ),
            20 => 
            array (
                'id' => 22,
                'number' => 'PR-1900022',
                'required_date' => NULL,
                'type' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
                'description' => 'Test',
                'revision_description' => '',
                'status' => 0,
                'branch_id' => 1,
                'user_id' => 2,
                'approved_by' => 2,
                'approval_date' => '2019-07-29',
                'created_at' => '2019-07-29 16:48:38',
                'updated_at' => '2019-07-29 16:49:13',
            ),
            21 => 
            array (
                'id' => 23,
                'number' => 'PR-1900023',
                'required_date' => NULL,
                'type' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
                'description' => '',
                'revision_description' => '',
                'status' => 0,
                'branch_id' => 1,
                'user_id' => 2,
                'approved_by' => 2,
                'approval_date' => '2019-07-29',
                'created_at' => '2019-07-29 16:58:40',
                'updated_at' => '2019-07-29 16:59:00',
            ),
        ));
        
        
    }
}