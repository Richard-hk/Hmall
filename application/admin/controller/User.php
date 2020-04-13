<?php
namespace app\admin\controller;

use think\captcha\Captcha;
use think\Controller;
use think\Db;
use think\facade\Cookie;
use \think\facade\Request;
use think\Loader;

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
            }else if($result['admin_status']==0){
                return json('banned');
            }else{
                session('admin_name',$admin_name);
                get_real_ip($admin_name,'后台');
                return json('correct');
            }
        }else{
            return json('code_err');
        }
    }
}
