<?php 
namespace app\basic\logic;
use think\Model;
use think\Db;

class Ad extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
    }


    //新增
    public function add($post,$post_id){
         
        $db=Db::name('ad');
        if($post_id){
            $db->where("id='".$post_id."'  ")->update($post);
        }else{
            $post_id=$db->insertGetId($post);
        }
        $res[status]=10001;
        $res[id]=$post_id;
        $res[sql]=$db->getLastsql();
        return $res;

    }


    public function lists($search){

        $db=Db::name('ad');

        $map=array();

        if($search['user_id']){
            $map['user_id']=['eq',$search['user_id']];
        }
       
        if($search['cate_id']){ //根据位置获取广告
            $map['cate_id']=['eq',$search['cate_id']];
        }
        
        $lists=$db->where($map)->order("sort_order asc,id desc")->select();
        
        
        for($i=0;$i<count($lists);$i++){
            $lists[$i]['cate_title']=Db::name("ad_cate")->where("id='".$lists[$i]['cate_id']."'")->value("title");
        }
        return $lists;
    }


    //分类列表
    public function cate_lists($search){
        
        $db=Db::name('ad_cate');   
         
        $where=" 1 ";
        if($search['user_id']){
            $where.=" AND user_id='".$search['user_id']."'";
        }
        
        $lists=$db->where($where)->select();
 
        return $lists;
    }



    //详情
    public function detail($search){
        $where="id='".$search[id]."'";
        $db=Db::name('ad');
        $detail=$db->where($where)->find();
        
        return $detail;

    }


}