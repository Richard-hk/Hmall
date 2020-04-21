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
    public function getOrder($customer_name){//获取用户所有订单
        return $this
            ->with('skuOrder')
            ->where([['customer_name','=',$customer_name],['order_status','<>','-1']])
            ->select();
    }
    public function getMoney($order_id,$status){//未支付订单获取金额并且判断未支付订单是否存在
        $result=$this::where('order_id',$order_id)->where('order_status',$status)->find();
        if($result){
            return $this::query("select sum(b.good_price*a.sku_order_num) money from hmall_good_sku b inner join (select *  from hmall_sku_order where order_id=:id) a on a.good_sku_id=b.good_sku_id",['id'=>$order_id]);
        }else{
            return null;
        }
    }
    public function addOrder($order_info){
        return $this->insert($order_info);
    }
    public function deleteOrderId($order_id){//添加sku错误删除order_id
        return $this->where('order_id',$order_id)->delete();
    }

    public function getdetail($order_id){//判断订单是否存在
        return $this::where('order_id',$order_id)->find();
    }
    public function address(){
        return $this->hasOne('address','address_id','address_id');
    }
    public function orderDetail($order_id){//获取某一订单详情
        return $this::where('order_id',$order_id)->with('sku_order,address')->select();
    }
    public function updateOrder($order_id,$address_id){
        return $this->where('order_id',$order_id)->data(['address_id'=>$address_id])->update();
    }
}
