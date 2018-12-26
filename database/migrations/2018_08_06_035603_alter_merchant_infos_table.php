<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMerchantInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //更改merchant_infos表字段
        //  将thumbnail、interior_figure_one、interior_figure_two、interior_figure_three、content 允许为空
        Schema::table('merchant_infos', function (Blueprint $table) {
            $table->string('thumbnail')->nullable()->change();
            $table->string('interior_figure_one')->nullable()->change();
            $table->string('interior_figure_two')->nullable()->change();
            $table->string('interior_figure_three')->nullable()->change();
            $table->text('content')->nullable()->change();
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
