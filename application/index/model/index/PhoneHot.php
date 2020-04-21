<?php


namespace app\index\model\index;

use think\Model;

class PhoneHot extends Model
{
    public function goodSpu(){
        return $this->hasOne('Good_Spu','good_spu_id','good_spu_id');
    }
    public function getGoodSpu(){
        return $this->with('goodSpu')->select();

    }
}