<?php
/**
 * 微信自动登录类
 * ============================================================================
 * * 版权所有深圳市托略计算机有限公司
网址地址 http://mp.weixin.qq.com/wiki/index.php?title=%E7%BD%91%E9%A1%B5%E6%8E%88%E6%9D%83%E8%8E%B7%E5%8F%96%E7%94%A8%E6%88%B7%E5%9F%BA%E6%9C%AC%E4%BF%A1%E6%81%AF
 * ============================================================================
 
*/

class tlwx_wxlogin{
	/*用户同意授权，获取code的链接
				 
		完整如下：	https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect
		#wechat_redirect 无论直接打开还是做页面302重定向时候，必须带此参数 
		如果用户同意授权，页面将跳转至 redirect_uri/?code=CODE&state=STATE。若用户禁止授权，则重定向后不会带上code参数，仅会带上state参数redirect_uri?state=STATE 
		code说明 ：
code作为换取access_token的票据，每次用户授权带上的code将不一样，code只能使用一次，5分钟未被使用自动过期。
	*/
	private $_url_get_code			=	"https://open.weixin.qq.com/connect/oauth2/authorize?";	
	//获取ACCESS_TOKEN及WECHAT_ID的网址
	private $_url_get_access_token			= "https://api.weixin.qq.com/sns/oauth2/access_token?";
	//刷新 access_token
	private $_url_refresh_token			= "https://api.weixin.qq.com/sns/oauth2/refresh_token?";
	//拉取用户资料
	private $_url_get_user_info			= "https://api.weixin.qq.com/sns/userinfo?";
	//APPID;	
	private $_appid			=	"";
	//secret;	
	private $_secret			=	"";
	//默认值
	private $_grant_type   =  "authorization_code ";
	//回调网址，需要urlencode编码
	private $_redirect_uri			=	"";	
	/*
	应用授权作用域，snsapi_base （不弹出授权页面，直接跳转，只能获取用户openid），snsapi_userinfo （弹出授权页面，可通过openid拿到昵称、性别、所在地。并且，即使在未关注的情况下，只要用户授权，也能获取其信息） 	
	*/
	private $_scope			=	"snsapi_base";	
	private $_scope_info	=	"snsapi_userinfo";	
	/*
	重定向后会带上state参数，开发者可以填写a-zA-Z0-9的参数值 
	*/
	private $_state			=	"STATE";
 
	
 	//初始化相关值 数组形式
	public function config($data){
		$this->_appid=trim($data["appid"]);
		$this->_scope=trim($data["scope"]);
		$this->_state=trim($data["state"]);
		$this->_secret=trim($data["secret"]);
		$this->_redirect_uri=urlencode($data["redirect_uri"]);
	}
	//拼接获取CODE的网址
	public function get_code_url(){
		$str = ''
			.$this->_url_get_code
			.'appid='.$this->_appid
			.'&redirect_uri='.$this->_redirect_uri
			.'&response_type=code&scope='.$this->_scope_info.'&state='.$this->_state.'#wechat_redirect';
		return $str;
	}	 
	// 第一步，获取CODE，返回  $_REQUEST["code"]
	public function get_code(){
		$url=$this->get_code_url();
		header("Location: ".$url."");
		exit;
	}
	//接受CODE后，去获取 wechat_id，及access_token
	/*
	{
	   "access_token":"ACCESS_TOKEN",
	   "expires_in":7200,
	   "refresh_token":"REFRESH_TOKEN",
	   "openid":"OPENID",
	   "scope":"SCOPE"
	}
	错误信息
	{"errcode":40029,"errmsg":"invalid code"}
	*/
	public function get_wechat_id($code){
		
		$url=''
			.$this->_url_get_access_token
			.'appid='.$this->_appid
			.'&secret='.$this->_secret
			.'&code='.$code
			.'&grant_type='.$this->_grant_type;
		$data=$GLOBALS['pf']->get_data($url);
 		 
		 
		$wechat_id=$data['openid'];
		return $wechat_id;
	}	
	public function get_wechat_info($code){
		
		$url=''
			.$this->_url_get_access_token
			.'appid='.$this->_appid
			.'&secret='.$this->_secret
			.'&code='.$code
			.'&grant_type='.$this->_grant_type;
		 
		$url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->_appid.'&secret='.$this->_secret.'&code='.$code.'&grant_type=authorization_code';
	 
		$data1=$GLOBALS['pf']->get_data($url);
 		 
		$url=''
			.$this->_url_get_user_info
			.'access_token='.$data1[access_token]
			.'&openid='.$data1[openid]
			.'&lang=zh_CN';
			 
		$data2=$GLOBALS['pf']->get_data($url);
		
		 
		return $data2;
	}	
	public function get_access_token($code){
		//获取缓存文件中的get_access_token
		 
		if($token){
		}else{
			 
			$url=''
				.$this->_url_get_access_token
				.'appid='.$this->_appid
				.'&secret='.$this->_secret
				.'&code='.$code
				.'&grant_type='.$this->_grant_type;
			$data=$GLOBALS['pf']->get_data($url);
			 print_r($data);
			$access_token=$data['access_token'];
			return $access_token;
		}
	}	
	/*刷新refresh_token  https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=APPID&grant_type=refresh_token&refresh_token=REFRESH_TOKEN
		{
		   "access_token":"ACCESS_TOKEN",
		   "expires_in":7200,
		   "refresh_token":"REFRESH_TOKEN",
		   "openid":"OPENID",
		   "scope":"SCOPE"
		}	
		{"errcode":40029,"errmsg":"invalid code"}
	*/
	public function refresh_token($refresh_token){
		//获取缓存文件中的get_access_token
		//require(dirname(__FILE__) . '/caches_token.php');
		if($token){
		}else{
			$url=''
				.$this->_url_refresh_token
				.'appid='.$this->_appid
				.'&grant_type=refresh_token'
				.'&refresh_token='.$refresh_token;
			$data=$GLOBALS['pf']->get_data($url);
			$access_token=$data['access_token'];
			return $access_token;
		}
	}	
	/*
	获取用户信息
	https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
	{
	   "openid":" OPENID",
	   " nickname": NICKNAME,
	   "sex":"1",
	   "province":"PROVINCE"
	   "city":"CITY",
	   "country":"COUNTRY",
		"headimgurl":    "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46", 
		"privilege":[
		"PRIVILEGE1"
		"PRIVILEGE2"
		]
	}	
	{"errcode":40003,"errmsg":" invalid openid "}
	*/
	
	 
	public function get_access_token_for_user($wechat_id,$code){
 
		 
		$url='https://api.weixin.qq.com/sns/oauth2/refresh_token?appid='.$this->_appid.'&grant_type=refresh_token&refresh_token=REFRESH_TOKEN';
		$data=$GLOBALS['pf']->get_data($url);
	 	 
		return $data;
		 
	}		
	public function get_user_info($wechat_id){
 
		 
		$url=''
			.$this->_url_get_user_info
			.'access_token='.$this->get_access_token($code)
			.'&openid='.$wechat_id
			.'&lang=zh_CN';
		$data=$GLOBALS['pf']->get_data($url);
	 	 
		return $data;
		 
	}				
}

?>