<?php 
namespace app\cms\logic;
use think\Model;
use think\Db;

class Cms extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
    }


    //列表
    public function lists($cate_id,$data,$num=''){

        $array["table"]="cms_content";
        
        $map=array();
        
        if ($cate_id){
            $str=Db::name("cms_category")->where("parent_id='".$cate_id."'")->value("id",true);
            $str=implode(",",$str);
            if($str){
                $str=$str.",".$cate_id;
                $map["cate_id"]=['in',$str];
            }else{
                $map["cate_id"]=['eq',$cate_id];
            }   
             
        }
        if ($data['keyword']){
            $map['title']=['LIKE',"%{$data[keyword]}%"];
        }
        if ($data['status']){
            $map["status"]=['eq',$data['status']];
        }
        if ($data['user_id']){
            $map["user_id"]=['eq',$data['user_id']];
        }
        $array['num']=$num;
        if(!$num){
            $array['num']=10;
        }

        $array['field']="*";
        if($data['field']){
            $array['field']=$data['field'];
        }
        $array['order']=$data['order'];


        if($data['order']==""){
            $array['order']='tl_cms_content.listsorder DESC,tl_cms_content.id desc';
        }
        
        $lists=$this->db->Page($array);

        $cms_gallery=Db::name('cms_gallery');
        
        if ($lists[content]){
            foreach ($lists['content'] as $key => &$value) {
                $value['cate_title']=Db::name('cms_category')->where('id',$value['cate_id'])->value("title");
                
                $gallery=$cms_gallery->where("cms_id='$value[id]'")->column("img_orogin");
                $value['gallery']=$gallery;
            }

            $lists[status]=10001;   
        }else {
            $lists[status]=10002;
        }
        
        return $lists;      
    }


    //添加文章
    public function add($id,$post,$gallery_thumb, $gallery_orogin){

        $cms=Db::name('cms_content');

        $where="id='$id'";

        if(!$post[showtime]){
            $post[showtime]=time();
        }else{
            $post[showtime]=strtotime($post[showtime]);
        }
        
        $image_thumb=$cms->where($where)->value("img_thumb");
        
        if(!$id){

            $post[addtime_1]=time();
            $id=$check=$cms->insertGetId($post);
        }else{

            $check=$cms->where($where)->update($post);   
        }

        $this->add_cms_gallery($id,$gallery_thumb,$gallery_orogin);
        
        if ($id){         
            $data[status]=10001;
        }else{
            $data[status]=10002;
        }

        $data[sql]=$cms->getLastsql();
        return $data;
    }


    public function add_cms_gallery($cms_id,$gallery_thumb,$gallery_orogin){

        $cms_gallery=Db::name('cms_gallery');
        $cms_gallery->where('cms_id',$cms_id)->delete();

        $options[cms_id]=$cms_id;
        for ($i=0;$i<count($gallery_orogin);$i++){
            
            $options['img_thumb']=$gallery_thumb[$i];
            $options['img_orogin']=$gallery_orogin[$i];
        
            $check=$cms_gallery->insert($options);
        }
        return $check;
    }


    //文章详情
    public function detail($id){

        $cms=Db::name("cms_content");
        $detail=$cms->where('id',$id)->find();

        $detail['gallery']=$this->find_cms_gallery($detail[id]);
        $detail['img_lists']=$detail[gallery];

         return $detail;     
    }

    public function find_cms_gallery($cms_id){
        $cms_gallery=Db::name('cms_gallery');
        $gallery=$cms_gallery->where("cms_id='$cms_id'")->select();
        return $gallery;
    }


    //分类新增
    public function category_add($post,$post_id){
         
        $db=Db::name('cms_category');

        if($post_id){
            $db->where("id='".$post_id."'  ")->update($post);
        }else{
             
            $post_id=$db->insertGetId($post);
        }
        $res[sql]=$db->getLastsql();
        $res[status]=10001;
        $res[id]=$post_id;
        return $res;

    }

    //分类列表
    public function category_lists($search){
        
        // $array['where']="user_id='".$search[user_id]."'";
        $array['num']=10000;
        $array['table']="cms_category";
        $result=$this->db->Page($array);
        return $result;
    }


    //分类详情
    public function category_detail($search){
        $where="id='".$search[id]."'";
        $db=Db::name('cms_category');
        $detail=$db->where($where)->find();
        //return false;
        return $detail;
    }


    //递归
    public function get_category_tree($user_id='',$parent_id,$level=0,$is_all=0){
     
        if($user_id){
            $where="parent_id='".$parent_id."' AND user_id='".$user_id."'   ";
        }else{
            $where="parent_id='".$parent_id."'    ";
        }
        
        $db=Db::name('cms_category');
        
        $lists=$db->where($where)->order(" listsorder DESC,id DESC")->select();
        $level=$level+1;
        for ($i=0;$i<count($lists);$i++){           
            $lists[$i]["child"]=$this->get_category_tree($user_id,$lists[$i][id],$level,$is_all); 
            $lists[$i]["level"]=$level;   
        }
        return $lists;              
    }


    //分类列表下拉框
    public function get_select($lists,$select_id=""){

        for ($i=0;$i<count($lists);$i++){
            
            $null="";

            for ($j=0;$j<$lists[$i]["level"];$j++){               
                $null.='-&nbsp;&nbsp;';                 
            }

            if ($select_id==$lists[$i]['id']){    
                $str.="<option selected='selected' value=".$lists[$i]['id'].">".$null.$lists[$i]['title']."</option>";  
            }else {                 
                $str.="<option value=".$lists[$i]['id'].">".$null.$lists[$i]['title']."</option>";                  
            }   
            $str.=$this->get_select($lists[$i]['child'],$select_id);              
                         
        }   
 
        return $str;
    }


}
