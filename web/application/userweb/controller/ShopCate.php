<?php
namespace app\userweb\controller;
use Think\Controller;
use think\Db;

class ShopCate extends Base{

    public function __construct(){
        parent::__construct();
        $this->Cate_logic = new \app\shop\logic\Category();
    }

    //显示添加分类
    public function cate_form(){
        
        $cate_id=$_REQUEST[cate_id];        
        if ($cate_id){            
            $data=$this->Cate_logic->get_cate_detail($cate_id,$this->shop_id);
        }       
        $field="cat_name,keywords,sort_order,show_in_nav,parent_id,grade,img_thumb,img_orogin,cate_id";         
        $tree=$this->Cate_logic->get_cate_tree($this->shop_id,$field);      
        $op_lists=$this->Cate_logic->get_select($tree[lists][content],0,$data[parent_id]);

        $this->assign('data',$data);
        $this->assign('op_lists',$op_lists);   
        return $this->fetch("ShopCate/cate_form");
    }

    //添加分类
    public function add_cate(){
        
        $cate_id=$_REQUEST[cate_id];
        $post=$_REQUEST[post];
        $post['shop_id'] = $this->shop_id; 
        $parent_id=$post[parent_id];        
        $data=$this->Cate_logic->add_cate($cate_id,$post,$parent_id);
        
        if ($data[status]==10001){
            return $this->showmsg('修改成功',url('cate_lists'));
        }else {
            return $this->showmsg('修改失败');
        }
    }

    //分类列表
    public function cate_lists(){
        
        $field="cat_name,keywords,sort_order,show_in_nav,parent_id,grade,img_thumb,img_orogin,cate_id,is_index";        
        $data=$this->Cate_logic->get_cate_tree($this->shop_id,$field);
        $data=$this->Cate_logic->get_lists_show($data[lists][content]); 
        $this->assign('data',$data);
        return $this->fetch("ShopCate/cate_lists");
    }

    //删除分类
    public function cate_delete(){
        $cate_id=$_REQUEST[cate_id];
        $this->Cate_logic->cate_delete($cate_id);
        return $this->showmsg('操作成功');
    }


}