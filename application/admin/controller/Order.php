<?php


namespace app\admin\controller;

use app\admin\model\order\OrderInfo;
use think\Controller;
use app\index\model\alipay\OrderInfo as orderinfoModel;
use buildermodel\AlipayTradeRefundContentBuilder;
use service\AlipayTradeService;

class Order extends Controller
{
    public function orderList()
    {
        $orderinfo = new orderinfoModel();
        $list = $orderinfo->select();
        $this->assign('list', $list);
        return $this->fetch('orderList');
    }

    public function returnMoney()
    {
        $out_trade_no = trim($_POST['order_id']);
        $trade_no = trim($_POST['alipay_id']);
        $orderInfo = new orderinfoModel();
        $money = $orderInfo->getMoney($out_trade_no, 2)[0]['money'];
        $config = config_str();
        $refund_amount = strval($money);
        $out_request_no = "";
        $refund_reason = "test";
        $RequestBuilder = new AlipayTradeRefundContentBuilder();
        $RequestBuilder->setOutTradeNo($out_trade_no);
        $RequestBuilder->setTradeNo($trade_no);
        $RequestBuilder->setRefundAmount($refund_amount);
        $RequestBuilder->setOutRequestNo($out_request_no);
        $RequestBuilder->setRefundReason($refund_reason);
        $aop = new AlipayTradeService($config);
        $response = $aop->Refund($RequestBuilder);
        if ($response->code == 10000) {
            $order = new OrderInfo();
            $email = $order->getEmail($out_trade_no)['customer']['customer_email'];
            if ($email) {
                SendMail($email,'Hmall商城测试订单通知','管理员已同意退款->订单号： '.$out_trade_no.' 总金额为：'.$money);
            }
            return Db('order_info')->where('order_id', $out_trade_no)->data(['order_status' => 4])->update();
        } else {
            return -1;
        }
    }
    
}
