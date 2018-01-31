<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/31
 * Time: 23:58
 */

namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;

class Category
{
    public function getAllCategories(){
        $categories = CategoryModel::all([],'img');
        if($categories->isEmpty()){
            throw new CategoryException();
        }
        return $categories;
    }
}