<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/11/21
 * Time: 17:05
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = 60000;
}