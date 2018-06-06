<?php

// require_once 'weixin.class.php';

class ShareController extends Controller {
	
	private $_APPID = "wxadc15b293156b7f2";
	private $_SECRET = "d1e8029c6f9c7a342e32c188a6948fca";
	private $_GRANT_TYPE = 'authorization_code';
	private $_yuming = 'http://zhichiwangluo.com';
	
	/**
	 * 每次需要access_token时，获取
	 * @return mixed
	 */
	public function getToken($code){
		$token = Yii::app()->filecache->get('token');
		if(empty($token)){
// 			$code = $this->getCode();
			$token = $this->getAccessToken($this->_APPID, $this->_SECRET,
					$code, $this->_GRANT_TYPE);
			Yii::app()->filecache->set('token',$token,7200);
		}
		return $token;
	}
	
	/**
	 * 需要code获取openid是的url格式化
	 * @param unknown $url
	 * @return string
	 */
	public function codeUrlEncode($url){
		$lastUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?'
			.'appid='.$this->_APPID
			.'&redirect_uri='.urlencode($url)
			.'&response_type=code&scope=snsapi_base&state=123#wechat_redirect';
		return $lastUrl;
	}
	
	/**
	 * 默认页面
	 */
	public function actionIndex()
	{	
		
		$openid = Yii::app()->request->getParam('openid');
// 		$openid = $this->getOpenId($code);
// 		$openid = 'oxNmfuPuC2pxd-xIyD3GvxcszCrA';
		
// 		$access_token = $this->getToken();
// 		$access_token = "access_token";
		session_start();
		
		Yii::app()->session['openid'] = $openid;
		$_SESSION['openid'] = $openid;
				
		$createUrl = $this->_yuming.'/index.php?r=share/create&From_openid='.$openid;
		
		$createUrl = $this->codeUrlEncode($createUrl);
		
		$this->render('index',array(
				'createUrl' => $createUrl,
		));
	}
	//中转
	public function actionTran() {
		//判断来自微信的回调函数，获取OPENID
		$From_openid=$_REQUEST["From_openid"]; //$From_openid 
		if($_REQUEST["code"]){
			$code = $_REQUEST["code"];
			$self_openid=$this->getOpenId($code);
			//写入SESSION
 
			if($self_openid){
				$_SESSION["openid"]=$self_openid;
			}
			 
		}
		$this->From_openid=$From_openid;
		$this->actionCreate();
	}
	//测试清除	
	public function actionDelSession() {
		$_SESSION["openid"]="";
		if(!$_SESSION["openid"]){
			 
		}
	}	
	//测试创建
	public function actionCreateSession() {
		$_SESSION["openid"]="test";
		 
	}			
	/**
	 * 创建
	 */
	public function actionCreate() {
	
		$shareUrl = Yii::app()->request->hostInfo.Yii::app()->request->getUrl();
	
		$txt = 'text';
		$is_self = 1;
		
		session_start();
		
		
		/*
		 修改开始
		*/
		//获取URL的openid
		 
		$From_openid=$_REQUEST["From_openid"]; //$From_openid 
		
		//{{获取用户名
		$result=file_get_contents("http://bbs.chimelong.com/exist.php?openid=".$From_openid);
      	$data=json_decode($result,true);  // {"code":"N"}
	 
      	$create_name = $data[nickname]; //默认存在
		$headimgurl = $data[avatar]; //默认存在
		if($data[code]=="N"){
			echo "尚未关注";
			exit;
		}
		//echo $create_name;exit();	
      		//}

		//判断是否本人，如果不是，跳转获取OPENID，通过SESSION来判断，tiaozhuang,，判断是否是回调
		$tiaozhuang=$_REQUEST["tiaozhuang"];
		if(!$_SESSION["openid"] && $_REQUEST["code"]==""){
			$_SESSION["num"]=1;
			$url=$this->_yuming."/index.php?r=share/create&From_openid=".$From_openid; //定义ajax参数
			$url=$this->codeUrlEncode($url);
			header("Location: ".$url."");
			exit;
		}	 
		 
		//判断来自微信的回调函数，获取OPENID
		if($_REQUEST["code"]){
			$code = $_REQUEST["code"];
			$data=$this->getOpenId($code);
			//写入SESSION
 			$self_openid=$data[openid];
			if($self_openid){
				$_SESSION["openid"]=$self_openid;
				$_SESSION["num"]=1;
			}else{
				$_SESSION["num"]=1+$_SESSION["num"];
				//exit;	
				//从分享进来时，CODE过期，重新获取
				if($_SESSION["num"]<3){
					$url=$this->_yuming."/index.php?r=share/create&From_openid=".$From_openid; //定义ajax参数
					$url=$this->codeUrlEncode($url);
				 	header("Location: ".$url."");
					echo "code:".$_REQUEST["code"];
					echo "<br>";
					echo "num1:".$_SESSION["num"];
					echo "<br>";
				}else{
					$_SESSION["num"]=1;
					print_r($data);
					echo "获取OPENID失败，请重新获取";
					
				}
							//	exit;				
			}
			 
		}	
  
		/*
		 修改结束
		*/
		/*
		$code = $_REQUEST["code"];
		
		$openid = $this->getOpenId($code);
// 		$openid = 'o6_bmjrPTlm6_2sgVt7hMZOPfL2M';
		
		$access_token = $this->getToken($code);
// 		$access_token = "access_token";
		*/
		$flag = Yii::app()->request->getParam('flag');
		
		Yii::app()->session['openid'];
		
		if($_SESSION['openid'] == $From_openid ){//创建
			 
			//{{检测用户是否创建过分享
			$tempOpenId = addslashes($From_openid);
			$sql = "SELECT * FROM tbl_share WHERE user_id = '$From_openid'";
			$share = Yii::app()->db->createCommand($sql)->queryRow();
			
 
			
			if(!empty($share)){//分享过，回到发出邀请页面
				$this->render('create',array(
						'userInfo' => $From_openid,
						'is_self' => 1,
						'newShareId' => $share['id'],
						'create_name' => $create_name,
						'shareUrl' => $shareUrl,
				));
				exit();
			}else{//没有分享过，创建分享，到发出邀请页
				$share = new Share ();
				$share->user_id = $From_openid;
				$share->username = $create_name;
				$share->headimgurl = $headimgurl;
				$share->accept_count = 0;
				$share->create_time = date ( 'Y-m-d H:i:s' );
				$share->update_time = date ( 'Y-m-d H:i:s' );
				
				$saveFlag = $share->save ();
			
				if ( $saveFlag ) {
					$newShareId = $share->id;
	// 				$newShareId = 12345678;
					//创建成功
	// 				$return ['status'] = 0;
				} else {
					//创建失败
	// 				$return ['status'] = 2;
				}
			}
		}
		
					 
		if($_SESSION['openid'] !== $From_openid ){//创建
// 		if($_SESSION['openid'] !== $openid){//接受分享
		 
			$From_openid = Yii::app()->request->getParam('From_openid');
			$share_user = Yii::app()->request->getParam('share_user');
		//	$share_name = Yii::app()->request->getParam('share_name');
			/*
			修改，获取用户名
			*/
			$result=file_get_contents("http://bbs.chimelong.com/exist.php?openid=".$From_openid);
				 
			$data=json_decode($result,true);  // {"code":"N"}
			$create_name = $data[nickname]; //默认存在
		    //结束
							
			$txt = "接受邀请";
			$is_self = 0; // 非本人
			$linkUrl = '/index.php?r=share/accetp'
					.'&From_openid='.$From_openid
					.'&acceptUserId='.$_SESSION['openid']
					.'&acceptUserName'.'nickname';
		}
		
		$createUrl = $this->_yuming.'/index.php?r=share/accept'
				.'&share_id='.$share->id
				.'&From_openid='.$From_openid.'&acceptUserId='.$_SESSION['openid'];
		



		//{{获取用户名
		//$result=file_get_contents("http://bbs.chimelong.com/exist.php?openid=".$_SESSION['openid']);
      		//$data=json_decode($result,true);  // {"code":"N"}
      		//$share_name = $data[nickname]; //默认存在
      		//}

		//{{获取用户名
                //$result=file_get_contents("http://bbs.chimelong.com/exist.php?openid=".$From_openid);
                //$data=json_decode($result,true);  // {"code":"N"}
                //$create_name = $data[nickname]; //默认存在
                //echo $create_name;exit();
                //}

	//	echo $createUrl;exit();
	//修改
		$createUrl = $this->codeUrlEncode($createUrl);		
	// 	echo $createUrl;
		$this->render('create',array(
				'txt' => $txt,
				'userInfo' => $openid,
				'is_self' => $is_self,
				'newShareId' => $newShareId,
				'linkUrl' => $linkUrl,
				'share_id' => $From_openid,
				'share_user' => $share_user,
				'share_name' => $share_name,
				'create_name' => $create_name,
				'createUrl' => $createUrl,
				'shareUrl' => $shareUrl,
		));
	}
 
	/**
	 * 接受
	 */
	public function actionAccept(){
		
		$From_openid = Yii::app ()->request->getParam ( 'From_openid' );
		/*
		$code = $_REQUEST["code"];
		
		$openid = $this->getOpenId($code);
// 		$openid = 'oxNmfuPuC2pxd-xIyD3GvxcszCrA';
		
		$access_token = $this->getToken($code);
// 		$access_token = "access_token";
		
		$userInfo = $this->getUserInfoFromWeixin($openid, $access_token);
		*/
		//{{/检测用户是否关注公众号
		/*
		修改 获取
		*/
		//判断来自微信的回调函数，获取OPENID
		if($_REQUEST["code"]){
			$code = $_REQUEST["code"];
			$data=$this->getOpenId($code);
			$self_openid=$data[openid];
			//写入SESSION
			if($self_openid){
				$_SESSION["openid"]=$self_openid;
				$result=file_get_contents("http://bbs.chimelong.com/exist.php?openid=".$self_openid);
				 
				$data=json_decode($result,true);  // {"code":"N"}
			}else{
				echo "获取失败OPENID，重新提交";
				exit;
			}
 
			 
			 
		}
		//结束		
		$userInfo['openid']=$_SESSION['openid'];
		
		if ($data['code']=="Y") { // 关注
			
			//{{检测用户是否接受过
			$sql = "SELECT * FROM tbl_share_accept WHERE user_id = '{$From_openid}'
				and accept_id = '{$userInfo['openid']}'";
			$acceptFlag = Yii::app()->db->createCommand($sql)->queryRow();
			if(!empty($acceptFlag)){
				$linkUrl = $this->_yuming.'/index.php?r=share/index&openid='.$_SESSION['openid'];
				$this->render('accepted',array(
					'linkUrl' => $linkUrl,
				));
				exit();
			}
			//}}
			
			$shareAccept = new ShareAccept();
			//$shareAccept->share_id = $share_id;
			$shareAccept->user_id = $From_openid;
			$shareAccept->accept_id = $userInfo['openid'];
			$shareAccept->create_time = date('Y-m-d H:i:s');
			$shareAccept->accept_name = $userInfo['nickname'];
			
			$sql = " update `tbl_share` SET accept_count=accept_count+1 WHERE user_id='".$From_openid."'";
			//$command=$connection->createCommand($sql);
			Yii::app()->db->createCommand($sql)->query();
 
			
			if($shareAccept->save()){


				$linkUrl = $this->_yuming.'/index.php?r=share/index&openid='.$_SESSION['openid'];
		
				//$linkUrl = $this->codeUrlEncode($createUrl);
				//echo $linkUrl;exit;
				$this->render('acceptaccess',array(
						'linkUrl' => $linkUrl,
				));
				//echo "接受邀请成功";
				exit;
			}else{
				echo "保存失败";
// 				$return['status'] = 2;
				exit;
			}
		}else{
			$this->render('guanzhu');
			exit();
		}
		
		$this->render('create',array(
				'userInfo' => $userInfo,
				'is_self' => 0,
				'newShareId' => '',
		));
	}
	
	/**
	 * 
	 */
	public function actionAddList(){
		$listsql = "SELECT * FROM (SELECT s.*,(SELECT COUNT(a.`user_id`)
			FROM tbl_share_accept a WHERE a.`user_id` = s.user_id) AS cnt FROM tbl_share s
			ORDER BY cnt DESC LIMIT 10) x WHERE x.cnt > 0 ";
			
		$listsql="SELECT *,count( accept_id)  as total_count FROM tbl_share_accept GROUP BY user_id ORDER BY total_count desc ";
		$listData = Yii::app()->db->createCommand($listsql)->queryAll();
	 	//print_r($listData);
		foreach ($listData as $key=>$val){
			$sql = " update `tbl_share` SET accept_count=".$val[total_count]." WHERE user_id='".$val[user_id]."'";
			
			Yii::app()->db->createCommand($sql)->query();
 
		}
		 
	}
	public function actionList100(){

	 
		 
		$listsql = "SELECT * FROM (SELECT s.*,(SELECT COUNT(a.`user_id`)
			FROM tbl_share_accept a WHERE a.`user_id` = s.user_id) AS cnt FROM tbl_share s
			ORDER BY cnt DESC LIMIT 10) x WHERE x.cnt > 0 ";
	 	$listsql="SELECT user_id,username,headimgurl,accept_count AS cnt FROM tbl_share ORDER BY cnt DESC LiMIT 0,102";
		$listData = Yii::app()->db->createCommand($listsql)->queryAll();
		
		$this->render('list',array(
				'listData' => $listData,
				'data' => $info,
				'order' => $order,
				'page_title'=> '活动页面',
		));	
	}
	public function actionList20(){

	 
		 
		$listsql = "SELECT * FROM (SELECT s.*,(SELECT COUNT(a.`user_id`)
			FROM tbl_share_accept a WHERE a.`user_id` = s.user_id) AS cnt FROM tbl_share s
			ORDER BY cnt DESC LIMIT 10) x WHERE x.cnt > 0 ";
	 	$listsql="SELECT user_id,username,headimgurl,accept_count AS cnt FROM tbl_share ORDER BY cnt DESC LiMIT 0,22";
		$listData = Yii::app()->db->createCommand($listsql)->queryAll();
		
		$this->render('list',array(
				'listData' => $listData,
				'data' => $info,
				'order' => $order,
				'page_title'=> '活动页面',
		));	
	}
	public function actionList(){

		$openid = Yii::app ()->request->getParam ( 'openid' );
		 
		$listsql = "SELECT * FROM (SELECT s.*,(SELECT COUNT(a.`user_id`)
			FROM tbl_share_accept a WHERE a.`user_id` = s.user_id) AS cnt FROM tbl_share s
			ORDER BY cnt DESC LIMIT 10) x WHERE x.cnt > 0 ";
	 	$listsql="SELECT user_id,username,headimgurl,accept_count AS cnt FROM tbl_share ORDER BY cnt DESC LiMIT 0,12";
		$listData = Yii::app()->db->createCommand($listsql)->queryAll();
		
	 
		/*
		if($listData){
			foreach ($listData as $key=>$val){
				$accepter = $this->getUserInfoFromWeixin($val['user_id'], $access_token);
			}
		}
		*/
 
		$sql = "SELECT s.*,accept_count AS cnt FROM tbl_share s
				WHERE s.`user_id` = '{$openid}'";
		$info = Yii::app()->db->createCommand($sql)->queryRow();
		//{{获取用户名
		$result=file_get_contents("http://bbs.chimelong.com/exist.php?openid=".$openid);
      	$data=json_decode($result,true);  // {"code":"N"}
      	$info[username] = $data[nickname]; //默认存在
		$info[headimgurl] = $data[avatar]; //默认存在
		$cnt=	$info[cnt];
		//echo $create_name;exit();	
      		//}

   		$orderSql = "
		SELECT p.rownum FROM 
			(
			SELECT @rownum:=@rownum+1 rownum,t.* FROM 
				(SELECT @rownum:=0,s.*  
				FROM  (SELECT * FROM 
								(SELECT s.*,(SELECT COUNT(a.`user_id`) FROM tbl_share_accept a WHERE a.`user_id` = s.user_id) AS cnt 
								 FROM tbl_share s ORDER BY cnt DESC) 
					   q WHERE q.cnt > 0 ) 
				 s ) 
			t 
		) p WHERE p.user_id = '{$openid}'";
	 
		$orderSql = "		
		SELECT p.rownum FROM 
			(
			SELECT @rownum:=@rownum+1 rownum,t.* FROM 
				(SELECT @rownum:=0,s.*,s.accept_count AS cnt FROM tbl_share s ORDER BY cnt DESC,id asc) 
			t 
		) p WHERE p.user_id = '{$openid}'";
		
		$orderSql = "			SELECT count(user_id) FROM tbl_share  WHERE accept_count > '{$cnt}'";		
		
		 
		//echo $orderSql;
 
		$order = Yii::app()->db->createCommand($orderSql)->queryscalar();
		$order=$order-1;
		
		$this->render('list',array(
				'listData' => $listData,
				'data' => $info,
				'order' => $order,
				'page_title'=> '活动页面',
		));	
	}
	
	
	/**
	 * 通过OpenID获取用户信息(微信接口)
	 * http请求方式: GET
	 * https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
	 */
	public function getUserInfoFromWeixin($openID, $access_token) {
		$requestStr = 'https://api.weixin.qq.com/cgi-bin/user/info?'
				. 'access_token=' . $access_token
				. '&openid=' . $openID
				. '&lang=zh_CN';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$requestStr);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$result = curl_exec($ch);
		return json_decode ( $result ,true);
	}
	
	/*
	 * 网页授权获取用户信息
	 */
	public function getOauth2($appid,$redirect_uri,$response_type,$scope,$state){
		$requestStr = 'https://open.weixin.qq.com/connect/oauth2/authorize?'
				.'appid='.$appid
				.'&redirect_uri='.$redirect_uri//http%3A%2F%2Fchong.qq.com%2Fphp%2Findex.php%3Fd%3D%26c%3DwxAdapter%26m%3DmobileDeal%26showwxpaytitle%3D1%26vb2ctag%3D4_2030_5_1194_60
				.'&response_type='.$response_type
				.'&scope='.scope//snsapi_base,snsapi_userinfo(弹页面)
				.'&state='.$state
				.'#wechat_redirect';//必选
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$requestStr);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$result = curl_exec($ch);
	}
	
	/**
	 * 授权后获取信息
	 * @param unknown $appid
	 * @param unknown $secret
	 * @param unknown $code
	 * @param unknown $grant_type
	 * {
		   "access_token":"ACCESS_TOKEN",
		   "expires_in":7200,
		   "refresh_token":"REFRESH_TOKEN",
		   "openid":"OPENID",
		   "scope":"SCOPE"
		}
	 */
	public function getAccessToken($appid,$secret,$code,$grant_type){
		$requestStr = 'https://api.weixin.qq.com/sns/oauth2/access_token?'
				.'appid='.$appid
				.'&secret='.$secret
				.'&code='.$code
				.'&grant_type='.$grant_type;//authorization_code
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$requestStr);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$result = curl_exec($ch);
		return json_decode ( $result ,true);
	}
	
	/**
	 * 刷新token
	 * @param unknown $appid
	 * @param unknown $grant_type
	 * @param unknown $refresh_token
	 * @return mixed
	 * {
		   "access_token":"ACCESS_TOKEN",
		   "expires_in":7200,
		   "refresh_token":"REFRESH_TOKEN",
		   "openid":"OPENID",
		   "scope":"SCOPE"
		}
	 */
	public function refreshToken($appid,$grant_type,$refresh_token){
		$requestStr = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?'
				.'appid='.$appid
				.'&grant_type='.$grant_type//refresh_token
				.'&refresh_token='.$refresh_token;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$requestStr);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$result = curl_exec($ch);
		return json_decode ( $result ,true);
	}
	
	public function getCode(){
		return $_REQUEST["code"];
	}
	
	/**
	 * 
	 * @return mixed
	 */
	public function getOpenId($CODE){
		
// 		$CODE = $this->getCode();
// 		var_dump($CODE);
		$url='https://api.weixin.qq.com/sns/oauth2/access_token?'
				.'appid='.$this->_APPID
				.'&secret='.$this->_SECRET
				.'&code='.$CODE
				.'&grant_type='.$this->_GRANT_TYPE;
  		//echo $url.'<br />';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
			
		$data=json_decode($result,true);
		//echo $result ;
		$openid=$data['openid'];
// 		var_dump($openid).'<br />';
// 		echo $openid;
		return $data;
	}
}
