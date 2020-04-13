<?php


namespace app\index\controller;


use app\index\model\alipay\OrderInfo;
use app\index\model\alipay\Address;
use app\index\validate\alipay\Alipay;
use think\Controller;
use think\Db;
use think\facade\Session;

class Order extends Controller
{
    public function initialize()
    {
        if(!session('customer_name')){
            $this->success('请登陆后查看','/login');
        }
    }

    public function myOrder(){//我的订单主页
        $customer_name=Session::get('customer_name');
        $order_list=new OrderInfo();
        $list=$order_list->getOrder($customer_name);
            if(count($list)){
                $this->assign('order_list',$list);
            }else{
                $this->assign('order_list',-1);
            }
            return $this->fetch('myOrder');       
    }
    public  function deleteOder()//删除订单(订单状态改为-1)
    {
        $order_id=$this->request->param('order_id');
        $data=['order_id'=>$order_id];
        $validate=new Alipay();
        if($validate->check($data)){
            $order=new OrderInfo();
            $list=$order->getdetail($order_id);
            if($list){
                $data['order_status']=-1;
                $list->data($data,true);
                return $list->save();
            }else{
                return 0;
            }
        }else{
            return -2;
        }
    }
    public function orderDetail($order_id){//某一订单详情
        $address=new Address();
        $addressObj=$address->getAllAddress(Session::get('customer_name'));
        $addressList=$addressObj->select();
        $order=new OrderInfo();
        $list=$order->orderDetail($order_id);
        $this->assign([
            'address_list'=>$addressList,
            'list'=>$list
        ]);
        return $this->fetch('OrderDetail');
    }

}