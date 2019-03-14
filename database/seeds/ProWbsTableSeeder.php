<?php

use Illuminate\Database\Seeder;

class ProWbsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pro_wbs')->delete();
        
        \DB::table('pro_wbs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'WBS181010001',
                'number' => 'H01',
                'description' => 'Dummy - Hull',
                'deliverables' => 'Dummy - Hull',
                'project_id' => 1,
                'wbs_id' => NULL,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 89,
                'planned_start_date' => '2019-03-04',
                'planned_end_date' => '2019-05-31',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 50.0,
                'user_id' => 5,
                'branch_id' => 1,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2018-12-19 09:27:15',
                'updated_at' => '2019-03-05 14:04:47',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'WBS181010002',
                'number' => 'H02',
                'description' => 'Dummy - Superstructure',
                'deliverables' => 'Dummy - Superstructure',
                'project_id' => 1,
                'wbs_id' => NULL,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 59,
                'planned_start_date' => '2019-06-03',
                'planned_end_date' => '2019-07-31',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 40.0,
                'user_id' => 5,
                'branch_id' => 1,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2018-12-19 09:27:44',
                'updated_at' => '2019-02-26 15:13:57',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'WBS181010003',
                'number' => 'H03',
                'description' => 'Dummy - Outfitting',
                'deliverables' => 'Dummy - Outfitting',
                'project_id' => 1,
                'wbs_id' => NULL,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 51,
                'planned_start_date' => '2019-08-01',
                'planned_end_date' => '2019-09-20',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 10.0,
                'user_id' => 5,
                'branch_id' => 1,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2018-12-19 09:28:25',
                'updated_at' => '2019-02-26 15:14:19',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'WBS181010004',
                'number' => 'H04',
                'description' => 'Dummy - Mengelas 1',
                'deliverables' => 'Dummy - Mengelas 1',
                'project_id' => 1,
                'wbs_id' => 1,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 88,
                'planned_start_date' => '2019-03-05',
                'planned_end_date' => '2019-05-31',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 20.0,
                'user_id' => 5,
                'branch_id' => 1,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2018-12-19 09:29:09',
                'updated_at' => '2019-03-05 14:06:21',
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'WBS181010005',
                'number' => 'H05',
                'description' => 'Dummy - Bending 1',
                'deliverables' => 'Dummy - Bending 1',
                'project_id' => 1,
                'wbs_id' => 1,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 90,
                'planned_start_date' => '2019-03-08',
                'planned_end_date' => '2019-06-05',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 25.0,
                'user_id' => 5,
                'branch_id' => 1,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2018-12-19 09:29:34',
                'updated_at' => '2019-03-05 14:06:39',
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'WBS181010006',
                'number' => 'H06',
                'description' => 'Dummy - Mengelas 2',
                'deliverables' => 'Dummy - Mengelas 2',
                'project_id' => 1,
                'wbs_id' => 2,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 26,
                'planned_start_date' => '2019-06-03',
                'planned_end_date' => '2019-06-28',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 20.0,
                'user_id' => 5,
                'branch_id' => 1,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2018-12-19 09:30:24',
                'updated_at' => '2019-02-26 15:16:53',
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 'WBS181010007',
                'number' => 'H07',
                'description' => 'Dummy - Bending 2',
                'deliverables' => 'Dummy - Bending 2',
                'project_id' => 1,
                'wbs_id' => 2,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 31,
                'planned_start_date' => '2019-07-01',
                'planned_end_date' => '2019-07-31',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 20.0,
                'user_id' => 5,
                'branch_id' => 1,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2018-12-19 09:30:42',
                'updated_at' => '2019-02-26 15:16:39',
            ),
            7 => 
            array (
                'id' => 8,
                'code' => 'WBS181010008',
                'number' => 'H08',
                'description' => 'Dummy - Coating',
                'deliverables' => 'Dummy - Coating',
                'project_id' => 1,
                'wbs_id' => 3,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 23,
                'planned_start_date' => '2019-08-01',
                'planned_end_date' => '2019-08-23',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 5.0,
                'user_id' => 5,
                'branch_id' => 1,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2018-12-19 09:31:28',
                'updated_at' => '2019-02-26 15:17:37',
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 'WBS181010009',
                'number' => 'H09',
                'description' => 'Dummy - Painting',
                'deliverables' => 'Dummy - Painting',
                'project_id' => 1,
                'wbs_id' => 3,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 26,
                'planned_start_date' => '2019-08-26',
                'planned_end_date' => '2019-09-20',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 5.0,
                'user_id' => 5,
                'branch_id' => 1,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2018-12-19 09:31:54',
                'updated_at' => '2019-02-26 15:17:48',
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 'WBS192010001',
                'number' => 'R0001',
                'description' => 'Replating',
                'deliverables' => 'Done',
                'project_id' => 2,
                'wbs_id' => NULL,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 12,
                'planned_start_date' => '2019-04-01',
                'planned_end_date' => '2019-04-12',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 50.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-02-25 17:04:49',
                'updated_at' => '2019-02-25 17:04:49',
            ),
            10 => 
            array (
                'id' => 11,
                'code' => 'WBS192010002',
                'number' => 'R0002',
                'description' => 'Out fitting',
                'deliverables' => 'Done',
                'project_id' => 2,
                'wbs_id' => NULL,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 10,
                'planned_start_date' => '2019-04-15',
                'planned_end_date' => '2019-04-24',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 50.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-02-25 17:05:24',
                'updated_at' => '2019-02-25 17:05:24',
            ),
            11 => 
            array (
                'id' => 12,
                'code' => 'WBS192010003',
                'number' => 'R2001',
                'description' => 'Man Hole',
                'deliverables' => 'Done',
                'project_id' => 2,
                'wbs_id' => 11,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 4,
                'planned_start_date' => '2019-04-15',
                'planned_end_date' => '2019-04-18',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 25.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-02-25 17:06:21',
                'updated_at' => '2019-02-25 17:06:21',
            ),
            12 => 
            array (
                'id' => 13,
                'code' => 'WBS192010004',
                'number' => 'R2002',
                'description' => 'Zink Anode',
                'deliverables' => 'Done',
                'project_id' => 2,
                'wbs_id' => 11,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 4,
                'planned_start_date' => '2019-04-19',
                'planned_end_date' => '2019-04-22',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 15.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-02-25 17:06:55',
                'updated_at' => '2019-02-25 17:06:55',
            ),
            13 => 
            array (
                'id' => 14,
                'code' => 'WBS192010005',
                'number' => 'R2003',
                'description' => 'Pemasangan Bolder',
                'deliverables' => 'Done',
                'project_id' => 2,
                'wbs_id' => 11,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 2,
                'planned_start_date' => '2019-04-23',
                'planned_end_date' => '2019-04-24',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 10.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-02-25 17:08:25',
                'updated_at' => '2019-02-25 17:08:25',
            ),
            14 => 
            array (
                'id' => 15,
                'code' => 'WBS192010006',
                'number' => 'R1001',
                'description' => 'Sideboard Forward',
                'deliverables' => 'Done',
                'project_id' => 2,
                'wbs_id' => 10,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 3,
                'planned_start_date' => '2019-04-02',
                'planned_end_date' => '2019-04-04',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 25.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-02-25 17:09:28',
                'updated_at' => '2019-02-25 17:09:28',
            ),
            15 => 
            array (
                'id' => 16,
                'code' => 'WBS192010007',
                'number' => 'R1002',
                'description' => 'Sideboard After',
                'deliverables' => 'Done',
                'project_id' => 2,
                'wbs_id' => 10,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 5,
                'planned_start_date' => '2019-04-05',
                'planned_end_date' => '2019-04-09',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 15.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-02-25 17:09:50',
                'updated_at' => '2019-02-25 17:09:50',
            ),
            16 => 
            array (
                'id' => 17,
                'code' => 'WBS192010008',
                'number' => 'R1003',
                'description' => 'Sideboard Star Board',
                'deliverables' => 'Done',
                'project_id' => 2,
                'wbs_id' => 10,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 3,
                'planned_start_date' => '2019-04-10',
                'planned_end_date' => '2019-04-12',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 10.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-02-25 17:10:21',
                'updated_at' => '2019-02-25 17:10:21',
            ),
            17 => 
            array (
                'id' => 18,
                'code' => 'WBS192010009',
                'number' => 'R1101',
                'description' => 'Panel Block F1 - F2',
                'deliverables' => 'Done',
                'project_id' => 2,
                'wbs_id' => 15,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 1,
                'planned_start_date' => '2019-04-02',
                'planned_end_date' => '2019-04-02',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 10.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-02-25 17:15:25',
                'updated_at' => '2019-02-25 17:15:25',
            ),
            18 => 
            array (
                'id' => 19,
                'code' => 'WBS192010010',
                'number' => 'R1102',
                'description' => 'Panel Block F3',
                'deliverables' => 'Done',
                'project_id' => 2,
                'wbs_id' => 15,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 1,
                'planned_start_date' => '2019-04-03',
                'planned_end_date' => '2019-04-03',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 15.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-02-25 17:15:46',
                'updated_at' => '2019-02-25 17:15:57',
            ),
            19 => 
            array (
                'id' => 20,
                'code' => 'WBS192010011',
                'number' => 'R1201',
                'description' => 'Panel Block A1 - A2',
                'deliverables' => 'Done',
                'project_id' => 2,
                'wbs_id' => 16,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 1,
                'planned_start_date' => '2019-04-05',
                'planned_end_date' => '2019-04-05',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 10.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-02-25 17:16:43',
                'updated_at' => '2019-02-25 17:16:43',
            ),
            20 => 
            array (
                'id' => 21,
                'code' => 'WBS192010012',
                'number' => 'R1202',
                'description' => 'Panel Block A3-A4',
                'deliverables' => 'Done',
                'project_id' => 2,
                'wbs_id' => 16,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 2,
                'planned_start_date' => '2019-04-08',
                'planned_end_date' => '2019-04-09',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 5.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-02-25 17:17:04',
                'updated_at' => '2019-02-25 17:17:04',
            ),
            21 => 
            array (
                'id' => 22,
                'code' => 'WBS192010013',
                'number' => 'R1301',
                'description' => 'Panel Block P1 - P2',
                'deliverables' => 'Done',
                'project_id' => 2,
                'wbs_id' => 17,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 1,
                'planned_start_date' => '2019-04-10',
                'planned_end_date' => '2019-04-10',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 2.5,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-02-25 17:19:17',
                'updated_at' => '2019-02-25 17:19:22',
            ),
            22 => 
            array (
                'id' => 23,
                'code' => 'WBS192010014',
                'number' => 'R1302',
                'description' => 'Panel Block P3 - P4',
                'deliverables' => 'Done',
                'project_id' => 2,
                'wbs_id' => 17,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 1,
                'planned_start_date' => '2019-04-10',
                'planned_end_date' => '2019-04-10',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 2.5,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-02-25 17:19:47',
                'updated_at' => '2019-02-25 17:19:47',
            ),
            23 => 
            array (
                'id' => 24,
                'code' => 'WBS192010015',
                'number' => 'R1303',
                'description' => 'Panel Block P5 - P6',
                'deliverables' => 'Done',
                'project_id' => 2,
                'wbs_id' => 17,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 1,
                'planned_start_date' => '2019-04-11',
                'planned_end_date' => '2019-04-11',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 2.5,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-02-25 17:20:09',
                'updated_at' => '2019-02-25 17:20:09',
            ),
            24 => 
            array (
                'id' => 25,
                'code' => 'WBS192010016',
                'number' => 'R1304',
                'description' => 'Panel Block P7 - P8',
                'deliverables' => 'Done',
                'project_id' => 2,
                'wbs_id' => 17,
                'wbs_configuration_id' => NULL,
                'status' => 1,
                'planned_duration' => 1,
                'planned_start_date' => '2019-04-12',
                'planned_end_date' => '2019-04-12',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 2.5,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-02-25 17:20:44',
                'updated_at' => '2019-02-25 17:20:44',
            ),
            25 => 
            array (
                'id' => 26,
                'code' => 'WBS192020001',
                'number' => 'Replating',
            'description' => 'Penggantian Plat (Replating)',
                'deliverables' => 'Replating',
                'project_id' => 3,
                'wbs_id' => NULL,
                'wbs_configuration_id' => 5,
                'status' => 1,
                'planned_duration' => 25,
                'planned_start_date' => '2019-04-01',
                'planned_end_date' => '2019-04-25',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 100.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-03-14 13:05:45',
                'updated_at' => '2019-03-14 13:05:45',
            ),
            26 => 
            array (
                'id' => 27,
                'code' => 'WBS192020002',
                'number' => 'Sideboard Forward',
                'description' => 'Sideboard Forward',
                'deliverables' => 'Sideboard Forward',
                'project_id' => 3,
                'wbs_id' => 26,
                'wbs_configuration_id' => 6,
                'status' => 1,
                'planned_duration' => 25,
                'planned_start_date' => '2019-04-01',
                'planned_end_date' => '2019-04-25',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 100.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-03-14 13:05:51',
                'updated_at' => '2019-03-14 13:05:51',
            ),
            27 => 
            array (
                'id' => 28,
                'code' => 'WBS192020003',
                'number' => 'Panel Block F1 - F2',
                'description' => 'Panel Block F1 - F2',
                'deliverables' => 'Panel Block F1 - F2',
                'project_id' => 3,
                'wbs_id' => 27,
                'wbs_configuration_id' => 7,
                'status' => 1,
                'planned_duration' => 25,
                'planned_start_date' => '2019-04-01',
                'planned_end_date' => '2019-04-25',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 100.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-03-14 13:05:57',
                'updated_at' => '2019-03-14 13:05:57',
            ),
        ));
        
        
    }
}