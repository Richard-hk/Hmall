<?php


namespace app\admin\model\order;


use think\Model;

class OrderInfo extends Model
{
    public function customer(){
        return  $this->hasOne('Customer','customer_name','customer_name')->field('customer_name,customer_email');
    }
    public function getEmail($order_id){
        return $this->with('customer')->where('order_id',$order_id)->find();
    }

}