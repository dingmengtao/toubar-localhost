<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/11/21
 * Time: 17:26
 */

namespace app\lib\exception;


class SuccessMessage extends BaseException
{
    public $code = 201;
    public $msg = 'ok';
    public $errorCode = 0;
}