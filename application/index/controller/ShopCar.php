<?php


namespace app\index\controller;


use think\Controller;
use think\Db;
use think\facade\Session;
use app\index\model\shopcar\SkuCar as shopCarModel;

class ShopCar extends Controller
{

    public function shopCar(){
        if(\session('customer_name')){
            $customer_namme=Session::get('customer_name');
            $car=new shopCarModel();
            $list=$car->getShopCar($customer_namme);
            if($list==0){
                $this->assign('list','none');
            }else{
                $this->assign('list',$list);
            }
            return $this->fetch('shopCar');
        }else{
            $this->success('请登陆后查看','/login');
        }
    }
    public function deleteCar(){
        $good_sku_ids= $_POST['good_sku_ids'];
        return Db::name('sku_car')->where('customer_name',Session::get('customer_name'))->where('good_sku_id','in',$good_sku_ids)->delete();
    }
}