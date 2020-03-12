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

}
