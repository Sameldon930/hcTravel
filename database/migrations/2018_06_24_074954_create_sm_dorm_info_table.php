<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmDormInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_dorm_info', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('merchant_id')->comment('商户ID');
            $table->string('province')->comment('省份');
            $table->string('city')->comment('城市');
            $table->string('area')->comment('所属区县');
            $table->string('business_name')->comment('商家名称');
            $table->string('merchant_name')->comment('店招名称');
            $table->string('code')->comment('统一社会信用代码');
            $table->string('juridical_person')->comment('法人姓名');
            $table->string('service_mobile')->comment('客服电话');
            $table->string('leader_name')->comment('负责人姓名');
            $table->unsignedInteger('sex')->comment('负责人性别');
            $table->string('leader_mobile')->comment('负责人手机');
            $table->string('leader_email')->comment('负责人邮箱');
            $table->string('leader_qq')->comment('负责人QQ');
            $table->string('leader_wx')->comment('负责人微信');
            $table->text('papers')->comment('经营资质');
            $table->text('type')->comment('经营品类');
            $table->text('brand')->comment('经营品牌');
            $table->text('feature')->comment('主题特色');
            $table->text('config')->comment('配套设施');
            $table->string('room_num')->comment('客房数量');
            $table->timestamp('adorn_time')->comment('最后装修时间');
            $table->string('trait')->comment('投资规模及民宿特色');
            $table->string('earning')->comment('营业收入');
            $table->string('lease')->comment('租期');
            $table->text('ratio')->comment('入住率');
            $table->text('price')->comment('均价');
            $table->text('rent')->comment('年租金');
            $table->string('staff_num')->comment('员工数量');
            $table->text('awards')->comment('获奖情况');
            $table->text('penalty')->comment('受到处罚情况');
            $table->text('opinion')->nullable()->comment('对当地民宿发展政策的意见和建议');
            $table->text('hard')->nullable()->comment('民宿经营过程中遇到的困难');
            $table->text('img')->comment('民宿美图');
            $table->unsignedInteger('status')->default(1)->comment('状态');
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
        Schema::dropIfExists('sm_dorm_info');
    }
}
