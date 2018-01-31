<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/11/1
 * Time: 0:14
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code = 404;
    public $msg = '指定类型不存在，请检查参数';
    public $errorCode = 50000;
}