<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/11/1
 * Time: 23:35
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'Token已过期或无效Token';
    public $errorCode = 10001;
}