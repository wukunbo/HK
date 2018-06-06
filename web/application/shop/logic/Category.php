<?php 
namespace app\shop\logic;
use think\Model;
use think\Db;

class Category extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
    }


    //添加分类
    public function add_cate($cate_id,$post,$parent_id){
        
        $sql=Db::name("shop_category");
        
        if ($parent_id!=0){

            $result=$sql->where("shop_id in ('".$post['shop_id']."') and  cate_id='$parent_id'")->find();

            if ($result[show_in_nav]!=1){               
                $sql->where("shop_id in ('".$post['shop_id']."') and  cate_id='$parent_id'")->setField('show_in_nav','1');              
            }

            $post[grade]=$result[grade]+1;
        }
        
        if ($cate_id){

            $sql->where("shop_id in ('".$post['shop_id']."') and  cate_id='$cate_id'")->update($post);
            $id=$cate_id;
            
        }else {
            $id=$sql->insertGetId($post);
        }
    
        if ($id){
            $data[status]=10001;
        }else {
            $data[status]=10002;
        }
        
        return $data;
        
    }


    //获取分类详情
    public function get_cate_detail($cate_id,$shop_id){
        
        $cate=Db::name('shop_category');       
        $result=$cate->where("  cate_id='$cate_id'")->find();       
        return $result;
        
    }

    //分类列表模板
    public function get_lists_show($data){
        //p($data);exit;
        for ($i=0;$i<count($data);$i++){                
            for ($j=0;$j<$data[$i][grade];$j++){                    
                $null.='&nbsp;->';              
            }
            
            if ($data[$i][is_show]==1){             
                $is_show="显示";              
            }else{              
                $is_show="不显示";             
            }

            //是否首页推荐分类
            // if($data[$i][is_index]){
            //     $index_cate="<a href='userweb.php?m=Userweb&c=ShopCate&a=is_index_cate&cate_id={$data[$i][cate_id]}&is_index=0'>取消推荐分类</a>";
            // }else{
            //     $index_cate="<a href='userweb.php?m=Userweb&c=ShopCate&a=is_index_cate&cate_id={$data[$i][cate_id]}&is_index=1'>设置推荐分类</a>";
            // }
                    
            $str.="<tr>
                <td><input id=".$data[$i][cate_id]." type='checkbox' value=".$data[$i][cate_id]."  name='cate_id_delete[]'  ></td>
                <td >".$data[$i][cate_id]."</td>                     
                <td >".$null.$data[$i][cat_name]."</td>                 
                <td ><img src=".$data[$i][img_thumb]." width='50px'></td>                                         
                <td>".$data[$i][grade]."</td>                       
                                 
                <td>
                ".$index_cate."
                <a href='".url('ShopCate/cate_form')."?&cate_id=".$data[$i][cate_id]."' ><i class='fa fa-pencil'></i> </a>                        
                <a href='".url('ShopCate/cate_delete')."?&cate_id=".$data[$i][cate_id]."&type=1' onClick='return del_sure()' ><i class='fa fa-trash-o'></i></a>       
                </td>               
                </tr> ";    
                            
            if ($data[$i][show_in_nav]==1){         
                $str.=$this->get_lists_show($data[$i][child]);          
            }   
                      
            $null='';           
        }           
        return $str;
    }


    public function get_parent_str($cate_id,$data=""){
         
        $parent_id=Db::name("shop_category")->where("cate_id='".$cate_id."'")->value("parent_id");
        
        if($parent_id && $parent_id!=$cate_id){
            
            if($data==""){
                $data=$parent_id;
            }else{
                $data=$data.",".$parent_id;
            }
            $data=$this->get_parent_str($parent_id,$data);
            return $data;
        }else{
            return $data;
        }
    }


    //通过cate_id获取子分类id 递归获取所有的下级ID列表
    public function get_cate_children_id($cate_id){     
        $category_lists[]=$cate_id;
        $return_lists=$cate_id;     
        $cate_lists=$this->get_children_id($category_lists,$return_lists);      
        return $cate_lists;
        
    }

    //通过$category_lists检索下属子类，$return_lists 返回的数据
    public function get_children_id($category_lists,$return_lists){ 
        
        $category=Db::name('shop_category');

        for ($i=0;$i<count($category_lists);$i++){          
            $cate_id=$category_lists[$i];           
            $show_in_nav=$category->where("cate_id='$cate_id'")->value('show_in_nav');

            if($show_in_nav=='1'){                  
                $child_array=$category->where( " parent_id='$cate_id' ")->column('cate_id');     
                 // dump($child_data);exit;
                 if($child_array){
                    // dump($child_array);exit;
                    $return_lists=implode(",",$child_array).",".$return_lists;
                    $return_lists=$this->get_children_id($child_array,$return_lists);     
                 }
             
            }else {  
      
            }
        
        }
        return $return_lists;           
        
    }



    //分类列表下拉框
    public function get_select($data,$parent_id=0,$select_id=''){

        for ($i=0;$i<count($data);$i++){            
            for ($j=0;$j<$data[$i][grade];$j++){                
                $null.='-&nbsp;&nbsp;';                 
            }
            
            if ($select_id==$data[$i][cate_id]){    
                $str.="<option selected='selected' value=".$data[$i][cate_id].">".$null.$data[$i][cat_name]."</option>";    
            }else {                 
                $str.="<option value=".$data[$i][cate_id].">".$null.$data[$i][cat_name]."</option>";                    
            }
                    
            if ($data[$i][show_in_nav]==1){                                         
                $str.=$this->get_select($data[$i][child],$parent_id,$select_id);                
            }                   
            $null='';           
        }       
        return $str;    
    }


    //构造分类树
    public function get_cate_tree($shop_id='',$field='',$parent_id=0,$goods_count=0){
        
        $cate_lists=$this->get_cate_lists($shop_id,$num,$order="",$parent_id);          
        
        $content=$cate_lists[lists][content];

        for ($i=0;$i<count($content);$i++){
    
            $cate_id=$content[$i][cate_id];
            $lists=$this->get_cate_children($cate_id,$field);   
            if ($lists[status]==10001){     
                $content[$i][child]=$lists[lists][content];             
            }   
            $content[$i][child_num]=count($content[$i][child]);         
        }

        $cate_lists[lists][content]=$content;                   
        return $cate_lists;             
    }

    //获取子节点
    public function get_cate_children($cate_id,$field){

        $category_lists[]['cate_id']=$cate_id;
        $data[detail]=Db::name("shop_category")->where("cate_id='".$cate_id."'")->find();
      
        $cate_lists=$this->get_cate_children_child($category_lists,$field,$is_top==1);
        
        if ($cate_lists[0][child]==null){       
            $data[status]=10002;            
        }else {         
            $data[status]=10001;            
            $data[lists][content]=$cate_lists[0][child];            
        }
         
                        
        return $data;       
    }

    //多维 分类列表
    public function get_cate_children_child($category_lists,$field,$is_top=0){          
        $category=Db::name('shop_category');

        for ($i=0;$i<count($category_lists);$i++){      
            $cate_id=$category_lists[$i]['cate_id'];        
            $category_lists[$i][child]=$category->field($field)->order('sort_order')->where("  parent_id='$cate_id'")->select();
            
            if($category_lists[$i][child]){
                $category_lists[$i][child]=$this->get_cate_children_child($category_lists[$i][child],$field);
            }
        }
        return $category_lists;
        
    }


    //第一层分类
    public function get_cate_lists($shop_id,$num,$order="",$parent_id=0,$goods_count=0){
                
        if(!$order){
            $order=" sort_order ASC,cate_id DESC";
        }
        $array[order]=$order;
        
        $array[where]="shop_id='{$shop_id}' and parent_id='".$parent_id."' ";

        $lists[content]=Db::name("shop_category")->where($array[where])->order($array[order])->select();
       
        if (!$lists[content]){
            $data[status]=10002;            
        }else { 
            $data[status]=10001;            
        }       
        $data[lists]=$lists;
        return $data;
        
    }

    //获得父级ID 字符串
    public function get_parent_arr($cate_id){
        $lists[cate_id]=$cate_id;

        $lists[parent_id]=Db::name("shop_category")->where("cate_id='".$cate_id."'")->value("parent_id");

        if($lists[parent_id]){
            $lists["parent"]=$this->get_parent_arr($lists[parent_id]);
            return $lists;
        }else{
            return $lists;
        }
    }


    //删除分类
    public function cate_delete($cate_id){
        $data=$this->get_cate_children_id($cate_id);
        // dump($data);exit;
        Db::name('shop_category')->where("cate_id IN($data)")->delete();
        
    }   


}