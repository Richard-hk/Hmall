<?php

namespace app\index\controller;

use Pheanstalk\Pheanstalk;
use think\cache\driver\Redis;
use think\Controller;
use think\Db;
use think\facade\Session;
use think\facade\Cache;
use think\session\driver\Redis as DriverRedis;

class Index extends Controller
{
    public function initialize()
    {
        $customer_name = session('customer_name');
        if ($customer_name) {
            $list = Db::name('customer')->where('customer_name', $customer_name)->find();
            if (!$list) {
                Session::delete('customer_name');
                $this->redirect('/');
            }
        }
    }

    public function index()
    {
        // $phone_hot=new PhoneHot();
        // $phone_hot->getGoodSpu();
        // var_dump($phone_hot);
        // $phone_hot=PhoneHot::field('good_spu_id')->limit(0,5)->select()->toArray();
        // $good_spu=Db::name('good_spu')->where([['good_spu_id','in',$phone_hot]])->select();
        // var_dump($good_spu);
        return $this->fetch('index');
    }
    
    public function test()
    {
        // $judge=Cache::store('rediswrite')->get('order_id');
        // return $judge;
        $pheanstalk = Pheanstalk::create('127.0.0.1', 11300, 10);

        // return Dat
        // for ($i = 0; $i < 10; $i++) {
            // $num= date('Y') . date('m') . date('d') . substr(time(), -4) . substr(microtime(), 2, 7);

            // $res=cache::store('rediswrite')->select();
            // var_dump($res);
            // db('test')->where('id',1)->data(['name'=>'kehui'])->update();
            $id=$pheanstalk->useTube('pay')->put('2020042352838591660',0,10,0);
            // $res=$pheanstalk->peek($id);
            // var_dump($res);
            // $pheanstalk->useTube('pay')->put($num,0,0,0);
            // $res=$pheanstalk->watch()
        // }
        // while(true){
        //     $judge=Cache::store('rediswrite')->get('order_id*');
        //     if(!$judge){
        //         break;
        //     }
        // }
    }
    public function test1(){
        $pheanstalk=Pheanstalk::create('127.0.0.1');
        while(true){
            $job = $pheanstalk->watchOnly('pay')->ignore('default')->reserve();
            if($job->getData()){
                $order=db('order_info')->where('order_id',$job->getData())->select();
                if($order[0]['order_status']==1){
                    $username=$order[0]['customer_name'];
                    echo $username;
                    $customer=db('customer')->where('customer_name',$username)->select();
                    if($customer){
                        echo $customer[0]['customer_email'];
                        SendMail($customer[0]['customer_email'],'Hmall商城测试订单取消通知','你的订单'.$job->getData().'超时被取消');
                    }
                }
            }
            $pheanstalk->delete($job);
            usleep(10000);

        }        
    //    while(true){
    //         $job = $pheanstalk->watchOnly('pay')->ignore('default')->reserve();
            
    //         if($job){
    //             $order=db('order_info')->where('order_id',$job->getData())->select();
    //             if($order[0]['order_status']==1){
    //                 // SendMail('1636847365@qq.com','Hmall商城测试订单通知','000 ');
    //                 var_dump(1);
    //             }
    //         }
    //         $pheanstalk->delete($job);
    //         // usleep(10000);
    //     // db('test')->where('id',1)->data(['name'=>'kehui1'])->update();
    //    }
     
                // $pheanstalk->delete($job);
    }


    public function hello($name = 'ThinkPHP5')
    {
        return '前台控制器  hello方法,' . $name;
    }
    public function get_real_ip()
    {
        get_real_ip(null, '前台');
    }
    
}
