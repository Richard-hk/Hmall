<?php


namespace app\index\model\user;


use think\Db;
use think\Model;

class Customer extends Model
{
    public function getCustomerSexAttr($value){
        $get=['0'=>'女','1'=>'男'];
        return $get[$value];
    }
    public function getCustomerGmtCreatedAttr($value){
        $get=date('Y-m-d H:i:s',$value);
        return $get;
    }

}