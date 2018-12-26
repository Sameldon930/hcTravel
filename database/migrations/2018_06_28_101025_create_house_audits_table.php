<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHouseAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_audits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->text('img')->comment('房屋鉴定图');
            $table->string('code')->comment('房屋审批报告编号');
            $table->integer('status')->default(1)->comment('审核状态');
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
        Schema::dropIfExists('house_audits');
    }
}
