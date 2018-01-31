<?php

namespace app\api\controller\v1;

use app\api\validate\IdCollection;
use app\api\validate\IdMustBePostiveInt;
use app\lib\exception\ThemeException;
use think\Controller;
use think\Request;
use app\api\model\Theme as ThemeModel;

class Theme extends Controller
{
    /**
     * @url /theme?ids=id1,id2,id3........
     * @return 一组theme模型
     */
    public function getSimpleList($ids=''){
        (new IdCollection())->goCheck();
        $ids = explode(',', $ids);
        $result = ThemeModel::with('topicImg,headImg')->select($ids);
        if($result->isEmpty()){
            throw new ThemeException();
        }
        return $result;
   }

    /**
     * @url /theme/:id
     */
   public function getComplexOne($id){
       (new IdMustBePostiveInt())->goCheck();
       $theme = ThemeModel::getThemeWithProducts($id);
       if(!$theme){
           throw new ThemeException();
       }
       return $theme;
   }
}
