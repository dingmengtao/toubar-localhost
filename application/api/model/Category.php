<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/31
 * Time: 23:59
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ['delete_time','update_time','create_time'];
    public function img(){
        return $this->belongsTo('Image','topic_img_id','id');
    }
}