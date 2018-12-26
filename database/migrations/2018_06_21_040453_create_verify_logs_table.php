<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerifyLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verify_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id');
            $table->text('verify_success')->comment('审核记录内容');
            $table->integer('status')->default(1)->comment('审核状态');
            $table->integer('type')->comment('审核类型');
            $table->text('feedback')->nullable()->comment('客服反馈');
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
        Schema::dropIfExists('verify_logs');
    }
}
