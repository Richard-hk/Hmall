<?php


namespace app\index\controller;


use think\Controller;
use think\Db;
use think\facade\Session;
use app\index\model\introduction\GoodSpu as goodSpuModel;
use app\index\model\introduction\GoodSku as goodSkuModel;
class Introduction extends Controller
{
    public function introduction(){
        \session('customer_name');
        $good_spu_id=$_GET['good_spu_id'];
        $goodSpuModel=new goodSpuModel();
        $goodCategory=$goodSpuModel->getCategory($good_spu_id);
        if($goodSpuModel){
            $good_pic=$goodCategory[0]['good_sku_pic'];
            $good_sku=new goodSkuModel();
            $comment=$good_sku->getAllSku($good_spu_id);
            $good_sku_pic_color=$good_sku->goodSkuPicColor($good_spu_id);
            $good_sku_rom_ram=$good_sku->goodSkuRom($good_spu_id);
            $max_price=$good_sku->maxPrice($good_spu_id);
            $min_price=$good_sku->minPrice($good_spu_id);
            $this->assign([
                'good_pic'=>$good_pic,
                'max_price'=>$max_price,
                'min_price'=>$min_price,
                'good_sku_pic_color'=>$good_sku_pic_color,
                'good_sku_rom_ram'=>$good_sku_rom_ram,
                'goodCategory'=>$goodCategory,
                'commentList'=>$comment
            ]);
            return $this->fetch('introduction');
        }else{
            $this->success('非法请求spu_id,即将跳转主页','/');
        }
    }
    public function findRom(){
        $good_sku_color=trim($_POST['color']);
        $good_sku=new goodSkuModel();
        $list= $good_sku->findRom($good_sku_color);
        return json_encode($list);
    }
    public function findColor(){
        $good_sku_rom=trim($_POST['good_sku_rom']);
        $good_sku_ram=trim($_POST['good_sku_ram']);
        $good_sku=new goodSkuModel();
        $list= $good_sku->findColor($good_sku_rom,$good_sku_ram);
        return json_encode($list);

    }
    public function getPrice(){
        $sku_rom=trim($_POST['sku_rom']);
        $sku_ram=trim($_POST['sku_ram']);
        $sku_color=trim($_POST['sku_color']);
        $good_sku=new goodSkuModel();
        $list= $good_sku->getPrice($sku_rom,$sku_ram,$sku_color);
        return json_encode($list);
    }
    public function toShopCar(){
        $customer_name=Session::get('customer_name');
        if($customer_name){
            $good_sku_id=$_POST['good_sku_id'];
            $num=$_POST['num'];
            $list=Db::name('sku_car');
            $judge=$list->where([['customer_name','=',$customer_name],['good_sku_id','=',$good_sku_id]])->find();
            if($judge){
                $pre_num=$judge['sku_num'];
                $data=[
                    'good_sku_id'=>$good_sku_id,
                    'customer_name'=>$customer_name,
                    'sku_num'=>$num+$pre_num
                ];
                $list->removeOption('where')->update($data);
                if($list){
                    return 1;
                }else{
                    return 0;
                }
            }else{
                $data=[
                    'good_sku_id'=>$good_sku_id,
                    'customer_name'=>$customer_name,
                    'sku_num'=>$num
                ];
                $list->removeOption('where')->insert($data);
                if($list){
                    return 1;
                }else{
                    return 0;
                }
            }
        }else{
            return -1;
        }

    }
}