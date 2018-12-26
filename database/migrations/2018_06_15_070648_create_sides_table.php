<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sides', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image')->comment('幻灯片地址');
            $table->string('url')->comment('跳转链接');
            $table->unsignedInteger('orderby')->nullabel()->comment('排序值');
            $table->string('note')->nullable()->comment('备注');
            $table->unsignedTinyInteger('status')->default(1)->comment('客户端:1显示、2隐藏');
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
        Schema::dropIfExists('sides');
    }
}
