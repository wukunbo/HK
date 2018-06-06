<?php
include_once("WeixinMoude.class.php");
class WeixinAction extends WeixinMoude{
 
	 //发货通知
	 //{"errcode":0,"errmsg":"ok"}
 	 public function deliver($deliver_status=1,$deliver_msg="",$out_trade_no=""){ 
	 	define(APPKEY ,"Ckqr8SBzhtiNgxGdtACgD3kFsD02eDTA6je4Hju8ubzSuszpKT2mOv4gBeYdVtGWHKPMF4CeFcgeqhzgP3RDT7bzZZqrlZUSYaBNEvZipOqv9vsOvvL1F61hVSjjloVl"); //paysign key
	     $data_access_token=$this->get_access_token();
		 
	 	 $url="https://api.weixin.qq.com/pay/delivernotify?access_token=".$data_access_token[access_token]."";
		  
		 $config=$this->config;
		 
		 $sql = "SELECT * " .
						"FROM " . $GLOBALS['ecs']->table('tlwx_notify') . "   "  .
						"WHERE out_trade_no = '" . $out_trade_no. "'";
		 $wx_detail = $GLOBALS['db']->getRow($sql);			 
		 
		 $data[appid]=$config[appid];
	 
		 $data[openid]=$wx_detail[openid];
		 $data[transid]=$wx_detail[transaction_id];
		 $data[out_trade_no]=$out_trade_no;
		 $data[deliver_timestamp]=time();
		 $data[deliver_status]=$deliver_status;
		 $data[deliver_msg]=$deliver_msg;
		 
		 $app_signature= $this->get_biz_sign($data);; 
		 
		 $data[app_signature]=$app_signature;
		 $data[sign_method]="sha1";
		 
		 $s=$this->post_data($url,json_encode($data));
		 
		 return $s;
 
	 }	
}
?>