<?php
namespace app\userweb\controller;
use Think\Controller;
use think\Db;

class Config extends Base{

    public function __construct(){
        parent::__construct();
        $this->logic= new \app\basic\logic\Material();
    }

    //素材分类列表
    public function material_cate_lists(){
         
        $search[user_id]=$this->user_id;
        $data=$this->logic->material_cate_lists($search);
     
        $this->assign('data',$data);
        return $this->fetch("Config/material_cate_lists");
    }


    public function material_cate_add(){
 
        $search[id]=$_REQUEST[id];
        $data=$this->logic->material_cate_detail($search);
        $this->assign('data',$data);
        return $this->fetch("Config/material_cate_add");
    }

    public function material_cate_add_action(){
        
        // dump($_REQUEST);exit;
        $post_id=$_REQUEST[post_id];
        $post=$_REQUEST[post];
        $post[user_id]=$this->user_id;
        $data=$this->logic->material_cate_add($post,$post_id);
        return $this->showmsg("操作成功!");
 
    }


    public function get_material_lists(){
        $search[user_id]=$this->user_id; 
        $search[num]=12;   
        $data[lists]=$this->logic->material_lists($search);
        $this->assign('data',$data);
        $html=$this->fetch("Config/material_lists_tpl");
        if($_REQUEST["json"]){
            $res[status]=10001;
            $res[html]=$html;
            echo json_encode($res);
            exit;
        }else{
            return $this->showmsg("操作成功!",url("Config/material_lists"));
        }
    }


    //添加图片素材
    public function material_add_action(){
 
        $post=$_REQUEST[post];
        $post[user_id]=$this->user_id;
 
        $data=$this->logic->material_add($post,$post_id);
        

        if($_REQUEST["json"]){
            $res[status]=10001;
            echo json_encode($res);
            exit;
        }else{
            return $this->showmsg("操作成功!",url("Config/material_lists"));
        }
 
    }


    //素材列表
    public function material_lists(){
 
        $search[user_id]=$this->user_id;    
        $search[num]=12;
        if($_REQUEST[cate_id]<0 || !$_REQUEST[cate_id]){
            $search[all]=1;//获取公共部分的
        }
        $search[cate_id]=$_REQUEST[cate_id];    
        $data[lists]=$this->logic->material_lists($search);
        
        $search[user_id]=$this->user_id;
        $data[cate_lists]=$this->logic->material_cate_lists($search);

        $this->assign('data',$data);
         
        if($_REQUEST[ajax]==1){
            $return_fn=isset($_REQUEST[return_fn])?$_REQUEST[return_fn]:"material_select";
 
            $data[lists][page]=str_replace('href="','href="javascript:show_content(\'',$data[lists][page]);
            $data[lists][page]=str_replace('">','\')">',$data[lists][page]);
            $data[lists][page]=str_replace('current\')','current',$data[lists][page]);
            $data[page]=$data[lists][page];

            $this->assign('data',$data);
            $this->assign('return_fn',$return_fn);            
            
            $res_html=$this->fetch("Config/material_lists_ajax");
            echo $res_html;
        }else{
            return $this->fetch("Config/material_lists");
        }
         
    }

    //删除图片
    public function material_del(){
        $id=input("id");
        Db::name('tlwx_material')->where("id={$id}")->delete();
        return $this->showmsg("操作成功");
    }


}
