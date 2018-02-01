<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/12/12
 * Time: 13:46
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\Item as ItemModel;
use app\api\model\ItemTrade;
use app\api\service\Token as TokenService;
use app\api\validate\CheckItem;
use app\api\validate\CheckTradeStage;
use app\lib\exception\ItemException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UploadFileException;
use tests\thinkphp\library\think\config\driver\iniTest;
use think\Db;
use think\Exception;

class Item extends BaseController
{
    //    权限检查：用户级别才能创建项目
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createItem']
    ];
    //    融资人创建项目接口
    public function createItem(){
        $validate = new CheckItem();
        $validate->goCheck();
        $uid = TokenService::getCurrentUid();
        $itemArray = $validate->getDataByRule(input('post.'));
        Db::startTrans();
        try{
            $item = new ItemModel();
            $item->user_id = $uid;
            $item->name = $itemArray['item_name'];
            $item->stage_id = $itemArray['item_stage_id'];
            $item->telephone = $itemArray['item_telephone'];
            // $item->bp_url = $itemArray['item_bp_url'];
            $item->video_url = $itemArray['item_video_url'];
            $item->img_url = $itemArray['video_img_url'];
            $item->type = 1;
            $item->save();

            $item_id = $item->id;
            $itemTradeIds = explode(',',$itemArray['item_trade_ids']);
            foreach($itemTradeIds as $itemTradeId){
                $itemTrade = new ItemTrade();
                $itemTrade->item_id = $item_id;
                $itemTrade->trade_id = $itemTradeId;
                $itemTrade->save();
            }
            Db::commit();
            return json(new SuccessMessage([
                'code' => 200,
                'msg' => '项目创建成功，审核通过后正常显示'
            ]),200);
        }catch (Exception $exception){
            Db::rollback();
            throw $exception;
        }
    }
    //    精选项目列表接口
    public function getGoodItemAll(){
        $goodItemAll = ItemModel::getGoodItems()->hidden(['id']);
        if($goodItemAll->isEmpty()){
            throw new ItemException([
                'msg' => '暂无精选项目'
            ]);
        }
        return $goodItemAll;
    }
    //    所有项目列表接口
    public function getItemAll(){
        $validate = new CheckTradeStage();
        $validate->goCheck();
        $tradeidStageidArray = $validate->getDataByRule(input('get.'));
        $itemAll = ItemModel::getItems($tradeidStageidArray['tradeid'],$tradeidStageidArray['stageid'])->hidden(['id']);
        if($itemAll->isEmpty()){
            throw new ItemException([
                'msg' => '暂无项目'
            ]);
        }
        return $itemAll;
    }
    //上传视频
    public function uploadVideo(){
        if(array_key_exists('item_video_url',$_FILES)){
            $item_video_ary = $_FILES;
            $video_url = ItemModel::saveVideo($item_video_ary);
        }else{
            throw new UploadFileException([
                'msg' => '视频未上传或上传过程出现异常，请重新上传'
            ]);
        }
        return $video_url;
    }
    //上传视频缩略图
//    public function uploadVideoImg(){
//        if(array_key_exists('video_img_url',$_FILES)){
//            $video_img_ary = $_FILES;
//            $video_img_url = ItemModel::saveVideoImg($this->video_url,$video_img_ary);
//        }else{
//            throw new UploadFileException([
//                'msg' => '视频缩略图未上传或上传过程出现异常，请重新上传'
//            ]);
//        }
//        return $video_img_url;
//    }
}