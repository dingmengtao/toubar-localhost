<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/12/20
 * Time: 9:52
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\Token as TokenService;
use app\api\validate\CheckUser;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;
use app\api\model\User as UserModel;
use think\Db;
use think\Exception;

class User extends BaseController
{
    //    根据用户id判断是否是投资人，从而判断用户能否“约谈、看BP”
    public function getInvestorByUid(){
        $uid = TokenService::getCurrentUid();
        if($uid){
            $investor = UserModel::getInvestor($uid);
            if(!empty($investor) && array_key_exists('investor',$investor)){
                if(empty($investor['investor'])){
                    throw new UserException([
                        'code' => 404,
                        'msg' => '未认证投资人或认证暂未审核，无操作权限'
                    ]);
                }
                return json(new SuccessMessage(['code'=>200]),200);
            }else{
                throw new UserException([
                    'code' => 404,
                    'msg' => '未认证投资人或认证暂未审核，无操作权限'
                ]);
            }
        }else{
            throw new UserException();
        }
    }
    // 保存访问小程序用户的信息
    public function setWechatUserInfo(){
        $validate = new CheckUser();
        $validate->goCheck();
        $uid = TokenService::getCurrentUid();
        $userInfoArray = $validate->getDataByRule(input('post.'));
//        $userInfoArray = $validate->input('post.');
        Db::startTrans();
        try{
            $user = UserModel::get($uid);
            $user->nickname = $userInfoArray['user_nickname'];
            $user->country = $userInfoArray['user_country'];
            $user->province = $userInfoArray['user_province'];
            $user->city = $userInfoArray['user_city'];
            $user->gender = $userInfoArray['user_gender'];
            $user->language = $userInfoArray['user_language'];
            $user->save();
            Db::commit();
            return json(new SuccessMessage([
                'code' => 200,
                'msg' => '用户数据更新成功'
            ]),200);
        }catch (Exception $exception){
            Db::rollback();
            throw $exception;
        }
    }
}