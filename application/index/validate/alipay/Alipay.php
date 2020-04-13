<?php


namespace app\index\validate\alipay;


use think\Validate;

class Alipay extends Validate //订单编号验证
{
    protected $rule=[
        'order_id'=>'number'
    ];
}