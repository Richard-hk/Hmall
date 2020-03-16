<?php


namespace app\index\model\alipay;


use think\Model;

class GoodSku extends Model
{
    public function goodSpu(){
        $field='good_name,good_spu_id,category_id';
        return $this->hasOne('GoodSpu','good_spu_id','good_spu_id')->field($field)->with('Category');
    }

}