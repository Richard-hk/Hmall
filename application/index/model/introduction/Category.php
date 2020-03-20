<?php


namespace app\index\model\introduction;


use think\Model;

class Category extends Model
{
    public function brand(){
        return $this
            ->hasOne('Brand','brand_id','brand_id');
    }
    public function pCategory(){
        return $this
            ->hasOne('Category','category_id','hma_category_id')
            ->with('brand');
    }

}