<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/11/1
 * Time: 16:46
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 400;
    public $msg = '微信服务器接口调用失败';
    public $errorCode = 999;
}