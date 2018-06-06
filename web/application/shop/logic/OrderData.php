<?php 
namespace app\shop\logic;
use think\Model;
use think\Db;

class OrderData extends Model{

    public function __construct(){
        $this->db= new \app\userweb\model\PublicModel();
    }


    //订单列表
    /*
     * 订单列表
     public function order_lists($user_id,$pay_status,$shipping_status,$key,$search,$where='',$app){
    shipping_status  0 未发货 1 已发货（未收货）  5 部分发货  2 已收货  
     */
    public function order_lists($user_id='',$search=array(),$app_array=array()){
        $PRE="tl_";
        $tb_order=$PRE."order";
        $tb_user=$PRE."user";
        $array[table]='order';    
        //var_dump($search);
        $status=$search[status];
        //综合排序筛选
        if($status){
            switch ($status){
            
                case 1: //未付款
                    $search[pay_status]=0;  
                break;  
                case 2://已付款
                    $search[pay_status]=1;      
                break;  
                case 3://未发货
                    $search[shipping_status]=0;             
                break;  
                case 4://已发货
                    $search[shipping_status]=1;             
                break;  
                case 5://已收货
                    $search[shipping_status]=2;             
                break;  
                case 6://
                    $search[shipping_status]=3;             
                break;  
                case 7:
                    $search[shipping_status]=4; 
                case 8:// 已付款 未发货
                    $search[pay_status]=1;  
                    $search[shipping_status]=0; 
                    $search[back_status]=0;
                    $search[order_status]=1;    
                break;  
                case 9://评价完成，订单完成
                    $search[order_status]=3;    
                    $search[comment_status]=1;  
                 
                break;      
                case 10://已收货，未评价
                    $search[shipping_status]=2; 
                    $search[comment_status]=0;
                                
                break;  
            }
        }    
         
        $array[where].=" 1 ";       
        if ($user_id){      
            $array[where].=" AND user_id='$user_id'";   
        }

        //正常的商品的时间
        if($search[back_order]==""){ //正常的商品
            if($search[$date_1]){
                $array[where].=" AND back_time>=".strtotime($search[$date_1])."";
            }
            if($search[$date_2]){
                $array[where].=" AND back_time<=".strtotime($search[$date_2])."";
            }
        }
        /*
        back_end 0 无争议 1 有争议 2 争议结束   平台介入
        back_status  0,无退货 1 售后处理中 2已同意退货3拒绝退货4买家已发货(退货)5退货完成 6 退货结束
        back_comfirm  0 未完成 1退货完成
        back_type 1 仅退款 2退货退款
        */
        if($search[back_order]==1){ //退款的商品
            $day_where="";
            if($search[$date_1]){
                $day_where=" AND back_time>=".strtotime($search[$date_1])."";
            }
            if($search[$date_2]){
                $day_where.=" AND back_time<=".strtotime($search[$date_2])."";
            }
            if($search[back_status]==-1){ // 等待商家处理的
                $where=" AND ( ( back_status !=5  AND  back_end=1) || ( back_comfirm!=1 AND back_status >0 AND back_end!=1) )";
            }
            if($search[back_status]==2){
                $where=" AND (shipping_status=1 AND back_status!=0  AND back_type=1)";
            }
            if($search[back_status]==3){ //
                $where=" AND (shipping_status=1 AND back_status!=0 AND back_type=2)";
            }
 
             
            if($search[back_end]==1){//有争议的订单，需要商户处理的。
                $where=" AND order_status!=3 AND ( back_end=1 )";
            }
            $back_status_where="  AND order_status!=3 AND back_status!=0   ";
            $array[where].=$back_status_where;
            $array[where].=$day_where;
            $array[where].=$where;
            
        }
        //var_dump($search[back_order]);
        if($search[back_order]!=1 && isset($search[back_order])){ //排除退货的商品
            $array[where].=" AND ( back_status=0  ||  back_status=3 ) ";
        }
       
       
        
        //不现实用户删除的       
 
        if ($search[user_del]!=""){
            $array[where].=" and ".$tb_order.".user_del = ".$search[user_del]." ";
        }
        
        if ($search[is_user_del]=="1"){
            $array[where].=" and ".$tb_order.".user_del !=1 ";
        }

        if ($search[shipping_status]!=0){           
            $search[pay_status]=1;          
        }
        
        if (isset($pay_status)){
             
            $array[where].=" and ".$tb_order.".pay_status = '$pay_status'";         
        }   
        if (isset($search[pay_status])){
             
            $array[where].=" and ".$tb_order.".pay_status = '$search[pay_status]'";         
        }

        if (isset($search[back_status])){
             
            $array[where].=" and ".$tb_order.".back_status = '$search[back_status]'";           
        }


        if (isset($shipping_status) ){          
            $array[where].=" and ".$tb_order.".shipping_status = '$shipping_status'";   
            //echo 1;   
        }
        if (isset($search[shipping_status])){           
            $array[where].=" and ".$tb_order.".shipping_status = '$search[shipping_status]'";   
        }

        if (isset($search[app])){           
            $array[where].=" and app = '".$search[app]."'"; 
        }
        if (isset($search[comment_status])){            
            $array[where].=" and shipping_status =2 AND back_status=0 AND ".$tb_order.".comment_status = ".$search[comment_status]." "; 
        }
        
        if (isset($search[addtime_1])){
             
            $array[where].=" and ".$tb_order.".addtime >='".$search[addtime_1]."' ";    
 
        }
        if (isset($search[addtime_2])){
             
            $array[where].=" and ".$tb_order.".addtime <='".$search[addtime_2]."' ";    
 
        }

        if (isset($search[date_1]) && $search[date_1]){
             
            $array[where].=" and ".$tb_order.".addtime >='".strtotime($search[date_1])."' ";    
 
        }
        if (isset($search[date_2]) && $search[date_2]){
             
            $array[where].=" and ".$tb_order.".addtime <='".strtotime($search[date_2])."' ";    
 
        }


        if ($search[keyword]!=null){
            $key=trim($search[keyword]);
            $array[where]=" ( ".$tb_order.".order_sn like '%$key%'  or ".$tb_order.".address_name like '%$key%' or ".$tb_order.".address_phone like '%$key%' or ".$tb_order.".address like '%$key%' or ".$tb_order.".weixin_order_sn like '%$key%' ) ";
            
        }
        
        if($app['business_id']){
            $array[where].= "   and  (  ".$tb_order.".business_id = '".$app['business_id']."' )" ;
        }

        if($app['app']){
            if(is_array($app[app])){
                $str="";
                for($i=0;$i<count($app[app]);$i++){
                    $str.="'".$app[app][$i]."',";
                }
                $str=substr($str,0,-1);
                $array[where].= "   and  ( ".$tb_order.".app in (".$str.")  )" ;
            }else{
                $array[where].= "   and  ( ".$tb_order.".app ='".$app['app']."'   )" ;
            }
        }

        $array[where].=$search[where];
        $array[num]=$search[num]?$search[num]:20;   
        $array[order]=" ".$tb_order.".order_id DESC";       
        $array[field]='*';      
         
        $result=$this->db->Page($array);

        // dump($result);exit;
        foreach ($result['content'] as $key => &$value) {
            //订单状态
            $status_text=$this->get_order_status_text($value['order_id']);
            $value['pay_status_text']=$status_text['pay_status_text'];
            $value['shipping_status_text']=$status_text['shipping_status_text'];
            $value['back_status_text']=$status_text['back_status_text'];
            $value['comfirm_status_text']=$status_text['comfirm_status_text'];
            $value['order_status_text']=$status_text['order_status_text'];
        }

        //查询微信订单结果
        
        $tmp=$result[content];
        
        return $result;     
    }



    public function get_order_status_text($order_id){ 

        $detail=Db::name('order')->where("order_id=".$order_id."")->find();
         
        $app=$detail['app'];          
        $pay_status=$detail['pay_status'];            
        $shipping_stauts=$detail['shipping_status'];      
        $back_status=$detail['back_status'];      
        $comfirm_stauts=$detail['comfirm_stauts'];    
        $order_status=$detail['order_status'];
     
        $back_end=$detail['back_end'];
         
            
        if($pay_status==0){             
            $result['pay_status_text']='等待付款';            
                
        }else { 
            $result['pay_status_text']='已付款';             
        }
                 
        if ($pay_status==1 ){   
                
            if ($shipping_stauts==0){

                $result['shipping_status_text']=' 等待发货';              
            }elseif ($shipping_stauts==1){
                $result['shipping_status_text']='已发货';

            }elseif ($shipping_stauts==2){              
                $result['shipping_status_text']='已收货';

            }elseif ($shipping_stauts==3){  
            
            }elseif ($shipping_stauts==5){  
                $result['shipping_status_text']='部分发货';       
        }   
        }

        if($back_status!=0 ){

        }
        if ($back_status==1){               
                $result['back_status_text']='售后处理中';              
        }elseif  ($back_status==2 && $shipping_stauts==1){          
                $result['back_status_text']='已同意退货退款，等待买家发货';                 
        }elseif  ($back_status==2 &&  $shipping_stauts==0){         
                $result['back_status_text']='已同意退货退款，等待最终确认';                 
        }elseif  ($back_status==3){
                $result['back_status_text']='拒绝退货退款';                 
        }elseif  ($back_status==4){
                $result['back_status_text']='买家已发货(退货)';                  
        }elseif  ($back_status==5){
                $result['back_status_text']='退货完成';                   
        }
 
       
                 
        //0 无争议 1 有争议 2争议结束 
        if  ($back_end==1){
            $result['back_status_text'].=' 平台介入售后处理，处理中。';                    
        }
        if($back_end==2){
            $result['back_status_text'].=' 平台介入，处理完毕。';                   
        }

        if ($comfirm_stauts==1 || $comfirm_stauts==2){  
            $result['comfirm_stauts_text']='已收货'; 
        }
        
        if ($order_status==3){              
            $result['order_status_text']='交易成功';              
        }
          
        if ($order_status==-1){                
            $result['order_status_text']='等待确认';      
        }

        if ($order_status==2){              
                $result['order_status_text']='交易关闭';  
        }

        if ($order_stauts==5){             
                $result['order_status_text']='交易关闭，订单已被拒绝';   
                $result['pay_status_text']='';            
        }
        return $result;
        
    }


}