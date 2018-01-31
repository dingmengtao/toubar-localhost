<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/31
 * Time: 22:39
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule = [
        'count' =>  'isPositiveInteger|between:1,16'
    ];
    protected $message = [
        'count' =>  '必须是正整数',
        'count.between' =>  '可选最近新品范围1到16条'
    ];
}