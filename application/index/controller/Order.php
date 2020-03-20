<?php


namespace app\index\controller;


use app\index\model\alipay\OrderInfo;
use think\Controller;
use think\facade\Session;

class Order extends Controller
{
    public function myOrder(){
        $customer_name=Session::get('customer_name');
        if($customer_name){
            $order_list=new OrderInfo();
            $list=$order_list->getOrder($customer_name);
            if(count($list)){
                $this->assign('order_list',$list);
            }else{
                $this->assign('order_list',-1);
            }
            return $this->fetch('myOrder');
        }else{
            $this->success('请登陆后查看','/login');
        }

    }

}