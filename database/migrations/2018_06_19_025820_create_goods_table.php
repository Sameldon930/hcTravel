<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->string('name')->comment('商家');
            $table->bigInteger('price')->comment('价格');
            $table->bigInteger('market_price')->comment('市场价格');
            $table->string('thumbnail')->comment('缩略图');
            $table->text('content')->comment('商品描述');
            $table->string('address')->nullable()->comment('地址');
            $table->string('mobile')->comment('联系电话');
            $table->string('url')->nullable()->comment('网址');
            $table->unsignedInteger('top')->default(2)->comment('是否置顶,默认为2，不置顶');
            $table->unsignedInteger('orderby')->nullable()->comment('排序');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态值：默认为1，为显示状态');
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
        Schema::dropIfExists('goods');
    }
}
