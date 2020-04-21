<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;
define('WB_AKEY','2793921729');
define('WB_SKEY','62cf2db7b74994acae1f8ba45d708cde');
define('WB_CALLBACK_URL','http://101.200.32.25/callback');

// 加载基础文件
require __DIR__ . '/../thinkphp/base.php';

// require __DIR__.'/../vendor/autoload.php'; 

// 支持事先使用静态方法设置Request对象和Config对象

// 执行应用并响应
Container::get('app')->run()->send();