<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/11/22
 * Time: 17:20
 */

namespace app\api\controller;


use app\api\service\Token as TokenService;
use think\Controller;

class BaseController extends Controller
{
//    用户和CMS管理员可以访问的接口权限
    protected function checkPrimaryScope(){
        TokenService::needPrimaryScope();
    }
//    只有用户才能访问的接口权限
    protected function checkExclusiveScope(){
        TokenService::needExclusiveScope();
    }

}