<?php


namespace app\admin\controller;


use think\Controller;

class Member extends Controller
{
    public function index(){
        return $this->fetch('member_list');
    }
    public function member_del(){
        return $this->fetch('member_del');

    }
}