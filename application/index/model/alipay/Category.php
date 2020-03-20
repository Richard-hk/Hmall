<?php


namespace app\index\model\alipay;


use think\Model;

class Category extends Model
{
    public function Brand(){
        $field='brand_id,brand_name';
        return $this
            ->hasOne('Brand','brand_id','brand_id')
            ->field($field);
    }

}