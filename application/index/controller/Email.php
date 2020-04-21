<?php
namespace app\index\controller;

use think\Controller;
class Email extends Controller
{
    public function index(){
        $res = SendMail('1636847365@qq.com','hmall商城测试','kehui发送成功了');
        if(!$res){
            return $this->error('发送邮件失败');
        }
        return $this->success('发送邮件成功','/');
    }

}
