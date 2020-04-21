<?php


namespace app\admin\model\product;


use think\Db;
use think\Model;

class Good_sku extends  Model
{
    public function goodSkuCheck($good_sku_id){
        $sku_order= db('sku_order')->where('good_sku_id',$good_sku_id)->find();
        $sku_car= db('sku_car')->where('good_sku_id',$good_sku_id)->find();
        if($sku_order||$sku_car){
            return -1;
        }else{
            return $this::where('good_sku_id',$good_sku_id)->delete();
        }
    }
   
}