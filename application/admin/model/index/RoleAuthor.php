<?php


namespace app\admin\model\index;


use think\Model;

class RoleAuthor extends Model
{
    public function author(){
        return $this->hasOne('Author','author_id','author_id')->with('authorChild');
    }

}