<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlteAllUrlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goods', function (Blueprint $table) {
            $table->text('url')->nullable()->comment('网址')->change();
        });
        Schema::table('marketings', function (Blueprint $table) {
            $table->text('url')->nullable()->comment('网址')->change();
        });
        Schema::table('finances', function (Blueprint $table) {
            $table->text('url')->nullable()->comment('网址')->change();
        });
        Schema::table('decorations', function (Blueprint $table) {
            $table->text('url')->nullable()->comment('网址')->change();
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
