<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/11/29
 * Time: 16:14
 */

namespace app\api\validate;


class PagingParameter extends BaseValidate
{
    protected $rule = [
        'page' => 'isPositiveInteger',
        'size' => 'isPositiveInteger'
    ];
    protected $message = [
        'page' => '分页参数必须是正整数',
        'size' => '分页参数必须是正整数',
    ];
}