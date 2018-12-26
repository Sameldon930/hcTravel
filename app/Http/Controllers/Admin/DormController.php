<?php

namespace App\Http\Controllers\Admin;

use App\HomestayInfo;
use App\Http\Requests\StoreSidePost;
use App\Merchant;
use App\MerchantInfo;
use App\Side;
use App\SmDormInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDecorationPost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Excel;



class DormController extends Controller
{
    /***
     * 民宿统计
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){

        $search_items = [
            'site' => [
                'type' => 'equal',
                'form' => 'select',
                'label' => '所属区域',
                'options' => SmDormInfo::SITE,
            ],
            'leader_name' => [
                'type' => 'like',
                'form' => 'text',
                'label' => '负责人',
            ],
            'leader_mobile' => [
                'type' => 'like',
                'form' => 'text',
                'label' => '负责人手机',
            ],
            'merchant_name' => [
                'type' => 'like',
                'form' => 'text',
                'label' => '商家简称',
            ],
        ];
        $sql = SmDormInfo::latest()
            ->search($search_items)
        ;
        $all = SmDormInfo::get();
        //导出或者搜索
        $datas = $sql->export(20);
        $table[0] = [
            '商户编号',
            '商家名称', '所属区域',
            '店铺招牌', '法人姓名',
            '信用代码','客服电话',
            '负责人名称','负责人性别',
            '负责人手机','负责人邮箱',
            '负责人QQ','负责人微信',
            '经营资质','经营品类',
            '经营品牌','主题特色',
            '配套设施','客房数量',
            '最后装修时间','投资规模及民宿特色',
            '营业收入/年(万元)','租期',
            '入住率','均价（元）',
            '年租金(万元)','员工数量',
            '获奖情况','受到处罚情况',
            '民宿建议','民宿困难',
        ];
        foreach ($datas as $key=>&$data){
            $papers = '';
            foreach(json_decode($data->papers) as $item){
                $papers .= SmDormInfo::PAPERS[$item].',';
            }
            $type = '';
            foreach(json_decode($data->type) as $item){
                $type .= SmDormInfo::PAPERS[$item].',';
            }
            $brand = '';
            foreach(json_decode($data->brand) as $item){
                $brand .= SmDormInfo::PAPERS[$item].',';
            }
            $feature = '';
            if(json_decode($data->feature)){
                foreach(json_decode($data->feature) as $item){
                    $feature .= SmDormInfo::PAPERS[$item].',';
                }
            }

            $config = '';
            foreach(json_decode($data->config) as $item){
                $config .= SmDormInfo::PAPERS[$item].',';
            }
            $table[$key+1] = [
                $data->merchant_id,
                $data->business_name, json_decode($data->province)->name.json_decode($data->city)->name.json_decode($data->area)->name,
                $data->merchant_name, $data->juridical_person,
                $data->code, $data->service_mobile,
                $data->leader_name, SmDormInfo:: SEX[$data->sex]??'未填写',
                $data->leader_mobile, $data->leader_email,
                $data->leader_qq, $data->leader_wx,
                $papers, $type,
                $brand, $feature,
                $config, $data->room_num,
                $data->adorn_time = date('Y-m-d',strtotime($data->adorn_time)), $data->trait,
                $data->earning, $data->lease,
                $data->ratio, $data->price,
                $data->rent, $data->staff_num,
                $data->awards, $data->penalty,
                $data->opinion, $data->hard,

            ];
        }
        if($request->get('export')){
            $title ='民宿列表';
            $msg =export_data($table, $title);
            admin_action_logs($table, "导出民宿列表");
            return back()->with('msg',$msg);
        }
        return _view('admin.operation.dorm.index',compact('datas','count','all'));
    }

    /***
     * 民宿详情
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id){
        $data = SmDormInfo::find($id);
        return _view('admin.operation.dorm.show',compact('data'));
    }

    /**
     * 同步商户数据
     * @param Request $request
     * @return $this
     */
    public function import(Request $request){
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
            unset($data[1]);
            unset($data[2]);

            foreach ($data as $key=>$value ){
                //判断是否有手机
                if(empty($value[4])){
                    continue;
                }

                $mobile = explode('.',$value[4])[0];
                $old_merchant = Merchant::where('mobile',$mobile)->first();

                //判断商户是否存在，不存在就跳出
                if(!empty($old_merchant)){
                    $err_arr[$key] = $mobile.'已存在';
                    continue;
                }
                $token = str_random(60);
                $api_token = hcGetToken($token);
                $merchant_data = [
                    'mobile'=>$mobile,
                    'api_token'=>$api_token,
                ];
                $merchant = Merchant::create($merchant_data);

                $province = '{"code":"350000","name":"\u798f\u5efa\u7701"}'; //省份
                $city='{"code":"350200","name":"\u53a6\u95e8\u5e02"}';//城市
                $area ='{"code":"350203","name":"\u601d\u660e\u533a"}'; //区域
                $site = explode('-',$value[0])[0];
                if($site != 1&&$site != 2&&$site != 3&&$site != 4){
                    $err_arr[$key] = '请按模版输入区域位置';
                    continue;
                }
                $business_name=$value[1];        //商家名称
                $merchant_name=$value[2];        //商家简称
                $leader_name=$value[3];            //负责人姓名
                $mobile =$mobile;                 //负责人手机
                $leader_email = $value[5];           //负责人邮箱
                $leader_qq = explode('.',$value[7])[0];                 //负责人QQ
                $leader_wx = explode('.',$value[8])[0];                  //负责人微信
                $juridical_person= $value[9];    //法人姓名
                $service_mobile= explode('.',$value[11])[0];        //客服电话
                //经营资质
                $papers =[];
                if( $value[12] == 1){
                    $papers[] = 1;
                }
                if( $value[13] == 1){
                    $papers[] = 2;
                }
                if( $value[14] == 1){
                    $papers[] = 3;
                }
                if( $value[15] == 1){
                    $papers[] = 4;
                }
                if( $value[16] == 1){
                    $papers[] = 5;
                }
                if( $value[17] == 1){
                    $papers[] = 6;
                }
                if( $value[18] == 1){
                    $papers[] = 7;
                }
                if( $value[19] == 1){
                    $papers[] = 8;
                }
                $papers = json_encode($papers);
                $code = $value[20]; //统一社会信用代码
                //经营品类
                $type =[];
                if( $value[21] == 1){
                    $type[] = 1;
                }
                if( $value[22] == 1){
                    $type[] = 2;
                }
                if( $value[23] == 1){
                    $type[] = 3;
                }
                if( $value[24] == 1){
                    $type[] = 4;
                }
                if( $value[25] == 1){
                    $type[] = 5;
                }
                if( $value[26] == 1){
                    $type[] = 6;
                }
                $type = json_encode($type);
                //经营品牌
                $brand = [];
                if($value[27] == 1){
                    $brand[] = 1;
                }
                if($value[27] == 1){
                    $brand[] = 2;
                }
                if($value[29] == 1){
                    $brand[] = 3;
                }
                if($value[30] == 1){
                    $brand[] = 4;
                }
                $brand = json_encode($brand);
                $room_num = explode('.',$value[31])[0];//客房数量
                //最后装修时间
                $str = $value[32];
                $arr = date_parse_from_format('Y年m月d日',$str);
                if($arr['month'] == false){
                    $arr['month'] = rand(1,11);
                }
                if($arr['day'] == false){
                    $arr['day'] = rand(1,28);
                }
                $time = mktime(0,0,0,$arr['month'],$arr['day'],$arr['year']);
                $adorn_time = date("Y-m-d",$time);
                if($value[33]){
                    $invest = $value[33].'万,';
                }else{
                    $invest = $value[33];
                }
                $trait = $invest.$value[34];//投资规模及民宿特色
                $earning = $value[35];//营业收入（万/年）
                $lease = $value[36];//租期
                $rati = $value[37]; //入住率
                $price = $value[38];  //均价（元/间）
                $rent = $value[39];   //房租成本（万/年）
                $staff_num= $value[40]; //员工数量（人）
                //配套设施
                $config= [];
                if($value[41] = 1){
                    $config[] = 1;
                }
                if($value[42] = 1){
                    $config[] = 1;
                }
                if($value[43] = 1){
                    $config[] = 1;
                }
                if($value[44] = 1){
                    $config[] = 1;
                }
                if($value[45] = 1){
                    $config[] = 1;
                }
                if($value[46] = 1){
                    $config[] = 1;
                }
                $config = json_encode($config);
                //为用户预存数据到商户信息表中


                $item = [
                    'merchant_id'=> $merchant->id,         //商户id
                    'province'=>$province,                 //省份
                    'city'=>$city,                          //城市
                    'area'=>$area,                          //区域
                    'business_name'=>$business_name,        //商家名称
                    'merchant_name'=>$merchant_name,        //商家简称
                    'leader_name'=>$leader_name,            //负责人姓名
                    'leader_mobile'=>$mobile,               //负责人手机
                    'leader_email'=>$leader_email,           //负责人邮箱
                    'leader_qq'=>$leader_qq,                 //负责人QQ
                    'leader_wx'=>$leader_wx,                  //负责人微信
                    'juridical_person'=>$juridical_person,    //法人姓名
                    'service_mobile'=>$service_mobile,        //客服电话
                    'papers'=>$papers,                        //经营资质
                    'code'=>$code,                            //统一社会信用代码
                    'type'=>$type ,                            //经营品类
                    'brand' =>$brand,                           //经营品牌
                    'room_num' => $room_num,                   //客房数量
                    'adorn_time' =>$adorn_time ,               //最后装修时间
                    'trait' => $trait,                         //投资规模及民宿特色
                    'earning'=>$earning ,                      //营业收入（万/年）
                    'lease'=>$lease ,                          //租期
                    'ratio'=>$rati ,                           //入住率
                    'price'=> $price,                          //均价（元/间）
                    'rent'=>$rent,                             //房租成本（万/年）
                    'staff_num'=>$staff_num,                   //员工数量（人）
                    'config' => $config,                       //配套设施
                    'site' => $site,                       //所属区域
                ];
                $merchant_info = [
                    'merchant_id'=> $merchant->id, //商户id
                    'merchant_name'=>$business_name, //商家名称
                    'merchant_short_name'=>$merchant_name,//商家简称
                    'merchant_principal'=>$leader_name,//负责人
                    'business_num'=>$code, //注册号
                    'business_name'=>$business_name,//营业执照名称
                    'business_person'=>$juridical_person,//营业执照法人
                    'identity_name'=>$juridical_person,//身份证姓名
                ];
                $dorm_data = SmDormInfo::create($item);
                $merchant_data = MerchantInfo::create($merchant_info);
                $homestay_data = HomestayInfo::create($merchant_info);
            }

        });

        if (empty($err_arr)) {
            DB::commit();
            $msg = '文件上传成功';
            admin_action_logs($cretae_path, "导入商户");
        } else {
            DB::rollback();
            $msg = "文件上传失败，存在错误";
        }
        return back()->with('msg', $msg)->withErrors($err_arr);
    }
}
