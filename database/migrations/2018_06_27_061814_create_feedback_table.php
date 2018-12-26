<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id')->default(0)->comment('管理员ID');
            $table->unsignedInteger('merchant_id')->index();
            $table->text('content')->comment('反馈内容');
            $table->text('feedback')->nullable()->comment('回复内容');
            $table->string('img')->nullable()->comment('反馈照片');
            $table->tinyInteger('is_read')->default(0)->comment('阅读状态:0未读,1已读');
            $table->integer('type')->default(0)->comment('类型');
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
        Schema::dropIfExists('feedback');
    }
}
