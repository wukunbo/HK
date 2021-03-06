<?php
namespace app\userweb\controller;
use Think\Controller;
use think\Db;

class Ad extends Base{

    public function __construct(){
        parent::__construct();
        $this->logic= new \app\basic\logic\Ad();
    }

    //新增
    public function add(){
 
        $search[id]=$_REQUEST[id];
        $data=$this->logic->detail($search);
        
        $data[cate_lists]=$this->logic->cate_lists($search);

        $this->assign('data',$data);
        return $this->fetch("Ad/add");
    }

    //新增
    public function add_action(){
 
        $post_id=$_REQUEST[post_id];
        $post=$_REQUEST[post];
        $post[user_id]=$this->user_id;
        $data=$this->logic->add($post,$post_id);
        return $this->showmsg("操作成功!");
 
    }


    //上下架
    public function chang_status(){
 
        $id=$_REQUEST[id];      
        $string="is_show";  
        $string_val=$_REQUEST[to_is_show];
        $db=Db::name('ad');
        $check=$db->where("id='$id'")->setField($string,$string_val);   
        
        return $this->showmsg("操作成功!");
 
    }



    //列表
    public function lists(){

        $search[user_id]=$this->user_id;
        $search[is_show]=1;
        $data=$this->logic->lists($search);
        // dump($data);exit;
         
        $this->assign('data',$data);
        return $this->fetch("Ad/lists");
         
    }

    public function del(){
        $id=$_REQUEST[id];
        Db::name('ad')->where('id',$id)->delete();
        return $this->showmsg("操作成功!");
    }

}