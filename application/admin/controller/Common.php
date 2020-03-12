<?php


namespace app\admin\controller;


use think\Controller;

class Common extends  Controller
{
    public function  welcome(){
        return $this->fetch('common/welcome');
    }
    public function feedback(){
        return $this->fetch('common/feedback');
    }
}