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
            $role=$adminModel->getRole($admin_name)[0]->role->role_name;
            $this->assign('list',$list[0]['role_author']);
            $this->assign('role',$role);
            return  $this->fetch('index');
        }
    }
}
