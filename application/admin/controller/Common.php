<?php


namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\facade\Session;

class Common extends  Controller
{
    public function  welcome(){
        $admin_name=Session::get('admin_name');
        $list=Db::name('ip')->where('adminname',$admin_name)->order('look_date','desc')->limit(1,1)->select();
        $this->assign('ip',$list[0]['ip']);
        $this->assign('look_date',$list[0]['look_date']);
        return $this->fetch('common/welcome');
    }
    
}