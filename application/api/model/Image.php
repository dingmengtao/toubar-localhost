<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/30
 * Time: 14:24
 */

namespace app\api\model;


class Image extends BaseModel
{
    protected $hidden = ['id','delete_time','update_time','from'];
//    读取器
    public function getUrlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }
}