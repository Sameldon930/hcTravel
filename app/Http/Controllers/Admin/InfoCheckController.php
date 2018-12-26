<?php

namespace App\Http\Controllers\Admin;

use App\HomestayInfo;
use App\HouseAudit;
use App\Lib\MobileMsg\MobileMsgSend;
use App\Merchant;
use App\MerchantInfo;
use App\VerifyLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InfoCheckController extends Controller
{
    /***
     * 信息审核首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        $search_items = [
            'mobile' => [
                'type' => 'custom',
                'form' => 'text',
                'label' => '手机号',
            ],
            'status' => [
                'type' => 'equal',
                'form' => 'select',
                'label' => '状态',
                'options' => VerifyLog::CHECK_AUDIT,
            ],
            'type' => [
                'type' => 'equal',
                'form' => 'select',
                'label' => '类型',
                'options' => VerifyLog::VERIFY_TYPE,
            ],
            'created_at' => [
                'type' => 'date',
            ],
        ];

        $datas =VerifyLog::orderby('created_at','desc')
            ->with('merchant')
            ->search($search_items)
            ->paginate(20)
        ;

        return _view('admin.merchant.info_check.index',compact('datas'));
    }


    /**
     * 信息审核详情
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {   $data = VerifyLog::find($id);
        $data->verify_success = json_decode($data->verify_success);
        if($data->type == VerifyLog::MERCHANT_VERIFY){
            return _view('admin.merchant.info_check.merchant',compact('data'));
        }
        if($data->type == VerifyLog::HOMESTAY_VERIFY){
            return _view('admin.merchant.info_check.show',compact('data'));
        }
        if($data->type == VerifyLog::HOUSE_VERIFY){
            return _view('admin.merchant.info_check.house',compact('data'));
        }
    }


    /**
     * 审核信息
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request, $id)
    {
        //判断审核是否通过
        $successId =  '338965';//通过短信模版
        $failId =  '338966';//不通过短信模版
        $mobileSend = new MobileMsgSend();
        DB::beginTransaction();
        $merchantModel = new merchant();
        //认证通过
        if($request->status == VerifyLog::SUCCESS_AUDIT){
            $verify = VerifyLog::find($id);
            $verify->status = VerifyLog::SUCCESS_AUDIT;
            $verify->save();
            //商户认证通过
            if($verify->type ==VerifyLog::MERCHANT_VERIFY){
                $merchantInfo = MerchantInfo::where('merchant_id',$verify->merchant_id)->first();
                $merchantInfo->status = MerchantInfo::SUCCESS_AUDIT;
                $merchantInfo->save();
                $merchant = Merchant::find($verify->merchant_id);
                $merchantModel->auditSuccess($merchant,Merchant::STATUS_ARRAY[0]);
                $result = $mobileSend->send($merchant->mobile, '商户认证',$successId,false);
                admin_action_logs($merchant, "商户审核通过（{$merchant->merchantInfo->merchant_principal}）");
            }
            //民宿核验认证通过
            if($verify->type ==VerifyLog::HOMESTAY_VERIFY){
                $homestay = HomestayInfo::where('merchant_id',$verify->merchant_id)->first();
                $homestay->status = HomestayInfo::SUCCESS_AUDIT;
                $homestay->save();
                $merchant = Merchant::find($verify->merchant_id);
                $merchantModel->auditSuccess($merchant,Merchant::STATUS_ARRAY[0]);
                $merchantModel->auditSuccess($merchant,Merchant::STATUS_ARRAY[1]);
                $result = $mobileSend->send($merchant->mobile, '民宿核验',$successId,false);
                admin_action_logs($merchant, "民宿核验通过（{$merchant->merchantInfo->merchant_principal}）");
            }
            //房屋鉴定通过
            if($verify->type ==VerifyLog::HOUSE_VERIFY){
                $house = HouseAudit::where('merchant_id',$verify->merchant_id)->first();
                $house->status = HouseAudit::SUCCESS_AUDIT;
                $house->save();
                $merchant = Merchant::find($verify->merchant_id);
                $merchantModel->auditSuccess($merchant,Merchant::STATUS_ARRAY[2]);
                $result = $mobileSend->send($merchant->mobile, '房屋鉴定',$successId,false);
                admin_action_logs($merchant, "房屋鉴定通过（{$merchant->merchantInfo->merchant_principal}）");
            }

        }else{
            //认证失败
            $verify = VerifyLog::find($id);
            $verify->status = VerifyLog::FAIL_AUDIT;
            $verify->feedback = $request->feedback;
            $verify->save();
            //商户认证失败
            if($verify->type ==VerifyLog::MERCHANT_VERIFY){
                $merchantInfo = MerchantInfo::where('merchant_id',$verify->merchant_id)->first();
                $merchantInfo->status = MerchantInfo::FAIL_AUDIT;
                $merchantInfo->save();
                $merchant = Merchant::find($verify->merchant_id);
                $merchantModel->auditFail($merchant,Merchant::STATUS_ARRAY[0]);
                $result = $mobileSend->send($merchant->mobile, '商户认证',$failId,false);
                admin_action_logs($merchant, "商户认证失败（{$merchant->merchantInfo->merchant_principal}）");
            }
            //民宿核验失败
            if($verify->type ==VerifyLog::HOMESTAY_VERIFY){
                $homestay = HomestayInfo::where('merchant_id',$verify->merchant_id)->first();
                $homestay->status = HomestayInfo::FAIL_AUDIT;
                $homestay->save();
                $merchant = Merchant::find($verify->merchant_id);
                $merchantModel->auditFail($merchant,Merchant::STATUS_ARRAY[1]);
                $result =$mobileSend->send($merchant->mobile, '民宿核验',$failId,false);
                admin_action_logs($merchant, "民宿核验失败（{$merchant->merchantInfo->merchant_principal}）");
            }
            //房屋鉴定失败
            if($verify->type ==VerifyLog::HOUSE_VERIFY){
                $house = HouseAudit::where('merchant_id',$verify->merchant_id)->first();
                $house->status = HouseAudit::FAIL_AUDIT;
                $house->save();
                $merchant = Merchant::find($verify->merchant_id);
                $merchantModel->auditFail($merchant,Merchant::STATUS_ARRAY[2]);
                $result =$mobileSend->send($merchant->mobile, '房屋鉴定',$failId,false);
                admin_action_logs($merchant, "房屋鉴定失败（{$merchant->merchantInfo->merchant_principal}）");
            }

        }
        DB::commit();

        return redirect()->route('admin.info_check.index')->with('msg','已审核');
    }


}
