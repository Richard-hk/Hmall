<?php
namespace app\admin\controller;

use think\Controller;
use think\Cookie;
use think\Db;

class Index extends  Controller
{
    public function index()
    {
        if(!Cookie('admin_name')){
          return  redirect('user/login');
        }else{
            return  $this->fetch('index');
        }
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
            'look_type'=>'后台',
            'adminname'=>'admin'
        ];
        Db::name('ip')->insert($ipdetail);
    }
}
