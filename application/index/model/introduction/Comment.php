<?php


namespace app\index\model\introduction;


use think\Model;

class Comment extends Model
{
    public function skuOrder(){
        return $this->belongsTo('SkuOrder');
    }

}