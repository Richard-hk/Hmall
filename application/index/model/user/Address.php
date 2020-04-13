<?php


namespace app\index\model\user;

use think\Model;

class Address extends Model
{
    public function saveAddress($customer_name,$address_name,$address_phone,$province,$city,$area,$address_detail,$is_default,$last_id){

        $district=db('district');
        $address_province=$district->where('id',$province)->find()['district_name'];
        $address_city=$district->removeOption('where')->where('id',$city)->find()['district_name'];
        $address_area=$district->removeOption('where')->where('id',$area)->find()['district_name'];
        // if(isset($_POST['is_default'])){
        //     $is_default=1;
        // }else{
        //     $is_default=0;
        // }
        $address=[
            'customer_name'=>$customer_name,
            'address_name'=>$address_name,
            'address_phone'=>$address_phone,
            'address_province'=>$address_province,
            'address_city'=>$address_city,
            'address_region'=>$address_area,
            'address_detail'=>$address_detail,
            'is_default'=>$is_default
        ];
//        return json_encode($address);
        $list=$this->insert($address);
        if($last_id){
            return $this->getLastInsID();
        }else{
            return $list;
        }
    }

}