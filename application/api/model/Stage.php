<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/12/15
 * Time: 12:43
 */

namespace app\api\model;


class Stage extends BaseModel
{
    protected $table = 'we_stage';
    //    隐藏不需要显示的字段
    protected $hidden = ['isshow','delete_time','create_time','update_time'];
    //    自动写入时间戳
    protected $autoWriteTimestamp = true;

    //    获取所有阶段名称列表
    public static function getStages(){
        $stages = self::all();
        return $stages;
    }
}