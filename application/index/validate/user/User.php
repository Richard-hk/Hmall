<?php


namespace app\index\validate\user;


use think\Validate;

class User extends Validate
{
    protected $rule=[
        'username'=>'chsDash',
        'password'=>'chsDash'
    ];
}