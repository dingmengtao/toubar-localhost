<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/31
 * Time: 14:17
 */

namespace app\api\service;


use app\api\model\User as UserModel;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ThemeException;
use app\lib\exception\WeChatException;
use think\Exception;

class UserToken extends Token
{
    protected $code;
    protected $wxAppId;
    protected $wxAppSecret;
    protected $wxLoginUrl;
    public function __construct($code){
        $this->code = $code;
        $this->wxAppId = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'),$this->wxAppId, $this->wxAppSecret, $this->code);
    }
    public function get(){
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result,true);
        if(empty($wxResult)){
            throw new Exception('获取session_key及openid时异常，微信内部错误');
        }else{
            $loginFail = array_key_exists('errcode',$wxResult);
            if($loginFail){
                return $this->processLoginError($wxResult);
            }else{
                return $this->grantToken($wxResult);
            }
        }
//        return $wxResult;
    }
    private function processLoginError($wxResult){
        throw new WeChatException([
            'msg'   =>  $wxResult['errmsg'],
            'errorCode' =>  $wxResult['errcode']
        ]);
    }
    private function grantToken($wxResult){
        $openid = $wxResult['openid'];
        $user = UserModel::getByOpenID($openid);
        if($user){
            $uid = $user->id;
        }else{
            $uid = $this->newUser($openid);
        }
        $cacheValue = $this->prepareCacheValue($wxResult,$uid);
        $token = $this->saveToCache($cacheValue);
        return $token;
    }
    private function newUser($openid){
        $user = UserModel::create([
            'openid'    =>  $openid
        ]);
        return $user->id;
    }
    private function prepareCacheValue($wxResult,$uid){
        $cacheValue = $wxResult;
        $cacheValue['uid'] = $uid;
        $cacheValue['scope'] = ScopeEnum::User;
        return $cacheValue;
    }
    private function saveToCache($cacheValue){
        $key = self::generateToken();
        $value = json_encode($cacheValue);
        $expire_in = config('setting.token_expire_in');
        $result = cache($key,$value,$expire_in);
        if(!$result){
            throw new ThemeException([
                'msg'   =>  '服务器缓存异常',
                'errorCode' =>  10005
            ]);
        }
        return $key;
    }
}