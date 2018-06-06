<?php
/**
  * wechat php test
  */

//define your token
 
 
define('IN_ECS', true);
session_start();
 
require(dirname(__FILE__).'/includes/init.php');
ini_set("display_errors","On");
error_reporting(E_ALL);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

 

require_once( 'tlwx/WeixinCode.class.php'); //微信返回的错误代码信息
require_once( 'tlwx/TlwxMysql.class.php'); //读取数据库类
require_once( 'tlwx/TlwxMsg.class.php'); //读取数据库信息类
require_once( 'tlwx/tlwx.function.php'); //公共函数类
require_once( 'tlwx/WeixinAction.class.php');//微信接收及返回数据类
require_once( 'tlwx/TlwxReply.class.php');//根据信息类别，返回相关信息类。

require('../log/logAction.class.php');

//获取配置项
$pf = new pubilc_function; 
$config=$pf->read_static_cache("tlwx_config");
if($config==false){
	$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('tlwx_config') . " WHERE id=1";
	$config = $GLOBALS['db']->getRow($sql);
	$pf->write_static_cache("tlwx_config",$config);
}

global $config;
$config[domain]=str_replace("mobile/tlwx.php","",$config[url]);
$config[domain]=$config[domain];
$domain_mobile=$config[domain]."mobile/";
$config[url_mobile]=$config[domain]."mobile/";
$config[url_acticle]=$domain_mobile."tlwx.php?m=arctilce&a=detail&id=";
$config[url_goods]=$domain_mobile."goods.php?id=";
 
 


 

$logAction= new logAction;
$logAction->add();

$weixincode = new WeixinCodeAction;

$weixin = new WeixinAction;
$tlwxmsg = new TlwxMsgAction;
$tlwxreply = new TlwxReplyAction;
$tdb = new TlwxMysqlAction;

 

global $tdb;
 
define("TOKEN", "shop_wx");
//验证码 
 

if($_REQUEST[echostr]){
	$weixin->valid();
}

$MsgType=$weixin->MsgType();
$EventKey=$weixin->EventKey();
$FromUsername=$weixin->FromUsername();
$Keyword=$weixin->Keyword();
$Event=$weixin->Event();
 
 /*
$MsgType= "event";
 
$Event="subscribe";
$Event="CLICK";
$Keyword="大转盘";
$EventKey="大转盘";
*/

 
 
$FromUsername="FromUser123"; 
 
   
//接收事件推送
if($MsgType=="event"){


 
	if($Event=="subscribe"){
		$str="请点击下面的菜单栏了解更多关于我们公众平台";
		$weixin->responseText($str);
		//用户资料
		$data=$weixin->user_get($FromUsername);
		 
		//用户注册
 		if(!$data[nickname]) $data[nickname]=$FromUsername;
		$sql="SELECT user_id,user_name FROM ". $ecs->table('users')." WHERE wechat_id='".$FromUsername."'";
		 
		$user=$db->getRow($sql);
		if($user[user_id]!=""){
 			$sql = "UPDATE   ". $ecs->table('users') . " SET user_name='". $data[nickname]."',headimgurl='". $data[headimgurl]."'  WHERE wechat_id='".$FromUsername."'";
            $db->query($sql);
		}else{
			 
			 $sql = "INSERT INTO ". $ecs->table('users') . " (`wechat_id`, `user_name`, `headimgurl`) VALUES ( '". $FromUsername."', '". $data[nickname]."', '". $data[headimgurl]."')";
			  $sql = "INSERT INTO ". $ecs->table('tlwx_user') . " (`openid`, `nickname`, `step`) VALUES ( '". $FromUsername."', '". $data[nickname]."',3)";
			  
             $db->query($sql);
		}
		//签到送积分
		$tlwxmsg->plusPoint($FromUsername,$config[points_guanzhu],$type="guanzhu");
		//关注自动回复		
		$sql = "SELECT msg_cata,context,id,msg_id FROM " . $ecs->table('tlwx_keyword') . " WHERE id=1";
		 
		$detail = $db->getRow($sql);
	 
		if($detail[msg_cata]=='txt'){
			$ContentStr=$detail[context];
			$weixin->responseText($ContentStr);
		
		}
		if($detail[msg_cata]=='article'){
		 	 
			$ContentArray=$tlwxmsg->reply_detail($detail[msg_id],$num=0);
			$weixin->responseMsg($ContentArray);
			
		}
	}
	//点击菜单拉取消息时的事件推送
	if($Event=="CLICK"){
		//$EventKey，相当回复的文字
		if($EventKey){
			$tlwxreply->reply($EventKey,$Event,$FromUsername);
		}
	}
 	
} 
//接收文本消息
if($MsgType=="text"){
	//获取具体关键字内容
	//获取ID，用户判断重复性
 
 	$MsgId=$weixin->MsgId();
	$tlwxreply->reply($Keyword,"text",$FromUsername,$MsgId,$weixin);
 
}

?>