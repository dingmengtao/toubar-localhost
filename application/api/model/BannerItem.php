<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/30
 * Time: 11:53
 */

namespace app\api\model;


class BannerItem extends BaseModel
{
    protected $hidden = ['id','banner_id','img_id','delete_time','update_time'];
    public function img(){
        return $this->belongsTo('Image','img_id','id');
    }
}