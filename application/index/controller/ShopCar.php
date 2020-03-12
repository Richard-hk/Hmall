<?php


namespace app\index\controller;


use think\Controller;
use think\Db;
use think\facade\Session;
use app\index\model\shopcar\sku_car as shopCarModel;

class ShopCar extends Controller
{

    public function shopCar(){
        $customer_namme=Session::get('customer_name');
            $car=new shopCarModel();
            $list=$car->getShopCar($customer_namme);
            if($list==0){
                $this->assign('list','none');

            }else{
                $this->assign('list',$list);

            }


        return $this->fetch('shopCar');
    }
}