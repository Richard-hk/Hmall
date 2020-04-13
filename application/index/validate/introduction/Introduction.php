<?php


namespace app\index\validate\Introduction;


use think\Validate;

class Introduction extends Validate
{
    protected $rule=[
        'good_spu_id'=>'number'
    ];
}