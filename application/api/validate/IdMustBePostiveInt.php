<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/25
 * Time: 22:21
 */

namespace app\api\validate;



class IdMustBePostiveInt extends BaseValidate
{
    protected $rule = [
        'id'    =>  'require|isPositiveInteger',
    ];
    protected $message = [
        'id' => '必须是正整数'
    ];
}