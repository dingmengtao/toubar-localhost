<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/12/15
 * Time: 13:31
 */

namespace app\api\validate;


class CheckTradeStage extends BaseValidate
{
    protected $rule = [
        'tradeid' => 'isPositiveInteger',
        'stageid' => 'isPositiveInteger'
    ];
}