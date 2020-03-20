<?php


namespace app\index\model\alipay;


use think\Model;

class GoodSpu extends Model
{
    public function Category(){
        $field='category_id,brand_id';
        return $this
            ->hasOne('Category','category_id','category_id')
            ->field($field)
            ->with('Brand');
    }

}