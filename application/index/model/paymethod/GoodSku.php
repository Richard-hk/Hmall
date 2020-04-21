<?php


namespace app\index\model\paymethod;


use think\Controller;
use think\Db;

class GoodSku extends  Controller
{
    public function getDetail($good_sku_id)
    {
        return Db::name('good_sku')
            ->alias('t1')
            ->where('good_sku_id',$good_sku_id)
            ->field('t1.good_sku_id,t1.good_sku_rom,t1.good_sku_ram,t2.good_name,t4.brand_name,t1.good_sku_color,t1.good_sku_pic,t1.good_price')
            ->join('good_spu t2','t2.good_spu_id=t1.good_spu_id')
            ->join('category t3','t2.category_id=t3.category_id')
            ->join('brand t4','t4.brand_id=t3.brand_id')
            ->select();
    }

}