<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/12/13
 * Time: 15:01
 */

namespace app\api\model;

use app\api\model\Trade as TradeModel;

class Item extends BaseModel
{
    //    隐藏不需要显示的字段
    protected $hidden = ['user_id','stage_id','isgood','isshow','isaudit','delete_time','update_time'];
    //    自动写入时间戳
    protected $autoWriteTimestamp = true;
    //    读取器
    public function getBpUrlAttr($value){
        return $this->prefixBpUrl($value);
    }
    public function getVideoUrlAttr($value){
        return $this->prefixVideoUrl($value);
    }
    public function getImgUrlAttr($value){
        return $this->prefixVideoUrl($value);
    }
    //    项目所属阶段
    public function stage(){
        return $this->belongsTo('Stage','stage_id','id');
    }
    //    模型关联：项目模型关联行业模型，多对多关联
    public function trades(){
        return $this->belongsToMany('Trade','item_trade','trade_id','item_id');
    }
    //    精选项目列表
    public static function getGoodItems(){
        $goodItems = self::with(['stage','trades'])->where('isgood','=','1')->order('create_time','desc')->select();
        return $goodItems;
    }
    //    项目列表
    public static function getItems($trade_id=1,$stage_id=1){
        if($trade_id && $stage_id){
            if($trade_id==1 && $stage_id==1){
                $items = self::with(['stage','trades'])->order('create_time','desc')->select();
            }elseif($trade_id==1 && $stage_id!=1){
                $items = self::with(['trades','stage'])->where('stage_id','=',$stage_id)->order('create_time','desc')->select();
            }elseif($trade_id!=1 && $stage_id==1){
                $items_ids = TradeModel::itemIds($trade_id);
                $items = self::with(['trades','stage'])->where('id','in',$items_ids)->order('create_time','desc')->select();
            }elseif($trade_id!=1 && $stage_id!=1){
                $items_ids = TradeModel::itemIds($trade_id);
                $items = self::with(['trades','stage'])->where('stage_id','=',$stage_id)->where('id','in',$items_ids)->order('create_time','desc')->select();
            }
        }
        return $items;
    }
    //    保存路演视频
    public static function saveVideo($file){
        $videos_path = config('setting.upload_videos');
        $video_url = self::saveFiles($file,$videos_path);
        return $video_url;
    }
    //    保存路演视频缩略图
//    public static function saveVideoImg($video_url,$file){
//        $video_img_url = self::saveFiles($file,'',$video_url);
//        return $video_img_url;
//    }
}