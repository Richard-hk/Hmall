<?php


namespace app\index\controller;


use think\Controller;
use think\Session;
use think\facade\Session as sessionM;

class Test1 extends Controller
{
    public function  index(){
        return 1;
    }
}