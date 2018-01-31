<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/11/22
 * Time: 14:40
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg = '权限不够';
    public $errorCode = 10001;
}