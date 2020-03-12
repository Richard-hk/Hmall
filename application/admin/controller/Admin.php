<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use \app\admin\model\admin\Admin as AdminModel;
class Admin extends Controller
{
    public function admin()//管理员列表页面
    {

        $list= AdminModel::where('admin_status','<>','2')->select();
        $total=$list->count();
        $this->assign('list',$list);
        $this->assign('total',$total);
        return $this->fetch('admin');
    }

    public function adminAdd()//管理员添加页面
    {
        $list=Db::name('role')->select();
        $this->assign('role',$list);
        return $this->fetch('adminAdd');
    }


    public function adminAddAct()//管理员添加
    {
        $admin=[
            'admin_name'=>trim($_POST['admin_name']),
            'admin_psw'=>md5(trim($_POST['admin_psw'])),
            'admin_phone'=>trim($_POST['admin_phone']),
            'role_id'=>trim($_POST['role_id']),
            'admin_gmt_created'=>time(),
            'admin_status'=>'1'
        ];
        $list=Db::name('admin')->insert($admin);
        return $list;
    }

    public function adminSearch()//管理员查询
    {
        $admin=[
            ['admin_status','<>','2'],
            ['admin_name','like','%'.$_GET['admin_name'].'%']
        ];
        $list=AdminModel::where($admin)->select();
        $total=$list->count();
        $this->assign('total',$total);
        $this->assign('list',$list);
        return $this->fetch('adminList');

    }

    public function adminDel()//管理员删除
    {
        $admin_name=$_POST['admin_name'];
        $list=Db::name('admin')->where('admin_name',$admin_name)->update(['admin_status'=>'2']);
        return $list;
    }

    public function adminAllDel()//管理员选中删除
    {
        $admin_name=$_POST['admin_name_all'];
        $list=Db::name('admin')->where('admin_name','in',$admin_name)->update(['admin_status'=>'2']);
        return $list;
    }

    public function adminUpdate()//管理员修改
    {
        $admin= new AdminModel();
        $list =$admin->save([
            'admin_status'=>$_POST['admin_status']
        ],[
            'admin_name'=>$_POST['admin_name']
        ]);
        return $list;
    }

    public function adminEdit($admin_name)//管理员编辑页面
    {
        $admin=Db::name('admin')->where('admin_name',$admin_name)->select();
        $list=Db::name('role')->select();
        $admin_phone=$admin[0]['admin_phone'];
        $this->assign('admin_name',$admin_name);
        $this->assign('admin_phone',$admin_phone);
        $this->assign('list',$list);
        return $this->fetch('adminEdit');
    }

    public function adminEditAct()//管理员编辑
    {
        $admin=[
            'admin_psw'=>trim($_POST['admin_psw1']),
            'admin_phone'=>trim($_POST['admin_phone']),
            'role_id'=>trim($_POST['role_id']),
        ];
        $list=Db::name('admin')->where('admin_name',trim($_POST['admin_name']))->update($admin);
        return $list;
    }


}
