<?php


namespace app\index\controller;


use think\Controller;
use think\Db;
use think\facade\Session;

class Introduction extends Controller
{
    public function introduction(){
        \session('customer_name');
        $good_spu_id=$_GET['good_spu_id'];
        $good_spu=Db::name('good_spu')->where('good_spu_id',$good_spu_id)->find();
        if($good_spu){
            $good_pic=$good_spu['good_sku_pic'];
            $good_name=$good_spu['good_name'];
            $category_id=$good_spu['category_id'];
            $good_desc=$good_spu['good_desc'];
            $brand_id=\db('category')->where('category_id',$category_id)->find()['brand_id'];
            $brand_name=\db('brand')->where('brand_id',$brand_id)->find()['brand_name'];
            $good_sku=Db::name('good_sku')->where('good_spu_id',$good_spu_id);
            $good_sku_pic_color=$good_sku->field('good_sku_color,good_sku_pic')->group('good_sku_color,good_sku_pic')->select();
            $good_sku_rom_ram=$good_sku->removeOption('field')->removeOption('group')->field('good_sku_rom,good_sku_ram')->group('good_sku_rom,good_sku_ram')->select();
            $max_price=$good_sku->removeOption('group')->where('good_spu_id',$good_spu_id)->max('good_price');
            $min_price=$good_sku->removeOption('where')->where('good_spu_id',$good_spu_id)->min('good_price');
            $this->assign([
                'good_pic'=>$good_pic,
                'good_name'=>$good_name,
                'brand_name'=>$brand_name,
                'good_desc'=>$good_desc,
                'max_price'=>$max_price,
                'min_price'=>$min_price,
                'good_sku_pic_color'=>$good_sku_pic_color,
                'good_sku_rom_ram'=>$good_sku_rom_ram,
            ]);

            return $this->fetch('introduction');
        }else{
            $this->success('非法请求,即将跳转主页','/');
        }

    }
    public function findRom(){
        $good_sku_color=trim($_POST['color']);
        $list= Db::name('good_sku')->where('good_sku_color',$good_sku_color)->field('good_sku_rom,good_sku_ram')->group('good_sku_rom,good_sku_ram')->select();
        return json_encode($list);
    }
    public function findColor(){
        $good_sku_rom=trim($_POST['good_sku_rom']);
        $good_sku_ram=trim($_POST['good_sku_ram']);
        $list= Db::name('good_sku')->where([['good_sku_rom','=',$good_sku_rom],['good_sku_ram','=',$good_sku_ram]])->field('good_sku_color')->group('good_sku_color')->select();
        return json_encode($list);

    }
    public function getPrice(){
        $sku_rom=trim($_POST['sku_rom']);
        $sku_ram=trim($_POST['sku_ram']);
        $sku_color=trim($_POST['sku_color']);
        $good_sku=Db::name('good_sku')->where([['good_sku_rom','=',$sku_rom],['good_sku_ram','=',$sku_ram],['good_sku_color','=',$sku_color]])->field('good_price,left_num,good_sku_id')->find();
        return json_encode($good_sku);
    }
    public function toShopCar(){
        $good_sku_id=$_POST['good_sku_id'];
        $num=$_POST['num'];
        $customer_name=Session::get('customer_name');
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
    }
}