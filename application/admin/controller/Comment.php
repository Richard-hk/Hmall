<?php


namespace app\admin\controller;


use think\Controller;
use think\Db;
use app\admin\model\comment\SkuOrder as skuOrderModel;
class Comment extends Controller
{
    public function feedback(){
        $list=Db::name('feedback')->select();
        $this->assign('list',$list);
        $this->assign('total',count($list));
        return $this->fetch('feedback');
    }
    public function feedbackDel(){
        $feed_id=$_POST['feed_id'];
        return Db::name('feedback')->where('feed_id',$feed_id)->delete();
    }
    public function feedbackAllDelete(){
        $feed_ids=$_POST['feed_ids'];
        return Db::name('feedback')->where('feed_id','in',$feed_ids)->delete();
    }
    public function comment(){
        $skuOrderModel=new skuOrderModel();
        $comment=$skuOrderModel->getComment();
        $this->assign('list',$comment);
        return $this->fetch('comment');
    }

}