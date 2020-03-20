<?php


namespace app\admin\model\comment;


use think\Model;

class GoodSku extends Model
{
    public function goodSpu(){
        return $this->hasOne('GoodSpu','good_spu_id','good_spu_id');
    }

}