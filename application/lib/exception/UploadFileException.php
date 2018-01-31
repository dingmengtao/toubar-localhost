<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/12/25
 * Time: 15:24
 */

namespace app\lib\exception;


class UploadFileException extends BaseException
{
    public $code = 404;
    public $msg = '创建项目未上传对应文件';
    public $errorCode = 50010;
}