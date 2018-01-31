<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/31
 * Time: 13:59
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;

class Token
{
    public function getToken($code=''){
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        return [
            'token' =>  $token
        ];
    }
}