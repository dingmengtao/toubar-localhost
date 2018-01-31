<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/31
 * Time: 14:56
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $code = 404;
    public $msg = '制定的主题不存在，请检查主题ID';
    public $errorCode = 30000;
}