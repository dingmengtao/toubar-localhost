<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/11/21
 * Time: 11:05
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['product_id','img_id','delete_time'];
    public function imgUrl(){
        return $this->belongsTo('Image','img_id','id');
    }
}