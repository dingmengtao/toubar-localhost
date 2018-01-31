<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/12/12
 * Time: 15:22
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class CheckItem extends BaseValidate
{
    protected $rule = [
        'item_name' => 'require|isNotEmpty',
        'item_trade_ids' => 'require|checkTradeIds',
        'item_stage_id' => 'require|isPositiveInteger',
        'item_telephone' => 'require|isMobile',
        // 'item_bp_url' => 'require|isFileTypePdf',
        'item_video_url' => 'require|isFileTypeVideo',
        'video_img_url' => 'require|isFileTypeImage'
    ];
    // 验证文件类型-自定义方法名，isFileType+文件类型
    // 验证文件类型是否pdf格式
    protected function isFileTypePdf($value){
        $type_array = array('pdf');//目标文件类型
        $need_type = strtolower(implode('/',$type_array));
        if($value){
            $res = BaseValidate::isFileType($value,$type_array);
            if($res){
                return true;
            }else{
                throw new ParameterException([
                    'msg' => '文件类型错误，必须为'.$need_type.'类型'
                ]);
            }
        }else{
            throw new ParameterException([
                'msg' => '未上传项目BP或出现异常，请重新上传'
            ]);
        }
    }
    // 验证文件类型是否视频格式
    protected function isFileTypeVideo($value){
        $type_array = array('rm','rmvb','wmv','avi','mp4','3gp','mkv','mov','flv');//目标文件类型
        $need_type = strtolower(implode('/',$type_array));
        if($value){
            $res = BaseValidate::isFileType($value,$type_array);
            if($res){
                return true;
            }else{
                throw new ParameterException([
                    'msg' => '文件类型错误，必须为'.$need_type.'类型'
                ]);
            }
        }else{
            throw new ParameterException([
                'msg' => '未上传路演视频或出现异常，请重新上传'
            ]);
        }
    }
    // 验证文件类型是否图片格式
    protected function isFileTypeImage($value){
        $type_array = array('jpg','jpeg','png','gif');//目标文件类型
        $need_type = strtolower(implode('/',$type_array));
        if($value){
            $res = BaseValidate::isFileType($value,$type_array);
            if($res){
                return true;
            }else{
                throw new ParameterException([
                    'msg' => '文件类型错误，必须为'.$need_type.'类型'
                ]);
            }
        }else{
            throw new ParameterException([
                'msg' => '未生成视频对应的封面图片'
            ]);
        }
    }
}