<?php


namespace app\index\model\alipay;


use think\Model;

class Address extends Model
{
    public function getAllAddress($customer_name){//获得所有地址
        return $this::where('customer_name',$customer_name);
    }

}