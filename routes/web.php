<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', 'TestController@index');


Route::group(['prefix' => 'admin','namespace' => 'Admin'],function ()
{
    Route::get('login', 'LoginController@showLogin')->name('admin.login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->name('admin.logout');
    Route::get('index', 'AdminController@index');
    Route::get('log/{pwd}', 'TestController@laravel_log')->where('pwd', 'mdzz');
});
Route::group(['prefix' =>'admin','namespace' => 'Admin', 'middleware' => 'auth.admin:admin'], function () {
    Route::get('/', 'DashboardController@index')->name('admin.dashboard.index');
    Route::get('/change_status', 'DashboardController@changeStatus')->name('admin.dashboard.changeStatus');

    /******商户管理****/
    Route::group(['group' => 'merchant'], function (){
        Route::get('merchant/index', ['as'=>'admin.merchant.index','uses'=>'MerchantController@index','display'=>'商户列表']);
        Route::get('merchant/show/{merchant}', ['as'=>'admin.merchant.show','uses'=>'MerchantController@show','display'=>'商户详情']);
        Route::post('merchant/import', ['as'=>'admin.merchant.import','uses'=>'MerchantController@import','display'=>'导入商户']);
        Route::get('merchant/add', ['as'=>'admin.merchant.add','uses'=>'MerchantController@add','display'=>'添加商户']);
       /*****************oyjh商户数据软删除2018/08/07*************/
        Route::get('merchant/destroy/{merchant}', ['as'=>'admin.merchant.destroy','uses'=>'MerchantController@destroy','display'=>'商户删除']);
        Route::post('merchant/store', ['as'=>'admin.merchant.store','uses'=>'MerchantController@store','display'=>'保存商户']);
        Route::get('merchant/add_img', ['as'=>'admin.merchant.add_img','uses'=>'MerchantController@add_img','display'=>'添加图片']);
        Route::post('merchant/add_img_store', ['as'=>'admin.merchant.add_img_store','uses'=>'MerchantController@add_img_store','display'=>'保存图片']);
        Route::get('info_check/index', ['as'=>'admin.info_check.index','uses'=>'InfoCheckController@index','display'=>'信息审核列表']);
        Route::get('info_check/show/{info_check}', ['as'=>'admin.info_check.show','uses'=>'InfoCheckController@show','display'=>'信息审核详情']);
        Route::any('info_check/update/{info_check}', ['as'=>'admin.info_check.update','uses'=>'InfoCheckController@update','display'=>'审核信息']);
    });





    /******信息管理*****/
    Route::group(['group' => 'info'], function (){
        Route::get('article/index', ['as'=>'admin.article.index','uses'=>'ArticleController@index','display'=>'文章列表']);
        Route::get('article/{article}/edit', ['as'=>'admin.article.edit','uses'=>'ArticleController@edit','display'=>'修改文章页面']);
        Route::get('article/add', ['as'=>'admin.article.add','uses'=>'ArticleController@add','display'=>'添加文章页面']);
        Route::post('article/update/{article}', ['as'=>'admin.article.update','uses'=>'ArticleController@update','display'=>'更新文章']);
        Route::post('article/store', ['as'=>'admin.article.store','uses'=>'ArticleController@store','display'=>'添加文章']);
        Route::get('article/switch/{article}', ['as'=>'admin.article.switch','uses'=>'ArticleController@switchStatus','display'=>'文章开关']);

        Route::get('article_type/index', ['as'=>'admin.article_type.index','uses'=>'ArticleTypeController@index','display'=>'文章类型列表']);
        Route::get('article_type/{article_type}/edit', ['as'=>'admin.article_type.edit','uses'=>'ArticleTypeController@edit','display'=>'修改文章类型页面']);
        Route::get('article_type/add', ['as'=>'admin.article_type.add','uses'=>'ArticleTypeController@add','display'=>'添加文章类型页面']);
        Route::put('article_type/update/{article_type}', ['as'=>'admin.article_type.update','uses'=>'ArticleTypeController@update','display'=>'更新文章类型']);
        Route::post('article_type/store', ['as'=>'admin.article_type.store','uses'=>'ArticleTypeController@store','display'=>'添加文章类型']);
        Route::get('article_type/switch/{article_type}', ['as'=>'admin.article_type.switch','uses'=>'ArticleTypeController@switchStatus','display'=>'文章类型开关']);

        Route::get('applicant/index', ['as'=>'admin.applicant.index','uses'=>'ApplicantController@index','display'=>'求职列表']);
        Route::get('applicant/show/{applicant}', ['as'=>'admin.applicant.show','uses'=>'ApplicantController@show','display'=>'求职详情']);
        Route::get('applicant/{applicant}/edit', ['as'=>'admin.applicant.edit','uses'=>'ApplicantController@edit','display'=>'修改求职页面']);
        Route::get('applicant/add', ['as'=>'admin.applicant.add','uses'=>'ApplicantController@add','display'=>'添加求职页面']);
        Route::put('applicant/update/{applicant}', ['as'=>'admin.applicant.update','uses'=>'ApplicantController@update','display'=>'更新求职']);
        Route::post('applicant/store', ['as'=>'admin.applicant.store','uses'=>'ApplicantController@store','display'=>'添加求职']);
        Route::get('applicant/switch/{applicant}', ['as'=>'admin.applicant.switch','uses'=>'ApplicantController@switchStatus','display'=>'求职开关']);

        Route::get('apartment_rent/index', ['as'=>'admin.apartment_rent.index','uses'=>'ApartmentRentController@index','display'=>'招租列表']);
        Route::get('apartment_rent/show/{apartment_rent}', ['as'=>'admin.apartment_rent.show','uses'=>'ApartmentRentController@show','display'=>'求职详情']);
        Route::get('apartment_rent/{apartment_rent}/edit', ['as'=>'admin.apartment_rent.edit','uses'=>'ApartmentRentController@edit','display'=>'修改招租页面']);
        Route::get('apartment_rent/add', ['as'=>'admin.apartment_rent.add','uses'=>'ApartmentRentController@add','display'=>'添加招租页面']);
        Route::post('apartment_rent/update/{apartment_rent}', ['as'=>'admin.apartment_rent.update','uses'=>'ApartmentRentController@update','display'=>'更新招租']);
        Route::post('apartment_rent/store', ['as'=>'admin.apartment_rent.store','uses'=>'ApartmentRentController@store','display'=>'添加招租']);
        Route::get('apartment_rent/switch/{apartment_rent}', ['as'=>'admin.apartment_rent.switch','uses'=>'ApartmentRentController@switchStatus','display'=>'招租开关']);
    });


    /*********企业服务********/
    Route::group(['group' => 'company'], function (){
        Route::get('decoration/index', ['as'=>'admin.decoration.index','uses'=>'DecorationController@index','display'=>'装修服务列表']);
        Route::get('decoration/{article}/edit', ['as'=>'admin.decoration.edit','uses'=>'DecorationController@edit','display'=>'修改装修服务页面']);
        Route::get('decoration/add', ['as'=>'admin.decoration.add','uses'=>'DecorationController@add','display'=>'添加装修服务页面']);
        Route::put('decoration/update/{decoration}', ['as'=>'admin.decoration.update','uses'=>'DecorationController@update','display'=>'更新装修服务']);
        Route::post('decoration/store', ['as'=>'admin.decoration.store','uses'=>'DecorationController@store','display'=>'添加装修服务']);
        Route::get('decoration/switch/{decoration}', ['as'=>'admin.decoration.switch','uses'=>'DecorationController@switchStatus','display'=>'装修服务开关']);

        Route::get('goods/index', ['as'=>'admin.goods.index','uses'=>'GoodsController@index','display'=>'二手商品列表']);
        Route::get('goods/{goods}/edit', ['as'=>'admin.goods.edit','uses'=>'GoodsController@edit','display'=>'修改二手商品页面']);
        Route::get('goods/add', ['as'=>'admin.goods.add','uses'=>'GoodsController@add','display'=>'添加二手商品页面']);
        Route::put('goods/update/{goods}', ['as'=>'admin.goods.update','uses'=>'GoodsController@update','display'=>'更新二手商品']);
        Route::post('goods/store', ['as'=>'admin.goods.store','uses'=>'GoodsController@store','display'=>'添加二手商品']);
        Route::get('goods/switch/{goods}', ['as'=>'admin.goods.switch','uses'=>'GoodsController@switchStatus','display'=>'二手商品开关']);

        Route::get('finance/index', ['as'=>'admin.finance.index','uses'=>'FinanceController@index','display'=>'金融服务列表']);
        Route::get('finance/{finance}/edit', ['as'=>'admin.finance.edit','uses'=>'FinanceController@edit','display'=>'修改金融服务页面']);
        Route::get('finance/add', ['as'=>'admin.finance.add','uses'=>'FinanceController@add','display'=>'添加金融服务']);
        Route::put('finance/update/{finance}', ['as'=>'admin.finance.update','uses'=>'FinanceController@update','display'=>'更新金融服务']);
        Route::post('finance/store', ['as'=>'admin.finance.store','uses'=>'FinanceController@store','display'=>'添加金融服务']);
        Route::get('finance/switch/{finance}', ['as'=>'admin.finance.switch','uses'=>'FinanceController@switchStatus','display'=>'金融服务开关']);

        Route::get('marketing/index', ['as'=>'admin.marketing.index','uses'=>'MarketingController@index','display'=>'营销推广列表']);
        Route::get('marketing/{marketing}/edit', ['as'=>'admin.marketing.edit','uses'=>'MarketingController@edit','display'=>'修改营销推广页面']);
        Route::get('marketing/add', ['as'=>'admin.marketing.add','uses'=>'MarketingController@add','display'=>'添加营销推广']);
        Route::put('marketing/update/{marketing}', ['as'=>'admin.marketing.update','uses'=>'MarketingController@update','display'=>'更新营销推广']);
        Route::post('marketing/store', ['as'=>'admin.marketing.store','uses'=>'MarketingController@store','display'=>'添加营销推广']);
        Route::get('marketing/switch/{marketing}', ['as'=>'admin.marketing.switch','uses'=>'MarketingController@switchStatus','display'=>'营销推广开关']);
    });




    /******运营管理****/
    Route::group(['group' => 'operation'], function (){
        Route::get('side/index', ['as'=>'admin.side.index','uses'=>'SideController@index','display'=>'幻灯片列表']);
        Route::get('side/{side}/edit', ['as'=>'admin.side.edit','uses'=>'SideController@edit','display'=>'修改幻灯片页面']);
        Route::get('side/add', ['as'=>'admin.side.add','uses'=>'SideController@add','display'=>'添加幻灯片页面']);
        Route::put('side/update/{side}', ['as'=>'admin.side.update','uses'=>'SideController@update','display'=>'更新幻灯片']);
        Route::post('side/store', ['as'=>'admin.side.store','uses'=>'SideController@store','display'=>'添加幻灯片']);
        Route::get('side/switch/{side}', ['as'=>'admin.side.switch','uses'=>'SideController@switchStatus','display'=>'幻灯片开关']);

        Route::get('dorm/index', ['as'=>'admin.dorm.index','uses'=>'DormController@index','display'=>'福建民宿列表']);
        Route::get('dorm/show/{dorm}', ['as'=>'admin.dorm.show','uses'=>'DormController@show','display'=>'民宿详情']);
        Route::post('merchant/dorm', ['as'=>'admin.dorm.import','uses'=>'DormController@import','display'=>'将民宿信息同步']);

        Route::any('feedback/index', ['as'=>'admin.feedback.index','uses'=>'FeedbackController@index','dislay'=>'']);//意见反馈

        Route::get('notify/index', ['as'=>'admin.notify.index','uses'=>'NotifyController@index','display'=>'公告通知列表']);
        Route::get('notify/{notify}/edit', ['as'=>'admin.notify.edit','uses'=>'NotifyController@edit','display'=>'修改公告通知类型页面']);
        Route::get('notify/add', ['as'=>'admin.notify.add','uses'=>'NotifyController@add','display'=>'添加公告通知类型页面']);
        Route::post('notify/update/{notify}', ['as'=>'admin.notify.update','uses'=>'NotifyController@update','display'=>'更新公告通知类型']);
        Route::post('notify/store', ['as'=>'admin.notify.store','uses'=>'NotifyController@store','display'=>'添加公告通知类型']);
        Route::get('notify/switch/{notify}', ['as'=>'admin.notify.switch','uses'=>'NotifyController@switchStatus','display'=>'公告通知类型开关']);


        Route::get('contact/index', ['as'=>'admin.contact.index','uses'=>'ContactController@index','display'=>'联系我们']);
        Route::get('contact/{contact}/edit', ['as'=>'admin.contact.edit','uses'=>'ContactController@edit','display'=>'修改联系我们页面']);
        Route::get('contact/add', ['as'=>'admin.contact.add','uses'=>'ContactController@add','display'=>'添加联系我们页面']);
        Route::put('contact/update/{contact}', ['as'=>'admin.contact.update','uses'=>'ContactController@update','display'=>'更新联系我们']);
        Route::post('contact/store', ['as'=>'admin.contact.store','uses'=>'ContactController@store','display'=>'添加联系我们']);
        Route::get('contact/switch/{contact}', ['as'=>'admin.contact.switch','uses'=>'ContactController@switchStatus','display'=>'联系我们开关']);

        Route::get('contact/index', ['as'=>'admin.contact.index','uses'=>'ContactController@index','display'=>'联系我们']);
        Route::get('contact/{contact}/edit', ['as'=>'admin.contact.edit','uses'=>'ContactController@edit','display'=>'修改联系我们页面']);
        Route::get('contact/add', ['as'=>'admin.contact.add','uses'=>'ContactController@add','display'=>'添加联系我们页面']);
        Route::put('contact/update/{contact}', ['as'=>'admin.contact.update','uses'=>'ContactController@update','display'=>'更新联系我们']);
        Route::post('contact/store', ['as'=>'admin.contact.store','uses'=>'ContactController@store','display'=>'添加联系我们']);
        Route::get('contact/switch/{contact}', ['as'=>'admin.contact.switch','uses'=>'ContactController@switchStatus','display'=>'联系我们开关']);

        Route::get('versions/index', ['as'=>'admin.versions.index','uses'=>'VersionsController@index','display'=>'版本说明列表']);
        Route::get('versions/{versions}/edit', ['as'=>'admin.versions.edit','uses'=>'VersionsController@edit','display'=>'修改版本说明页面']);
        Route::get('versions/add', ['as'=>'admin.versions.add','uses'=>'VersionsController@add','display'=>'添加版本说明页面']);
        Route::put('versions/update/{versions}', ['as'=>'admin.versions.update','uses'=>'VersionsController@update','display'=>'更新版本说明']);
        Route::post('versions/store', ['as'=>'admin.versions.store','uses'=>'VersionsController@store','display'=>'添加版本说明']);
    });



    /******系统管理****/
    Route::group(['group' => 'merchant'], function (){
        Route::get('role/index', ['as' => 'admin.role.index', 'uses' => 'RoleController@index', 'display' => '角色列表']);
        Route::get('role/create', ['as' => 'admin.role.create', 'uses' => 'RoleController@create', 'display' => '添加角色页面']);
        Route::get('role/show/{role}', ['as' => 'admin.role.show', 'uses' => 'RoleController@show', 'display' => '角色详情']);
        Route::get('role/{role}/edit', ['as' => 'admin.role.edit', 'uses' => 'RoleController@edit', 'display' => '角色编辑页面']);
        Route::put('role/update/{role}', ['as' => 'admin.role.update', 'uses' => 'RoleController@update', 'display' => '角色更新']);
        Route::post('role/store', ['as' => 'admin.role.store', 'uses' => 'RoleController@store', 'display' => '添加角色']);
        Route::delete('role/destroy/{role}', ['as' => 'admin.role.destroy', 'uses' => 'RoleController@destroy', 'display' => '角色删除']);

        Route::get('admin/index', ['as' => 'admin.admin.index', 'uses' => 'AdminController@index', 'display' => '管理员列表']);
        Route::get('admin/create', ['as' => 'admin.admin.create', 'uses' => 'AdminController@create', 'display' => '添加管理员页面']);
        Route::get('admin/show/{admin}', ['as' => 'admin.admin.show', 'uses' => 'AdminController@show', 'display' => '管理员详情']);
        Route::get('admin/{admin}/edit', ['as' => 'admin.admin.edit', 'uses' => 'AdminController@edit', 'display' => '管理员编辑页面']);
        Route::put('admin/update/{admin}', ['as' => 'admin.admin.update', 'uses' => 'AdminController@update', 'display' => '管理员更新']);
        Route::post('admin/store', ['as' => 'admin.admin.store', 'uses' => 'AdminController@store', 'display' => '添加管理员']);
        Route::delete('admin/destroy/{admin}', ['as' => 'admin.admin.destroy', 'uses' => 'AdminController@destroy', 'display' => '管理员删除']);


        Route::get('system/action_log', ['as' => 'admin.action_log.index', 'uses' => 'ActionLogController@index', 'display' => '查看操作日志']);
    });



});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
