<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlteSmDormInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_dorm_info', function (Blueprint $table) {
            $table->string('province')->nullable()->comment('省份')->change();
            $table->string('city')->nullable()->comment('城市')->change();
            $table->string('area')->nullable()->comment('所属区县')->change();
            $table->string('business_name')->nullable()->comment('商家名称')->change();
            $table->string('merchant_name')->nullable()->comment('店招名称')->change();
            $table->string('code')->nullable()->comment('统一社会信用代码')->change();
            $table->string('juridical_person')->nullable()->comment('法人姓名')->change();
            $table->string('service_mobile')->nullable()->comment('客服电话')->change();
            $table->string('leader_name')->nullable()->comment('负责人姓名')->change();
            $table->unsignedInteger('sex')->nullable()->comment('负责人性别')->change();
            $table->string('leader_mobile')->nullable()->comment('负责人手机')->change();
            $table->string('leader_email')->nullable()->comment('负责人邮箱')->change();
            $table->string('leader_qq')->nullable()->comment('负责人QQ')->change();
            $table->string('leader_wx')->nullable()->comment('负责人微信')->change();
            $table->text('papers')->nullable()->comment('经营资质')->change();
            $table->text('type')->nullable()->comment('经营品类')->change();
            $table->text('brand')->nullable()->comment('经营品牌')->change();
            $table->text('feature')->nullable()->comment('主题特色')->change();
            $table->text('config')->nullable()->comment('配套设施')->change();
            $table->string('room_num')->nullable()->comment('客房数量')->change();
            $table->string('trait')->nullable()->comment('投资规模及民宿特色')->change();
            $table->string('earning')->nullable()->comment('营业收入')->change();
            $table->string('lease')->nullable()->comment('租期')->change();
            $table->text('ratio')->nullable()->comment('入住率')->change();
            $table->text('price')->nullable()->comment('均价')->change();
            $table->text('rent')->nullable()->comment('年租金')->change();
            $table->string('staff_num')->nullable()->comment('员工数量')->change();
            $table->text('awards')->nullable()->comment('获奖情况')->change();
            $table->text('penalty')->nullable()->comment('受到处罚情况')->change();
            $table->text('opinion')->nullable()->comment('对当地民宿发展政策的意见和建议')->change();
            $table->text('hard')->nullable()->comment('民宿经营过程中遇到的困难')->change();
            $table->text('img')->nullable()->comment('民宿美图')->change();
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
