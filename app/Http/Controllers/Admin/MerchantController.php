<?php

namespace App\Http\Controllers\Admin;

use App\HomestayInfo;
use App\HouseAudit;
use App\Http\Requests\StoreMenchantRequest;
use App\Merchant;
use App\MerchantInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Excel;


class MerchantController extends Controller
{
    /***
     * 商户列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $search_items = [
            'mobile' => [
                'type' => 'like',
                'form' => 'text',
                'label' => '手机号',
            ],
            'created_at' => [
                'type' => 'date',
            ]
        ];
        $datas = Merchant::latest()
            ->with('merchantInfo')
            ->search($search_items)
            ->paginate(20);
        return _view('admin.merchant.merchant.index', compact('datas'));
    }

    /***
     * 商户详情
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {

        $data = Merchant::where('id', $id)->with('merchantInfo')->with('homestayInfo')->with('houseAudit')->first();
        return _view('admin.merchant.merchant.show', compact('data'));
    }

    /***
     * 添加商户
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {

        $data = null;
        return _view('admin.merchant.merchant.edit', compact('data'));
    }

    /***
     * 添加商户
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(StoreMenchantRequest $request)
    {
        //判断手机号是否重复 重复不能添加
        //后面开发可能会去掉这个判断
        $merchant = Merchant::where('mobile', $request->mobile)->first();

//        dd($merchant);
        if (!empty($merchant)) {
            return back()->withErrors('该用户已存在');
        }
        $token = str_random(60);
        $api_token = $this->getToken($token);
        $newMerchantData = [
            'mobile' => $request->mobile,
            'api_token' => $api_token,
        ];
        DB::beginTransaction();
        $newMerchant = Merchant::create($newMerchantData);
        $newData = [
            'merchant_id' => $newMerchant->id,//Merchantid
            'merchant_principal' => $request->merchant_principal,//负责人
            'merchant_name' => $request->merchant_name,//商家名称
            'merchant_short_name' => $request->merchant_short_name,//商家简称
            'merchant_address' => $request->merchant_address,//商家地址
            'business_num' => $request->business_num,//注册号
            'business_address' => $request->business_address,//营业地址
            'business_name' => $request->business_name,//营业执照名称
            'business_person' => $request->person,//营业执照法人
            'identity_name' => $request->person,//身份证姓名
            'identity_num' => $request->identity_num,//身份证号
        ];
        //上传缩略图
        $input = $request->all();
        if (isset($input['file']) && is_object($input['file'])) {

            $file_name = save_image_file($input['file'], 'merchant_infos');
            if (!$file_name) {
                return back()->withErrors('msg', '图片上传失败,请重试!');
            }
//            dd($file_name);
            $input['thumbnail'] = $file_name;
            unset($input['_token']);
            unset($input['file']);
        } else {
            return back()->withErrors('msg', '请上传图片');
        }
        //上传内景图1
        if (isset($input['image1']) && is_object($input['image1'])) {

            $file_name_1 = save_image_file($input['image1'], 'merchant_infos');
            if (!$file_name_1) {
                return back()->withErrors('msg', '图片上传失败,请重试!');
            }

            $input['interior_figure_one'] = $file_name_1;
            unset($input['_token']);
            unset($input['image1']);
        } else {
            return back()->with('msg', '请上传图片');
        }
        //上传内景图2
        if (isset($input['image2']) && is_object($input['image2'])) {

            $file_name_2 = save_image_file($input['image2'], 'merchant_infos');
            if (!$file_name_2) {
                return back()->withErrors('msg', '图片上传失败,请重试!');
            }
            $input['interior_figure_two'] = $file_name_2;
            unset($input['_token']);
            unset($input['image2']);
        } else {
            return back()->withErrors('msg', '请上传图片');
        }
        //上传内景图3
        if (isset($input['image3']) && is_object($input['image3'])) {

            $file_name_3 = save_image_file($input['image3'], 'merchant_infos');
            if (!$file_name_3) {
                return back()->withErrors('msg', '图片上传失败,请重试!');
            }
            $input['interior_figure_three'] = $file_name_3;
            unset($input['_token']);
            unset($input['image3']);
        } else {
            return back()->withErrors('msg', '请上传图片');
        }

        $merchantInfo = MerchantInfo::where('merchant_id', $newMerchant->id)->first();
        if (!empty($merchantInfo)) {
            return back()->withErrors('该用户已录入信息');
        }
        $homestayInfo = HomestayInfo::where('merchant_id', $newMerchant->id)->first();
        if (!empty($homestayInfo)) {
            return back()->withErrors('该用户已录入信息');
        }
        //录入商户信息
        $newData['thumbnail'] = $input['thumbnail'];
        $newData['interior_figure_one'] = $input['interior_figure_one'];
        $newData['interior_figure_two'] = $input['interior_figure_two'];
        $newData['interior_figure_three'] = $input['interior_figure_three'];
        $newData['content'] = $input['content'];
        $newData['time'] = $input['time'];
        $newData['score'] = $input['score'];
        $newData['register'] = $input['register'];
        $newMerchantInfo = MerchantInfo::create($newData);
        $newHomestayInfo = HomestayInfo::create($newData);
        if ($newMerchantInfo && $newHomestayInfo && $newMerchant) {
            DB::commit();
            admin_action_logs($newMerchant, "添加商户成功");
            return redirect()->route('admin.merchant.index')->with('msg', '添加成功');
        } else {
            DB::rollback();
            return back()->withErrors('添加失败，请联系管理员');
        }


    }

    /***
     * 编辑
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_img()
    {
        $data = null;
        return _view('admin.merchant.merchant.add', compact('data'));
    }

    /***
     * 编辑后保存图片
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_img_store(Request $request)
    {
        //上传缩略图
        $input = $request->all();
        //dd($input);
        if (isset($input['file']) && is_object($input['file'])) {

            $file_name = save_image_file($input['file'], 'merchant_infos');
            if (!$file_name) {
                return back()->witherrors('msg', '图片上传失败,请重试!');
            }

            $input['thumbnail'] = $file_name;
            unset($input['_token']);
            unset($input['file']);
        } else if (isset($input['file_1'])) {
            $input['thumbnail'] = $input['file_1'];
        } else {
            return back()->witherrors('请上传图片')->withInput($input);
        }
        //上传内景图1
        if (isset($input['image1']) && is_object($input['image1'])) {

            $file_name_1 = save_image_file($input['image1'], 'merchant_infos');
            if (!$file_name_1) {
                return back()->witherrors('msg', '图片上传失败,请重试!');
            }

            $input['interior_figure_one'] = $file_name_1;
            unset($input['_token']);
            unset($input['image1']);
        } else if (isset($input['image1_1'])) {
            $input['interior_figure_one'] = $input['image1_1'];
        } else {
            return back()->witherrors('请上传图片')->withInput($input);
        }
        //上传内景图2
        if (isset($input['image2']) && is_object($input['image2'])) {

            $file_name_2 = save_image_file($input['image2'], 'merchant_infos');
            if (!$file_name_2) {
                return back()->witherrors('msg', '图片上传失败,请重试!');
            }
            $input['interior_figure_two'] = $file_name_2;
            unset($input['_token']);
            unset($input['image2']);
        } else if (isset($input['image2_1'])) {
            $input['interior_figure_two'] = $input['image2_1'];
        } else {
            return back()->witherrors('请上传图片')->withInput($input);
        }
        //上传内景图3
        if (isset($input['image3']) && is_object($input['image3'])) {

            $file_name_3 = save_image_file($input['image3'], 'merchant_infos');
            if (!$file_name_3) {
                return back()->witherrors('msg', '图片上传失败,请重试!');
            }
            $input['interior_figure_three'] = $file_name_3;
            unset($input['_token']);
            unset($input['image3']);
        } else if (isset($input['image3_1'])) {
            $input['interior_figure_three'] = $input['image3_1'];
        } else {
            return back()->witherrors('请上传图片')->withInput($input);
        }

        //录入商户信息
        $merchang_info = MerchantInfo::where('merchant_id', '=', $input['id'])->first();
        if (empty($merchang_info)) {
            $newData['thumbnail'] = $input['thumbnail'];
            $newData['merchant_id'] = $input['id'];
            $newData['merchant_name'] = $input['merchant_name'];
            $newData['interior_figure_one'] = $input['interior_figure_one'];
            $newData['interior_figure_two'] = $input['interior_figure_two'];
            $newData['interior_figure_three'] = $input['interior_figure_three'];
            $newData['content'] = $input['content'];
            $newData['time'] = $input['time'];
            $newData['score'] = $input['score'];
            $newData['register'] = $input['register'];
            $newData['merchant_address'] = $input['merchant_address'];
            $result = MerchantInfo::create($newData);
        }
        else {
            $merchang_info->merchant_name = $input['merchant_name']??'';
            $merchang_info->thumbnail = $input['thumbnail']??'';
            $merchang_info->interior_figure_one = $input['interior_figure_one']??'';
            $merchang_info->interior_figure_two = $input['interior_figure_two']??'';
            $merchang_info->interior_figure_three = $input['interior_figure_three']??'';
            $merchang_info->content = $input['content']??'';
            $merchang_info->time = $input['time']??'';
            $merchang_info->score = $input['score']??'';
            $merchang_info->register = $input['register']??'';
            $merchang_info->merchant_address = $input['merchant_address']??'';
            $result = $merchang_info->save();
        }
        if ($result) {
            DB::commit();
            admin_action_logs($result, "编辑商户成功");
            return redirect()->route('admin.merchant.index')->with('msg', '编辑成功');
        } else {
            DB::rollback();
            return back()->withErrors('编辑失败，请联系管理员');
        }
    }

    /**
     * @return $this
     */
    public function import(Request $request)
    {
        $input = Input::all();


        if (!isset($input['file_data'])) {
            return back()->withErrors('没有上传文件!');
        }
        if ($_FILES['file_data']['type'] != 'application/octet-stream' && $_FILES['file_data']['type'] != 'application/vnd.ms-excel') {
            return back()->withErrors('msg', '文件错误!');
        }
        $file = $input['file_data'];
        $realPath = $file->getRealPath();
        $entension = $file->getClientOriginalExtension(); //上传文件的后缀.
        $tabl_name = date('YmdHis') . mt_rand(100, 999);
        $newName = $tabl_name . '.' . 'xls';//$entension;
        $path = $file->move(base_path() . '/storage/app/excel_uploads', $newName);
        $cretae_path = base_path() . '/storage/app/excel_uploads/' . $newName; //导入文件路径
        $err_arr = [];
        #start 事务，处理收益
        DB::beginTransaction();

        Excel::load($cretae_path, function ($reader) use (&$err_arr) {

            $reader = $reader->getSheet(0);
            //获取表中的数据
            $data = $reader->toArray();
            unset($data[0]);
            foreach ($data as $key => $value) {
                //判断是否有手机好
                if (empty($value[3])) {
                    continue;
                }
                $mobile = explode('.', $value[3])[0];
                //判断商户是否存在
                $merchant = Merchant::where('mobile', $mobile)->first();
                if (!empty($merchant)) {
                    $err_arr[$key] = $mobile . '已存在';
                    continue;
                }


                $token = str_random(60);
                $api_token = $this->getToken($token);
                //创建新商户
                $newMerchantData = [
                    'mobile' => $mobile,
                    'api_token' => $api_token,
                    'name' => $value[2],
                ];
                $newMerchant = Merchant::create($newMerchantData);
                $newData = [
                    'merchant_id' => $newMerchant->id,
                    'merchant_principal' => $value[2],
                    'merchant_name' => $value[0],
                    'merchant_short_name' => $value[1],
                    'business_num' => $value[4],
                    'business_name' => $value[5],
                    'identity_name' => $value[5],
                ];

                $merchantInfo = MerchantInfo::where('merchant_id', $newMerchant->id)->first();
                if (!empty($merchantInfo)) {
                    $err_arr[$key] = $mobile . '商户认证信息已存在';
                    continue;
                }
                $homestayInfo = HomestayInfo::where('merchant_id', $newMerchant->id)->first();
                if (!empty($homestayInfo)) {
                    $err_arr[$key] = $mobile . '民宿认证信息已存在';
                    continue;
                }
                //录入商户信息
                $newMerchantInfo = MerchantInfo::create($newData);
                $newHomestayInfo = HomestayInfo::create($newData);
            }

        });

        if (empty($err_arr)) {
            DB::commit();
            $msg = '文件上传成功';

            admin_action_logs($realPath, "导入商户");
        } else {

            DB::rollback();
            $msg = "文件上传失败，存在错误";
        }
        return back()->with('msg', $msg)->withErrors($err_arr);
    }


    //获取token
    public function getToken($token)
    {

        $has_token = Merchant::where('api_token', $token)->first();
        if (!empty($has_token)) {
            $token = str_random(60);
            $this->getToken($token);
        }

        return $token;
    }


    /**
     * 软删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $merchant_id = $id;
//      merchants表数据软删除
        $merchant = Merchant::find($merchant_id);
        DB::beginTransaction();
        if ($merchant != null) {
            $merchant->delete();
        } else {
            DB::rollback();
            return back()->withErrors('删除失败');
        }
//      merchant_infos表数据软删除
        $merchant_infos = MerchantInfo::where("merchant_id","=",$merchant_id)->first();
        if ($merchant_infos != null) {
            $merchant_infos->delete();
        }
//      homestay_infos表数据软删除
        $homestay_infos = HomestayInfo::where("merchant_id","=",$merchant_id)->first();
        if ($homestay_infos != null) {
            $homestay_infos->delete();
        }

//      house_audits表数据软删除
        $house_audits = HouseAudit::where("merchant_id","=",$merchant_id)->first();
        if ($house_audits != null) {
            $house_audits->delete();
        }

        DB::commit();
        admin_action_logs($merchant, "删除商户信息（{$merchant->id}）");
        return back()->with("msg", "删除成功");

    }
}
