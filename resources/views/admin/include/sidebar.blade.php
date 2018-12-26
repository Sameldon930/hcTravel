
<?php
$menus_groups = [
    [
        'name' => 'dashboard.index', 'display' => '数据中心', 'icon' => 'glyphicon glyphicon-stats',
    ],
    /*[
        'name' => 'order', 'display' => '订单管理', 'icon' => 'fa fa-user-plus',
        "menus" => [
            ['order.index', '订单列表'],
        ],
    ],*/
    /*[
        'name' => 'user', 'display' => '用户管理', 'icon' => 'fa fa-user',
        "menus" => [
            ['user.index', '用户列表'],
        ],
    ],*/
    [
        'name' => 'merchant', 'display' => '商户管理', 'icon' => 'fa fa-user',
        "menus" => [
            ['merchant.index', '商户列表'],
            ['info_check.index', '信息审核'],
        ],
    ],
    [
        'name' => 'info', 'display' => '信息管理', 'icon' => 'fa fa-edit',
        "menus" => [
            ['article.index', '文章列表'],
            ['article_type.index', '文章分类列表'],
            ['applicant.index', '求职列表'],
            ['apartment_rent.index', '招租列表'],
        ],
    ],
    [
        'name' => 'serve', 'display' => '企业服务管理', 'icon' => 'fa fa-server',
        "menus" => [
            ['decoration.index', '装修服务'],
            ['finance.index', '金融服务'],
            ['goods.index', '二手商品'],
            ['marketing.index', '营销推广'],
        ],
    ],
    /*[
        'name' => 'account_change', 'display' => '账变管理', 'icon' => 'fa fa-table',
        "menus" => [
            ['withdrawal_audit.index', '提现审核列表'],
            ['withdrawal.index', '提现列表'],
            ['merchant_account_change.index', '用户账变列表'],
            ['merchant_account_change.index', '商户账变列表'],
        ],
    ],*/
    [
        'name' => 'operation', 'display' => '运营管理', 'icon' => 'fa fa-link',
        "menus" => [
            ['side.index', '幻灯片'],
            ['dorm.index', '民宿统计列表'],
            ['feedback.index', '意见反馈'],
            ['notify.index', '公告通知'],
          /*  ['contact.index', '联系我们'],
            ['versions.index', '版本说明'],*/
        ],
    ],
    [
        'name' => 'system', 'display' => '系统设置', 'icon' => 'fa fa-cog',
        "menus" => [
            ['admin.index', '管理员管理'],
            ['role.index', '角色管理'],
            ['action_log.index', '操作日志'],
        ],
    ],

];

$user = Auth::user();
$all_permissions = $user->getPermissions()->all();


if (!$user->isAdmin()) {
    foreach ($menus_groups as $group_key => $group) {
        if (isset($group['menus'])) {
            foreach ($group['menus'] as $menu_key => &$menu) {
                $route = "admin.{$menu[0]}";
                if (!in_array($route, $all_permissions)) {
                    unset($menus_groups[$group_key]['menus'][$menu_key]);
                }
            }
            if (count($menus_groups[$group_key]['menus']) === 0){
                unset($menus_groups[$group_key]);
            }
        }
    }
}


?>
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            @foreach($menus_groups as $group)
                <li @if(isset($group['menus'])) class="treeview" @endif id="{{$group['name']}}">
                    <a href="@if(isset($group['menus'])) # @else {{ route("admin.{$group['name']}") }} @endif">
                        <i class="{{ $group['icon'] }}"></i> <span>{{ $group['display'] }}</span>
                        @if(isset($group['menus']))
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        @endif
                    </a>
                    @if(isset($group['menus']))
                        <ul class="treeview-menu">
                            @foreach($group['menus'] as $menu)
                                <li id="{{ $group['name'] . '_' . str_replace('.', '_', $menu[0]) }}">
                                    <a href="{{ route("admin.{$menu[0]}") }}"><i class="fa fa-circle-o"></i>{{ $menu[1] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </section>
</aside>


{{--
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="active treeview" id="index">
                <a href="">
                    <i class="fa fa-dashboard"></i> <span>数据中心</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>
            <li class="treeview" id="order">
                <a href="#">
                    <i class="fa fa-user-plus"></i>
                    <span>订单管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li id="order_"><a href=""><i class="fa fa-circle-o"></i> 订单列表</a></li>
                </ul>
            </li>
            <li class="treeview" id="account_change">
                <a href="#">
                    <i class="fa fa-table"></i>
                    <span>用户管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li id="agent_withdrawal"><a href=""><i class="fa fa-circle-o"></i> 用户列表</a></li>
                </ul>
            </li>
            <li class="treeview" id="account_change">
                <a href="#">
                    <i class="fa fa-table"></i>
                    <span>商户管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li id="agent_withdrawal"><a href=""><i class="fa fa-circle-o"></i> 商户列表</a></li>
                </ul>
            </li>
            <li class="treeview" id="merchant">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>账变管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li id="merchant_index"><a href=""><i class="fa fa-circle-o"></i> 提现审核列表</a></li>
                    <li id="merchant_info_check"><a href=""><i class="fa fa-circle-o"></i>提现列表</a></li>
                    <li id="merchant_info_check"><a href=""><i class="fa fa-circle-o"></i>账变列表</a></li>
                </ul>
            </li>
            <li class="treeview" id="transaction">
                <a href="#">
                    <i class="fa fa-bar-chart"></i>
                    <span>商品管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li id="order"><a href=""><i class="fa fa-circle-o"></i> 商品列表</a></li>
                    <li id="manage"><a href=""><i class="fa fa-circle-o"></i> 商品类别列表</a></li>
                </ul>
            </li>
            <li class="treeview" id="account_change">
                <a href="#">
                    <i class="fa fa-table"></i>
                    <span>物流管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li id="agent_withdrawal"><a href=""><i class="fa fa-circle-o"></i> 配送列表</a></li>
                    <li id="agent_account_change"><a href=""><i class="fa fa-circle-o"></i> 异常物流列表</a></li>
                    <li id="platform_account_change"><a href=""><i class="fa fa-circle-o"></i> 退货列表</a></li>
                </ul>
            </li>
            <li class="treeview" id="system">
                <a href="#">
                    <i class="fa fa-cog"></i>
                    <span>运营管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li id="system_index"><a href=""><i class="fa fa-circle-o"></i> 幻灯片</a></li>
                    <li id="system_index"><a href=""><i class="fa fa-circle-o"></i> 加权分红</a></li>
                    <li id="system_index"><a href=""><i class="fa fa-circle-o"></i> 公告</a></li>
                    <li id="system_index"><a href=""><i class="fa fa-circle-o"></i> 意见反馈</a></li>
                    <li id="system_index"><a href=""><i class="fa fa-circle-o"></i> 联系我们</a></li>
                    <li id="system_index"><a href=""><i class="fa fa-circle-o"></i> 版本说明</a></li>
                </ul>
            </li>
            <li class="treeview" id="system">
                <a href="#">
                    <i class="fa fa-cog"></i>
                    <span>系统管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li id="system_index"><a href=""><i class="fa fa-circle-o"></i> 会员奖励设置</a></li>
                    <li id="system_index"><a href=""><i class="fa fa-circle-o"></i> 会员等级设置</a></li>
                </ul>
            </li>

        </ul>
    </section>
</aside>--}}
