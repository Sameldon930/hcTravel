<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('merchant_id')->comment('商户ID');
            $table->text('business_img')->nullable()->comment('营业执照');
            $table->string('business_num')->nullable( )->comment('注册号');
            $table->string('business_name')->nullable( )->comment('营业执照名称');
            $table->string('business_person')->nullable( )->comment('营业执照法人');
            $table->string('business_address')->nullable()->comment('营业地址');
            $table->text('identity_front')->nullable()->comment('身份证正面');
            $table->text('identity_contrary')->nullable()->comment('身份证正面');
            $table->string('identity_num')->nullable()->comment('身份证号');
            $table->string('identity_name')->nullable()->comment('身份证姓名');
            $table->text('contract_tenancy')->nullable()->comment('租赁合同');
            $table->tinyInteger('status')->default(1)->comment('状态');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchant_infos');
    }
}
