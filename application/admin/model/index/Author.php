<?php


namespace app\admin\model\index;


use think\Model;

class Author extends Model
{
    public function authorChild(){
        return $this->hasMany('AuthorChild','author_id','author_id');
    }

}