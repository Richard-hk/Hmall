<?php


namespace app\admin\model\customer;


use think\Model;

class Customer extends Model
{
    public function getCustomerSexAttr($value){
        $get=['0'=>'女','1'=>'男'];
        return $get[$value];
    }
    public function changeStatus($customer_name,$status){
        return $this::where('customer_name',$customer_name)->update(['customer_status'=>$status]);
    }
    public function changeAllStatus($customer_name,$status){
        return $this::where('customer_name','in',$customer_name)->update(['customer_status'=>$status]);
    }
}