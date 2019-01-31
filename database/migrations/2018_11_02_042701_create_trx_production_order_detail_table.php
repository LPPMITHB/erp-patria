<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxProductionOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_production_order_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('production_order_id');
            $table->unsignedInteger('production_order_detail_id')->nullable();
            $table->unsignedInteger('material_id')->nullable();
            $table->string('source')->nullable();
            $table->unsignedInteger('resource_id')->nullable();
            $table->unsignedInteger('resource_detail_id')->nullable();
            $table->unsignedInteger('service_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('actual')->nullable();
            $table->integer('performance')->nullable();
            $table->unsignedInteger('performance_uom_id')->nullable();
            $table->longText('morale')->nullable();
            $table->integer('usage')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('production_order_id')->references('id')->on('trx_production_order');
            $table->foreign('production_order_detail_id')->references('id')->on('trx_production_order_detail');
            $table->foreign('material_id')->references('id')->on('mst_material');
            $table->foreign('resource_id')->references('id')->on('mst_resource');
            $table->foreign('resource_detail_id')->references('id')->on('mst_resource_detail');
            $table->foreign('service_id')->references('id')->on('mst_service');
            $table->foreign('performance_uom_id')->references('id')->on('mst_uom');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_production_order_detail');
    }
}
