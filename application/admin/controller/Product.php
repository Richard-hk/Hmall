<?php
namespace app\admin\controller;

use app\admin\model\product\Brand;
use app\admin\model\product\Category;
use app\admin\model\product\Good_sku;
use app\admin\model\product\Good_spu;
use think\Controller;
use think\Db;
use think\Exception;
use think\facade\Url;
use think\Request;
use const http\Client\Curl\Versions\CURL;


class Product extends Controller
{
    public function productBrand($page_count=5,$brand_search=null)//品牌管理页面
    {
        if($brand_search){
            $brand_name=['brand_name','like','%'.$brand_search.'%'];
            $brand_desc=['brand_desc','like','%'.$brand_search.'%'];
            $list=Brand::order('brand_id', 'desc')->whereor([$brand_name,$brand_desc])->paginate($page_count);
        }else{
            $list = Brand::order('brand_id', 'desc')->paginate($page_count);
        }
        $total = $list->total();
        $current_page = $list->CurrentPage();
        $per_page = $list->Count();
        $last_page = $list->LastPage();
        $this->assign([
            'list' => $list,
            'total' => $total,
            'current_page' => $current_page,
            'per_page' => $per_page,
            'page_count' => $page_count,
            'last_page' => $last_page
        ]);
        return $this->fetch('productBrand');
    }

    public function productBrandAdd()//品牌添加
    {
        $file = request()->file('brand_logo');
        $brand_name = $_POST['brand_name'];
        $file_path='uploads/admin/brand_logo/';
        $info = $file->move($file_path, $brand_name);
        if ($info) {
            $brand = [
                'brand_name' => trim($_POST['brand_name']),
                'brand_logo' => '/'.$file_path . $brand_name . '.png',
                'brand_desc' => trim($_POST['brand_desc'])
            ];
            $result = Db::name('brand')->insert($brand);
            if ($result) {
                return 'correct';
            } else {
                return 'add_err';
            }
        } else {
            return $file->getError();
        }
    }

    public function productBrandEdit()//品牌编辑页面
    {
        $brand_id=$_GET['brand_id'];
        $list=Db::name('brand')->where('brand_id','=',$brand_id)->select();
        $this->assign('list',$list);
        $this->assign('brand_id',$brand_id);
        return $this->fetch('productBrandEdit');
    }

    public function productBrandAlert()//品牌编辑
    {
        $brand_id=$_POST['brand_id'];
        $brand_name = $_POST['brand_name'];
        $file_path = 'uploads/admin/brand_logo/';
        if(empty(request()->file('brand_logo'))){
            $brand = [
                'brand_name' => trim($_POST['brand_name']),
                'brand_desc' => trim($_POST['brand_desc'])
            ];
        }else{
            $file = request()->file('brand_logo');
            $info = $file->move($file_path, $brand_name);
            $brand = [
                'brand_name' => trim($_POST['brand_name']),
                'brand_logo' => '/'.$file_path . $brand_name . '.png',
                'brand_desc' => trim($_POST['brand_desc'])
            ];
        }
        $result = Db::name('brand')->where('brand_id',$brand_id)->data($brand)->update();
        return $result;
    }

    public function productBrandDelete()//品牌删除
    {
        $brand_id = $_POST['brand_id'];
        // $res = Db::name('brand')->where('brand_id', '=', $brand_id)->destory();
        // return $res;
    }

    public function productBrandAllDel()//品牌全选删除
    {
        $brand_id_all = $_POST['brand_id_all'];
        $res = Db::name('brand')->delete($brand_id_all);
        return Db::getlastsql();
    }

    public function productCategory()//品牌分类管理页面
    {
        return $this->fetch('product/productCategory');
    }

    public function productCategoryAdd()//品牌分类添加页面
    {
        if(isset($_GET['category_id'])){
            $category_id=$_GET['category_id'];
            $categoryAll=Db::name('category');
            $category=$categoryAll->where('category_id','=',$category_id)->find();
            $category_level=$category['category_level'];
            if($category_level==1){
                $name1=$category['category_name'];
                $this->assign('name1',$name1);
            }elseif($category_level==2){
                $hma_category_id=$category['hma_category_id'];
                $name2=$category['category_name'];
                $category=$categoryAll->removeOption('where')->where('category_id','=',$hma_category_id)->find();
                $name1=$category['category_name'];
                $this->assign(['name1'=>$name1,'name2'=>$name2]);
            }else{
                $name3=$category['category_name'];
                $hma_category_id=$category['hma_category_id'];
                $category=$categoryAll->removeoption('where')->where('category_id','=',$hma_category_id)->find();
                $name2=$category['category_name'];
                $hma_category_id=$category['hma_category_id'];
                $category=$categoryAll->removeoption('where')->where('category_id','=',$hma_category_id)->find();
                $name1=$category['category_name'];
                $this->assign(['name1'=>$name1,'name2'=>$name2,'name3'=>$name3]);
            }
            $brand=Db::name('brand')->where('brand_name',$name1)->find();
            $brand_id=$brand['brand_id'];
            $this->assign('category_level',$category_level);
            $this->assign('brand_id',$brand_id);
            $this->assign('category_id',$category_id);
            
        }else{
            $this->assign('category_level',0);
        }
        return $this->fetch('product/productCategoryAdd');
    }

    public function productCategoryAddAct()//品牌分类添加
    {
        
        $category = [
            'brand_id'=>$_POST['brand_id'],
            'hma_category_id'=>$_POST['category_id'],
            'category_name'=>$_POST['category_name'],
            'category_desc'=>$_POST['category_desc'],
            'category_level'=>$_POST['category_level']+1
        ];
        $list=Db::name('category')->insert($category);
        return $list;
    }
    public function productCategoryEditAct()//品牌分类添加
    {
        $category_id=$_POST['category_id'];
        $category = [
            'category_name'=>$_POST['category_name'],
            'category_desc'=>$_POST['category_desc'],
        ];
        $list=Db::name('category')->where('category_id',$category_id)->data($category)->update();
        return $list;
    }

    public function productList()//产品管理页面
    {
        return $this->fetch('product/productList');
    }

    public function productListAct()//左侧分类展示
    {
        $list=Db::name('category')->field('category_id,hma_category_id,category_name')->select();
        return json_encode($list);
    }

    public function  productListShow()//分类产品展示页面
    {
        if(isset($_GET['category_id'])) {
            $category_id = $_GET['category_id'];
            $list = Category::where('category_id', '=', $category_id)->find();
            $brand_name = $list->brand_id[0]['brand_name'];
            $category_name = $list->category_name;
            $category_level = $list->category_level;
            $hma_category_id = $list->hma_category_id;
            if ($category_level != 1) {
                $list1 = Category::where('category_id', '=', $hma_category_id)->find();
                $hma_category_name = $list1->category_name;
                $this->assign('hma_category_name', $hma_category_name);
            }
            if (isset($_GET['search']) == 1) {
                $datemin = strtotime($_GET['datemin']);
                $datemax = strtotime($_GET['datemax']);
                $good_spu = Db::name('good_spu')->where('gmt_up', ['>', $datemin], ['<', $datemax], 'and')->where('good_status','<>','-2')->select();
            } else {
                $good_spu = Db::name('good_spu')->where('category_id', $category_id)->where('good_status','<>','-2')->select();
            }
            $total = count($good_spu);
            $this->assign([
                'category_id' => $category_id,
                'category_name' => $category_name,
                'category_level' => $category_level,
                'brand_name' => $brand_name,
                'good_spu' => $good_spu,
                'total' => $total,
            ]);
        }else{
            $this->assign([
                'category_id' => "",
                'category_name' => "",
                'category_level' =>"" ,
                'brand_name' =>"" ,
                'good_spu' =>"" ,
                'total' => 0,
            ]);

        }
        return $this->fetch('productListShow');
    }

    public function productListStop($good_spu_id)//分类产品下架
    {
        $list=Db::name('good_spu')->where('good_spu_id',$good_spu_id)->update(['good_status'=>-1]);
        return $list;
    }

    public function productListStart($good_spu_id)//分类产品上架
    {
        $list=Db::name('good_spu')->where('good_spu_id',$good_spu_id)->update(['good_status'=>1]);
        return $list;
    }

    public function productListDelete($good_spu_id)//分类产品删除
    {
        $list=Db::name('good_spu')->where('good_spu_id',$good_spu_id)->data(['good_status'=>-2])->update();
        return $list;

    }


    public function productListAdd($category_id)//分类产品添加页面
    {

        $this->assign('category_id',$category_id);
        return $this->fetch('productListAdd');
    }

    public function productListAddAct()//分类产品添加
    {
        $category_id=$_POST['category_id'];
        $good_name=$_POST['good_name'];
        $good_desc=$_POST['good_desc'];
        $good_pic=$this->request->file('brand_logo');
        $good_pic_path='uploads/admin/product_logo/';
        $res=$good_pic->move($good_pic_path,$good_name);
        $pic_extension=$res->getExtension();

        if($res){
            $good_spu=[
                'category_id'=>$category_id,
                'gmt_up'=>strtotime($_POST['datemin']),
                'gmt_down'=>strtotime($_POST['datemax']),
                'good_name'=>$good_name,
                'good_desc'=>$good_desc,
                'good_status'=>1,
                'good_sku_pic'=>'/'.$good_pic_path.$good_name.'.'.$pic_extension
            ];
            $list=Db::name('good_spu')->insert($good_spu);
            return $list;
        }else{
            return 0;
        }

    }
    

    public function productListPicture(){
        $good_spu_id=$_GET['good_spu_id'];
        $good_spu=Good_spu::where('good_spu_id','=',$good_spu_id)->find();
        $this->assign([
            'good_spu_id'=>$good_spu_id,
            'good_name'=>$good_spu->good_name,
        ]);
        return $this->fetch('productListPicture');
    }
    public function productListPictureAct(){
        $file = request()->file('file');
        $good_spu_id=$_POST['good_spu_id'];
        $filename =date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 6);
        $file_path = 'uploads/index/spu/'.$good_spu_id;
        $info = $file->move($file_path, $filename);
        $path=$info->getPathname();
        if($info){
            $data=[
                'good_spu_id'=>$good_spu_id,
                'spu_pic_src'=>'/'.$path
            ];
            $res=db('spu_pic')->insert($data);

        }
    }
    public function productListPictureShow(){
        $good_spu_id=$_GET['good_spu_id'];
        $good_spu=Good_spu::where('good_spu_id','=',$good_spu_id)->find();
        $list=db('spu_pic')->where('good_spu_id',$good_spu_id)->select();
        $this->assign([
            'good_spu_id'=>$good_spu_id,
            'good_name'=>$good_spu->good_name,
            'count'=>count($list),
            'list'=>$list
        ]);
        return $this->fetch('productListPictureShow');
    }
    public function productListPictureDelete($spu_pic_id){
        $res=db('spu_pic')->where('spu_pic_id',$spu_pic_id)->delete();
        return $res;
    }

    public function productListEdit()//分类产品编辑页面
    {
        $category_id=$_GET['category_id'];
        $good_spu_id=$_GET['good_spu_id'];
        $good_spu=Good_spu::where('good_spu_id','=',$good_spu_id)->find();
        $this->assign([
            'category_id'=>$category_id,
            'good_spu_id'=>$good_spu_id,
            'good_name'=>$good_spu->good_name,
            'gmt_up'=>$good_spu->gmt_up,
            'gmt_down'=>$good_spu->gmt_down,
            'good_desc'=>$good_spu->good_desc
        ]);
        return $this->fetch('productListEdit');
    }
    public function productListEditAct(){
        // $category_id=$_POST['category_id'];
        // $good_name=$_POST['good_name'];
        // $good_desc=$_POST['good_desc'];
        // $good_pic=$this->request->file('brand_logo');

        // $good_pic_path='uploads/admin/product_logo/';
        // $res=$good_pic->move($good_pic_path,$good_name);
        // $pic_extension=$res->getExtension();

        // if($res){
        //     $good_spu=[
        //         'category_id'=>$category_id,
        //         'gmt_up'=>strtotime($_POST['datemin']),
        //         'gmt_down'=>strtotime($_POST['datemax']),
        //         'good_name'=>$good_name,
        //         'good_desc'=>$good_desc,
        //         'good_status'=>1,
        //         'good_sku_pic'=>'/'.$good_pic_path.$good_name.'.'.$pic_extension
        //     ];
        //     $list=Db::name('good_spu')->insert($good_spu);
        //     return $list;
        // }else{
        //     return 0;
        // }
    }

    public function productListChild()//产品规格页面
    {

        $good_spu_id=$_GET['good_spu_id'];
        $good_name=$_GET['good_name'];
        $list=Db::name('good_sku')->where('good_spu_id',$good_spu_id)->select();
        $this->assign([
            'good_spu_id'=>$good_spu_id,
            'good_name'=>$good_name,
            'list'=>$list,
            'count'=>count($list)

        ]);

        return $this->fetch('productListChild');
    }
    public function productListChildAdd()//产品规格添加页面
    {
        $good_spu_id=$_GET['good_spu_id'];
        $good_name=$_GET['good_name'];
        $good_sku=Db::name('good_sku')->where('good_spu_id',$good_spu_id)->field('good_sku_color,good_sku_pic')->group('good_sku_color,good_sku_pic')->select();
        $this->assign([
            'good_spu_id'=>$good_spu_id,
            'good_name'=>$good_name,
            'good_sku'=>$good_sku,
        ]);

        return $this->fetch('productListChildAdd');
    }
    public function productListChildAddAct(){//产品规格添加
        $good_sku_color=trim($_POST['good_sku_color']);
        $good_spu_id=trim($_POST['good_spu_id']);
        if($_POST['good_color_select']==-1){
            $list =Db::name('good_sku')->where([
                ['good_spu_id','=',$good_spu_id],
                ['good_sku_color','=',$good_sku_color]
            ])->select();
            if($list){
                return -1;
            }else{

                $file = request()->file('good_pic');
                $file_path='uploads/admin/brand_logo/spu_id'.$good_spu_id.'/';
                $info = $file->move($file_path, $good_sku_color);
                $file_extension=$info->getExtension();
                $good_sku_pic='/'.$file_path.$good_sku_color.'.'.$file_extension;
            }

        }else{
            $good_sku_pic=$_POST['good_color_select'];
        }
        $good_sku=[
            'good_spu_id'=>$good_spu_id,
            'good_sku_rom'=>$_POST['good_sku_rom'],
            'good_sku_ram'=>$_POST['good_sku_ram'],
            'good_sku_color'=>$good_sku_color,
            'stock_num'=>$_POST['stock_num'],
            'left_num'=>$_POST['stock_num'],
            'good_price'=>$_POST['good_price'],
            'good_sku_pic'=>$good_sku_pic,
            ];
        $list=Db::name('good_sku')->insert($good_sku);
        if($list){
            return 1;
        }else{
            return 0;
        }
    }

    public function productListChildEdit(){
        $good_sku_id=$_GET['good_sku_id'];
        $list=Db::name('good_sku')->where('good_sku_id',$good_sku_id)->find();
        $good_sku=Db::name('good_sku')->field('good_sku_color,good_sku_pic')->group('good_sku_color,good_sku_pic')->select();
        $this->assign([
            'good_sku_id'=>$good_sku_id,
            'good_sku_rom'=>$list['good_sku_rom'],
            'good_sku_ram'=>$list['good_sku_ram'],
            'good_sku_pic'=>$list['good_sku_pic'],
            'good_sku_color'=>$list['good_sku_color'],
            'good_price'=>$list['good_price'],
            'stock_num'=>$list['stock_num'],
            'good_sku'=>$good_sku,

        ]);
        return $this->fetch('productListChildEdit');
    }
    public function productListChildEditAct(){

    }
    public function productListChildDelete($good_sku_id){
        $good_sku=new Good_sku();
        $res=$good_sku->goodSkuCheck($good_sku_id);
        return $res==-1?-1:$res;
    }

    // public function webPicSave(Request $request){
    //     $file = $this->request->file('file');//file是传文件的名称，这是webloader插件固定写入的。因为webloader插件会写入一个隐藏input，这里与TP5的写法有点区别
    //     $file->size = 524288000;
    //     $folder = input('folder');
    //     if ($folder) {
    //         //保存目录
    //         $Path = '/public' . DS . 'uploads' . DS . $folder;
    //         $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . $folder);
    //     }else{
    //         $Path = '/public' . DS . 'uploads';
    //         $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
    //     }

    //     if($info){
    //         // 成功上传后 获取上传信息
    //         // 输出 jpg 地址
    //         $filePath = "/".$Path. DS .$info->getSaveName();
    //         $filePath = str_replace("\\","/",$filePath);   //替换\为/
    //         return json(['success'=>true,'filePath'=>$filePath]);
    //     }else{
    //         // 上传失败获取错误信息
    //         echo $file->getError();
    //     }
    // }



//        try{
//            $file=$request->file('file');
//            $serverFile=$file->move('/uploads/test');
//            $imageUrl = $serverFile->getPathname();
//
//            $ajaxJson['success'] = true;
//            $ajaxJson['msg'] = $imageUrl;
//
//        }catch (Exception $e){
//            $ajaxJson['success'] = false;
//        }
//        return json_encode($ajaxJson);
//    }

}
