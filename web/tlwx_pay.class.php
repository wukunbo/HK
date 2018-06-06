<?php
header("Content-type: text/html; charset=utf-8");
session_start();
error_reporting(E_ALL ^ E_NOTICE);
require 'config.php';
		//获取记录
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		/*$xml="<xml>
			  <appid><![CDATA[wx2421b1c4370ec43b]]></appid>
			  <attach><![CDATA[293131be3fe9d60523ebbc6dd0c2e5c3]]></attach>
			  <bank_type><![CDATA[CFT]]></bank_type>
			  <fee_type><![CDATA[CNY]]></fee_type>
			  <is_subscribe><![CDATA[Y]]></is_subscribe>
			  <mch_id><![CDATA[10000100]]></mch_id>
			  <nonce_str><![CDATA[5d2b6c2a8db53831f7eda20af46e531c]]></nonce_str>
			  <openid><![CDATA[oUpF8uMEb4qRXf22hE3X68TekukE]]></openid>
			  <out_trade_no><![CDATA[2016031202542301-56e3145f82ba0]]></out_trade_no>
			  <result_code><![CDATA[SUCCESS]]></result_code>
			  <return_code><![CDATA[SUCCESS]]></return_code>
			  <sign><![CDATA[B552ED6B279343CB493C5DD0D78AB241]]></sign>
			  <sub_mch_id><![CDATA[10000100]]></sub_mch_id>
			  <time_end><![CDATA[20140903131540]]></time_end>
			  <total_fee>1</total_fee>
			  <trade_type><![CDATA[JSAPI]]></trade_type>
			  <transaction_id><![CDATA[1004400740201409030005092168]]></transaction_id>
			</xml>";
			*/
		$s=date("Y-M-D  h:i:s").":\n".$xml."\n";
		$postObj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
		 
		file_put_contents("temp/order/".$postObj->out_trade_no."-xml.txt",$s);
		//file_put_contents("temp/order/xml.txt",$s);
  
 
				//此处应该更新一下订单状态，商户自行增删操作
				$s=date("Y-M-D  h:i:s").":\zfcg\n";
				file_put_contents("log_error.txt",$s);
				
				//$log_->log_result($log_name,"【支付成功】:\n".$xml."\n");
				$tmp=json_encode($data);
				//echo "http://127.0.0.0/xingguanyuan/web/shop.php?c=Order&a=pay_off&var_login=1&attach=".$postObj->attach."&out_trade_no=".$postObj->out_trade_no;
				$notify_url="http://www.taiwaskii.com/web/api.php/ShopOrder/pay_off?&var_login=1&attach=".$postObj->attach."&out_trade_no=".$postObj->out_trade_no."";
				$result=file_get_contents($notify_url);
				file_put_contents('notify_url.txt',$notify_url);
															      	  
				//http://www.meijieshangmeng.com/web/shop.php?c=Order&a=pay_off&var_login=1&attach=293131be3fe9d60523ebbc6dd0c2e5c3&out_trade_no=20160331104501040-56fc8f2dd67ed
				$s=date("Y-m-d  h:i:s").$postObj->out_trade_no.":\zfcg\n";
				file_put_contents("temp/order/log.txt",$s);
				 
				if($result==1){
					file_put_contents('pay_success.txt', "".$notify_url);
					
					echo "success";
					//header($data[turn_url]);
				}else{
					file_put_contents('temp/order_error/'.$postObj->out_trade_no.'.txt', $s."---".$notify_url);
					
					echo "false";
				}	
 
 
 
	  
 
?>