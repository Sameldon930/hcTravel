<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlteHouseAuditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('house_audits', function (Blueprint $table) {
            $table->text('img')->nullable()->comment('房屋鉴定图')->change();
            $table->string('address_img')->nullable()->comment('公共场所地址方位示意图');
            $table->string('system_img')->nullable()->comment('公共制度');
            $table->string('duty_img')->nullable()->comment('黄厝社区民宿经营责任协议书');
            $table->string('mass_img')->nullable()->comment('建筑结构质量鉴定委托书');
            $table->string('safe_img')->nullable()->comment('民宿业治安管理制度');
            $table->string('self_img')->nullable()->comment('厦门市个体工商户安全生产标准化建设自评表');
            $table->string('audit_img')->nullable()->comment('厦门市民宿经营申报联合核验表');
            $table->string('accredit_img')->nullable()->comment('授权委托书');
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
