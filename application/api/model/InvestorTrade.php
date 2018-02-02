<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/12/14
 * Time: 10:49
 */

namespace app\api\model;


class InvestorTrade extends BaseModel
{
    protected $table = 'we_investor_trade';
    //    隐藏不需要显示的字段
    protected $hidden = [];
    //    自动写入时间戳
    protected $autoWriteTimestamp = true;

}