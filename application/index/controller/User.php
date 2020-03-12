<?php


namespace app\index\controller;


use sina\SaeTClientV2;
use sina\SaeTOAuthV2;
use think\Controller;
use think\facade\Cookie;
use think\Db;
use think\facade\Session;use think\Loader;

class User extends Controller
{


    public function login()//登陆页面
    {
        $customer_name=Cookie::get('customer_name');
        $customer_psw=Cookie::get('customer_psw');
        if($customer_name&&$customer_psw)
        {
            $customer=[
                ['customer_name','=',$customer_name],
                ['customer_psw','=',$customer_psw]
            ];
            $list= Db::name('customer')->where($customer)->find();
            if($list){
                Session::set('customer_name',$customer_name);
                $this->success('保存密码登陆成功，3秒后进入主页','/');
            }
        }
//        $0=new SaeTOAuthV2()
        $o=new SaeTOAuthV2(WB_AKEY,WB_SKEY);
        $code_url=$o->getAuthorizeURL(WB_CALLBACK_URL);
        $this->assign('code_url',$code_url);
        return $this->fetch('login');
    }

    public function verify()//登陆身份验证
    {
        $list=Db::name('customer');
        $username=$list->where('customer_name',$_POST['username'])->find();
        if($username){
            $psw=$list->where('customer_psw',md5($_POST['password']))->find();
            if($psw){
                if(isset($_POST['checked'])){
                    Cookie::set('customer_name',$psw['customer_name'],60*60*24*7);
                    Cookie::set('customer_psw',$psw['customer_psw'],60*60*24*7);
                }
                Session::set('customer_name',$psw['customer_name']);
                return 2;
            }else{
                return 1;
            }
        }else{
            return 0;
        }
    }

    public function callback()//微博oauth
    {
        $o=new SaeTOAuthV2(WB_AKEY,WB_SKEY);
        $keys=array();
        $param=$this->request->param();
        if(isset($param['code'])){
            $keys['code']=$param['code'];
            $keys['redirect_uri']=WB_CALLBACK_URL;
            try {
                $token=$o->getAccessToken('code',$keys);
            }catch (\Exception $e){
                return redirect('/login');
            }
            if($token){
                \session('token',$token);
                $info = new SaeTClientV2(WB_AKEY, WB_SKEY, $token['access_token']);
                $get_uid=$info->get_uid();
                $uid=$get_uid['uid'];
                $uname=$info->show_user_by_id($uid)['name'];
                $oauth=Db::name('oauth')->where([['third_uid','=',$uid],['third_id','=','1']])->find();
                if($oauth){
                    \session('customer_name',$oauth['customer_name']);
                    $this->success('微博用户 '.$uname.'  授权登陆成功,3秒后进入主页','/');
                }else{
                    $this->success('授权成功，绑定用户名,3秒后进入','/bindname');
                }
            }else{
                $this->success('授权失败，3秒后进入登陆页面','/login');
            }
        }else{
            $this->redirect('/login');
        }
    }

    public function  register()//注册
    {
        return $this->fetch('register');
    }
    public function registerAct(){
        $username=trim($_POST['username']);
        $customerlist=Db::name('customer');
        $customer_name=$customerlist->where('customer_name',$username)->find();
        if($customer_name){
            return -1;
        }else{
            $customer=[
                'customer_name'=> $username,
                'customer_phone'=>$_POST['phone'],
                'customer_sex'=>$_POST['sex'],
                'customer_psw'=>md5($_POST['password']),
                'customer_gmt_created'=>time(),
            ];
            $list=$customerlist->insert($customer);
            if($list){
                Session::set('customer_name',$username);
                return 1;
            }else{
                return 0;
            }
        }
    }
    public function usernameCheck(){
        $username=$_POST['username'];
        $customerlist=Db::name('customer');
        $customer_name=$customerlist->where('customer_name',$username)->find();
        if($customer_name){
            return -1;
        }else{
            return 0;
        }
    }

    public function bindname()//oauth后绑定用户名
    {
        return $this->fetch('bindname');
    }

    public function  quit()//退出
    {
        Session::delete('customer_name');
        Cookie::delete('customer_name');
        Cookie::delete('customer_psw');
        return redirect('/');
    }

    public function userInfo(){
        \session('customer_cutomer');
        return $this->fetch('userInfo');

    }
    public function saveAddress(){

        $district=Db::name('district');
        $address_province=$district->where('id',$_POST['province'])->find()['district_name'];
        $address_city=$district->removeOption('where')->where('id',$_POST['city'])->find()['district_name'];
        $address_area=$district->removeOption('where')->where('id',$_POST['area'])->find()['district_name'];
        if(isset($_POST['is_default'])){
            $is_default=1;
        }else{
            $is_default=0;
        }
        $address=[
            'customer_name'=>Session::get('customer_name'),
            'address_name'=>$_POST['address_name'],
            'address_phone'=>$_POST['address_phone'],
            'address_province'=>$address_province,
            'address_city'=>$address_city,
            'address_region'=>$address_area,
            'address_detail'=>$_POST['address_detail'],
            'is_default'=>$is_default
        ];
        return json_encode($address);
        $add=Db::name('address');
        $list=$address->insert($add);
        return $list;
    }

    public function province()
    {
        $list = Db::name('district')->where('type',1)->select();
        return $list;
    }

    public function city($provinceid)
    {
        if ($provinceid) {
            $where = "pid=$provinceid";
        } else {
            $where = "id=52";
        }
        $list = Db::name('district')->where($where)->select();
        return $list;
    }

    public function area($cityid)
    {
        if ($cityid) {
            $where = "pid=$cityid";
        } else {
            $where = "id=500";
        }
        $list = Db::name('district')->where($where)->select();
        return $list;
    }
}