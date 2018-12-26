<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admin_id')->default(1)->comment('管理员ID');
            $table->string('title')->comment('通知标题');
            $table->text('content')->comment('通知内容');
            $table->integer('type')->default(1)->comment('通知类型');
            $table->integer('status')->default(1)->comment('通知状态：显示或者隐藏');
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
        Schema::dropIfExists('notifies');
    }
}
