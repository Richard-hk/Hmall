<?php
namespace app\index\controller;

use app\index\model\index\PhoneHot;
use think\cache\driver\Redis;
use think\Controller;
use think\Db;
use think\facade\Cache;
use think\facade\Session;

class Index extends Controller
{
    public function initialize()
    {
        $customer_name=session('customer_name');
        if($customer_name){
            $list=Db::name('customer')->where('customer_name',$customer_name)->find();
            if(!$list){
                Session::delete('customer_name');
                $this->redirect('/');
            }
        }
    }

    public function index()
    {
        // $phone_hot=new PhoneHot();
        // $phone_hot->getGoodSpu();
        // var_dump($phone_hot);
        // $phone_hot=PhoneHot::field('good_spu_id')->limit(0,5)->select()->toArray();
        // $good_spu=Db::name('good_spu')->where([['good_spu_id','in',$phone_hot]])->select();
        // var_dump($good_spu);
        return $this->fetch('index');
    }
    public function test(){
        
    }

    public function hello($name = 'ThinkPHP5')
    {
        return '前台控制器  hello方法,' . $name;
    }
    public function get_real_ip(){
        get_real_ip(null,'前台');
    }

}
