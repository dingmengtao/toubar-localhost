<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/11/21
 * Time: 11:11
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = ['product_id','delete_time','id'];
}