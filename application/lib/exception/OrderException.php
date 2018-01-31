<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/11/23
 * Time: 13:04
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;
    public $msg = '订单不存在，请检查ID';
    public $errorCode = 80000;
}