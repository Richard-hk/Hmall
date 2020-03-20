<?php


namespace app\index\model\introduction;


use think\Model;

class GoodSku extends Model
{
    public function skuOrder(){
        return $this
            ->hasMany('SkuOrder','good_sku_id','good_sku_id')
            ->field('good_sku_id,order_id,comment_id')
            ->with(['comment','orderInfo']);
    }

    public function getAllSku($good_spu_id){
        return $this->with('skuOrder')
            ->field('good_sku_id,good_sku_rom,good_sku_ram,good_sku_color')
            ->where('good_spu_id',$good_spu_id)
            ->select();
    }

    public function goodSkuPicColor($good_spu_id){
        return $this
            ->where('good_spu_id',$good_spu_id)
            ->field('good_sku_color,good_sku_pic')
            ->group('good_sku_color,good_sku_pic')
            ->select();
    }
    public function goodSkuRom($good_spu_id){
        return $this
            ->where('good_spu_id',$good_spu_id)
            ->field('good_sku_rom,good_sku_ram')
            ->group('good_sku_rom,good_sku_ram')
            ->select();
    }
    public function maxPrice($good_spu_id){
        return $this
            ->where('good_spu_id',$good_spu_id)
            ->max('good_price');
    }
    public function minPrice($good_spu_id){
        return $this
            ->where('good_spu_id',$good_spu_id)
            ->min('good_price');
    }
    public function findRom($good_sku_color){
        return $this
            ->where('good_sku_color',$good_sku_color)
            ->field('good_sku_rom,good_sku_ram')
            ->group('good_sku_rom,good_sku_ram')
            ->select();
    }
    public function findColor($good_sku_rom,$good_sku_ram){
        return $this
            ->where([['good_sku_rom','=',$good_sku_rom],['good_sku_ram','=',$good_sku_ram]])
            ->field('good_sku_color')
            ->group('good_sku_color')
            ->select();
    }
    public function getPrice($sku_rom,$sku_ram,$sku_color)
    {
        return $this
            ->where([['good_sku_rom', '=', $sku_rom], ['good_sku_ram', '=', $sku_ram], ['good_sku_color', '=', $sku_color]])
            ->field('good_price,left_num,good_sku_id')
            ->find();

    }
}