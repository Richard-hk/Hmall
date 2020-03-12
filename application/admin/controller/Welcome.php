<?php


namespace app\admin\controller;


use think\Controller;

class Welcome extends Controller
{
    public function index(){
        $this->fetch('welcome');
    }
}