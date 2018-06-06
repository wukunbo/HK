<?php

/**
 *  微信接口
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: goods.php 17217 2011-01-19 06:29:08Z liubo $
*/
 
define('IN_ECS', true);
session_start();
 
require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . '/' . ADMIN_PATH . '/tlwx/tlwx.class.php'); 
require_once(ROOT_PATH . '/' . ADMIN_PATH . '/tlwx/tlwx.function.php');

$pageURL = 'http';
if ($_SERVER["HTTPS"] == "on") {    // 如果是SSL加密则加上“s”
    $pageURL .= "s";
}
$pageURL .= "://";
if ($_SERVER["SERVER_PORT"] != "80"){
	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
} else{
	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"];
}
$url_mobile=str_replace("wxadmin/admin/tlwx.php","",$pageURL);
define("url_mobile",$url_mobile);
$smarty->assign('url_mobile', $url_mobile);
 
 
//重新定义模版
$smarty->template_dir  = ROOT_PATH . ADMIN_PATH . '/tlwx_templates/';
$smarty->compile_dir   = ROOT_PATH . 'temp/compiled/tlwx_admin';
$GLOBALS['smarty']=$smarty;
$tlwx=new tlwx();
 
 
if(!$_SESSION[userweb][wx_id]){
	$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('tlwx_config') . " WHERE 1 AND user_id='".$_SESSION[userweb][userid]."'"; 
	$info = $GLOBALS['db']->getRow($sql);
	$_SESSION[userweb][wx_id]=$info[id];
	 
	if(!$info[id]){
		 
		$m=$_REQUEST['m'];
		$a=$_REQUEST['a'];
	//	var_dump($_REQUEST);
 		//var_dump($m);
		if($m!=="Config" && $a!="index"  ){
  echo 2;
 exit;
				header("location:tlwx.php?m=Config&a=index");
			exit;
		}
	}
};
 
 
//----------------0,参数获取，自动接收---------------------------------------------------
 
foreach($_REQUEST as $_k=>$_v){
     if( strlen($_k)>0 && preg_match('(cfg_|GLOBALS)',$_k) && !isset($_COOKIE[$_k]) ){
        exit('Request var not allow!');
     }
}

function _RunMagicQuotes(&$svar){
     if(!get_magic_quotes_gpc()){
          if( is_array($svar) ){
              foreach($svar as $_k => $_v) $svar[$_k] = _RunMagicQuotes($_v);
          }else {
             $svar = addslashes($svar);
           }
     }
    return $svar;
}
foreach(Array('_GET','_POST') as $_request){
    foreach($$_request as $_k => $_v) ${$_k} = _RunMagicQuotes($_v);
}
//----------------1,参数获取，自动接收--------------------------------------------------

$timestamp=time().rand(0000,9999);
$token=md5('unique_salt' . $_POST['timestamp']);
$ur_here = $_LANG['01_weixin_auto'];
$smarty->assign('ur_here', $ur_here);

$GLOBALS['m']=$m;
$GLOBALS['a']=$a;

require_once(ROOT_PATH . '/' . ADMIN_PATH . '/tlwx/'.$m.'Moude.class.php'); 
require_once(ROOT_PATH . '/' . ADMIN_PATH . '/tlwx/'.$m.'Action.class.php'); 

 
$moduleAction=$m."Action";
$module= new $moduleAction(); 

$module->$a();
 

exit;

 

  
 
function vpost($url,$data){ // 模拟提交数据函数
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)'); // 模拟用户使用的浏览器
    // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    // curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包x
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $tmpInfo = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
       echo 'Errno'.curl_error($curl);//捕抓异常
    }
    curl_close($curl); // 关闭CURL会话
    return $tmpInfo; // 返回数据
}
