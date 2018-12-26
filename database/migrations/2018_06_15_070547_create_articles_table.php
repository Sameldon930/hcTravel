<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admin_id')->comment('管理员');
            $table->unsignedInteger('group_id')->comment('文章分组');
            $table->string('title')->comment('文章标题');
            $table->string('thumbnail')->comment('缩略图');
            $table->text('content')->comment('内容');
            $table->integer('ready')->comment('阅读数');
            $table->unsignedInteger('top')->default(2)->comment('是否置顶,默认为2，不置顶');
            $table->unsignedInteger('orderby')->nullable()->comment('排序');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态值：默认为1，为显示状态');
            $table->timestamp('now')->nullable()->comment('发布时间');
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
        Schema::dropIfExists('articles');
    }
}
