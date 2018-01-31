<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/12/14
 * Time: 10:50
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class CheckInvestor extends BaseValidate
{
    protected $rule = [
        'investor_img_url' => 'require|isFileTypeImage',
        'investor_name' => 'require|isNotEmpty',
        'investor_company' => 'require|isNotEmpty',
        'investor_job' => 'require|isNotEmpty',
        'investor_telephone' => 'require|isMobile',
        'investor_trade_ids' => 'require|checkTradeIds',
        'investor_identify_one_url' => 'require|isFileTypeImage'
    ];
    //    验证文件类型是否图片格式
    protected function isFileTypeImage($value){
        $type_array = array('jpg','jpeg','png','gif');//目标文件类型
        if($value){
            $need_type = strtolower(implode('/',$type_array));
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
                'msg' => '未上传头像、名片或出现异常，请重新上传'
            ]);
        }
    }

}