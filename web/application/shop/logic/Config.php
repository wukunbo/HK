<?php 
namespace app\shop\logic;
use think\Model;
use think\Db;

class Config extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
    }


    public function detail($search){

        $map=array();

        if($search[shop_id]){
            $map['id']=['eq',$search['shop_id']];
         
        }
        if($search[id]){
            $map['id']=['eq',$search['id']];
         
        }

        if($search[wx_id]){
            $map['wx_id']=['eq',$search['wx_id']];
         
        }
        if($search[user_id]){
            $map['user_id']=['eq',$search['user_id']];
        }

        $detail=Db::name("shop_config")->where($map)->find();
      
        
        //图片处理
        $img_yingyezhizhao_lists=explode(",",$detail['img_yingyezhizhao']);
        $img_shenfenzheng_lists=explode(",",$detail['img_shenfenzheng']);
        $detail['img_yingyezhizhao_lists']=$img_yingyezhizhao_lists;
        $detail['img_shenfenzheng_lists']=$img_shenfenzheng_lists;
        
    
        
        $res=$detail;
        $res['detail']=$detail;
        $res['status']=10001;
        return $res;
    }



    public function add_action($post,$shop_id="",$user_id='',$post_img=array(),$parent_user_id=''){ 

        $db=Db::name("shop_config");

        if(!$user_id){
            $user_id=$db->where("id=".$shop_id."")->value("user_id");
        }
        if($post_img['img_shenfenzheng']){
            $post['img_shenfenzheng']=implode(",",$post_img['img_shenfenzheng']);
        }
        if($post_img['img_yingyezhizhao']){
            $post['img_yingyezhizhao']=implode(",",$post_img['img_yingyezhizhao']);
        }
        if(!$shop_id){
            $shop_id=$db->where("user_id='".$user_id."'")->value("id");
        }

        if(!$shop_id){
            $post[addtime]=time();
            $post[user_id]=$user_id;
            $shop_id=$db->insertGetId($post);

            $tmp['user_id']=$user_id;
            Db::name("user_shop")->insert($tmp);

        }else{
            unset($post['user_id']);
            $db->where("id=".$shop_id."")->update($post);
        }

        $res[sql]=$db->getLastsql();
        $res[shop_id]=$shop_id;
        $res[status]=10001;
        return $res; 
    }



}