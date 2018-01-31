<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/25
 * Time: 17:15
 */

namespace app\api\controller\v1;


use app\api\model\Banner as BannerModel;
use app\api\validate\IdMustBePostiveInt;
use app\lib\exception\BannerMissException;
use think\Exception;

class Banner
{
    /**
     *获取指定id的Banner信息
     * @url /banner/:id
     * @http GET
     * @id banner的id号
     * */
    public function getBanner($id){
        (new IdMustBePostiveInt())->goCheck();
        $banner = BannerModel::getBannerById($id);
        if(!$banner){
            throw new BannerMissException();
        }
        return $banner;
    }
    public function test(){
        $arr = array(1,2,3);
        return $arr;
    }
}