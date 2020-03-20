<?php


namespace app\index\model\alipay;


use think\Model;

class SkuOrder extends Model
{
    public function goodSku(){
        $field='good_sku_id,good_spu_id,good_price,good_sku_pic,good_sku_color,good_sku_rom,good_sku_ram';
        return $this
            ->hasOne('GoodSku','good_sku_id','good_sku_id')
            ->field($field)
            ->with('goodSpu');
    }

}