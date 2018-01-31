<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/31
 * Time: 0:02
 */

namespace app\api\validate;


class IdCollection extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIDs'
    ];
    protected $message = [
        'ids' => 'ids必须是以逗号分隔的多个正整数'
    ];
    public function checkIDs($value){
        $values = explode(',', $value);
        if(empty($values)){
            return false;
        }
        foreach ($values as $id){
            if(!$this->isPositiveInteger($id)){
                return false;
            }
        }
        return true;
    }
}