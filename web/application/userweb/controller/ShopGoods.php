<?php
namespace app\userweb\controller;
use Think\Controller;
use think\Db;

class ShopGoods extends Base{

    public function __construct(){
        parent::__construct();
        $this->Goods_logic = new \app\shop\logic\Goods();
        $this->Cate_logic = new \app\shop\logic\Category();
    }


    //商品添加
    public function add_goods(){
       
        
        $goods_id=$_REQUEST[goods_id];

        //基本信息
        $post=$_REQUEST[post];
        if($post[goods_name]==""){
            return $this->showmsg("请填写标题");
        }

        if($_REQUEST[gallery_thumb][0]==""){
            return $this->showmsg("请至少上传一张图片");
        }

        if($post[shop_price]==""){
            return $this->showmsg("请填写价格");
        }
        if($goods_id==""){
            $post['shop_id'] = $this->shop_id ;
        }

        //分类
        $post_cate=$_REQUEST[post_cate];
        for($i=0;$i<count($post_cate);$i++){
            if($post_cate[$i]!='请选择'){
                $post[cate_id]=$post_cate[$i];
            }
        }
        
     
        $post[img_thumb]=$_REQUEST[gallery_thumb][0];
        $post[img_orogin]=$_REQUEST[gallery_orogin][0];
 
        //属性
        $attr=$_REQUEST[attr];
        
        //标签
        $attr_tags=$_REQUEST[attr_tags];
        $data['attr_tags']=$attr_tags;

        //相册
        $gallery_thumb=$_REQUEST[gallery_thumb];
        $gallery_orogin=$_REQUEST[gallery_orogin];  
        //分类
        $cate_lists=$_REQUEST[cate_lists];
       
        
     
         
        $data=$this->Goods_logic->add_goods($goods_id,$post,$attr,$cate_lists,$gallery_thumb,$gallery_orogin,$data);    

        if ($data[status]==10001) {
            return $this->showmsg('添加/修改成功，页面跳转中...'); 
        }else {
            return $this->showmsg('修改失败');
        }
    }




    //添加商品
    public function goods_form(){
        $goods_id=$_REQUEST[goods_id];

        if($goods_id){
            
            $data=$this->Goods_logic->goods_form($goods_id,$this->shop_id);
        }


        //父级ID序列 ,1,2,4,5倒序
        if($data['detail']['cate_id']){
            $data['parent_str']=$data['detail']['cate_id'].",".$this->Cate_logic->get_parent_str($data['detail']['cate_id']);
            $data['parent_str']=rtrim($data['parent_str'],",");
        }

        //获取分类 列表
        $field="cat_name,keywords,sort_order,show_in_nav,parent_id,grade,img_thumb,img_orogin,cate_id";     
        $cate_lists=$this->Cate_logic->get_cate_tree($this->shop_id,$field);
        
        $tmp_cate_lists=$cate_lists[lists][content];     
        
        //主分类
        $data[detail][cate_str_main]=$this->Cate_logic->get_select($tmp_cate_lists,'1',$select_id=$data[detail][cate_id]);
        $tmp=$data[detail][cate_lists];

        $Attr_logic = new \app\shop\logic\Attr(); 
        $attr_lists=$Attr_logic->get_attr_cate_lists('');

        $this->assign('data',$data);
        $this->assign('cate_lists',$cate_lists);
        $this->assign('attr_lists',$attr_lists);
        
       return $this->fetch("ShopGoods/goods_form");
    }


    /*  
        *商品列表
        *$cate_id 所属分类id 可不传入
        *$num 要检索的数量
        *type 商品种类:0为普通商品、1推荐、2促销、3预购、4热销、5积分商品、6新品、7具有赠品,101所有商品
        *order 排序
        *field 需要检索的字段
        **/
    public function goods_lists(){

        $status = $_REQUEST['status'];
        $field=$_REQUEST[field];
        $type=$_REQUEST[type];
        $keyword=$_REQUEST[keyword];        
        $cate_id=$_REQUEST[cate_id];
        $is_recommended=$_REQUEST[is_recommended];
        $order=$_REQUEST[order];

        if($order==""){
            $order="tl_shop_goods.is_top DESC,tl_shop_goods.addtime DESC ";
        }

        $search[cate_id_str]=$_REQUEST[cate_id_str];
        
        $num=15;

        $shop_id=$this->shop_id;
        
        
        if($is_recommended=='1'){
             
            $type="is_recommended";
        }

        if($_REQUEST[is_new]=='1'){
             
            $type="is_new";
        }


        $data=$this->Goods_logic->goods_lists($shop_id,$cate_id,$num,$type,$order,$field,$keyword,$status,$search); 
        // dump($data);exit;
         
        $tree=$this->Cate_logic->get_cate_tree($shop_id); 
        $cate_str=$this->Cate_logic->get_select($tree[lists][content],0,$cate_id);
        $this->assign('cate_str',$cate_str);


        // var_dump($data);exit;
        if ($_REQUEST[ajax]==1){
            $data[lists][page]=str_replace('href="','href="javascript:goods_page(\'',$data[lists][page]);
            $data[lists][page]=str_replace('">','\')">',$data[lists][page]);
            $data[lists][page]=str_replace('current\')','current',$data[lists][page]);
            $data[page]=$data[lists][page];
            //var_dump($data[lists][page]);
            $this->assign('data',$data);
 
            $res[status]=1;
            $res[data]=$this->fetch("ShopGoods/goods_lists_tpl");
            echo json_encode($res);
            exit;
            
        }
        if ($_REQUEST[josn]==1){
            echo json_encode($data);
        }else {
            $this->assign('keyword',$keyword);
            $this->assign('cate_id',$cate_id);

            $this->assign('data',$data);
            $this->assign('user_id',$this->user_id);

            return $this->fetch("ShopGoods/goods_lists");
        }               
    }



    //便捷改数据
    public function change_someting(){

        $goods_id=$_REQUEST[goods_id];      
        $string=$_REQUEST[string];  
        $string_val=$_REQUEST[string_val];
        $goods=Db::name('shop_goods');

        $check=$goods->where("goods_id='$goods_id'")->setField($string,$string_val);    
        if (!$check){
            $data[status]=10002;
        }else {
            $data[status]=10001; 
        }
        if ($_REQUEST[json]==1){
            return $this->showmsg('设置成功');
        }else {
            echo json_encode($data);    
        }
            
    }

    public function goods_delete(){
        $goods_id=$_REQUEST['goods_id'];
        Db::name('shop_goods')->where('goods_id',$goods_id)->delete();
        return $this->showmsg("操作成功");
    }




    //菜单选择框 分类
    public function get_cate_select(){

        $parent_id=$_REQUEST[parent_id];
        $this_id=$_REQUEST[this_id];
        $select_id=$_REQUEST[select_id];
      
        $data=$this->Cate_logic->get_cate_lists(1,9999,$order="",$parent_id); 
        
        $res[status]=10001;
        if(count($data[lists][content])==0){
            $res[status]=10000;
        }
        if($_REQUEST[is_nodiv]!=1){
            $res[data]='<div class="col-lg-3 col-md-3"  id="div_cate_parent_'.$this_id.'"><select name="post_cate[]" data-id="'.$this_id.'"  id="cate_parent_'.$this_id.'" class="form-control"  onChange="javascript:change_cate(\''.$this_id.'\',\''.($this_id+1).'\')" >';
            $res[data].="<option >请选择</option>";
        
        }
         
        for ($i=0;$i<count($data[lists][content]);$i++){
            if( ( $this->shop_cate_id==1 && $data[lists][content][$i][cate_id]!=2 ) || ( $this->shop_cate_id==2 && $data[lists][content][$i][cate_id]!=1 ) || $this->user_id==1 ){ //商品和服务分类分开显示
                $select="";
                if($select_id==$data[lists][content][$i][cate_id]){
                    $select="selected";
                }
                $res[data]=$res[data]."<option ".$select." value='".$data[lists][content][$i][cate_id]."' >".$data[lists][content][$i][cat_name]."</option>";
            }
        } 
        if($_REQUEST[is_nodiv]!=1){
            $res[data]=$res[data]."</select></div>";
        }
 
        echo json_encode($res);
    }


    public function get_attr_cate(){
        $cate_id=$_REQUEST[cate_id];

        if(!is_numeric($cate_id)){
            return;
        }

         
        $lists=$this->Cate_logic->get_parent_arr($cate_id);
         

        $id=M("shop_attribute_cate")->where("cate_id='".$cate_id."'")->getField("attribute_cate_id",true);

        if(!$id){
            $id=M("shop_attribute_cate")->where("cate_id='".$lists[parent_id]."'")->getField("attribute_cate_id");
        }
        if(!$id){
            $id=M("shop_attribute_cate")->where("cate_id='".$lists["parent"][parent_id]."'")->getField("attribute_cate_id");
        }
        // $res[id]=$id;
        $res[id]=implode(",",$id);
        echo json_encode($res);
    }


}