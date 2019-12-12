<?php

namespace Database\Data;

use App\Models\Permission;

/**
 * Export to PHP Array plugin for PHPMyAdmin
 * @version 4.9.0.1
 */

/**
 * Database `erp_patria`
 */
class RolesDataSeeder
{
    /* `erp_patria`.`menus` */
    public static function getDataPamiPermissions()
    {
        $data = Permission::whereNotIn('middleware', [
            'list-reverse-transaction',
            'create-reverse-transaction',
            'show-reverse-transaction',
            'edit-reverse-transaction',
            'approve-reverse-transaction',
            'manage-wbs-images',
            'delete-project-repair',
            'manage-material-requirement-summary',
            'list-currencies',
            'create-currencies',
            'edit-currencies',
            'show-currencies',
            'create-qc-task',
            'list-qc-task',
            'show-qc-task',
            'edit-qc-task',
            'confirm-qc-task',
            'cancel-finish-qc-task',
            'summary-report-qc-task',
            'show-project-progress',
            'create-post',
            // 'list-estimator-wbs',
            // 'create-estimator-wbs',
            // 'edit-estimator-wbs',
            // 'delete-estimator-wbs',
        ])->get();

        $array_data = array();

        foreach ($data as $datas) {
            $array_data[$datas->middleware] = true;
        }
        return json_encode($array_data);
    }
    // public function pamis()
    // {
    //     return json_encode([
    //         'show-dashboard' => true,
    //         'edit-default-password' => true,
    //         'create-menu' => true,
    //         'list-menu' => true,
    //         'show-menu' => true,
    //         'edit-menu' => true,
    //         'create-user' => true,
    //         'list-user' => true,
    //         'show-user' => true,
    //         'edit-user' => true,
    //         'edit-password' => true,
    //         'change-role' => true,
    //         'change-branch' => true,
    //         'change-status' => true,
    //         'create-permission' => true,
    //         'list-permission' => true,
    //         'show-permission' => true,
    //         'edit-permission' => true,
    //         'create-role' => true,
    //         'list-role' => true,
    //         'show-role' => true,
    //         'edit-role' => true,
    //         'create-ship' => true,
    //         'list-ship' => true,
    //         'show-ship' => true,
    //         'edit-ship' => true,
    //         'create-company' => true,
    //         'list-company' => true,
    //         'show-company' => true,
    //         'edit-company' => true,
    //         'create-branch' => true,
    //         'list-branch' => true,
    //         'show-branch' => true,
    //         'edit-branch' => true,
    //         'create-business-unit' => true,
    //         'list-business-unit' => true,
    //         'show-business-unit' => true,
    //         'edit-business-unit' => true,
    //         'create-customer' => true,
    //         'list-customer' => true,
    //         'show-customer' => true,
    //         'edit-customer' => true,
    //         'create-material' => true,
    //         'list-material' => true,
    //         'show-material' => true,
    //         'edit-material' => true,
    //         'create-service' => true,
    //         'list-service' => true,
    //         'show-service' => true,
    //         'edit-service' => true,
    //         'create-bom' => true,
    //         'list-bom' => true,
    //         'show-bom' => true,
    //         'edit-bom' => true,
    //         'confirm-bom' => true,
    //         'create-bom-repair' => true,
    //         'list-bom-repair' => true,
    //         'show-bom-repair' => true,
    //         'edit-bom-repair' => true,
    //         'confirm-bom-repair' => true,
    //         'create-project' => true,
    //         'list-project' => true,
    //         'show-project' => true,
    //         'edit-project' => true,
    //         'delete-project' => true,
    //         'create-project-repair' => true,
    //         'list-project-repair' => true,
    //         'show-project-repair' => true,
    //         'edit-project-repair' => true,
    //         'list-appearence' => true,
    //         'edit-appearence' => true,
    //         'list-rap' => true,
    //         'show-rap' => true,
    //         'edit-rap' => true,
    //         'list-rap-repair' => true,
    //         'show-rap-repair' => true,
    //         'edit-rap-repair' => true,
    //         'create-other-cost' => true,
    //         'approve-other-cost' => true,
    //         'create-actual-other-cost' => true,
    //         'view-planned-cost' => true,
    //         'view-remaining-material' => true,
    //         'create-other-cost-repair' => true,
    //         'create-actual-other-cost-repair' => true,
    //         'view-planned-cost-repair' => true,
    //         'view-remaining-material-repair' => true,
    //         'create-purchase-requisition' => true,
    //         'list-purchase-requisition' => true,
    //         'show-purchase-requisition' => true,
    //         'edit-purchase-requisition' => true,
    //         'approve-purchase-requisition' => true,
    //         'consolidation-purchase-requisition' => true,
    //         'cancel-purchase-requisition' => true,
    //         'cancel-approval-purchase-requisition' => true,
    //         'create-purchase-requisition-repair' => true,
    //         'list-purchase-requisition-repair' => true,
    //         'show-purchase-requisition-repair' => true,
    //         'edit-purchase-requisition-repair' => true,
    //         'approve-purchase-requisition-repair' => true,
    //         'consolidation-purchase-requisition-repair' => true,
    //         'cancel-purchase-requisition-repair' => true,
    //         'cancel-approval-purchase-requisition-repair' => true,
    //         'create-purchase-order' => true,
    //         'list-purchase-order' => true,
    //         'show-purchase-order' => true,
    //         'edit-purchase-order' => true,
    //         'approve-purchase-order' => true,
    //         'cancel-purchase-order' => true,
    //         'cancel-approval-purchase-order' => true,
    //         'create-purchase-order-repair' => true,
    //         'list-purchase-order-repair' => true,
    //         'show-purchase-order-repair' => true,
    //         'edit-purchase-order-repair' => true,
    //         'approve-purchase-order-repair' => true,
    //         'cancel-purchase-order-repair' => true,
    //         'cancel-approval-purchase-order-repair' => true,
    //         'create-goods-movement' => true,
    //         'list-goods-movement' => true,
    //         'view-goods-movement' => true,
    //         'edit-goods-movement' => true,
    //         'create-goods-movement-repair' => true,
    //         'list-goods-movement-repair' => true,
    //         'view-goods-movement-repair' => true,
    //         'edit-goods-movement-repair' => true,
    //         'create-material-requisition' => true,
    //         'list-material-requisition' => true,
    //         'show-material-requisition' => true,
    //         'edit-material-requisition' => true,
    //         'approve-material-requisition' => true,
    //         'create-material-requisition-repair' => true,
    //         'list-material-requisition-repair' => true,
    //         'show-material-requisition-repair' => true,
    //         'edit-material-requisition-repair' => true,
    //         'approve-material-requisition-repair' => true,
    //         'create-goods-issue' => true,
    //         'list-goods-issue' => true,
    //         'show-goods-issue' => true,
    //         'edit-goods-issue' => true,
    //         'create-goods-issue-repair' => true,
    //         'list-goods-issue-repair' => true,
    //         'show-goods-issue-repair' => true,
    //         'edit-goods-issue-repair' => true,
    //         'create-snapshot' => true,
    //         'count-stock' => true,
    //         'adjust-stock' => true,
    //         'list-adjustment-history' => true,
    //         'show-adjustment-history' => true,
    //         'show-snapshot' => true,
    //         'create-snapshot-repair' => true,
    //         'show-snapshot-repair' => true,
    //         'count-stock-repair' => true,
    //         'adjust-stock-repair' => true,
    //         'list-adjustment-history-repair' => true,
    //         'show-adjustment-history-repair' => true,
    //         'create-work-request' => true,
    //         'list-work-request' => true,
    //         'show-work-request' => true,
    //         'edit-work-request' => true,
    //         'approve-work-request' => true,
    //         'create-work-request-repair' => true,
    //         'list-work-request-repair' => true,
    //         'show-work-request-repair' => true,
    //         'edit-work-request-repair' => true,
    //         'approve-work-request-repair' => true,
    //         'create-material-write-off' => true,
    //         'list-material-write-off' => true,
    //         'edit-material-write-off' => true,
    //         'show-material-write-off' => true,
    //         'approve-material-write-off' => true,
    //         'create-material-write-off-repair' => true,
    //         'list-material-write-off-repair' => true,
    //         'edit-material-write-off-repair' => true,
    //         'show-material-write-off-repair' => true,
    //         'approve-material-write-off-repair' => true,
    //         'show-stock-management' => true,
    //         'show-stock-management-repair' => true,
    //         'create-goods-receipt' => true,
    //         'create-goods-receipt-without-ref' => true,
    //         'list-goods-receipt' => true, 'show-goods-receipt' => true,
    //         'create-goods-receipt-repair' => true,
    //         'create-goods-receipt-without-ref-repair' => true,
    //         'list-goods-receipt-repair' => true,
    //         'show-goods-receipt-repair' => true,
    //         'create-work-order' => true,
    //         'list-work-order' => true,
    //         'show-work-order' => true,
    //         'edit-work-order' => true,
    //         'approve-work-order' => true,
    //         'create-work-order-repair' => true,
    //         'list-work-order-repair' => true,
    //         'show-work-order-repair' => true,
    //         'edit-work-order-repair' => true,
    //         'approve-work-order-repair' => true,
    //         'create-storage-location' => true,
    //         'list-storage-location' => true,
    //         'show-storage-location' => true,
    //         'edit-storage-location' => true,
    //         'create-vendor' => true,
    //         'list-vendor' => true,
    //         'show-vendor' => true,
    //         'edit-vendor' => true,
    //         'create-unit-of-measurement' => true,
    //         'list-unit-of-measurement' => true,
    //         'show-unit-of-measurement' => true,
    //         'edit-unit-of-measurement' => true,
    //         'create-warehouse' => true,
    //         'list-warehouse' => true,
    //         'show-warehouse' => true,
    //         'edit-warehouse' => true,
    //         'create-production-order-repair' => true,
    //         'list-production-order-repair' => true,
    //         'show-production-order-repair' => true,
    //         'release-production-order-repair' => true,
    //         'confirm-production-order-repair' => true,
    //         'edit-production-order-repair' => true,
    //         'create-resource-repair' => true,
    //         'list-resource-repair' => true,
    //         'show-resource-repair' => true,
    //         'edit-resource-repair' => true,
    //         'assign-resource-repair' => true,
    //         'create-receive-resource-repair' => true,
    //         'list-receive-resource-repair' => true,
    //         'show-receive-resource-repair' => true,
    //         'create-issue-resource-repair' => true,
    //         'list-issue-resource-repair' => true,
    //         'show-issue-resource-repair' => true,
    //         'edit-issue-resource-repair' => true,
    //         'resource-schedule-repair' => true,
    //         'manage-wbs-profile-repair' => true,
    //         'manage-project-standard' => true,
    //         'manage-bom-profile-repair' => true,
    //         'manage-activity-profile-repair' => true,
    //         'manage-resource-profile-repair' => true,
    //         'create-goods-return-repair' => true,
    //         'list-goods-return-repair' => true,
    //         'show-goods-return-repair' => true,
    //         'edit-goods-return-repair' => true,
    //         'approve-goods-return-repair' => true,
    //         'create-production-order' => true,
    //         'list-production-order' => true,
    //         'show-production-order' => true,
    //         'release-production-order' => true,
    //         'confirm-production-order' => true,
    //         'edit-production-order' => true,
    //         'manage-yard-plan' => true,
    //         'view-yard-plan' => true,
    //         'create-resource' => true,
    //         'list-resource' => true,
    //         'show-resource' => true,
    //         'edit-resource' => true,
    //         'assign-resource' => true,
    //         'create-receive-resource' => true,
    //         'list-receive-resource' => true,
    //         'show-receive-resource' => true,
    //         'create-issue-resource' => true,
    //         'list-issue-resource' => true,
    //         'show-issue-resource' => true,
    //         'manage-wbs-profile' => true,
    //         'manage-bom-profile' => true,
    //         'manage-activity-profile' => true,
    //         'manage-resource-profile' => true,
    //         'resource-schedule' => true,
    //         'create-goods-return' => true,
    //         'list-goods-return' => true,
    //         'show-goods-return' => true,
    //         'edit-goods-return' => true,
    //         'approve-goods-return' => true,
    //         'create-pica' => true,
    //         'list-pica' => true,
    //         'show-pica' => true,
    //         'edit-pica' => true,
    //         'delete-pica' => true,
    //         'create-yard' => true,
    //         'list-yard' => true,
    //         'show-yard' => true,
    //         'edit-yard' => true,
    //         'create-estimator-wbs-repair' => true,
    //         'list-estimator-wbs-repair' => true,
    //         'edit-estimator-wbs-repair' => true,
    //         'delete-estimator-wbs-repair' => true,
    //         'create-cost-standard-repair' => true,
    //         'list-cost-standard-repair' => true,
    //         'edit-cost-standard-repair' => true,
    //         'show-cost-standard-repair' => true,
    //         'delete-cost-standard-repair' => true,
    //         'create-estimator-profile-repair' => true,
    //         'list-estimator-profile-repair' => true,
    //         'edit-estimator-profile-repair' => true,
    //         'show-estimator-profile-repair' => true,
    //         'delete-estimator-profile-repair' => true,
    //         'create-quotation-repair' => true,
    //         'list-quotation-repair' => true,
    //         'edit-quotation-repair' => true,
    //         'show-quotation-repair' => true,
    //         'create-sales-order-repair' => true,
    //         'list-sales-order-repair' => true,
    //         'edit-sales-order-repair' => true,
    //         'show-sales-order-repair' => true,
    //         'reply-post' => true,
    //         'create-invoice-repair' => true,
    //         'list-invoice-repair' => true,
    //         'edit-invoice-repair' => true,
    //         'show-invoice-repair' => true,
    //         'create-invoice' => true,
    //         'list-invoice' => true,
    //         'edit-invoice' => true,
    //         'show-invoice' => true,
    //         'manage-weather' => true,
    //         'manage-tidal' => true,
    //         'manage-approval-configuration' => true,
    //         'manage-cost-type-configuration' => true,
    //         'manage-appearance-configuration' => true,
    //         'manage-currencies-configuration' => true,
    //         'manage-material-family-configuration' => true,
    //         'manage-density-configuration' => true,
    //         'manage-payment-terms-configuration' => true,
    //         'manage-delivery-terms-configuration' => true,
    //         'manage-weather-configuration' => true,
    //         'manage-tidal-configuration' => true,
    //         'manage-dimension-type-configuration' => true,
    //         'list-qc-type' => true,
    //         'create-qc-type' => true,
    //         'show-qc-type' => true,
    //         'edit-qc-type' => true,
    //         'delete-qc-type' => true,
    //         'list-qc-task-repair' => true,
    //         'create-qc-task-repair' => true,
    //         'show-qc-task-repair' => true,
    //         'edit-qc-task-repair' => true,
    //         'delete-qc-task-repair' => true,
    //         'confirm-qc-task-repair' => true,
    //         'cancel-finish-qc-task-repair' => true,
    //         'summary-report-qc-task-repair' => true,
    //         'manage-sales-plan' => true,
    //         'manage-sales-plan-repair' => true,
    //         'manage-weather' => true,
    //         'manage-tidal' => true,
    //         'manage-daily-man-hour' => true,
    //         'manage-customer-visit-repair' => true,
    //         'list-email-template' => true,
    //         'create-email-template' => true,
    //         'show-email-template' => true,
    //         'edit-email-template' => true,
    //         'list-rfi' => true,
    //         'create-rfi' => true,
    //         'show-rfi' => true,
    //         'manage-delivery-document-repair' => true,
    //         'list-delivery-document-repair' => true,
    //         'show-delivery-document-repair' => true,
    //         'close-project-repair' => true,
    //     ]);
    // }
}
