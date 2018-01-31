<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/26
 * Time: 10:35
 */

namespace app\api\model;


class Banner extends BaseModel
{
    protected $hidden = ['delete_time','update_time'];
//    关联BannerItem模型
    public function items(){
        return $this->hasMany('BannerItem','banner_id','id');
    }
    /**
     * 根据id获取banner信息
     * @id banaer的id号
     * */
    public static function getBannerById($id){
        $banner = self::with(['items','items.img'])->find($id);
        return $banner;
    }
}