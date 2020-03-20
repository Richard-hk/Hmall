<?php


namespace app\admin\model\Product;


use think\Db;
use think\Model;

class Category extends  Model
{
    public function getBrandIdAttr($value){
        $list=Db::name('brand')
            ->field('brand_name')
            ->where('brand_id',$value)
            ->select();
        return $list;
    }
}