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
use think\facade\Route;
use think\facade\Url;

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

//Url::root('/');
//前台
Route::get('login','index/user/login');
Route::get('callback','index/user/callback');
Route::get('bindname','index/user/bindName');
Route::get('register','index/user/register');
Route::get('quit','index/user/quit');

Route::get('introduction','index/introduction/introduction');
Route::get('shopcar','index/ShopCar/shopCar');

Route::get('alipayaccept','index/alipay/alipayAccept');
//Route::get('test','index/alipay/alipay');
Route::get('paymethod','index/PayMethod/payMethod');
Route::get('userinfo','index/User/userInfo');
Route::get('judgepay','index/Alipay/judgePay');
Route::get('myorder','index/Alipay/myOrder');



//后台
Route::get('hello/:name', 'index/hello');
Route::get('enter','user/login');
Route::get('test','common/test');

//Route::group('adminRoleAuthor',function (){
//   Route::get(':role_id/:role_name','adminRoleAuthor');
//})->prefix('role/')->pattern(['role_id'=>'\d+']);
//Route::miss('role/test');
//Route::group('test',function (){
//    Route::get('test_<id>_<name>','role/test1');
//})->prefix('role/');


//Route::get('roleAuthorUpdate','admin.php/role/roleAuthorUpdate');

//Route::get('test','index/test/index');
return [

];
