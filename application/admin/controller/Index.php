<?php
namespace app\admin\controller;

use think\Controller;
use think\Cookie;
use think\Db;
use app\admin\model\index\Admin as adminModel;

class Index extends  Controller
{
    public function index()
    {
        $admin_name=session('admin_name');
        if(!$admin_name){
          return  redirect('user/login');
        }else{
            $adminModel=new adminModel();
            $list=$adminModel->getAuthor($admin_name);
//            return json($list[0]['role_author']);
            $this->assign('list',$list[0]['role_author']);
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
