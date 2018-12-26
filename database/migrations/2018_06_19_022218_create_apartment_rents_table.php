<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApartmentRentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartment_rents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('出租信息标题');
            $table->bigInteger('rental')->comment('租金');
            $table->string('thumbnail')->comment('缩略图');
            $table->string('image')->comment('详情图');
            $table->string('house_type')->comment('房屋类型：一室一厅 28平 精装修');
            $table->tinyInteger('rent_way')->comment('租赁方式：整租');
            $table->string('payment_mode')->comment('支付方式：押一付一、面议');
            $table->string('region')->comment('所属区域');
            $table->string('mobile')->comment('联系电话');
            $table->string('is_hidden',8)->default('F')->comment('是否隐藏');
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
        Schema::dropIfExists('apartment_rents');
    }
}
