<?php

namespace App\Lib\WxMsg;

use EasyWeChat\Factory;


class WxMsg
{
    //说明，该类依赖于easywechat,是基于easywechat而实现的业务处理逻辑类

    private $app; //微信模型

    //模板初始化信息，可以归纳成类
    private $templateIdArr = [
        'check_info' => [
            'tempid' => 's5JOa4KO33E6_EVTrqu5fZdoLG1XgFoUufY_U-NKkDk',
        ],
    ];

    public function __construct($options)
    {
        //实例化微信模型
        //$options=config('wechat');

        $this->app=Factory::officialAccount($options);
    }

    /**
     * 发送微信公众号模板信息
     * @param string $type 模板类型
     * @param string $web_url 链接地址
     * @param array $detail_type=null 数组数据
     * @return object
     */
    public function notice_send($type, $web_url, $detail_type = null)
    {

        if (!isset($this->templateIdArr[$type])) {
            return false;
        }

        switch ($type) {
            case 'check_info':
                $this->check_info($web_url, $detail_type);
                break;

        }
    }


    //商户通过身份储蓄卡认证信息发送
    private function check_info($web_url, $detail_type)
    {
        $type = 'check_info';

        $open_id='o9rlv1o79BxxuAR2TR3F1kmHgUCQ';
        $templateId = $this->templateIdArr[$type]['tempid'];
        $url = $web_url; //跳转的位置

        $time = date('Y年m月d日 H时');
        $data = array();

        $data['first'] = "1，商户入驻信息审核*条2，民宿核验信息审核*条 3，意见反馈*条";
        $data['remark'] = '请尽快登录平台进行处理！';
        $data['keyword1'] = '审核和意见反馈';
        $data['keyword2'] = '10';
        $data['keyword2'] = $time;

        try{
           return $this->app->template_message->send([
                        'touser' => $open_id,
                        'template_id' => $templateId,
                        'url' => $url,
                        'data' => $data]);
        }catch(\Exception $e){
            return false;
        }

    }

}
