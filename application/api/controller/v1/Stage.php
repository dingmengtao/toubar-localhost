<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/12/16
 * Time: 16:27
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\Stage as StageModel;
use app\lib\exception\StageException;

class Stage extends BaseController
{
    //    获取所有阶段列表
    public function getStageAll(){
        $stages = StageModel::getStages();
        if(empty($stages)){
            throw new StageException();
        }
        return $stages;
    }
}