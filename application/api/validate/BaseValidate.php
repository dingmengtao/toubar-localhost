<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/25
 * Time: 22:56
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck(){
        $request = Request::instance();
        $params = $request->param();
        $result = $this->batch()->check($params);
        if(!$result){
            $e = new ParameterException([
                'msg'   =>  $this->error
            ]);
//            $e->msg = $this->error;
            throw $e;
//            $error = $this->error;
//            throw new Exception($error);
        }else{
            return true;
        }
    }
//    是否正整数
    protected function isPositiveInteger($value, $rule='', $data='', $field='')
    {
        if(is_numeric($value) && is_int($value + 0) && ($value + 0) > 0){
            return true;
        }else{
//            return $field.'必须是正整数';
            return false;
        }
    }
//    是否为空
    protected function isNotEmpty($value, $rule='', $data='', $field='')
    {
        if(empty($value)){
            return false;
        }else{
            return true;
        }
    }
//    是否数组
    public function isArray($value){
        $values = explode(',', $value);
        if(empty($values)){
            return false;
        }else{
            foreach ($values as $id){
                if($this->isPositiveInteger($id)){
                    continue;
                }else{
                    return false;
                }
            }
        }
        return true;
    }
    //    验证所属行业（trade）数组
    protected function checkTradeIds($value){
        if(self::isArray($value)){
            return true;
        }else{
            throw new ParameterException([
                'msg' => '所属行业不能为空且参数必须为正整数且中间用逗号拼接成字符串'
            ]);
        }
    }
//    验证手机号
    protected function isMobile($value){
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule,$value);
        if($result){
            return true;
        }else{
            return false;
        }
    }
    //返回原值
    protected function isOriginValue($value){
        return true;
    }
//    验证文件类型
    protected function isFileType($value,$type_array){
        $path_info = pathinfo($value);
        if(array_key_exists('extension',$path_info)){
            $ext = strtolower($path_info['extension']);
            if(in_array($ext,$type_array)){
                return true;
            }else{
                return false;
            }
        }else{
            throw new ParameterException([
                'msg' => $value.'必须选定文件，不能只有目录'
            ]);
        }
    }
    public function getDataByRule($arrays){
        if(array_key_exists('user_id',$arrays) || array_key_exists('uid',$arrays)){
            throw new ParameterException([
                'msg' => '参数中包含有非法的参数名user_id或uid'
            ]);
        }
        $newArray = [];
        foreach($this->rule as $key => $value){
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }
}