<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//
//];

use think\Route;

//Route::get('api/:version/banner/:id','api/:version.Banner/getBanner');

//Route::group('api/:version/theme',function (){
//    Route::get('/','api/:version.Theme/getSimpleList');//theme?ids=1,2,3
//    Route::get('/:id','api/:version.Theme/getComplexOne');
//});

//Route::group('api/:version/product',function (){
//    Route::get('/by_category','api/:version.Product/getAllInCategory');//by_category?id=3
//    Route::get('/:id','api/:version.Product/getOne',[],['id'=>'\d+']);//商品详情
//    Route::get('/recent','api/:version.Product/getRecent');//最近商品
//});

//Route::get('api/:version/category/all','api/:version.Category/getAllCategories');

//Route::post('api/:version/token/user','api/:version.Token/getToken');
Route::any('api/:version/token/user','api/:version.Token/getToken');

//Route::post('api/:version/address','api/:version.Address/createOrUpdateAddress');

//Route::post('api/:version/order','api/:version.Order/placeOrder');
//Route::get('api/:version/order/:id', 'api/:version.Order/getDetail',[], ['id'=>'\d+']);
//Route::get('api/:version/order/by_user','api/:version.Order/getSummaryByUser');

//Route::post('api/:version/pay/pre_order','api/:version.Pay/getPreOrder');
//Route::post('api/:version/pay/notify','api/:version.Pay/receiveNotify');

//融资人创建项目
Route::post('api/:version/item/create','api/:version.Item/createItem');
//精选项目列表
Route::get('api/:version/item/good','api/:version.Item/getGoodItemAll');
//全部项目
Route::get('api/:version/item/all','api/:version.Item/getItemAll');//?tradeid=1&stageid=1

//---start
//创建项目-上传视频
Route::post('api/:version/item/upload_video','api/:version.Item/uploadVideo');
//创建项目-上传视频缩略图
//Route::post('api/:version/item/upload_video_img','api/:version.Item/uploadVideoImg');
//---end

//认证投资人
Route::post('api/:version/investor/create','api/:version.Investor/createInvestor');
//投资人列表
Route::get('api/:version/investor/all','api/:version.Investor/getInvestorAll');
//---start
//认证投资人-上传头像
Route::post('api/:version/investor/upload_img','api/:version.Investor/uploadImage');
//认证投资人-上传名片
Route::post('api/:version/investor/upload_identify','api/:version.Investor/uploadIdentify');
//---end

//行业（领域）列表
Route::get('api/:version/trade/all','api/:version.Trade/getTradeAll');

//阶段列表
Route::get('api/:version/stage/all','api/:version.Stage/getStageAll');

//根据用户id获取投资人信息
Route::get('api/:version/user/user_investor','api/:version.User/getInvestorByUid');
//保存授权用户信息
Route::post('api/:version/user/save_userinfo','api/:version.User/setWechatUserInfo');
