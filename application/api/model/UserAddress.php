<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/11/22
 * Time: 0:06
 */

namespace app\api\model;


class UserAddress extends BaseModel
{
    protected $hidden = ['user_id','delete_time','id'];
}