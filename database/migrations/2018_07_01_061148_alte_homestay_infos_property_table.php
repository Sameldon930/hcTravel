<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlteHomestayInfosPropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('homestay_infos', function (Blueprint $table) {
            $table->text('property_img')->nullable()->comment('其他产权证明')->change();
            $table->text('property_img_1')->nullable()->comment('集体土地使用权证农村房屋所有权证')->after('property_img');
            $table->text('property_img_2')->nullable()->comment('乡村建房宅基地许可证个人建房田地临时凭据')->after('property_img');
            $table->text('property_img_3')->nullable()->comment('乡村房屋契证')->after('property_img');
            $table->text('property_img_4')->nullable()->comment('土地房产所有证')->after('property_img');
            $table->text('property_img_5')->nullable()->comment('乡村企业田地许可证')->after('property_img');
            $table->text('property_img_6')->nullable()->comment('建设工程规划许可证')->after('property_img');
            $table->text('property_img_7')->nullable()->comment('私危房翻改建许可证')->after('property_img');
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
