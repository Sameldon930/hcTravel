<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AletrMerchantInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_infos', function (Blueprint $table) {
            $table->string('merchant_principal')->nullable()->comment('负责人')->after('merchant_id');
            $table->string('merchant_name')->nullable()->comment('商家名称')->after('merchant_id');
            $table->string('merchant_short_name')->nullable()->comment('商家简称')->after('merchant_id');
            $table->string('merchant_address')->nullable()->comment('商家地址')->after('merchant_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
