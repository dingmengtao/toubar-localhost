<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/12/15
 * Time: 12:52
 */

namespace app\lib\exception;


class ItemException extends BaseException
{
    public $code = 404;
    public $msg = '没有指定精选项目';
    public $errorCode = 50000;
}