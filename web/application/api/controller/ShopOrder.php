<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
use think\Session;

class ShopOrder extends Base{

    public function __construct(){
        parent::__construct();
        $this->logic= new \app\shop\logic\Order();
    }


    //添加订单
    public function add(){
        $this->is_login();
        $post=$_REQUEST[post];
        $post[app]="shop";

        if(is_array($_REQUEST[cart_id_lists])){
            $post[cart_id_lists]=implode(",",$_REQUEST[cart_id_lists]);
        }else{
            $post[cart_id_lists]=$_REQUEST[cart_id_lists];
        }

        // dump($post);exit;
        $data=$this->logic->add_order($this->user_id,$post);
        $this->return_data($data);
    }


    public function pay(){

        if($_REQUEST['log_id']=="" && $_REQUEST['order_id']==""){
            $res['msg']="付款记录ID，或订单ID不能为空";
            $res['status']=10002;
            echo json_encode($res);
            exit;
        }
        $this->is_login();
        $log_id=$_REQUEST['log_id'];
        if($_REQUEST['log_id']=="" && $_REQUEST['order_id']){
            $order_data=Db::name("order")->where("order_id={$_REQUEST[order_id]}")->find();
            $log_id=$this->logic->add_order_log($_REQUEST[order_id],$this->user_id,$pay_status=0,$point_fee=0,$order_data[real_fee],$form,$admin,$order_data);
            //$log_id=$this->add_order_log($order_id,$user_id,$pay_status=0,$order_data[point_fee],$order_data[real_fee]);
        }

        $openid=Db::name("user")->where("id={$this->user_id}")->value("openid");
        if($openid && !$_SESSION[wx][1]["openid"]){
            $_SESSION[wx][1]["openid"]=$openid;
            Session::set('wx_openid',$openid);
        }

        $token=$_REQUEST[token];
        if($token){
            $token=Db::name("user")->where("id={$this->user_id}")->value("token");
        }


        $url=config('DOMAIN')."/js_api_call.php?log_id=".$log_id."&trade_type=APP&token={$token}";

       
        $res[status]=10001; 
        $res[url]=$url;
 
        echo json_encode($res); 
    }    
    
    //获取log_id
    public function get_log_id(){
        
        if($_REQUEST[log_id]=="" && $_REQUEST[order_id]){
            $OrderLogLogic= new \Shop\Logic\OrderLogLogic();
            $order_data=M("order")->where("order_id={$_REQUEST[order_id]}")->find();
            $log_id=$OrderLogLogic->add_order_log($_REQUEST[order_id],$_REQUEST[user_id],$pay_status=0,$point_fee=0,$order_data[real_fee],$form,$admin,$order_data);
            //$log_id=$this->add_order_log($order_id,$user_id,$pay_status=0,$order_data[point_fee],$order_data[real_fee]);
        }
        $res[status]=10001;
        $res[log_id]=$log_id;
        echo json_encode($res); 
    }

    //完成付款
    public function pay_off(){

        $out_trade_no=$_REQUEST['out_trade_no'];
        $attach=$_REQUEST['attach'];
         
        $data=$this->logic->pay_off($attach,$out_trade_no);
         
        if($data['status']==10001){
            echo 1;
        }else{
            echo $data['status'];
        }
    }


}
