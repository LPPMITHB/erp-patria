<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AppTableSeeder::class);
        $this->call(FakerTableSeeder::class);
        // $this->call(MenusTableSeeder::class);
        // $this->call(PermissionsTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(BranchesTableSeeder::class);
        // $this->call(RolesTableSeeder::class);
        $this->call(MstCustomerTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ConfigurationsTableSeeder::class);
        // $this->call(SidenavsTableSeeder::class);
        $this->call(UOMTableSeeder::class);
        $this->call(MstMaterialTableSeeder::class);
        $this->call(ShipsTableSeeder::class);
        $this->call(WarehousesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(StorageLocationsTableSeeder::class);
        $this->call(MstVendorTableSeeder::class);
        $this->call(BusinessUnitsTableSeeder::class);
        // $this->call(StocksTableSeeder::class);
       
        $this->call(PamiMaterialTableSeeder::class);
        $this->call(YardsTableSeeder::class);
        $this->call(MstResourceTableSeeder::class);
        $this->call(MstResourceDetailTableSeeder::class);
        $this->call(MstServiceTableSeeder::class);
        $this->call(MstServiceDetailTableSeeder::class);
        // $this->call(MstWbsConfigurationTableSeeder::class);
        $this->call(MstEstimatorWbsTableSeeder::class);
        $this->call(MstEstimatorCostStandardTableSeeder::class);
        $this->call(MstEstimatorProfileTableSeeder::class);
        $this->call(MstEstimatorProfileDetailTableSeeder::class);
        $this->call(TrxQuotationTableSeeder::class);
        $this->call(TrxQuotationDetailTableSeeder::class);
        $this->call(TrxSalesOrderTableSeeder::class);
        $this->call(TrxSalesOrderDetailTableSeeder::class);
        $this->call(MstProjectStandardTableSeeder::class);
        $this->call(PamiTugboatWbsStandardSeeder::class);
        $this->call(ProProjectTableSeeder::class);
        // $this->call(MstActivityConfigurationTableSeeder::class);
        $this->call(TrxPurchaseRequisitionTableSeeder::class);
        $this->call(TrxPurchaseRequisitionDetailTableSeeder::class);
        $this->call(TrxPurchaseOrderTableSeeder::class);
        $this->call(TrxPurchaseOrderDetailTableSeeder::class);
        $this->call(TrxProductionOrderTableSeeder::class);
        $this->call(TrxProductionOrderDetailTableSeeder::class);
        $this->call(WorkRequestTableSeeder::class);
        $this->call(WorkRequestDetailTableSeeder::class);
        $this->call(MstWbsProfileTableSeeder::class);
        $this->call(MstActivityProfileTableSeeder::class);
        $this->call(MstBomProfileTableSeeder::class);
        $this->call(MstResourceProfileTableSeeder::class);
        $this->call(PurchasingInfoRecordTableSeeder::class);
        $this->call(MstWbsStandardTableSeeder::class);
        // $this->call(MstActivityStandardTableSeeder::class);
        $this->call(MstMaterialStandardTableSeeder::class);
        $this->call(MstResourceStandardTableSeeder::class);
        $this->call(ProWbsTableSeeder::class);
        $this->call(ProActivityTableSeeder::class);
        $this->call(MstBomPrepTableSeeder::class);
        $this->call(MstBomTableSeeder::class);
        $this->call(MstBomDetailTableSeeder::class);
        // $this->call(ProActivityDetailTableSeeder::class);
        $this->call(TrxGoodsReceiptTableSeeder::class);
        $this->call(TrxGoodsReceiptDetailTableSeeder::class);
        $this->call(MstStorageLocationDetailTableSeeder::class);
        $this->call(MstStockTableSeeder::class);
        $this->call(ProWbsMaterialTableSeeder::class);
        $this->call(TrxResourceTableSeeder::class);
        $this->call(MstPartDetailStandardTableSeeder::class);
        $this->call(MstQualityControlTypeTableSeeder::class);
        // $this->call(QualityPlanSeeder::class);
        //test
        // // $this->call(SidenavsV3TableSeeder::class);
        
        
    }
}
