<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/11/23
 * Time: 10:43
 */

namespace app\api\service;


use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use think\Db;
use think\Exception;

class Order
{
//    订单的商品列表，即客户端传来的商品列表参数
    protected $oProducts;
//    数据库中的商品列表
    protected $products;
    protected $uid;
    public function place($uid,$oProducts){
//        products和oProducts对比
//        products从数据库中取出
        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrder($oProducts);
//        $this->products = self::getProductsByOrder($oProducts);
        $this->uid = $uid;
        $status = $this->getOrderStatus();
        if(!$status['pass']){
            $status['order_id'] = -1;
            return $status;
        }
//        开始创建订单
        $orderSnap = $this->snapOrder($status);
        $order = $this->createOrder($orderSnap);
        $order['pass'] = true;
        return $order;
    }
//    创建订单
    private function createOrder($snap){
//        开启事务
        Db::startTrans();
        try {
            $orderNo = $this->makeOrderNo();
            $order = new \app\api\model\Order();
            $order->user_id = $this->uid;
            $order->order_no = $orderNo;
            $order->total_price = $snap['orderPrice'];
            $order->total_count = $snap['totalCount'];
            $order->snap_img = $snap['snapImg'];
            $order->snap_name = $snap['snapName'];
            $order->snap_address = $snap['snapAddress'];
            $order->snap_items = json_encode($snap['pStatus']);//快照
            //        写入数据库order表
            $order->save();

            $orderId = $order->id;
            $create_time = $order->create_time;
            foreach ($this->oProducts as &$p) {
                $p['order_id'] = $orderId;
            }
            $orderProduct = new OrderProduct();
//            写入数据库order_product
            $orderProduct->saveAll($this->oProducts);

//            提交事务
            Db::commit();
            return [
                'order_no' => $orderNo,
                'order_id' => $orderId,
                'create_time' => $create_time
            ];
        }catch (Exception $ex){
//            执行数据库出现异常，回滚事务
            Db::rollback();
            throw $ex;
        }
    }
//    生成订单号
    public static function makeOrderNo(){
        $yCode = array('A','B','C','D','E','F','G','H','I','J');
        $orderSn = $yCode[intval(date('Y')) - 2017].strtoupper(dechex(date('m'))).date('d').substr(time(),-5).substr(microtime(),2,5).sprintf('%02d',rand(0,99));
        return $orderSn;
    }
//    生成订单快照
    private function snapOrder($status){
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus'    => [],
            'snapAddress'=> null,
            'snapName'   => '',
            'snapImg'    => ''
        ];
        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapName'] = $this->products[0]['name'];
        $snap['snapImg'] = $this->products[0]['main_img_url'];
        if(count($this->products) > 1){
            $snap['snapName'] .= '等';
        }
        return $snap;
    }
    private function getUserAddress(){
        $userAddress = UserAddress::where('user_id','=',$this->uid)->find();
        if(!$userAddress){
            throw new UserException([
                'msg' => '用户收货地址不存在，下单失败',
                'errorCode' => 60001
            ]);
        }
        return $userAddress->toArray();
    }
    public function checkOrderStock($orderId){
        $oProducts = OrderProduct::where('order_id','=',$orderId)->select();
        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrder($oProducts);
        $status = $this->getOrderStatus();
        return $status;
    }
//    检查库存
    private function getOrderStatus(){
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatusArray' => []
        ];
        foreach($this->oProducts as $oProduct){
            $pStatus = $this->getProductStatus($oProduct['product_id'],$oProduct['count'],$this->products);
            if(!$pStatus['haveStock']){
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['count'];
            array_push($status['pStatusArray'],$pStatus);
        }
        return $status;
    }
    private function getProductStatus($oPID,$oCount,$products){
        $pIndex = -1;
        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'totalPrice' => 0
        ];
        for($i=0;$i<count($products);$i++){
            if($oPID == $products[$i]['id']){
                $pIndex = $i;
            }
        }
        if($pIndex == -1){
//            客户端传递过来的product_id有可能不存在
            throw new OrderException([
                'msg' => 'id为'.$oPID.'商品不存在，创建订单失败'
            ]);
        }else{
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['name'] = $product['name'];
            $pStatus['count'] = $oCount;
            $pStatus['totalPrice'] = $product['price'] * $oCount;
            if($product['stock'] - $oCount >= 0){
                $pStatus['haveStock'] = true;
            }
        }
        return $pStatus;
    }
//    根据订单信息查找真实的数据库商品列表
    private function getProductsByOrder($oProducts){
        $oPIDs = [];
        foreach($oProducts as $item){
            array_push($oPIDs, $item['product_id']);
        }
        $products = Product::all($oPIDs)->visible(['id','price','stock','name','main_img_url'])->toArray();
        return $products;
    }

}