<?php


namespace app\admin\model\index;


use think\Model;

class Admin extends Model
{
    public function roleAuthor(){
        return $this->hasMany('RoleAuthor','role_id','role_id')->with('author');
    }
    public function getAuthor($admin_name){
        $admin=new Admin();
        return $admin
            ->with('roleAuthor')
            ->where('admin_name',$admin_name)
            ->select();
    }

}