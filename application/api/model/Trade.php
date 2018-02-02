<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/12/15
 * Time: 10:47
 */

namespace app\api\model;


class Trade extends BaseModel
{
    protected $table = 'we_trade';
    //    隐藏不需要显示的字段
    protected $hidden = ['isshow','delete_time','create_time','update_time','pivot'];
    //    自动写入时间戳
    protected $autoWriteTimestamp = true;

    //    模型关联：项目模型关联项目模型，多对多关联
    public function items(){
        return $this->belongsToMany('Item','we_item_trade','item_id','trade_id');
    }
    //    根据行业id获取项目id列表,形成数组并返回
    public static function itemIds($trade_id){
        $trades = self::with('items')->where('id','=',$trade_id)->select()->toArray();
        $item_ids = array();
        if(array_key_exists('items',$trades[0])){
            foreach($trades[0]['items'] as $items){
                $item_ids[] = $items['id'];
            }
        }
        return $item_ids;
    }
    //    获取所有行业（领域）名称列表
    public static function getTrades(){
        $trades = self::all();
        return $trades;
    }
}