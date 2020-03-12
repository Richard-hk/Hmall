<?php

namespace app\index\controller;

use sina\SaeTOAuthV2;
use think\Controller;
use think\Db;
use think\Request;

class Test extends  Controller
{
//    public function index(){
//        $o=new SaeTOAuthV2(WB_AKEY,WB_SKEY);
//        $code_url=$o->getAuthorizeURL(WB_CALLBACK_URL);
//        $this->assign('code_url',$code_url);
//        return  $this->fetch('index');
//    }
//    public function callback(){
//
//        $o=new SaeTOAuthV2(WB_AKEY,WB_SKEY);
//        $keys=array();
//        $param=$this->request->param();
//        $keys['code']=$param['code'];
//        $keys['redirect_uri']=WB_CALLBACK_URL;
//        $token=$o->getAccessToken('code',$keys);
//        if($token){
////            var_dump('aaaaaaaaaaaaaa');
//            return $this->fetch('correct');
//        }else{
//            return $this->fetch('error');
//        }
//    }
    public function distinct(){
        return $this->fetch('distinct');
    }

    public function privance()
    {
        $list = Db::name('district')->where('type',1)->select();
        return $list;
    }

//读取市
    public function city($provinceid)
    {
        if ($provinceid) {
            $where = "pid=$provinceid";
        } else {
            $where = "id=52";
        }
        $list = Db::name('district')->where($where)->select();
        return $list;
    }

//读取区
    public function area($cityid)
    {
        if ($cityid) {
            $where = "pid=$cityid";
        } else {
            $where = "id=500";
        }
        $list = Db::name('district')->where($where)->select();
        return $list;
    }

}