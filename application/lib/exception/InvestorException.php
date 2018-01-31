<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/12/15
 * Time: 12:53
 */

namespace app\lib\exception;


class InvestorException extends BaseException
{
    public $code = 404;
    public $msg = '没有认证的投资人信息';
    public $errorCode = 50000;
}