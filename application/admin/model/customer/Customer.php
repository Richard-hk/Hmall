<?php


namespace app\admin\model\customer;


use think\Model;

class Customer extends Model
{
    public function getCustomerSexAttr($value){
        $get=['0'=>'女','1'=>'男'];
        return $get[$value];
    }
}