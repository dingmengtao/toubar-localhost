<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/26
 * Time: 16:53
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 10000;
}