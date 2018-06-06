<?php

/**
 *  微信支付接口
 . tlwx_wxpay.php?=Pay&a=notify
*/
define('IN_ECS', true);
 
require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_order.php');
require(ROOT_PATH . 'includes/lib_payment.php');
error_reporting(E_ALL);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//写入记录
//写入记录
		 
		
		include_once("wxpay/demo/log_.php");
		include_once("wxpay/WxPayPubHelper/WxPayPubHelper.php");
		$log_ = new Log_();
		$log_name="wxpay/demo/notify_url.log";//log文件路径
		 	
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		 
		$notify = new Notify_pub();
		$notify->saveData($xml);
		$data=$notify->data;
		$s=json_encode($data);
		
		$str=date("Y-m-d H:i:s")."-";
		$open=fopen("log.txt","a" );
		$s=$str."_".$GLOBALS['a']." out_trade_no : ".$data["out_trade_no"]."\n";
		fwrite($open,$s);
		fclose($open);	
 
		//file_put_contents("text2.txt",$s);
	 
 
		//var_dump($data);
		
		//验证签名，并回应微信。
		//对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
		//微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
		//尽可能提高通知的成功率，但微信不保证通知最终能成功。
		if($notify->checkSign() == FALSE){
			$notify->setReturnParameter("return_code","FAIL");//返回状态码
			$notify->setReturnParameter("return_msg","签名失败");//返回信息
		}else{
			$notify->setReturnParameter("return_code","SUCCESS");//设置返回码
		}
		$returnXml = $notify->returnXml();
		//echo $returnXml;
		$log_->log_result($log_name,"【回应微信】:\n".$returnXml."\n");	
 
		if($notify->checkSign() == TRUE)
		{
			
			if ($notify->data["return_code"] == "FAIL") {
				//此处应该更新一下订单状态，商户自行增删操作
				$log_->log_result($log_name,"【通信出错】:\n".$xml."\n");
			}
			elseif($notify->data["result_code"] == "FAIL"){
				//此处应该更新一下订单状态，商户自行增删操作
				$log_->log_result($log_name,"【业务出错】:\n".$xml."\n");
			}
			else{
					$_REQUEST[out_trade_no]=$data["out_trade_no"];
			
					$str=date("Y-m-d H:i:s")."-";
					$open=fopen("log.txt","a" );
					$s=$str."-notify out_trade_no:".$_REQUEST[out_trade_no]." \n";
					fwrite($open,$s);
					fclose($open);	
					$data=$notify->data;
					$s=json_encode($data);
		
	 	 
			//引用
			include_once(ROOT_PATH."includes/lib_payment.php");
			//获取log_id;
			$sql = "SELECT pay_log.log_id  " .
					"FROM " . $GLOBALS['ecs']->table('pay_log') . " AS pay_log " .
					"LEFT JOIN " . $GLOBALS['ecs']->table('order_info') . " AS order_info ON order_info.order_id = pay_log.order_id " .
						 
					"WHERE order_info.order_sn = '" . $_REQUEST[out_trade_no]. "'";
			$log_id = $GLOBALS['db']->getOne($sql);		 	
			$order_log_id=$log_id;
			//写入微信订单表
			$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
			if($postStr){
				$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			}
			$data[out_trade_no]=$_REQUEST[out_trade_no];
			$data[notify_id]=$_REQUEST[notify_id];
			$data[transaction_id]=$_REQUEST[transaction_id];	
			$data[time_end]=$_REQUEST[time_end];	
			$data[trade_state]=$_REQUEST[trade_state];		
			$data[openid]=$postObj->OpenId;	
			$sql = "SELECT id  " .
					"FROM " . $GLOBALS['ecs']->table('tlwx_notify') . "   " .
					"WHERE transaction_id = '" . $_REQUEST[transaction_id]. "'";
			$id = $GLOBALS['db']->getOne($sql);		 	
			if(!$id){
				$this->insert($data,"tlwx_notify"); 	
			}
			 	
			 
		 
	 		order_paid($order_log_id, 2);
		}
	}


$m=$_REQUEST[m];
$a=$_REQUEST[a];
$GLOBALS['m']=$m;
$GLOBALS['a']=$a;
/*
require_once('tlwx_wxpay/tlwx.class.php');  
require_once('tlwx_wxpay/'.$m.'Action.class.php'); 
 
 
$moduleAction=$m."Action";
$module= new $moduleAction(); 
$module->$a();
 */