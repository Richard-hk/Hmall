<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 缓存设置
// +----------------------------------------------------------------------

return [

  // 缓存配置为复合类型
  'type'  =>  'complex',
 
  'default'    =>    [
    // 驱动方式
      'type'    =>    'file',
      // 全局缓存有效期（0为永久有效）
      'expire'=>  0,
      // 缓存前缀
      'prefix'=>  'think',
      // 缓存目录
      'path'  =>  '',
  ],

  'rediswrite'    =>    [
      'type'    =>    'redis',
      'host'    =>    '127.0.0.1',
      'port' => 6379,
      'password' => '123456',
      // 全局缓存有效期（0为永久有效）
      //        'expire'=>  0,
      // 缓存前缀
      'prefix'=>  '',
      'timeout'=> 3600
  ],
  'redisread'    =>    [
      'type'    =>    'redis',
      'host'    =>    'r-2ze0a4ff02168094pd.redis.rds.aliyuncs.com',
      'port' => 6379,
      'password' => '123456',
      // 全局缓存有效期（0为永久有效）
      //        'expire'=>  0,
      // 缓存前缀
      'prefix'=>  '',
      'timeout'=> 3600
  ],
   
];
