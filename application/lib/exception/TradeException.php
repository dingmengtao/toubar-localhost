<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/12/20
 * Time: 9:48
 */

namespace app\lib\exception;


class TradeException extends BaseException
{
    public $code = 404;
    public $msg = '没有行业列表信息';
    public $errorCode = 50004;
}