<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
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
        return $this->fetch('index');
    }

    public function hello($name = 'ThinkPHP5')
    {
        return '前台控制器  hello方法,' . $name;
    }
    public function get_real_ip(){
        static $realip;
        if(isset($_SERVER)){
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $realip=$_SERVER['HTTP_X_FORWARDED_FOR'];
            }else if(isset($_SERVER['HTTP_CLIENT_IP'])){
                $realip=$_SERVER['HTTP_CLIENT_IP'];
            }else{
                $realip=$_SERVER['REMOTE_ADDR'];
            }
        }else{
            if(getenv('HTTP_X_FORWARDED_FOR')){
                $realip=getenv('HTTP_X_FORWARDED_FOR');
            }else if(getenv('HTTP_CLIENT_IP')){
                $realip=getenv('HTTP_CLIENT_IP');
            }else{
                $realip=getenv('REMOTE_ADDR');
            }
        }

        $ipdetail=[
            'ip'=>$realip,
            'look_date'=>date('Y-m-d H:i:s',time()),
            'look_type'=>'前台'
        ];
        return Db::name('ip')->insert($ipdetail);
    }
}
