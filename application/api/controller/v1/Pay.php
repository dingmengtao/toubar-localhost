<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/11/28
 * Time: 11:18
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\WxNotify;
use app\api\validate\IdMustBePostiveInt;
use app\api\service\Pay as PayService;

class Pay extends BaseController
{
//    权限校验
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];
    public function getPreOrder($id=''){
        (new IdMustBePostiveInt())->goCheck();
        $pay = new PayService($id);
        return $pay->pay();
    }
    public function receiveNotify(){
//        1.检查库存，超卖（可能性非常小）
//        2.更新这个订单的状态
//        3.减库存
//        如果成功处理，返回给微信成功处理的消息；否则，返回给微信没有成功处理的消息
//        特点：post；xml格式；不携带参数
        $notify = new WxNotify();
        $notify->Handle();
    }
}