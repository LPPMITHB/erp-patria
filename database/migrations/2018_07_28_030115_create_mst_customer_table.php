<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_customer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->longText('address_1')->nullable();
            $table->longText('address_2')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_email')->unique()->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->integer('tax_number')->nullable();
            $table->integer('pkp_number')->nullable();
            $table->string('province')->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->string('status')->default(1);
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();
            
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
        Schema::dropIfExists('mst_customer');
    }
}
