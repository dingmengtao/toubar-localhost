<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/11/22
 * Time: 17:45
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{
    protected $rule = [
        'products' => 'checkProducts',
    ];
    protected $singRule = [
        'product_id' => 'require|isPositiveInteger',
        'count' => 'require|isPositiveInteger'
    ];
    protected function checkProducts($values){
        if(empty($values)){
            throw new ParameterException([
                'msg' => '商品列表不能为空'
            ]);
        }elseif(!is_array($values)){
            throw new ParameterException([
                'mag' => '商品参数不正确（必须是数组）'
            ]);
        }else{
            foreach($values as $value){
                $this->checkProduct($value);
            }
        }
        return true;
    }
    protected function checkProduct($value){
        $validate = new BaseValidate($this->singRule);
        $result = $validate->batch()->check($value);
        if(!$result){
            throw new ParameterException([
                'msg' => '商品列表参数错误'
            ]);
        }
    }
}