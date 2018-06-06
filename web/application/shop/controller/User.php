<?php
namespace app\shop\controller;
use think\Controller;
use think\Db;

class User extends Base{

    public function __construct(){
        parent::__construct();
    }



    //个人中心首页
    public function index(){
        $this->assign('page_title','我的');

        $data=Db::name('user')->where('id',$this->user_id)->find();

        $this->assign('data',$data);
        return $this->fetch("User/index");
    }


    //添加地址
    public function add_address(){
        $this->assign('page_title','添加地址');

        $data=Db::name('address')->where('id',$_REQUEST['id'])->find();

        $this->assign('data',$data);

        return $this->fetch("User/add_address");
    }

    public function address_action(){
        $post=$_REQUEST['post'];
        // dump($post);
        // 默认地址
        if($post['type']==1){
            Db::name('address')->where('user_id',$this->user_id)->setField('type',0);
        }

        $post['user_id']=$this->user_id;

        $region=Db::name('region');
        $province_name=$region->where("id='{$post[province]}'")->value('region_name');
        $city_name=$region->where("id='{$post[city]}'")->value('region_name');
        $area_name=$region->where("id='{$post[area]}'")->value('region_name');
        $post['address']=$province_name.$city_name.$area_name.$post['details_site'];


        if($post['id']){
            Db::name('address')->where('id',$post['id'])->update($post);
        }else{
            Db::name('address')->insert($post);
        }

        $this->redirect("User/address_lists",array("cart_ids"=>input('cart_ids')));

    }

    //地址列表
    public function address_lists(){
        $this->assign('page_title','地址列表');

        $data=Db::name('address')->where('user_id',$this->user_id)->select();

        $region=Db::name('region');

        foreach ($data as $key => &$value) {
            $value['province_name']=$region->where("id='{$value[province]}'")->value('region_name');
            $value['city_name']=$region->where("id='{$value[city]}'")->value('region_name');
            $value['area_name']=$region->where("id='{$value[area]}'")->value('region_name');
            $value['address']=$value['province_name'].$value['city_name'].$value['area_name'].$value['details_site'];
        }

        $this->assign('data',$data);
        $this->assign('cart_ids',input('cart_ids'));
        return $this->fetch("User/address_lists");
    }

    public function address_delete(){
        Db::name('address')->where('id',$_REQUEST['id'])->delete();
        return $this->showmsg("操作成功");   
    }


    //添加收藏
    public function add_collect(){
        $goods_id=input('goods_id');
        $is=Db::name('shop_wish')->where("user_id={$this->user_id} AND goods_id={$goods_id}")->find();
        if(!$is){
            $dataList=array("user_id"=>$this->user_id,"goods_id"=>$goods_id,"addtime"=>time());
            Db::name('shop_wish')->insert($dataList);
        }

        $res['status']=10001;
        echo json_encode($res);
    }

    //我的收藏
    public function wish_lists(){
        $this->assign('page_title','地址列表');

        $join[]=["tl_shop_goods","tl_shop_goods.goods_id=tl_shop_wish.goods_id"];
        $field=" tl_shop_goods.goods_id,tl_shop_goods.goods_name,tl_shop_goods.market_price,tl_shop_goods.img_orogin ";
        $data=Db::name('shop_wish')->where('user_id',$this->user_id)->join($join)->field($field)->select();

        $this->assign('data',$data);
        return $this->fetch("User/wish_lists");
    }

}