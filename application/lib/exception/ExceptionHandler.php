<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/26
 * Time: 10:54
 */

namespace app\lib\exception;


use think\exception\Handle;
use think\Log;
use think\Request;
use think\Exception;

class ExceptionHandler extends Handle
{
    public function render(\Exception $e)
    {
        if($e instanceof BaseException){
//            如果是自定义的异常
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }else{
            if(config('app_debug')){
                return parent::render($e);
            }else{
                $this->code = 500;
                $this->msg = '服务器内部错误';
                $this->errorCode = 999;
                $this->recordErrorLog($e);
            }
        }
        $request = Request::instance();
        $result = [
            'msg'   =>  $this->msg,
            'errorCode' =>  $this->errorCode,
            'request_url'   =>  $request->url()
        ];
        return json($result,$this->code);
    }

//    日志
    private function recordErrorLog(\Exception $e){
//        初始化日志
        Log::init([
            'type'  =>  'File',
            'path'  =>  LOG_PATH,
            'level' =>  ['error']
        ]);
        Log::record($e->getMessage(),'error');
    }
}