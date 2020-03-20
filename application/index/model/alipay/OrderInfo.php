<?php


namespace app\index\model\alipay;


use think\Model;

class OrderInfo extends Model
{
    public function skuOrder(){
        return $this
            ->hasMany('SkuOrder','order_id', 'order_id')
            ->with('goodSku');
    }
    public function getOrder($customer_name){
        $order=new OrderInfo();
        return $order
            ->with('skuOrder')
            ->where('customer_name',$customer_name)
            ->select();
    }

}