<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/12/16
 * Time: 14:18
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\Trade as TradeModel;
use app\lib\exception\TradeException;

class Trade extends BaseController
{
    //    获取所有行业（领域）名称列表接口
    public function getTradeAll(){
        $trades = TradeModel::getTrades();
        if(empty($trades)){
            throw new TradeException();
        }
        return $trades;
    }
}