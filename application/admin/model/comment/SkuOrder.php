<?php


namespace app\admin\model\comment;


use think\Model;

class SkuOrder extends Model
{
    public function comment(){
        return $this->hasOne('Comment','comment_id','comment_id');
    }
    public function goodSku(){
        return $this->hasOne('GoodSku','good_sku_id','good_sku_id')->with('goodSpu');
    }
    public function getComment(){
        $comment=new SkuOrder();
        return $comment->with(['comment','goodSku'])->select();
    }

}