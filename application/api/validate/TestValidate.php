<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/25
 * Time: 21:33
 */

namespace app\api\validate;


use think\Validate;

class TestValidate extends Validate
{
    protected $rule = [
        'name'  =>  'require|min:2|max:10',
        'email' =>  'email'
    ];
}