<?php


namespace app\index\model\alipay;


use think\Model;

class SkuOrder extends Model
{
    public function goodSku()
    {
        $field='good_sku_id,good_spu_id,good_price,good_sku_pic,good_sku_color,good_sku_rom,good_sku_ram';
        return $this
            ->hasOne('GoodSku','good_sku_id','good_sku_id')
            ->field($field)
            ->with('goodSpu');
    }
    public function addsku(array $sku_order,$out_trade_no,$good_sku_id,$sku_num)
    {
        foreach ($good_sku_id as $key=>$value){
            $sku_order['order_id']=$out_trade_no;
            $sku_order['good_sku_id']=$good_sku_id[$key];
            $sku_order['sku_order_num']=$sku_num[$key];
            $list=$this->insert($sku_order);
            if(!$list){
                return null;
            }
        }
        return 1;

    }

}