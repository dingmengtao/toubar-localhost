<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/11/28
 * Time: 13:05
 */

namespace app\api\service;


use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use app\api\service\Token as TokenService;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay',EXTEND_PATH,'.Api.php');

class Pay
{
    private $orderId;
    private $orderNo;

    function __construct($orderId){
        if(!$orderId){
            throw  new Exception('订单号id不允许为NULL');
        }
        $this->orderId = $orderId;
    }
    public function pay(){
//        1.订单号可能根本就不存在
//        2.订单号存在，但是订单和当前用户不存在
//        3.订单可能已经被支付过
//        4.库存量检测
        $this->checkOrderValid();
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderId);
        if(!$status['pass']){
            return $status;
        }
        return $this->makeWxPreOrder($status['orderPrice']);
    }
    private function makeWxPreOrder($totalPrice){
//        获取openid
        $openid = TokenService::getCurrentTokenVar('openid');
        if(!$openid){
            throw new TokenException();
        }
        $wxOrderData = new \WxPayUnifiedOrder();
//        在WxPay.Config.php中配置appid、商户号、密钥、app_secret以及curlde 539行严格校验false改为2
        $wxOrderData->SetOut_trade_no($this->orderNo);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice*100);
        $wxOrderData->SetBody('零食商贩');
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url(config('secure.pay_back_url'));//回调函数调用的url
        return $this->getPaySignature($wxOrderData);
    }
    private function getPaySignature($wxOrderData){
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);
        if($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] != 'SUCCESS'){
            Log::record($wxOrder,'error');
            Log::record('获取预支付订单失败','error');
        }
//        将prepay_id更新到对应订单的记录里，用于发送模板消息
        $this->recordPreOrder($wxOrder);
        $signature = $this->sign($wxOrder);
        return $signature;
    }
    private function sign($wxOrder){
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());
//        生成随机字符串
        $rand = md5(time().mt_rand(0,1000));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage('prepay_id='.$wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');
//        生成签名
        $sign = $jsApiPayData->MakeSign();
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;
        unset($rawValues['appId']);

        return $rawValues;
    }
    private function recordPreOrder($wxOrder){
        OrderModel::where('id','=',$this->orderId)->update(['prepay_id' => $wxOrder['prepay_id']]);
    }
    private function checkOrderValid(){
        $order = OrderModel::where('id','=',$this->orderId)->find();
        if(!$order){
            throw new OrderException();
        }
        if(!TokenService::isValidOperate($order->user_id)){
            throw new TokenException([
                'msg' => '订单与用户不匹配',
                'errorCode' => 10003
            ]);
        }
        if($order->status != OrderStatusEnum::UNPAID){
            throw new OrderException([
                'msg' => '订单已经支付过',
                'errorCode' => 80003,
                'code' => 400
            ]);
        }
        $this->orderNo = $order->order_no;
        return true;
    }
}