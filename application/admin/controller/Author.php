<?php


namespace app\admin\controller;


use think\Controller;
use think\Db;

class Author extends Controller
{
    public function adminAuthor()//权限管理页面
    {
        $list=Db::name('author')->select();
        $this->assign('list',$list);
        $this->assign('count',count($list));
        return $this->fetch('adminAuthor');
    }
    public function adminAuthorAdd()//权限添加页面
    {
        return $this->fetch('adminAuthorAdd');

    }
    public function adminAuthorAddAct()//权限添加
    {
        $author=[
          'author_name'=>$_POST['author_name'],
          'author_desc'=>$_POST['author_desc']
        ];
        $list=Db::name('author')->insert($author);
        return $list;

    }

    public function adminAuthorEdit()//权限编辑
    {
        $author_id=$_GET['author_id'];
        $list=Db::name('author')->where('author_id',$author_id)->find();
        $this->assign('author_name',$list['author_name']);
        $this->assign('author_desc',$list['author_desc']);
        $this->assign('author_id',$author_id);
        return $this->fetch('adminAuthorEdit');
    }
    public function adminAuthorEditAct(){
        $author_id=$_POST['author_id'];
        $author=[
            'author_name'=>$_POST['author_name'],
            'author_desc'=>$_POST['author_desc']
        ];
        $list=Db::name('author')->where('author_id',$author_id)->data($author)->update();
        return $list;
    }
    public function adminAuthorChild()//添加子权限页面
    {
        $author_id=$_GET['author_id'];
        $author_name=$_GET['author_name'];
        $this->assign('author_name',$author_name);
        $list=Db::name('author_child')->where('author_id',$author_id)->select();
        $this->assign('list',$list);
        $this->assign('author_id',$author_id);
        return $this->fetch('adminAuthorChild');
    }
    public function adminAuthorChildAdd($author_id)//添加子页面
    {
        $this->assign('author_id',$author_id);
        return $this->fetch('adminAuthorChildAdd');
    }
    public function adminAuthorChildAddAct()//添加子权限
    {
        $author_child=[
            'author_id'=>$_POST['author_id'],
            'author_child_name'=>$_POST['author_child_name'],
            'author_child_src'=>$_POST['author_child_desc']
        ];
       $list=Db::name('author_child')->insert($author_child);
        return $list;
    }

}