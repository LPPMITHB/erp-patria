<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxPurchaseOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_purchase_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->unsignedInteger('purchase_requisition_id')->nullable();
            $table->unsignedInteger('vendor_id');
            $table->unsignedInteger('project_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('status')->default(1);
            $table->double('total_price')->nullable();
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('purchase_requisition_id')->references('id')->on('trx_purchase_requisition');
            $table->foreign('vendor_id')->references('id')->on('mst_vendor');
            $table->foreign('project_id')->references('id')->on('pro_project');
            $table->foreign('branch_id')->references('id')->on('mst_branch');
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_purchase_order');
    }
}
