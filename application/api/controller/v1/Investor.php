<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/12/14
 * Time: 10:47
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\BaseModel;
use app\api\model\Investor as InvestorModel;
use app\api\model\InvestorTrade;
use app\api\service\Token as TokenService;
use app\api\validate\CheckInvestor;
use app\lib\exception\InvestorException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UploadFileException;
use think\Db;
use think\Exception;

class Investor extends BaseController
{
    //    权限检查：用户级别才能创建项目
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createInvestor']
    ];
    //    投资人认证接口
    public function createInvestor(){
        $validate = new CheckInvestor();
        $validate->goCheck();
        $uid = TokenService::getCurrentUid();
        $investorArray = input('post.');
        $files = $_FILES;
        if(count($files)){
            $name_urls = InvestorModel::saveImages($files);
            foreach($name_urls as $key => $value){
                $investorArray[$key] = $value;
            }
        }
        $investorArray = $validate->getDataByRule($investorArray);
        Db::startTrans();
        try{
            $result = InvestorModel::getInvestor($investorArray['investor_telephone'],$uid);
            if(!empty($result)){
                return json(new SuccessMessage([
                    'code' => 400,
                    'msg' => '该号码或微信用户投资人已认证，无需重复认证'
                ]),201);
            }
            $investor = new InvestorModel();
            $investor->user_id = $uid;
            $investor->name = $investorArray['investor_name'];
            $investor->company = $investorArray['investor_company'];
            $investor->job = $investorArray['investor_job'];
            $investor->telephone = $investorArray['investor_telephone'];
            $investor->img_url = $investorArray['investor_img_url'];
            $investor->identify_one_url = $investorArray['investor_identify_one_url'];
            $investor->type = 1;
            $investor->save();

            $investor_id = $investor->id;
            $inverstorTradeIds = explode(',',$investorArray['investor_trade_ids']);
            foreach($inverstorTradeIds as $inverstorTradeId){
                $investorTrade = new InvestorTrade();
                $investorTrade->investor_id = $investor_id;
                $investorTrade->trade_id = $inverstorTradeId;
                $investorTrade->save();
            }
            Db::commit();
            return json(new SuccessMessage([
                'code' => 200,
                'msg' => '投资人认证成功，审核通过后正常显示'
            ]),200);
        }catch (Exception $exception){
            Db::rollback();
            throw $exception;
        }
    }
    //    投资人列表接口
    public function getInvestorAll(){
        $investorAll = InvestorModel::getInvestors();
        if(empty($investorAll)){
            throw new InvestorException();
        }
        return $investorAll;
    }
    //上传头像
    public function uploadImage(){
        if(array_key_exists('investor_img_url',$_FILES)){
            $investor_img_ary = $_FILES;
            $img_url = InvestorModel::saveImages($investor_img_ary);
        }else{
            throw new UploadFileException([
                'msg' => '头像未上传或上传过程出现异常，请重新上传'
            ]);
        }
        return $img_url;
    }
    //上传名片
    public function uploadIdentify(){
        if(array_key_exists('investor_identify_one_url',$_FILES)){
            $investor_identify_one_ary = $_FILES;
            $identify_one_url = InvestorModel::saveImages($investor_identify_one_ary);
        }else{
            throw new UploadFileException([
                'msg' => '名片未上传或上传过程出现异常，请重新上传'
            ]);
        }
        return $identify_one_url;
    }
}