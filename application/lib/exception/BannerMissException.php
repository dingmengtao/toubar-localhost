<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/26
 * Time: 13:19
 */

namespace app\lib\exception;

class BannerMissException extends BaseException
{
    public $code = 404;
    public $msg = '请求的Banner不存在';
    public $errorCode = '40000';
}