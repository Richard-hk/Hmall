<?php


namespace app\index\model\introduction;


use think\Model;

class GoodSpu extends Model{
    public function category(){
        return $this
            ->hasOne('Category','category_id','category_id')
            ->with('pCategory');
    }
    public function getCategory($good_spu_id){
        $goodSpu =new GoodSpu();
        return $goodSpu
            ->with('category')
            ->where('good_spu_id',$good_spu_id)
            ->select();
    }

}