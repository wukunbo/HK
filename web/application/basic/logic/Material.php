<?php 
namespace app\basic\logic;
use think\Model;
use think\Db;

class Material extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
    }

    //素材分类列表
    public function material_cate_lists($search){
            
        $where="user_id='".$search[user_id]."'";            
        $lists=Db::name("tlwx_material_cate")->where($where)->select();
        $result[content]=$lists;
         
        return $result;
    }


    //素材分类详情
    public function material_cate_detail($search){
        $where="id='".$search[id]."'";
        $db=Db::name('tlwx_material_cate');
        $detail=$db->where($where)->find();
        //return false;
        return $detail;

    }


    //素材分类新增
    public function material_cate_add($post,$post_id){
         
        $db=Db::name('tlwx_material_cate');
        if($post_id){
            $db->where("id='".$post_id."' AND user_id='".$post[user_id]."'")->update($post);
        }else{
            $post_id=$db->insertGetId($post);
        }
        $res[status]=10001;
        $res[id]=$post_id;
        return $res;

    }


    //素材新增
    public function material_add($post,$post_id){
         
        $db=Db::name('tlwx_material');
        if($post_id){
            $db->where("id='".$post_id."' AND user_id='".$post[user_id]."'")->save($post);
        }else{
            $post_id=$db->insertGetId($post);
        }
        $res[status]=10001;
        $res[id]=$post_id;
        return $res;

    }


    //素材列表
    public function material_lists($search){
        $map=array();

        if($search[user_id]){
            $map['user_id']=['eq',$search['user_id']];
        }
        if($search[agent_id]){
            $map['agent_id']=['eq',$search['agent_id']];
        }
        if($search[admin_id]){
            $map['admin_id']=['eq',1];
        }
        if($search[cate_id]){
            $map['cate_id']=['eq',$search['cate_id']];
        }
        if($search[all]){
            // $where.=" OR user_id ='-1'";
        }
         
        
        $array['where']=$map;         
        $array['num']=$search[num];     
        $array['table']="tlwx_material";    

        $result=$this->db->Page($array);    
        return $result;
    }




}