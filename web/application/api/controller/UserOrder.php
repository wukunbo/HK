<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
use think\Session;

class UserOrder extends Base{

    public function __construct(){
        parent::__construct();
        $this->logic= new \app\shop\logic\OrderData();
        $this->order_logic= new \app\shop\logic\Order();
    }


    /**
     * 订单列表
     */
    public function lists(){
        $app['app']=$_REQUEST['app'] ? $_REQUEST['app'] : 'shop';

        if($_REQUEST['pay_status']){
            $search['pay_status']=$_REQUEST['pay_status'];
        }

        if($_REQUEST['shipping_status']){
            $search['shipping_status']=$_REQUEST['shipping_status'];
        }

        if($_REQUEST['comment_status']){
            $search['comment_status']=$_REQUEST['comment_status'];
        }
    

        // $search[back_status]=$_REQUEST[back_status];
        if($_REQUEST['back_status']){
            $search['back_order']=1;//退货订单
        }
         
        $search['num']=$_REQUEST['page_num'] ? $_REQUEST['page_num'] : 999;
        
        // dump($search);exit;

        $ret=$this->logic->order_lists($this->user_id,$search,$app);
        // dump($ret);exit;
       
        for($i=0;$i<count($ret['content']);$i++){
            $ret['content'][$i]=$this->order_logic->order_detail($ret['content'][$i]['order_id'],$this->user_id);
            $ret['content'][$i]['goods_num']=count($ret['content'][$i]['goods_lists']);
        }
        if($ret['content']===null){
            $data['status']=10003;
            $data['msg']="无数据";
        }elseif($ret['content']===false){
            $data['status']=10002;
            $data['msg']="数据查询错误";
        }else{
            $data['status']=10001;
            $data['msg']="成功";
        }

      
        $data['lists']=$ret['content'];
        $data['total']=$ret['total'];
        $this->return_data($data);
    }


    /**
     * 订单详情
     */
    public function detail(){
        $order_id=$_REQUEST['order_id'];
        $ret=$this->order_logic->order_detail($order_id,$this->user_id);
        // dump($ret);exit;

        if(isset($ret['order_id'])){
        
           
            $data['status']=10001;
            $data['msg']="成功";

            $data['detail']=$ret;
            
            $data['detail']['goods_num']=count($data['detail']['goods_lists']);
        }else{
            $data['status']=10003;
            $data['msg']="无数据";
        }
        

        $this->return_data($data);
    }


    /**
     * 确认收货
     */
    public function shouhuo(){
        $shipping_status=2;
        $order_id=$_REQUEST['order_id'];
        $data=$this->order_logic->change_shipping_order($order_id,$this->user_id,$shipping_status);     
        echo json_encode($data);
    }


}