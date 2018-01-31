<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/31
 * Time: 14:00
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule = [
        'code'  =>  'require|isNotEmpty'
    ];
    protected $message = [
        'code'  =>  '没有code，不能获取token'
    ];
}