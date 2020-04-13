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
        get_real_ip(null,'前台');
    }
}
