<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/11/21
 * Time: 15:24
 */

namespace app\api\validate;


class AddressNew extends BaseValidate
{
    protected $rule = [
        'name'      =>  'require|isNotEmpty',
        'mobile'    =>  'require|isMobile',
        'province'  =>  'require|isNotEmpty',
        'city'      =>  'require|isNotEmpty',
        'country'   =>  'require|isNotEmpty',
        'detail'    =>  'require|isNotEmpty',
    ];
}