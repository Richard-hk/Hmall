<?php


namespace app\index\controller;


use think\Controller;
use think\Db;
use think\facade\Session;
use app\index\model\introduction\GoodSpu as goodSpuModel;
use app\index\model\introduction\GoodSku as goodSkuModel;
use app\index\model\introduction\SpuPic;
use app\index\validate\introduction\Introduction as IntroductionValidate;
use think\facade\Cache;

class Introduction extends Controller
{
    public function introduction($good_spu_id){
        \session('customer_name');
        $data=[
          'good_spu_id'=>$good_spu_id
        ];
        $validate=new IntroductionValidate();
        if($validate->check($data)){
            $goodSpuModel=new goodSpuModel();
            $goodCategory=$goodSpuModel->getCategory($good_spu_id);
            if($goodCategory!=null){
                $good_sku=new goodSkuModel();
                try {
                    $list=cache::store('redisread')->get('spu_pic'.$good_spu_id);//redis服务关闭，切换到mysql
                } catch (\Throwable $th) {
                    $list=SpuPic::where('good_spu_id',$good_spu_id)->select()->toArray();
                }
                if(!$list){
                    $list=SpuPic::where('good_spu_id',$good_spu_id)->select()->toArray();
                    if($list){
                        cache::store('redisread')->set('spu_pic'.$good_spu_id,$list);
                    }
                }
                $this->assign([
                    'good_pic'=>$goodCategory[0]['good_sku_pic'],
                    'good_status'=>$goodCategory[0]['good_status'],
                    'max_price'=>$good_sku->maxPrice($good_spu_id),
                    'min_price'=>$good_sku->minPrice($good_spu_id),
                    'good_sku_pic_color'=>$good_sku->goodSkuPicColor($good_spu_id),
                    'good_sku_rom_ram'=>$good_sku->goodSkuRom($good_spu_id),
                    'goodCategory'=>$goodCategory,
                    'commentList'=>$good_sku->getAllSku($good_spu_id),
                    'time_down'=>$goodCategory[0]['gmt_down']<time()?1:0,
                    'spu_pic'=>$list,
                    'good_spu_id'=>$good_spu_id
                ]);
                return $this->fetch('introduction');
            }else{
                $this->success('非法请求,即将跳转主页','/');
            }
        }else{
            return $this->fetch('/common/illegal');
        }
        
    }
    public function findRom(){
        $good_sku_color=trim($_POST['color']);
        $good_spu_id=trim($_POST['good_spu_id']);
        $good_sku=new goodSkuModel();
        $list= $good_sku->findRom($good_sku_color,$good_spu_id);
        return json_encode($list);
    }
    public function findColor(){
        $good_sku_rom=trim($_POST['good_sku_rom']);
        $good_sku_ram=trim($_POST['good_sku_ram']);
        $good_spu_id=trim($_POST['good_spu_id']);

        $good_sku=new goodSkuModel();
        $list= $good_sku->findColor($good_sku_rom,$good_sku_ram,$good_spu_id);
        return json_encode($list);

    }
    public function getPrice(){
        $sku_rom=trim($_POST['sku_rom']);
        $sku_ram=trim($_POST['sku_ram']);
        $sku_color=trim($_POST['sku_color']);
        $good_spu_id=trim($_POST['good_spu_id']);
        $good_sku=new goodSkuModel();
        $list= $good_sku->getPrice($sku_rom,$sku_ram,$sku_color,$good_spu_id);
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