<?php
namespace app\userweb\controller;
use Think\Controller;
use think\Db;

class ShopConfig extends Base{

    public function __construct(){
        parent::__construct();
        $this->logic= new \app\shop\logic\Config();
    }


    public function add(){
        //获取配置信息
        $BasicLogic=new \app\basic\logic\Basic();
        $wx_config=$BasicLogic->wx_config($this->wx_id);
        
        //获取商店信息
        $search['shop_id']=$this->shop_id;
        $res=$this->logic->detail($search);

        
        $data=$res[detail];
        $data[domain]=config('DOMAIN');
        
        $this->assign('wx_config',$wx_config);
        $this->assign('data',$data);

        return $this->fetch("ShopConfig/add");
    }


    public function add_action(){

        $post=$_REQUEST[post];
        
        if(!$post[title]){
            $this->showmsg("请填写商城名称");
        }

        $res=$this->logic->add_action($post,$this->shop_id,$this->user_id);
  
        return $this->showmsg("更新成功");
    }


}
