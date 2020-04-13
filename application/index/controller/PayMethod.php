<?php


namespace app\index\controller;

use app\index\model\alipay\Address;
use app\index\model\paymethod\GoodSku as goodskuModel;
use app\index\model\user\Address as UserAddress;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;

class PayMethod extends Controller
{
    public function initialize()
    {
        if(!session('customer_name')){
           $this->success('请登陆账号，即将进入登陆页','/login');
        }
    }

    public function payMethod(){
        $out_trade_no=date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        $address=new Address();
        $addressObj=$address->getAllAddress(Session::get('customer_name'));
        $addressList=$addressObj->select();
        $list=$addressObj->where('is_default',1)->find();
        $this->assign([
            'out_trade_no'=>$out_trade_no,
            'list'=>$list,
            'address_list'=>$addressList,
        ]);
        return $this->fetch('payMethod');
    }
    public function PayDetail(){
        $good_sku_id=$_POST['good_sku_id'];
        $good=new goodskuModel();
        return json($good->getDetail($good_sku_id));
    }
    public function addAddress(){
        $address=new UserAddress();
        $customer_name=Session::get('customer_name');
        return $address->saveAddress($customer_name,$_POST['address_name'],$_POST['address_phone'],$_POST['province'],$_POST['city'],$_POST['area'],$_POST['address_detail'],1,1);

    }
    public function return_url(){

    }
}