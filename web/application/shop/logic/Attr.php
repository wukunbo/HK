<?php 
namespace app\shop\logic;
use think\Model;
use think\Db;

class Attr extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
    }


    //获取选项
    public function get_op_detail($option_id,$shop_id=""){             
        $attribute_option=Db::name("shop_attribute_option");       
        $detail=$attribute_option->where("attr_op_id='$option_id'")->find();        
        return $detail;     
    }


    //属性分类
    public function get_attr_cate_lists($shop_id){      
        $attribute_cate=Db::name('shop_attribute_cate');       
        if($shop_id){
            $where='shop_id='.$shop_id.'';
        }
        $lists=$attribute_cate->where($where)->order("attribute_cate_id DESC")->select();   
         
        return $lists;      
    }


    //根据属性值获取商品信息
    public function get_goods_attr_detail($text,$goods_id,$user_id=""){

        $tmp=$text;
        $detail=Db::name("shop_goods_attr")->where("goods_id='$goods_id' AND text='".$tmp."'")->find();
       
        //重新定义价格
        if($detail){
            $GoodsLogic= new \app\shop\logic\Goods();
            $tmp=$GoodsLogic->get_goods_price($goods_id,$user_id,$attr=$tmp,$num=1,$is_total=1);
            // dump($tmp);exit;
            $detail[is_point]=$tmp[is_point];
            $detail[price]=$tmp[price];
            $detail[goods_price]=$tmp[goods_price];
            $detail[point_price]=$tmp[point_price];
        }
         
        return $detail;
    }


    public function get_goods_attr_lists($goods_id){    
        $db_goods_attr=Db::name('shop_goods_attr');    
        $db_shop_attribute=Db::name('shop_attribute');
        $tmp=$db_goods_attr->where("goods_id='".$goods_id."'")->order("id asc")->select();
        
        $str=$tmp[0][title];
        $arr_title=explode("_",$str);
        $k=0;
        //var_dump($tmp);
        for($i=0;$i<count($tmp);$i++){
             $str=$tmp[$i][text];
             $arr=explode("_",$str);
             for($j=0;$j<count($arr);$j++){
                $lists[$j][title]=$arr_title[$j];
                if(!in_array($arr[$j],$all_lists[$j][text])){
                    
                    $all_lists[$j][text][count($all_lists[$j][text])]=$arr[$j];
                    
                    $all_lists[$j][count($lists[$j])]=$lists[$j][title];
                    $t=$arr[$j];
                    $c=Db::name("shop_goods_attr")->where(" goods_id='".$goods_id."' AND text LIKE '%".$t."%'")->value("sum(stock) as t");
                    // echo M()->getLastsql();
                     
                        $lists[$j][text][$k][title]=$arr[$j];
                        $lists[$j][text][$k][stock]=$c;
                        $k++;
                     
                }
             }
              
        }
    
        return $lists;
        
        
    }


    //获取属性价格
    public function get_attr_price($text,$goods_id){

        $tmp=$this->K_Tosort($text);
        $price=Db::name("shop_goods_attr")->where("goods_id='$goods_id' AND (text='".$tmp."' OR text='".$text."')")->getField("price");
        return $price;
    }

    //排序处理 字符串 转字符串
    public function Tosort($tmp){
        $tmp=explode("_",$tmp);
        $tmp=$this->TosortArray($tmp);
        $tmp=implode("_",$tmp);
        return $tmp;
    }
    public function TosortArray($tmp){
        //sort($tmp);
        return $tmp;
    }
    //排序处理 字符串 转字符串
    public function K_Tosort($tmp){
        $tmp=explode("_",$tmp);
        $tmp=$this->K_TosortArray($tmp);
        $tmp=implode("_",$tmp);
        return $tmp;
    }
    public function K_TosortArray($tmp){
        sort($tmp);
        return $tmp;
    }


}