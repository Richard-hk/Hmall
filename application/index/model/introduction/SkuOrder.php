<?php


namespace app\index\model\introduction;


use think\Model;

class SkuOrder extends Model
{
    public function comment(){
        return $this->hasOne('Comment','comment_id','comment_id');
    }
    public function orderInfo(){
        return $this
            ->hasOne('OrderInfo','order_id','order_id')
            ->field('order_id,customer_name')
            ->with('customer');
    }

}