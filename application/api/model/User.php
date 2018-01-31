<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/31
 * Time: 14:16
 */

namespace app\api\model;


class User extends BaseModel
{
    //    自动写入时间戳
    protected $autoWriteTimestamp = true;

//    根据openid获取用户信息
    public static function getByOpenID($openid){
        $user = self::where('openid','=',$openid)->find();
        return $user;
    }
//    public function address(){
//        return $this->hasOne('UserAddress','user_id','id');
//    }
    //    关联模型，关联investor表，一对一
    public function investor(){
        return $this->hasOne('Investor','user_id','id');
    }
    //    根据uid获取投资人信息
    public static function getInvestor($uid){
        $investor = self::with(['investor'])->where('id','=',$uid)->find();
        if(empty($investor)){
           $investor = array();
        }else{
            $investor = $investor->toArray();
        }
        return $investor;
    }
}