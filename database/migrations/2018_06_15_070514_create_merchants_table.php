<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('昵称');
            $table->integer('flow_status')->default(1)->comment('是否显示流程');
            $table->string('mobile',20)->unique()->comment('手机号');
            $table->string('password')->nullable()->comment('密码');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态：默认为1未认证');
            $table->string('api_token',64)->unique()->comment('判断登录用的缓存token');
            $table->softDeletes();
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
        Schema::dropIfExists('merchants');
    }
}
