<?php
/**
* 	配置账号信息
*/

class WxPayConf
{
	//=======【基本信息设置】=====================================
	//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
	const APPID = "wxa635dea4526dd937";

	//受理商ID，身份标识
	const MCHID = "10011402";
	//商户支付密钥Key。审核通过后，在微信发送的邮件中查看
	const KEY = "LEGOU3721TkggfmudltABCDEFGHIJKLM";
	//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
	const APPSECRET = "57a67882dd5295fdbf9ee63581717854";

	//=======【JSAPI路径设置】===================================
	//获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面
	const JS_API_CALL_URL = "http://www.legou3721.com/mobile/js_api_call.php";
	
	//=======【证书路径设置】=====================================
	//证书路径,注意应该填写绝对路径
	const SSLCERT_PATH = "http://www.legou3721.com/mobile/wxpay/WxPayHelper/cacert/apiclient_cert.pem";
	const SSLKEY_PATH  = "http://www.legou3721.com/mobile/wxpay/WxPayHelper/cacert/apiclient_key.pem";
	
	//=======【异步通知url设置】===================================
	//异步通知url，商户根据实际开发过程设定
	const NOTIFY_URL = "http://www.legou3721.com/mobile/tlwx_wxpay.php?m=Pay&a=notify";
}
	
?>