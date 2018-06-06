<?php
class PayAction extends tlwx{
	 public function __constuct(){
	 
		//写入记录
		$str=date("Y-m-d H:i:s")."-";
		$open=fopen("log.txt","a" );
		$s=$GLOBALS['m']."_".$GLOBALS['a'].$_REQUEST[out_trade_no]." \n";
		fwrite($open,$s);
		fclose($open);	
	 }
	 public function notify(){ 
	 	
	    //写入记录
		$str=date("Y-m-d H:i:s")."-";
		$open=fopen("log.txt","a" );
		$s=$GLOBALS['m']."_".$GLOBALS['a']."-notify out_trade_no:".$_REQUEST[out_trade_no]." \n";
		fwrite($open,$s);
		fclose($open);	
		
	 	if($_REQUEST[out_trade_no]){
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
	public function get_wxpay(){ 

		include_once(ROOT_PATH."/mobile/tlwx/wxpay/WxPayHelper.php");
  
		 
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){
			  $cip = $_SERVER["HTTP_CLIENT_IP"];
			}
			elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
			  $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			}
			elseif(!empty($_SERVER["REMOTE_ADDR"])){
			  $cip = $_SERVER["REMOTE_ADDR"];
			}
			else{
			  $cip = "278.0.0.2";
		}
			
	 
 

 		$order[order_sn]=$_REQUEST["order_sn"];
		$order[order_amount]=$_REQUEST["order_amount"];
		$order[log_id]=$_REQUEST["log_id"];
	   	 
		$commonUtil = new CommonUtil();
		$wxPayHelper = new WxPayHelper();
		
	
		$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('tlwx_config') . " WHERE id=1";
		$config = $GLOBALS['db']->getRow($sql);
	 
		//print_r($config);
		define(APPID , $config[appid]);  //appid
	  //define(APPKEY ,"Ckqr8SBzhtiNgxGdtACgD3kFsD02eDTA6je4Hju8ubzSuszpKT2mOv4gBeYdVtGWHKPMF4CeFcgeqhzgP3RDT7bzZZqrlZUSYaBNEvZipOqv9vsOvvL1F61hVSjjloVl"); //paysign key
		define(APPKEY ,"Jh7ScYnwp1kKDFTnqgbpVviUwfhvmF6GWvWfQk3TfBlQj6p0gnLv6VC2eB9yQ2qaX9YRCK9i6IhN1Kfy6sYcy7ar9jpCE5rSiqHxpIPU5DLBlF0mBrDDwehG9m53yB4T");  
		define(SIGNTYPE, "SHA1"); //method
		define(PARTNERKEY,$config[partner_key]);//通加密串
		define(APPSERCERT, $config[appsecret]);
	
	  
	 
	 /*
		$order['order_amount']=1;
		$order['log_id']=121;
		*/
		//echo "<br><br><br><br><br><br><br>"; 
	 //	echo print_r($order);
		//echo $order['log_id'];
		   
		$wxPayHelper->setParameter("bank_type", "WX");
		$wxPayHelper->setParameter("body", "test");
		$wxPayHelper->setParameter("partner", $config[partner_id]);
		$wxPayHelper->setParameter("out_trade_no", $order['order_sn']);
		$wxPayHelper->setParameter("total_fee", $order['order_amount']*100);
		$wxPayHelper->setParameter("fee_type", "1");
		$wxPayHelper->setParameter("notify_url", $config[notify_url]);
		$wxPayHelper->setParameter("spbill_create_ip",$cip);
		$wxPayHelper->setParameter("input_charset", "UTF-8");	
		
		$wxPayHelper->create_app_package($order['log_id']);
		 
		
		$wxpay=$wxPayHelper->create_biz_package(); 
		echo $wxpay;
		exit;
		
 
	 }	 
 
	/*
	<OpenId><![CDATA[oDF3iY9P32sK_5GgYiRkjsCo45bk]]></OpenId>
	<AppId><![CDATA[w
	8b4f85f3a794e77]]></AppId> 
	<TimeStamp>1393400471</TimeStamp> 
	<MsgType><![CDATA[request]]></MsgType> 
	<FeedBackId>7197417460812502768</FeedBackId> 
	<TransId><![CDATA[1900000109201402143240185685]]></TransId> 
	<Reason><![CDATA[质量问题]]></Reason> 
	<Solution><![CDATA[换货]]></Solution> 
	<ExtInfo><![CDATA[备注  12435321321]]></ExtInfo> 
	<AppSignature> 
	<![CDATA[d60293982cc7c97a5a9d3383af761db763c07c86]]></AppSignature> 
	<SignMethod> 
	<![CDATA[sha1]]> 
	</SignMethod> 
	<PicInfo> 
	<item><PicUrl><![CDATA[http://mmbiz.qpic.cn/mmbiz/49ogibiahRNtOk37iaztwmdgFbyFS9FU
	rqfodiaUAmxr4hOP34C6R4nGgebMalKuY3H35riaZ5vtzJh25tp7vBUwWxw/0]]></PicUrl> 
	</item> 
	<item> 
	<PicUrl> 
	<![CDATA[http://mmbiz.qpic.cn/mmbiz/49ogibiahRNtOk37iaztwmdgFbyFS9FUrqfn3y72eHKRS
	AwVz1PyIcUSjBrDzXAibTiaAdrTGb4eBFbib9ibFaSeic3OIg/0]]></PicUrl> 
	</item> 
	<item> 
	<PicUrl> 
	<![CDATA[]]></PicUrl></item><item><PicUrl><![CDATA[]]></PicUrl></item><item><PicUrl
	><![CDATA[]]></PicUrl></item></PicInfo> 
	
	(2) 用户确认处理完毕投诉的xml 
		<xml> 
		 <OpenId><![CDATA[111222]]></OpenId> 
		 <AppId><![CDATA[wwwwb4f85f3a797777]]></AppId> 
		 <TimeStamp> 1369743511</TimeStamp> 
		 <MsgType><![CDATA[confirm/reject]]></MsgType> 
		 <FeedBackId><![CDATA[5883726847655944563]]></FeedBackId> 
		 <Reason><![CDATA[商品质量有问题]]></Reason> 
		 <AppSignature><![CDATA[bafe07f060f22dcda0bfdb4b5ff756f973aecffa]]> 
		 </AppSignature> 
		 <SignMethod><![CDATA[sha1]]></ SignMethod > 
	</xml> 
	*/
	 public function feedback(){ 
	 	 
		 
	 	$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		$postStr="
<xml>		
	<OpenId><![CDATA[oDF3iY9P32sK_5GgYiRkjsCo45bk]]></OpenId>
	<AppId><![CDATA[w8b4f85f3a794e77]]></AppId> 
	<TimeStamp>1393400471</TimeStamp> 
	<MsgType><![CDATA[request]]></MsgType> 
	<FeedBackId>7197417460812502768</FeedBackId> 
	<TransId><![CDATA[1900000109201402143240185685]]></TransId> 
	<Reason><![CDATA[质量问题]]></Reason> 
	<Solution><![CDATA[换货]]></Solution> 
	<ExtInfo><![CDATA[备注  12435321321]]></ExtInfo> 
	<AppSignature> 
	<![CDATA[d60293982cc7c97a5a9d3383af761db763c07c86]]></AppSignature> 
	<SignMethod> 
	<![CDATA[sha1]]> 
	</SignMethod> 
	<PicInfo> 
		<item><PicUrl><![CDATA[http://mmbiz.qpic.cn/mmbiz/49ogibiahRNtOk37iaztwmdgFbyFS9FU
	rqfodiaUAmxr4hOP34C6R4nGgebMalKuY3H35riaZ5vtzJh25tp7vBUwWxw/0]]></PicUrl> 
		</item> 
		<item> 
			<PicUrl><![CDATA[http://mmbiz.qpic.cn/mmbiz/49ogibiahRNtOk37iaztwmdgFbyFS9FUrqfn3y72eHKRS
	AwVz1PyIcUSjBrDzXAibTiaAdrTGb4eBFbib9ibFaSeic3OIg/0]]></PicUrl> 
		</item> 
	</PicInfo>
</xml>			";
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		//echo json_encode($postStr);
		 
		 
		$data[openId] = $postObj->OpenId;   
		$data[timeStamp] = $postObj->TimeStamp;   
		$data[msgtype] = $postObj->MsgType;   
		$data[feedbackid] = $postObj->FeedBackId;   
		$data[transId] = $postObj->TransId;   
		$data[reason] = $postObj->Reason;   
		$data[solution] = $postObj->Solution;   
		$data[extinfo] = $postObj->ExtInfo;  
		$data[appsignature] = $postObj->AppSignature;   
		$data[signmethod] = $postObj->SignMethod;
		 
		 
		$s=$this->objectToArray($postObj->PicInfo);   
		 /*
		if($s){
			for($j=0;$j<count($s[item]);$j++){
				$p_arr[$j][picurl]=$s[item][$j][PicUrl];
			}
		} 
		*/
		$PicInfo=json_encode($s[item]);
		$PicInfo=str_replace('"PicUrl"','"picurl"',$PicInfo);
		$data[picinfo] = $PicInfo;  
 		//echo $PicInfo;  
		//判断是否存在
		$s=$this->getCount("tlwx_feedback","Where 1 AND feedbackid='".$data[feedbackid]."'");
		if($s){
			$updata_data[msgtype]=$data[msgtype];
			$updata_data[updatatime]=time();
			$msg=$this->updata($updata_data,"tlwx_feedback","Where feedbackid='".$data[feedbackid]."'",1);	
		}else{
			$data[addtime]=time();
			$s=$this->insert($data,"tlwx_feedback",1);
		
		}
		echo "success";
		exit;
 	
 
	 }		  
	 public function alert(){ 
	 	echo "success";
		exit;
	 }
}
?>