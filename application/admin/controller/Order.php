<?php


namespace app\admin\controller;


use think\Controller;
use app\index\model\alipay\OrderInfo as orderinfoModel;
class Order extends Controller
{
    public function orderList(){
        $orderinfo=new orderinfoModel();
        $list=$orderinfo->select();
        $this->assign('list',$list);
        return $this->fetch('orderList');

    }

}