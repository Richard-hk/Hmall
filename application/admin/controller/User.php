<?php
namespace app\admin\controller;

use think\captcha\Captcha;
use think\Controller;
use think\Db;
use think\facade\Cookie;
use \think\facade\Request;

class User extends  Controller
{
    public function login()
    {
     return $this->fetch('login');
    }

    public function check(){
        $code=trim($_POST['code']);
        if(!captcha_check($code)){
            $admin_name=trim($_POST['name']);
            $admin_psw=md5(trim($_POST['password']));
            $result=Db::name('admin')->where('admin_name','=',$admin_name)->find();
            if(!$result){
                return json('name_err');
            }elseif ($result['admin_psw']!=$admin_psw){
                return json('psw_err');
            }else{
                Cookie::set('admin_name',$admin_name,36000);
                return json('correct');
            }
        }else{
            return json('code_err');
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
            'look_type'=>'后台'
        ];
        Db::name('ip')->insert($ipdetail);
        $this->redirect('./enter');
    }
}
