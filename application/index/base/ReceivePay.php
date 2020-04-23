<?php


namespace app\index\base;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use Pheanstalk\Pheanstalk;
// ini_set("default_socket_timeout",-1);//socket不超时
class ReceivePay extends Command
{
    protected function configure(){//自定义订单接受命令
        $this->setName('pay:receive')->setDescription('ceceive oreder pay');
    }
    protected function execute(Input $input, Output $output)
    {
        $pheanstalk=Pheanstalk::create('127.0.0.1');
        try {
            while(true){
                $job = $pheanstalk->watchOnly('pay')->ignore('default')->reserve();
                if($job->getData()){
                    $order=db('order_info')->where('order_id',$job->getData())->select();
                    if($order[0]['order_status']==0){
                        $username=$order[0]['customer_name'];
                        echo $username;
                        $customer=db('customer')->where('customer_name',$username)->select();
                        if($customer){
                            echo $customer[0]['customer_email'];
                            SendMail($customer[0]['customer_email'],'Hmall商城测试订单取消通知','你的订单'.$job->getData().'超时被取消');
                            db('order_info')->where('order_id',$job->getData())->data('order_status',3)->update();
                        }
                    }
                }
                $pheanstalk->delete($job);
                usleep(10000);

            }        
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
            //连接不上通知管理员
        }
        
        
    }

}