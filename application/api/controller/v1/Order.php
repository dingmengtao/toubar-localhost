<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/11/22
 * Time: 15:44
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IdMustBePostiveInt;
use app\api\validate\OrderPlace;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;
use app\api\validate\PagingParameter;
use app\api\model\Order as OrderModel;
use app\lib\exception\OrderException;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope' => ['only' => 'getSummaryByUser,getDetail']
    ];
    public function placeOrder(){
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUid();

        $order = new OrderService();
        $status = $order->place($uid,$products);
        return $status;
    }
    public function getSummaryByUser($page=1,$size=15){
        (new PagingParameter())->goCheck();
        $uid = TokenService::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryByUser($uid,$page,$size);
        if($pagingOrders->isEmpty()){
            return [
                'data' => [],
                'current_page' => $pagingOrders->currentPage()
            ];
        }
        $data = $pagingOrders->hidden(['snap_items','snap_address','next_item','prepay_id'])->toArray();
//        $data = $pagingOrders->toArray();
        return [
            'data' => $data,
            'current_page' => $pagingOrders->currentPage()
        ];
    }
    public function getDetail($id){
        (new IdMustBePostiveInt())->goCheck();
        $orderDetail = OrderModel::get($id);
        if(!$orderDetail){
            throw new OrderException();
        }
        return $orderDetail->hidden(['prepay_id']);
    }
}