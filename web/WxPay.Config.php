<?php
	$sql = "SELECT * from tl_tlwx_config WHERE   1 and id='".$order_detail[wx_id]."'";
		 	 
	$result = mysql_query($sql,$con);
	$wx_config = mysql_fetch_assoc($result);
	//	 var_dump($wx_config);
	 define('_appid', $wx_config[appid]);
	 define('_mchid', $wx_config[mchid]);
	 define('_pay_key', $wx_config[pay_key]);
	 define('_appsecret', $wx_config[appsecret]);
	 define('_appid', $wx_config[appid]);
	 define('_sslcert_path', DOMAIN."".$wx_config[sslcert_path]);
	 define('_sslkey_path', DOMAIN."".$wx_config[sslkey_path]);
	 class WxPayConf_pub
	{
		//=======【基本信息设置】=====================================
		//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
		//const APPID = _appid;
		const APPID = _appid;
		//受理商ID，身份标识
		const MCHID = _mchid;
		//商户支付密钥Key。审核通过后，在微信发送的邮件中查看
		const KEY = _pay_key;
		//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
		const APPSECRET = _appsecret;
		
		//=======【JSAPI路径设置】===================================
		//获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面
		const JS_API_CALL_URL = 'http://www.taiwaskii.com/web/js_api_call.php';
		
		//=======【证书路径设置】=====================================
		//证书路径,注意应该填写绝对路径
		const SSLCERT_PATH = _sslcert_path;
		const SSLKEY_PATH = _sslkey_path;
		
		//=======【异步通知url设置】===================================
		//异步通知url，商户根据实际开发过程设定
		const NOTIFY_URL = "http://www.taiwaskii.com/web/tlwx_pay.class.php";
	
		//=======【curl超时设置】===================================
		//本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒
		const CURL_TIMEOUT = 30;
	}
	
	 class WxPayConfig
	{
		//=======【基本信息设置】=====================================
		//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
		//const APPID = _appid;
		const APPID = _appid;
		//受理商ID，身份标识
		const MCHID = _mchid;
		//商户支付密钥Key。审核通过后，在微信发送的邮件中查看
		const KEY = _pay_key;
		//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
		const APPSECRET = _appsecret;
		
		//=======【JSAPI路径设置】===================================
		//获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面
		const JS_API_CALL_URL = 'http://www.taiwaskii.com/web/js_api_call.php';
		
		//=======【证书路径设置】=====================================
		//证书路径,注意应该填写绝对路径
		const SSLCERT_PATH = _sslcert_path;
		const SSLKEY_PATH = _sslkey_path;
		
		//=======【异步通知url设置】===================================
		//异步通知url，商户根据实际开发过程设定
		const NOTIFY_URL = "http://www.taiwaskii.com/web/tlwx_pay.class.php";
	
		//=======【curl超时设置】===================================
		//本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒
		const CURL_TIMEOUT = 30;
		
		//=======【curl代理设置】===================================
		/**
		 * TODO：这里设置代理机器，只有需要代理的时候才设置，不需要代理，请设置为0.0.0.0和0
		 * 本例程通过curl使用HTTP POST方法，此处可修改代理服务器，
		 * 默认CURL_PROXY_HOST=0.0.0.0和CURL_PROXY_PORT=0，此时不开启代理（如有需要才设置）
		 * @var unknown_type
		 */
		const CURL_PROXY_HOST = "0.0.0.0";//"10.152.18.220";
		const CURL_PROXY_PORT = 0;//8080;
		
		//=======【上报信息配置】===================================
		/**
		 * TODO：接口调用上报等级，默认紧错误上报（注意：上报超时间为【1s】，上报无论成败【永不抛出异常】，
		 * 不会影响接口调用流程），开启上报之后，方便微信监控请求调用的质量，建议至少
		 * 开启错误上报。
		 * 上报等级，0.关闭上报; 1.仅错误出错上报; 2.全量上报
		 * @var int
		 */
		const REPORT_LEVENL = 1;
	
	
	}