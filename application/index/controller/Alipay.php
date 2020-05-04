<?php


namespace app\index\controller;

use app\index\model\alipay\OrderInfo;
use service\AlipayTradeService;
use think\Controller;
use think\Db;
use app\index\model\alipay\SkuOrder;
use app\index\validate\alipay\Alipay as alipayValidate;
use buildermodel\AlipayTradePagePayContentBuilder;
use think\facade\Session;
use Pheanstalk\Pheanstalk;


class Alipay extends Controller
{
    public function initialize()
    {
        if(!session('customer_name')){
            $this->redirect('/');
        }
    }
    public function alipay($order_id=null,$address_id=null){//用户支付
        $config=config_str();
        $validate=new alipayValidate();
        $data=['order_id'=>$order_id];
        if(!$validate->check($data)){
             $this->success('非法订单字符','/');
        }else{
            $orderInfo=new OrderInfo();
            if($order_id==null){
                $out_trade_no = trim($this->request->param('WIDout_trade_no'));
                $total_amount = trim($this->request->param('WIDtotal_amount'));
                $good_sku_id=($_POST['good_sku_id']);
                $sku_num=($_POST['sku_num']);
                $address_id=$_POST['address_id'];
                $order_info=[
                    'order_id'=>$out_trade_no,
                    'customer_name'=>session('customer_name'),
                    'address_id'=>$address_id,
                    'order_gmt_created'=>time(),
                    'order_status'=>0
                ];
                try {
                    $order=$orderInfo->addOrder($order_info);
                } catch (\Throwable $th) {
                    try {
                        $orderInfo->deleteOrderId($out_trade_no);
                    } catch (\Throwable $th) {
                        var_dump('删除失败');
                    }
                    $this->success('订单创建失败','/');
                }
                if($order){
                    $sku_order=array();
                    $skuOrder=new SkuOrder();
                    try {
                        $list=$skuOrder->addsku($sku_order,$out_trade_no,$good_sku_id,$sku_num);
                    } catch (\Throwable $th) {
                        $orderInfo->deleteOrderId($out_trade_no);
                        $this->success('订单创建失败','/');
                    }
                    Alipay::deleteCar($out_trade_no);//创建订单成功后，在购物车中删除订单商品
                }else{
                    $this->success('创建订单失败','/');
                }
            }else{
                if($order_id==null){
                    return 1;
                }
                if($address_id!=null){//更新地址
                    try {
                        $orderInfo->updateOrder($order_id,$address_id);
                    } catch (\Throwable $th) {
                       $this->success('错误地址编号');
                    } 
                }
                $out_trade_no=$order_id;
                $orderInfo=new OrderInfo();
                $order=$orderInfo->getMoney($out_trade_no,0);
                if($order==null){
                    $this->success('该订单号不存在或者该订单已经支付','/');
                    return ;
                }else{
                    $money=$order[0]['money'];
                    $total_amount = $money;
                }
            }
            $pheanstalk = Pheanstalk::create('127.0.0.1', 11300, 10);
            $id=$pheanstalk->useTube('pay')->put($out_trade_no,0,70,0);

            $subject = 'Hmall在线商城支付';
            $body = "123";
            $payRequestBuilder = new AlipayTradePagePayContentBuilder();
            $payRequestBuilder->setBody($body);
            $payRequestBuilder->setSubject($subject);
            $payRequestBuilder->setTotalAmount($total_amount);
            $payRequestBuilder->setOutTradeNo($out_trade_no);

            try {
                $aop = new AlipayTradeService($config);
            } catch (\Exception $e) {
                
            }

            /**
             * pagePay 电脑网站支付请求
             * @param $builder 业务参数，使用buildmodel中的对象生成。
             * @param $return_url 同步跳转地址，公网可以访问
             * @param $notify_url 异步通知地址，公网可以访问
             * @return $response 支付宝返回的信息
             */
            $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);
            //输出表单
            var_dump($response);   
        }
    }
   
    public function judgePay(){//判断支付
        $config=config_str();
        $arr=$_GET;
        $alipaySevice = new AlipayTradeService($config);
        $result = $alipaySevice->check($arr);
        if($result) {//验证成功
            $out_trade_no = htmlspecialchars($_GET['out_trade_no']);
            // return $out_trade_no;
            $trade_no = htmlspecialchars($_GET['trade_no']);
            $order_info=Db::name('order_info');
            $list=$order_info->where('order_id',$out_trade_no)->data(['order_status'=>'1','alipay_id'=>$trade_no])->update();
            $this->redirect('http://101.200.32.25/myorder');
        }
        else {
            //验证失败
            $this->success('支付失败,即将到首页','/');
        }

    }

    public function deleteCar($order_id){//删除购物车
        $customer_name=Session::get('customer_name');
        $order=Db::name('SkuOrder');
        $skuOrder=$order->where('order_id',$order_id)->select();
        $skuCar=Db::name('SkuCar');
        foreach ($skuOrder as $skuOrders){
            $where=[
                ['good_sku_id','=',$skuOrders['good_sku_id']],
                ['customer_name','=',$customer_name]
            ];
            $skuNum=$skuCar->removeOption('where')->removeOption('field')->where($where)->field('sku_num')->find();
            $num=$skuNum['sku_num'];
            if($num==$skuOrders['sku_order_num']){
                $skuCar->removeOption('where')->removeOption('field')->where($where)->delete();
            }else{
                $num=$num-$skuOrders['sku_order_num'];
                $data=['sku_num'=>$num];
                $skuCar->removeOption('where')->removeOption('field')->where($where)->data($data)->update();
            }
        }
    }

}