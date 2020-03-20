<?php


namespace app\index\controller;

use think\Controller;
use think\Db;
use think\facade\Session;

class Common extends Controller
{

    public function feedback(){
        if(\session('customer_name')){
            return $this->fetch('common/feedback');

        }else{
            $this->success('请登陆账号后再反馈信息','/login');
        }
    }
    public function feedbackAct(){
        if(\session('customer_name')){
            $data=[
                'feed_text'=>$_POST['feed_text'],
                'feed_time'=>time(),
                'customer_name'=>\session('customer_name')
            ];
            return Db::name('feedback')->insert($data);
        }else{
            $this->success('非法请求','/');
        }

    }

}