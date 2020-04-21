<?php


namespace app\admin\controller;


use think\Controller;
use think\Db;
use app\admin\model\customer\Customer as customerModel;
use think\facade\Request;

class Customer extends Controller
{
    public function customerList(){
        $page_num=10;
        $current_page=1;
        if(isset($_GET['page_num'])){
            $page_num=$_GET['page_num'];
            $page_num=2;
        }
        if(isset($_GET['current'])&&isset($_GET['page_num'])){
            $current_page=$_GET['current'];
        }
        $customer=new customerModel();
        $list=$customer->where('customer_status','<>','-1')->paginate($page_num);
        $this->assign('list',$list);
        $this->assign('total',$list->total());
        $this->assign('totalPages',$list->lastPage());
        return $this->fetch('customerList');
    }
    public function customerDel(){
        $customer=new customerModel();
        $list=$customer->where('customer_status','=','-1')->select();
        $this->assign('list',$list);
        return $this->fetch('customerDel');

    }
    public function customerChangePassword(){
        $this->assign('customer_name',$_GET['customer_name']);
        return $this->fetch('customerChangePassword');
    }
    public function customerChangePasswordAct()
    {
        $custome_name=$_POST['customer_name'];
        $customer_psw=$_POST['newpassword'];
        return customerModel::where('customer_name',$custome_name)->update(['customer_psw'=>md5($customer_psw)]);
    }


    public function customerStart(){
        $customer_name=$_POST['customer_name'];
        $customer=new customerModel();
        return $customer->changeStatus($customer_name,1);
    }
    public function customerStop(){
        $customer_name=$_POST['customer_name'];
        $customer=new customerModel();
        return $customer->changeStatus($customer_name,0);
    }
    public function customerRestart(){
        $customer_name=$_POST['customer_name'];
        $customer=new customerModel();
        return $customer->changeStatus($customer_name,0);
    }
    public function customerDelete(){
        $customer_name=$_POST['customer_name'];
        $customer=new customerModel();
        return $customer->changeStatus($customer_name,-1);
    }
    public function customerAllDelete(){
        $customer_names=$_POST['customer_names'];
        $customer=new customerModel();
        return $customer->changeAllStatus($customer_names,-1);
    }
    public function customerAllRestart(){
        $customer_names=$_POST['customer_names'];
        $customer=new customerModel();
        return $customer->changeAllStatus($customer_names,1);
    }
}