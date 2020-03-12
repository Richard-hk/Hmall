<?php


namespace app\index\controller;

use think\Controller;
use think\facade\Session;

class Common extends Controller
{
    public function test(){
        return $this->fetch('test');
    }
    public function foot(){

    }
    public function top(){
        return 1;
    }

}