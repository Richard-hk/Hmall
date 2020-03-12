<?php


namespace app\index\model\shopcar;


use think\Controller;
use think\Db;
use think\facade\Session;

class sku_car extends Controller
{
    public function getShopCar($customer_name){
        if($customer_name){
            $list=Db::name('sku_car');
            $sku_car=$list->where('customer_name',$customer_name)->find();
            if($sku_car){
                $list=Db::name('sku_car')->alias('t1')->where('customer_name',$customer_name)
                    ->field('t2.good_spu_id,t2.good_sku_id,t1.sku_num,t2.good_sku_rom,t2.good_sku_ram,t2.good_price,t2.good_sku_pic,t3.good_name,t5.brand_name')
                    ->join('good_sku t2','t1.good_sku_id=t2.good_sku_id')
                    ->join('good_spu t3','t3.good_spu_id=t2.good_spu_id')
                    ->join('category t4','t4.category_id=t3.category_id')
                    ->join('brand t5','t5.brand_id=t4.brand_id')->select();
                return $list;
            }else{
                return 0;
            }
       }

    }
}