<?php


namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\facade\Url;
use think\Request;
use think\Route;

class Role extends Controller
{
    public function adminRole()//角色列表
    {
        $list=Db::name('role')->select();
        $total=count($list);
        $this->assign('list',$list);
        $this->assign('total',$total);
        return $this->fetch('adminRole');
    }

    public function adminRoleDel()//管理员角色删除
    {
        $role_id=$_POST['role_id'];
        $list=Db::name('role')->delete($role_id);
        return $list;
    }

    public function adminRoleAdd()//管理员角色添加页面
    {
        return $this->fetch('adminRoleAdd');
    }

    public function adminRoleAddAct()//管理员角色添加
    {
        $role=[
            'role_name'=>$_POST['role_name'],
            'role_desc'=>$_POST['role_desc']
        ];
        $list=Db::name('role')->insert($role);
        return $list;
    }
    public function adminRoleEdit()//管理员角色编辑页面
    {
        $role=Db::name('role')->where('role_id',$_GET['role_id'])->find();
        $this->assign('role_name',$role['role_name']);
        $this->assign('role_desc',$role['role_desc']);
        $this->assign('role_id',$_GET['role_id']);
        return $this->fetch('adminRoleEdit');
    }
    public function adminRoleEditAct()//管理员角色添加
    {
        $role_id=$_POST['role_id'];
        $role=[
            'role_name'=>$_POST['role_name'],
            'role_desc'=>$_POST['role_desc']
        ];

        $list=Db::name('role')->where('role_id',$role_id)->data($role)->update();
        return $list;
    }

    public function adminRoleAllDel()//管理员选中删除
    {
        $role_id_all=$_POST['role_id_all'];
        $list=Db::name('role')->delete([$role_id_all[0]]);
        return Db::getlastsql();

    }

    public function adminRoleAuthor()//管理员角色分配权限|页面
    {
        $role_id=$_GET['role_id'];
        $role_name=$_GET['role_name'];
        $sql=Db::name('role_author')->field('author_id')->where('role_id',$role_id)->buildsql(true);
        $sql1=Db::name('author')->field(['author_id','author_name','author_desc','1 as test'])->where('author_id','exp','in'.$sql)->buildsql();
        $sql2=Db::name('author')->field(['author_id','author_name','author_desc','0 as test'])->where('author_id','exp','not in'.$sql)->buildsql();
        $list=Db::query($sql1.' union '.$sql2);
        $this->assign('list',$list);
        $this->assign('role_id',$role_id);
        $this->assign('role_name',$role_name);
        $this->assign('total',count($list));
        return $this->fetch('adminRoleAuthor');
    }

    public function roleAuthorUpdate()//管理员角色权限修改
    {
        $status=$_POST['status'];
        if($_POST['status']==1){
            $list=Db::name('role_author')->where([
                ['role_id','=',$_POST['role_id']],
                ['author_id','=',$_POST['author_id']]
            ])->delete();
        }else{
            $list=Db::name('role_author')->insert([
                'role_id'=>$_POST['role_id'],
                'author_id'=>$_POST['author_id']
            ]);
        }
        return $list;
    }




}