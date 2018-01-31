<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/26
 * Time: 10:59
 */

namespace app\lib\exception;


use think\Exception;

class BaseException  extends Exception
{
    public $code = 400;//HTTP请求状态码
    public $msg = '参数错误';//错误具体信息
    public $errorCode = 10000;//自定义错误码
    public function __construct($params = [])
    {
        if(!is_array($params)){
            return ;
//            throw new Exception('参数必须是数组');
        }
        if(array_key_exists('code',$params)){
            $this->code = $params['code'];
        }
        if(array_key_exists('msg',$params)){
            $this->msg = $params['msg'];
        }
        if(array_key_exists('errorCode',$params)){
            $this->errorCode = $params['errorCode'];
        }
    }
}