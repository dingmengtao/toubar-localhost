<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/12/20
 * Time: 9:45
 */

namespace app\lib\exception;


class StageException extends BaseException
{
    public $code = 404;
    public $msg = '没有融资阶段信息';
    public $errorCode = 50004;
}