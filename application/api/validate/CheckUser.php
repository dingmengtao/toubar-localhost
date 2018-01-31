<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2018/1/6
 * Time: 17:35
 */

namespace app\api\validate;


class CheckUser extends BaseValidate
{
    protected $rule = [
//        'user_nickname' => 'require|isNotEmpty',
//        'user_gender' => 'require|isPositiveInteger',
//        'user_city' => 'require|isNotEmpty',
//        'user_province' => 'require|isNotEmpty',
//        'user_country' => 'require|isNotEmpty',
//        'user_language' => 'require|isNotEmpty'
        'user_nickname' => 'require|isNotEmpty',
        'user_gender' => 'require|isPositiveInteger',
        'user_city' => 'isOriginValue',
        'user_province' => 'isOriginValue',
        'user_country' => 'require|isNotEmpty',
        'user_language' => 'require|isNotEmpty'
    ];
}