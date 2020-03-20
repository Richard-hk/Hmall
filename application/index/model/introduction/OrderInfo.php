<?php


namespace app\index\model\introduction;


use think\Model;

class OrderInfo extends Model
{
    public function customer(){
        return $this->hasOne('Customer','customer_name','customer_name');
    }

}