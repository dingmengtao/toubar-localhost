<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/12/14
 * Time: 10:48
 */

namespace app\api\model;


use tests\thinkphp\library\think\cache\driver\redisTest;

class Investor extends BaseModel
{
    //        隐藏不需要的字段
    protected $hidden = ['id','user_id','isaudit','isshow','company','telephone','identify_one_url','identify_two_url','delete_time','create_time','update_time'];
    //    自动写入时间戳
    protected $autoWriteTimestamp = true;

    //    读取器
    public function getImgUrlAttr($value){
        return $this->prefixImgUrl($value);
    }
    public function getIdentifyOneUrlAttr($value){
        return $this->prefixImgUrl($value);
    }
    //    添加认证投资人时查询是否已经存在认证投资人
    public static function getInvestor($telephone){
        $investor = self::where('telephone','=',$telephone)->find();
        return $investor;
    }
    //    获取所有投资人信息，形成列表
    public static function getInvestors(){
//        $investors = self::all([],'trades');
        $investors = self::with(['trades'])->order('create_time','desc')->select();
        return $investors;
    }
    //    模型关联：投资人模型关联行业模型，多对多关联
    public function trades(){
        return $this->belongsToMany('Trade','investor_trade','trade_id','investor_id');
    }
    //    保存图片
    public static function saveImages($files){
        $images_path = config('setting.upload_images');
        $img_urls = self::saveFiles($files,$images_path);
        return $img_urls;
    }
}