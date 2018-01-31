<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2017/10/31
 * Time: 22:35
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\api\validate\IdMustBePostiveInt;
use app\lib\exception\ProductException;

class Product
{
    public function getRecent($count=16){
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);
        if($products->isEmpty()){
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }
    public function getAllInCategory($id){
        (new IdMustBePostiveInt())->goCheck();
        $products = ProductModel::getProductsByCategoryId($id);
        if($products->isEmpty()){
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }
    public function getOne($id){
        (new IdMustBePostiveInt())->goCheck();
        $product = ProductModel::getProductDetail($id);
        if(!$product){
            throw new ProductException();
        }
        return $product;
    }
}