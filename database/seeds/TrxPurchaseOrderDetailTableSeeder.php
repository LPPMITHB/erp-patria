<?php

use Illuminate\Database\Seeder;

class TrxPurchaseOrderDetailTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_purchase_order_detail')->delete();
        
        \DB::table('trx_purchase_order_detail')->insert(array (
            0 => 
            array (
                'id' => 25,
                'purchase_order_id' => 9,
                'purchase_requisition_detail_id' => 62,
                'discount' => 0.0,
                'quantity' => 15.5,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => 1780,
                'resource_id' => NULL,
                'project_id' => 1,
                'total_price' => 1550000.0,
                'delivery_date' => '2019-03-14',
                'created_at' => '2019-03-08 17:49:52',
                'updated_at' => '2019-03-08 17:49:52',
            ),
            1 => 
            array (
                'id' => 26,
                'purchase_order_id' => 9,
                'purchase_requisition_detail_id' => 63,
                'discount' => 0.0,
                'quantity' => 25.0,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => 293,
                'resource_id' => NULL,
                'project_id' => 1,
                'total_price' => 6250000.0,
                'delivery_date' => '2019-03-14',
                'created_at' => '2019-03-08 17:49:52',
                'updated_at' => '2019-03-08 17:49:52',
            ),
            2 => 
            array (
                'id' => 27,
                'purchase_order_id' => 9,
                'purchase_requisition_detail_id' => 64,
                'discount' => 0.0,
                'quantity' => 5.0,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => 10,
                'resource_id' => NULL,
                'project_id' => 1,
                'total_price' => 2500000.0,
                'delivery_date' => '2019-03-13',
                'created_at' => '2019-03-08 17:49:53',
                'updated_at' => '2019-03-08 17:49:53',
            ),
            3 => 
            array (
                'id' => 28,
                'purchase_order_id' => 9,
                'purchase_requisition_detail_id' => 65,
                'discount' => 0.0,
                'quantity' => 7.0,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => 316,
                'resource_id' => NULL,
                'project_id' => 1,
                'total_price' => 385000.0,
                'delivery_date' => '2019-03-15',
                'created_at' => '2019-03-08 17:49:53',
                'updated_at' => '2019-03-08 17:49:53',
            ),
            4 => 
            array (
                'id' => 29,
                'purchase_order_id' => 9,
                'purchase_requisition_detail_id' => 66,
                'discount' => 0.0,
                'quantity' => 3.0,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => 1130,
                'resource_id' => NULL,
                'project_id' => 1,
                'total_price' => 75000.0,
                'delivery_date' => '2019-03-14',
                'created_at' => '2019-03-08 17:49:53',
                'updated_at' => '2019-03-08 17:49:53',
            ),
            5 => 
            array (
                'id' => 30,
                'purchase_order_id' => 9,
                'purchase_requisition_detail_id' => 67,
                'discount' => 0.0,
                'quantity' => 8.0,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => 1070,
                'resource_id' => NULL,
                'project_id' => 1,
                'total_price' => 600000.0,
                'delivery_date' => '2019-03-12',
                'created_at' => '2019-03-08 17:49:53',
                'updated_at' => '2019-03-08 17:49:53',
            ),
            6 => 
            array (
                'id' => 31,
                'purchase_order_id' => 9,
                'purchase_requisition_detail_id' => 68,
                'discount' => 0.0,
                'quantity' => 2.0,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => 1220,
                'resource_id' => NULL,
                'project_id' => 1,
                'total_price' => 2500000.0,
                'delivery_date' => '2019-03-15',
                'created_at' => '2019-03-08 17:49:53',
                'updated_at' => '2019-03-08 17:49:53',
            ),
            7 => 
            array (
                'id' => 32,
                'purchase_order_id' => 10,
                'purchase_requisition_detail_id' => 69,
                'discount' => 0.0,
                'quantity' => 1.0,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => NULL,
                'resource_id' => 1,
                'project_id' => 1,
                'total_price' => 1500000.0,
                'delivery_date' => '2019-03-21',
                'created_at' => '2019-03-08 17:52:26',
                'updated_at' => '2019-03-08 17:52:26',
            ),
            8 => 
            array (
                'id' => 33,
                'purchase_order_id' => 10,
                'purchase_requisition_detail_id' => 70,
                'discount' => 0.0,
                'quantity' => 1.0,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => NULL,
                'resource_id' => 7,
                'project_id' => 1,
                'total_price' => 500000.0,
                'delivery_date' => '2019-03-20',
                'created_at' => '2019-03-08 17:52:26',
                'updated_at' => '2019-03-08 17:52:26',
            ),
            9 => 
            array (
                'id' => 34,
                'purchase_order_id' => 10,
                'purchase_requisition_detail_id' => 71,
                'discount' => 0.0,
                'quantity' => 1.0,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => NULL,
                'resource_id' => 4,
                'project_id' => NULL,
                'total_price' => 241594043.0,
                'delivery_date' => '2019-03-22',
                'created_at' => '2019-03-08 17:52:26',
                'updated_at' => '2019-03-08 17:52:26',
            ),
            10 => 
            array (
                'id' => 35,
                'purchase_order_id' => 11,
                'purchase_requisition_detail_id' => 72,
                'discount' => 0.0,
                'quantity' => 15.0,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => 1824,
                'resource_id' => NULL,
                'project_id' => 2,
                'total_price' => 1125000.0,
                'delivery_date' => '2019-03-14',
                'created_at' => '2019-03-08 17:57:16',
                'updated_at' => '2019-03-08 17:57:16',
            ),
            11 => 
            array (
                'id' => 36,
                'purchase_order_id' => 11,
                'purchase_requisition_detail_id' => 73,
                'discount' => 0.0,
                'quantity' => 7.5,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => 1782,
                'resource_id' => NULL,
                'project_id' => 2,
                'total_price' => 112500.0,
                'delivery_date' => '2019-03-12',
                'created_at' => '2019-03-08 17:57:16',
                'updated_at' => '2019-03-08 17:57:16',
            ),
            12 => 
            array (
                'id' => 37,
                'purchase_order_id' => 11,
                'purchase_requisition_detail_id' => 74,
                'discount' => 0.0,
                'quantity' => 25.0,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => 320,
                'resource_id' => NULL,
                'project_id' => 2,
                'total_price' => 6250000.0,
                'delivery_date' => '2019-03-15',
                'created_at' => '2019-03-08 17:57:16',
                'updated_at' => '2019-03-08 17:57:16',
            ),
            13 => 
            array (
                'id' => 38,
                'purchase_order_id' => 11,
                'purchase_requisition_detail_id' => 75,
                'discount' => 0.0,
                'quantity' => 55.0,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => 426,
                'resource_id' => NULL,
                'project_id' => 2,
                'total_price' => 30250000.0,
                'delivery_date' => '2019-03-14',
                'created_at' => '2019-03-08 17:57:16',
                'updated_at' => '2019-03-08 17:57:16',
            ),
            14 => 
            array (
                'id' => 39,
                'purchase_order_id' => 11,
                'purchase_requisition_detail_id' => 76,
                'discount' => 0.0,
                'quantity' => 8.0,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => 1045,
                'resource_id' => NULL,
                'project_id' => 2,
                'total_price' => 1000000.0,
                'delivery_date' => '2019-03-13',
                'created_at' => '2019-03-08 17:57:16',
                'updated_at' => '2019-03-08 17:57:16',
            ),
            15 => 
            array (
                'id' => 40,
                'purchase_order_id' => 11,
                'purchase_requisition_detail_id' => 77,
                'discount' => 0.0,
                'quantity' => 3.0,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => 1896,
                'resource_id' => NULL,
                'project_id' => 2,
                'total_price' => 165000.0,
                'delivery_date' => '2019-03-15',
                'created_at' => '2019-03-08 17:57:16',
                'updated_at' => '2019-03-08 17:57:16',
            ),
            16 => 
            array (
                'id' => 41,
                'purchase_order_id' => 12,
                'purchase_requisition_detail_id' => 78,
                'discount' => 0.0,
                'quantity' => 1.0,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => NULL,
                'resource_id' => 30,
                'project_id' => 2,
                'total_price' => 1250000.0,
                'delivery_date' => '2019-03-21',
                'created_at' => '2019-03-08 17:58:31',
                'updated_at' => '2019-03-08 17:58:31',
            ),
            17 => 
            array (
                'id' => 42,
                'purchase_order_id' => 12,
                'purchase_requisition_detail_id' => 79,
                'discount' => 0.0,
                'quantity' => 1.0,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => NULL,
                'resource_id' => 6,
                'project_id' => 2,
                'total_price' => 550000.0,
                'delivery_date' => '2019-03-19',
                'created_at' => '2019-03-08 17:58:31',
                'updated_at' => '2019-03-08 17:58:31',
            ),
            18 => 
            array (
                'id' => 43,
                'purchase_order_id' => 12,
                'purchase_requisition_detail_id' => 80,
                'discount' => 0.0,
                'quantity' => 1.0,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => NULL,
                'resource_id' => 15,
                'project_id' => 2,
                'total_price' => 187900000.0,
                'delivery_date' => '2019-03-22',
                'created_at' => '2019-03-08 17:58:31',
                'updated_at' => '2019-03-08 17:58:31',
            ),
        ));
        
        
    }
}