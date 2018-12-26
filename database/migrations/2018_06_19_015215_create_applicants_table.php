<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('age');
            $table->tinyInteger('sex')->comment('性别：1男、2女');
            $table->string('apply_position')->comment('求职意向');
            $table->string('work_experience')->comment('工作经验');
            $table->tinyInteger('education')->comment('学历');
            $table->string('current_position')->comment('近期职位');
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
        Schema::dropIfExists('applicants');
    }
}
