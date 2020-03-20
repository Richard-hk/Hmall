<?php


namespace app\admin\model\admin;


use app\admin\model\role as RoleModel;
use think\Db;
use think\Model;

class Admin extends  Model
{
    public function getAdminStatusAttr($value){
        $get=['0'=>'停用','1'=>'启用','2'=>'已删除'];
        return $get[$value];
    }
    public function  getRoleIdAttr($value){
        $role=Db::name('role')
            ->field('role_name')
            ->where('role_id',$value)
            ->select();
        return $role;
    }

}