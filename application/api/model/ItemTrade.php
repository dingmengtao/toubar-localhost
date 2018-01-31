<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/12/13
 * Time: 15:16
 */

namespace app\api\model;


class ItemTrade extends BaseModel
{
    //    隐藏不需要显示的字段
    protected $hidden = [];
    //    自动写入时间戳
    protected $autoWriteTimestamp = true;
}