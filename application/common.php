<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function get_real_ip($value=null,$type=null){//获取地址
    static $realip;
    if(isset($_SERVER)){
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $realip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }else if(isset($_SERVER['HTTP_CLIENT_IP'])){
            $realip=$_SERVER['HTTP_CLIENT_IP'];
        }else{
            $realip=$_SERVER['REMOTE_ADDR'];
        }
    }else{
        if(getenv('HTTP_X_FORWARDED_FOR')){
            $realip=getenv('HTTP_X_FORWARDED_FOR');
        }else if(getenv('HTTP_CLIENT_IP')){
            $realip=getenv('HTTP_CLIENT_IP');
        }else{
            $realip=getenv('REMOTE_ADDR');
        }
    }
    if($type=="后台"){
        $ipdetail=[
            'ip'=>$realip,
            'look_date'=>date('Y-m-d H:i:s',time()),
            'look_type'=>$type,
            'adminname'=>$value
        ];
    }else{
        $ipdetail=[
            'ip'=>$realip,
            'look_date'=>date('Y-m-d H:i:s',time()),
            'look_type'=>$type,
            'username'=>$value
        ];
    }
    
    return db('ip')->insert($ipdetail);
}

 function province()
 {
    $list = db('district')->where('type',1)->select();
    return $list;
}

 function city($provinceid)
{
    if ($provinceid) {
        $where = "pid=$provinceid";
    } else {
        $where = "id=52";
    }
    $list = db('district')->where($where)->select();
    return $list;
}

 function area($cityid)
{
    if ($cityid) {
        $where = "pid=$cityid";
    } else {
        $where = "id=500";
    }
    $list = db('district')->where($where)->select();
    return $list;
}   