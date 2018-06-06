<?php

class WeixinAction
{
	/*
	$postStr="<xml>
	<ToUserName><![CDATA[toUser]]></ToUserName>
	<FromUserName><![CDATA[FromUser]]></FromUserName>
	<CreateTime>123456789</CreateTime>
	<MsgType><![CDATA[event]]></MsgType>
	<Event><![CDATA[subscribe]]></Event>
	</xml>"
	*/
	public function __construct()
    {
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        /*$postStr="<xml>
	<ToUserName><![CDATA[toUser]]></ToUserName>
	<FromUserName><![CDATA[123]]></FromUserName>
	<CreateTime>123456789</CreateTime>
	<MsgType><![CDATA[event]]></MsgType>
	<Event><![CDATA[CLICK]]></Event>
	<EventKey><![CDATA[大转盘]]></EventKey>
	
	</xml>";	   
	*/
	 
	 
	   if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
				
                $this->FromUsername = $postObj->FromUserName;  //地发送方帐号（一个OpenID） 
                $this->ToUsername = $postObj->ToUserName;
                $this->MsgType = $postObj->MsgType;			      //text，image，location，link,event
			   
				 
		
				$this->Keyword = trim($postObj->Content);	
				
				$this->MsgId = trim($postObj->MsgId);
				 
				$this->PicUrl = trim($postObj->PicUrl);	
				
				$this->Location_X  = trim($postObj->Location_X);	//地理位置纬度
				$this->Location_Y  = trim($postObj->Location_Y);	//地理位置经度
				$this->Scale  = trim($postObj->Scale);				//地图缩放大小
				$this->Label  = trim($postObj->Label);				//地理位置信息
				
				$this->Title  = trim($postObj->Title);	//消息标题
				$this->Description  = trim($postObj->Description);	//消息描述
				$this->Url  = trim($postObj->Url);				//消息链接
				
				
				$this->Event  = trim($postObj->Event);	//事件类型，subscribe(订阅)、unsubscribe(取消订阅)、CLICK(自定义菜单点击事件) 
				$this->EventKey  = trim($postObj->EventKey);	//事件KEY值，与自定义菜单接口中KEY值对应 
 
				
				$this->CreateTime = $postObj->CreateTime;	
				$this->MsgId = $postObj->MsgId;				
				 
		}

    }
	public function valid()
    {
        $echoStr = $_GET["echostr"];
		echo $echoStr;
        exit;
 		global $config;
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
 
        $token = $config['token'];
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
            return true;
        }else{
            return false;
        }
    }
	private function checkSignature()
	{
			$signature = $_GET["signature"];
			$timestamp = $_GET["timestamp"];
			$nonce = $_GET["nonce"];	
					
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	public function MsgType(){
		return $this->MsgType;
    }
	public function EventKey(){
		return $this->EventKey;
    }	
	
	public function Event(){
        return $this->Event;
    }	
	
	public function Keyword(){
        return $this->Keyword;
    }	
	
	public function FromUsername(){
        return $this->FromUsername;
    }	
	public function MsgId(){
        return $this->MsgId;
    }			
 
    public function responseText($ContentStr)
    {
		$time = time();
		$textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
					</xml>";             

		$MsgType = "text";
		$ContentStr =$ContentStr;
	  
		$resultStr = sprintf($textTpl,  $this->FromUsername,$this->ToUsername, $time, $MsgType, $ContentStr);
		echo $resultStr;
    }
    public function responseMsg($ContentArray)
    {
		  

          $time = time();
		  $MsgType = "news";
		  $ArticleCount=count($ContentArray);
          $textTpl = "<xml>
         				 <ToUserName><![CDATA[".$this->FromUsername."]]></ToUserName>
         				 <FromUserName><![CDATA[".$this->ToUsername."]]></FromUserName>
         				 <CreateTime>".$time."</CreateTime>
         				 <MsgType><![CDATA[".$MsgType."]]></MsgType>
         				 <ArticleCount>".$ArticleCount."</ArticleCount>
         				 <Articles>";
			$s="";
		 	if($ContentArray){
				for($i=0;$i<count($ContentArray);$i++){
					$ContentArray[$i][url]=$ContentArray[$i][url]."&wechat_id=".$this->FromUsername;
					$s.="<item>
									<Title><![CDATA[".$ContentArray[$i][title]."]]></Title> 
									<Description><![CDATA[".$ContentArray[$i][summary]."]]></Description>
									<PicUrl><![CDATA[".$ContentArray[$i][image]."]]></PicUrl>
									<Url><![CDATA[".$ContentArray[$i][url]."]]></Url>
					 </item>";
				}
				$textTpl.=$s."</Articles>
						  </xml> 				
						 ";             
			}
          
		   //echo $textTpl ;
 
          // $resultStr = sprintf($textTpl,$this->FromUsername,$this->ToUsername, $time, $MsgType);
		   echo $textTpl;
       
    }	
	/*获取用户资料		
	{
		"subscribe": 1, 
		"openid": "o6_bmjrPTlm6_2sgVt7hMZOPfL2M", 
		"nickname": "Band", 
		"sex": 1, 
		"language": "zh_CN", 
		"city": "广州", 
		"province": "广东", 
		"country": "中国", 
		"headimgurl":    "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0", 
	   "subscribe_time": 1382694957
	}	
	*/
 	public function user_get($openid){
		global $config;
		$access_token=$this->get_access_token($url);
		$url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
		$data=$this->get_data($url);
		return $data;
	}
 
 	/*
	
	*/
	public function get_access_token(){
	 
		global $config;
		$url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$config['appid'].'&secret='.$config['appsecret'];
		 
		$data_token=$this->get_data($url);
	 	$access_token=$data['access_token'];
		return $access_token;
	}

	function get_data($url){ // 模拟提交数据函数
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			$data=json_decode($result,true);
			return $data;
	}			
 
public function curl_get_contents($url, $cookie_file = ''){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if(!empty($cookie_file)){
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        }
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;
    }
    public function curl_grab_page($url, $data, $proxy = '', $proxystatus = '', $ref_url = ''){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if ($proxystatus == 'true'){
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, TRUE);
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if(!empty($ref_url)){
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_REFERER, $ref_url);
        }
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        ob_start();
        return curl_exec ($ch);
        ob_end_clean();
        curl_close ($ch);
        unset($ch);
    } 
}

?>