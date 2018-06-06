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


require(ROOT_PATH . '/admin/includes/init.php');
require_once(ROOT_PATH . '/' . ADMIN_PATH . '/includes/lib_weixin.php');
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

if ($_REQUEST['action'] != '' ){
	$smarty->assign('action', $_REQUEST['action']);
}

//微信接口
if ($_REQUEST['action'] == 'wxconfig' ){
	$smarty->assign('action', $_REQUEST['action']);
	$smarty->display('tlwx_wxconfig.htm');
}
 
if ($_REQUEST['action'] == 'weixin_config' ){
	$smarty->assign('action', $_REQUEST['action']);
	$smarty->display('weixin_auto.htm');
}
if ($_REQUEST['action'] == 'weixin_auto' ){
	
	$sql = "SELECT * FROM " . $ecs->table('weixin_keywords') . " WHERE id=1";
	$weixin_keywords = $db->getRow($sql);
	$smarty->assign('info',       $weixin_keywords);
	
  
	if($weixin_keywords[context_cata]==2){
		$weixin_reply_info=weixin_reply_row($weixin_keywords["reply_id"]);
	}
 
	$smarty->assign('weixin_reply_info',       $weixin_reply_info[row]);
	$smarty->display('weixin_auto.htm');
}
if ($_REQUEST['action'] == 'weixin_all' ){
	
	$sql = "SELECT * FROM " . $ecs->table('weixin_keywords') . " WHERE id=2";
	$weixin_keywords = $db->getRow($sql);
	$smarty->assign('info',       $weixin_keywords);
	
  
	if($weixin_keywords[context_cata]==2){
		$weixin_reply_info=weixin_reply_row($weixin_keywords["reply_id"]);
	}
 
	$smarty->assign('weixin_reply_info',       $weixin_reply_info[row]);
	$smarty->display('weixin_all.htm');
}
if ($_REQUEST['action'] == 'weixin_keywords' ){
	
	 
	if($weixin_keywords[context_cata]==2){
		$weixin_reply_info=weixin_reply_row($weixin_keywords["reply_id"]);
	}
 	$context_cata=0;
	$smarty->assign('context_cata',       $context_cata);
	$smarty->assign('weixin_reply_info',       $weixin_reply_info[row]);
	$smarty->display('weixin_keywords.htm');
}
//关键字删除操作
if( $_REQUEST['action'] =='del_keywords'){

	$sql = "DELETE FROM  " . $ecs->table('weixin_keywords') . " WHERE id=$id";
    $db->query($sql);

	if($rule_id!=""){
		$where=" 1 AND id=$rule_id";
		$sql = "SELECT keywords_id ".
                    " FROM " . $ecs->table('weixin_rule') . "   WHERE  $where" ;
		$keywords_id = $db->getOne($sql);
	 
		$keywords_id=str_replace($id.",","",$keywords_id);
		$keywords_id=str_replace(",".$id,"",$keywords_id);

		$sql = "UPDATE " . $ecs->table('weixin_rule') . " SET keywords_id='$keywords_id' WHERE id=$rule_id";
 
		$db->query($sql);
	}
	if($_REQUEST['ajax'] == 1){
		echo "";
		exit;
	}
	ecs_header("Location:weixin_app.php?action=weixin_reply_list");

}
//关键字删除操作
if( $_REQUEST['action'] =='del_rule'){

	$where=" 1 AND id=$id";
	$sql = "SELECT keywords_id ".
                    " FROM " . $ecs->table('weixin_rule') . "   WHERE  $where" ;
	$keywords_id = $db->getOne($sql);
		
	$sql = "DELETE FROM  " . $ecs->table('weixin_keywords') . " WHERE id in ($keywords_id)";
	$db->query($sql);
 
	
	$sql = "DELETE FROM  " . $ecs->table('weixin_rule') . " WHERE id=$id";
    $db->query($sql);
 
 
	if($_REQUEST['ajax'] == 1){
		echo "";
		exit;
	}
	//ecs_header("Location:weixin_app.php?action=weixin_reply_list");

}
//跳转关键字修改页面
if ($_REQUEST['action'] == 'weixin_keywords_mod' ){
	
	$info=weixin_rule_row($id);

	$smarty->assign('info',       $info);
	$smarty->assign('keywords_count',    count($info[keywords]));
	
	//print_r($info);
	
	$smarty->display('weixin_keywords.htm');
}
 
//关键字列表
if ($_REQUEST['action'] == 'weixin_keywords_list' ){
	
	 
	$weixin_list = weixin_rule_list();
  
	 
  
    $smarty->assign('weixin_list',  $weixin_list['weixin_list']);
    $smarty->assign('filter',       $weixin_list['filter']);
    $smarty->assign('record_count', $weixin_list['record_count']);
    $smarty->assign('page_count',   $weixin_list['page_count']);
	
	$smarty->display('weixin_keywords_list.htm');
}

//回复列表
if ($_REQUEST['action'] == 'weixin_reply_list' ){
	
	$weixin_reply_list = weixin_reply_list();
 
	//处理多图文
    $smarty->assign('weixin_reply_list',   $weixin_reply_list['weixin_reply_list']);
    $smarty->assign('filter',       $weixin_reply_list['filter']);
    $smarty->assign('record_count', $weixin_reply_list['record_count']);
    $smarty->assign('page_count',   $weixin_reply_list['page_count']);
 	 
 
	$smarty->display('weixin_reply_list.htm');
}
//关键字自动回复添加
if ($_REQUEST['action'] == 'weixin_rule_keywords_add' ){
	
	if($context=="" && $reply_id==""){
		make_json_error("内容不能为空");
	}
 	if($context_cata==0){
		$context_cata=1;
	}
 	for($i=0;$i<count($title);$i++){

			if($keywords_id[$i]==""){
				$sql = "INSERT INTO " . $ecs->table('weixin_keywords') . " (title, context, reply_id, context_cata, reply_cata, match_rule)" .
						 "VALUES ('".$title[$i]."',  '$context','$reply_id','$context_cata','$reply_cata','$keywords_rule[$i]')";
				$db->query($sql);
			 	 
				$keywords_id[$i]=mysql_insert_id();
			 
			}else{
				$sql = "UPDATE " . $ecs->table('weixin_keywords') . " SET " .
						"title = '".$title[$i]."', " .
						"context = '$context', " .
						"reply_id = '$reply_id', " .
						"context_cata = '$context_cata', " .
						"reply_cata = '$reply_cata', " .
						"match_rule = '$match_rule' ".
						"WHERE id=$keywords_id[$i]";	
			 
				$db->query($sql);	
				 
			}
			
		 
	}
 
	$keywords_id_str=implode(",",$keywords_id);
 
	if($id=="") {
		$sql = "INSERT INTO " . $ecs->table('weixin_rule') . " (title, keywords_id)" .
               		 "VALUES ('$rule_title',  '$keywords_id_str')";
   		$db->query($sql);
	 
	}else{
        $sql = "UPDATE " . $ecs->table('weixin_rule') . " SET " .
                "title = '$rule_title', " .
                "keywords_id = '$keywords_id_str' " .
		
				"WHERE id=$id ";	
	 
   		$db->query($sql);		
	}
	 
	if($reply_cata=="auto"){
		ecs_header("Location:weixin_app.php?action=weixin_reply_list");
		exit;
	}
	ecs_header("Location:weixin_app.php?action=weixin_keywords_list");
    exit;
}
//优惠券设置
if ($_REQUEST['action'] == 'weixin_coupon_tpl_ajax' ){
	$smarty->display('weixin_coupon_tpl_ajax.htm');
}
//优惠券设置
if ($_REQUEST['action'] == 'weixin_coupon_add' ){
	
	if($id!=""){
        $sql = "UPDATE " . $ecs->table('weixin_coupon') . " SET " .
                "title = '$title', " .
                "image = '$image', " .
				"summary = '$summary', " .
                "author = '$author', " .
                "context = '$context', " .
				"cata = '1', " .
				"url = '$url' " .
 
				"WHERE id=1";	
   		$db->query($sql);
 
    }
	$sql = "SELECT * FROM " . $ecs->table('weixin_coupon') . " WHERE id=1";
	$weixin_info = $db->getRow($sql);
	$smarty->assign('info',       $weixin_keywords);
	
 
 
	$smarty->assign('weixin_info',       $weixin_info);
		
	//ecs_header("Location:weixin_app.php?action=weixin_coupon_add");

	$smarty->display('weixin_coupon_add.htm');
    //exit;
}
//关键字添加
if ($_REQUEST['action'] == 'weixin_keywords_add' ){
	
	if($context==""){
		make_json_error("内容不能为空");
	}

	 
 	 
	if($id=="") {
		$sql = "INSERT INTO " . $ecs->table('weixin_keywords') . " (title, context, reply_id, context_cata, reply_cata, match_rule)" .
               		 "VALUES ('$title',  '$context',, '$reply_id',, '$context_cata','$reply_cata',$match_rule)";
   		$db->query($sql);
	}else{
        $sql = "UPDATE " . $ecs->table('weixin_keywords') . " SET " .
                "title = '$title', " .
                "context = '$context', " .
				"reply_id = '$reply_id', " .
                "context_cata = '$context_cata', " .
                "reply_cata = '$reply_cata', " .
                "match_rule = '$match_rule' ".
				"WHERE id=$id ";	
	 
   		$db->query($sql);		
	}
 
	if($reply_cata=="auto"){
		ecs_header("Location:weixin_app.php?action=weixin_auto");
		exit;
	}
	if($reply_cata=="all"){
		ecs_header("Location:weixin_app.php?action=weixin_all");
		exit;
	}
	ecs_header("Location:weixin_app.php?action=weixin_keywords_list");
    //exit;
}
//回复列表——ajax
if ($_REQUEST['action'] == 'weixin_reply_list_ajax' ){
	
	$weixin_reply_list = weixin_reply_list();
	//处理多图文
    $smarty->assign('weixin_reply_list',   $weixin_reply_list['weixin_reply_list']);
    $smarty->assign('filter',       $weixin_reply_list['filter']);
    $smarty->assign('record_count', $weixin_reply_list['record_count']);
    $smarty->assign('page_count',   $weixin_reply_list['page_count']);
 	 
 
	$smarty->display('weixin_reply_list_ajax.htm');
}


//素材列表
if ($_REQUEST['action'] == 'weixin_material_list_ajax' ){
	
	 
	$weixin_material_list = weixin_material_list();
	 
	 
    $smarty->assign('weixin_material_list',   $weixin_material_list['weixin_material_list']);
    $smarty->assign('filter',       $weixin_reply_list['filter']);
    $smarty->assign('record_count', $weixin_reply_list['record_count']);
    $smarty->assign('page_count',   $weixin_reply_list['page_count']);
	$smarty->assign('item_id',   $item_id);
 
	 
	$smarty->display('weixin_material_list_ajax.htm');
}


if ($_REQUEST['action'] == 'weixin_reply_add_material' ){

	if($id!=""){
		$sql = "SELECT * FROM " . $ecs->table('weixin_material') . " WHERE id=$id";
	    $weixin_reply = $db->getRow($sql);
	
		$smarty->assign('weixin_material', $weixin_reply);
	}
	$smarty->display('weixin_reply_add_material.htm');
}
//单个回复添加
if ($_REQUEST['action'] == 'weixin_reply_add_single' ){

	$sql = "SELECT * FROM " . $ecs->table('weixin_reply') . " WHERE id=$id";
    $weixin_reply = $db->getRow($sql);
	
	$smarty->assign('weixin_reply', $weixin_reply);
	$smarty->display('weixin_reply_add_single.htm');
}

//多个回复添加
if ($_REQUEST['action'] == 'weixin_reply_add_more' ){

	if($id!=""){
		$sql = "SELECT * FROM " . $ecs->table('weixin_reply') . " WHERE id=$id";
	    $weixin_reply = $db->getRow($sql);
		
		$material_id_arr=explode(',',$weixin_reply[material_id]);
		$i=1;
		for($j=0;$j<count($material_id_arr);$j++){
			if($material_id_arr[$j]!=""){
				$weixin_reply[material][$i]=weixin_material_row($material_id_arr[$j]);
			}
			$i++;
		
		}
		 
 
		$smarty->assign('material_account', count($material_id_arr));
		$smarty->assign('weixin_reply', $weixin_reply);
	}
	$smarty->display('weixin_reply_add_more.htm');
}
//素材插入
if($_REQUEST['action'] =="weixin_reply_insert_material"){
	if($title==""){
		make_json_error("标题不能为空");
	}
	if($image==""){
		make_json_error("图片不能为空");
	}
	$cata=1;
	if($id=="") {
		$sql = "INSERT INTO " . $ecs->table('weixin_material') . " (title, image, author, context, cata)" .
               		 "VALUES ('$title', '$image', '$author','$context',$cata)";
   		$db->query($sql);
	}else{
        $sql = "UPDATE " . $ecs->table('weixin_material') . " SET " .
                "title = '$_POST[title]', " .
                "image = '$image', " .
                "author = '$author', " .
                "context = '$context', " .
                "cata = '$cata' ".
				"WHERE id=$id ";	
	 
   		$db->query($sql);		
	}
	
	ecs_header("Location:weixin_app.php?action=weixin_reply_list");
    exit;
}


//回复插入 
if ($_REQUEST['action'] == 'weixin_reply_add' ){
	 
	if($title==""){
		make_json_error("标题不能为空");
	}
	if($image==""){
		make_json_error("图片不能为空");
	}
	if($summary==""){
		make_json_error("摘要不能为空");
	}
	if($context==""){
		//make_json_error("正文不能为空");
	}
 	
 
 
	if($cata==2){
		 
		for($i=0;$i<count($item_cata);$i++){
			 
			if($item_cata[$i]==2 ){
				
				$sql = "SELECT id FROM " .$GLOBALS['ecs']->table('weixin_material'). " WHERE 1 AND goods_id=$item_id[$i]";
      			$material_id = $GLOBALS['db']->getOne($sql);
				 
				if($material_id==""){
					$sql = "INSERT INTO " . $ecs->table('weixin_material') . " (goods_id, cata)" .
							 "VALUES ('$item_id[$i]','$item_cata[$i]')";
					$db->query($sql);	
					$material_id_arr[$i]=mysql_insert_id();
				}else{
					$material_id_arr[$i]=$material_id;
				}
				 
			}else{
				$material_id_arr[$i]=$item_id[$i];
			}

		}
		 
		 
		$material_id_str=implode(',',array_filter($material_id_arr));
	} 
 
	 
	if($id=="") {
		$sql = "INSERT INTO " . $ecs->table('weixin_reply') . " (title, image, summary, author, context, cata, url, material_id)" .
               		 "VALUES ('$title', '$image', '$summary', '$author','$context','$cata','$url','$material_id_str')";
   		$db->query($sql);
		 
	}else{
        $sql = "UPDATE " . $ecs->table('weixin_reply') . " SET " .
                "title = '$_POST[title]', " .
                "image = '$image', " .
                "summary = '$summary', " .
                "author = '$author', " .
                "context = '$context', " .
				"cata = '$cata', " .
				"url = '$url', " .
                "material_id = '$material_id_str' ".
				"WHERE id=$id ";	
	 
   		$db->query($sql);	
		//echo $sql;	
	}
 
 
	ecs_header("Location:weixin_app.php?action=weixin_reply_list");
    exit;
		
}
if ($_REQUEST['action'] == 'reply_del' ){
	$sql = "DELETE FROM  " . $ecs->table('weixin_reply') . " WHERE id=$id";
    $db->query($sql);
	
	ecs_header("Location:weixin_app.php?action=weixin_reply_list");
}

if ($_REQUEST['action'] == 'good_list_ajax' )
{
	 
	require_once(ROOT_PATH . '/' . ADMIN_PATH . '/includes/lib_goods.php');
    
	$weixin_goods_list = weixin_goods_list();
	 
	 
    $smarty->assign('weixin_goods_list',   $weixin_goods_list['weixin_goods_list']);
    $smarty->assign('filter',       $weixin_goods_list['filter']);
    $smarty->assign('record_count', $weixin_goods_list['record_count']);
    $smarty->assign('page_count',   $weixin_goods_list['page_count']);
	$smarty->assign('item_id',   $item_id);
 
	 
	$smarty->display('weixin_goods_list_ajax.htm');
   
}  

//用户信息列表
if ($_REQUEST['action'] == 'weixin_msg_list' ){
	
	 
	$weixin_list = weixin_msg_list();
  
	 
  
    $smarty->assign('weixin_list',  $weixin_list['weixin_list']);
    $smarty->assign('filter',       $weixin_list['filter']);
    $smarty->assign('record_count', $weixin_list['record_count']);
    $smarty->assign('page_count',   $weixin_list['page_count']);
	
	$smarty->display('weixin_msg_list.htm');
}
//客户回复信息列表
if ($_REQUEST['action'] == 'weixin_msg_reply_ajax' ){

  
    $smarty->assign('msg_id',  $msg_id);
	$smarty->assign('wx_sn',   $wx_sn);
	 
	$smarty->display('weixin_msg_reply_ajax.htm');
	
}
//客户回复信息
if ($_REQUEST['action'] == 'weixin_msg_reply_add' ){

  
	$sql = "INSERT INTO " . $ecs->table('weinxin_msg_reply') . " (msg_id, context)" .
               		 "VALUES ('$msg_id', '$context')";
   	$db->query($sql);
 
 /*
		//获取access_token
		 $ch = curl_init();
		 $appid="wx002bc6fbf8f56c83";
		 $AppSecret="179b7d69d0d80ce0a38f6dd1f0456dd3";
		 
		  
		 	$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$AppSecret;  
			
		
            $ch = curl_init();  
            curl_setopt($ch, CURLOPT_URL,$url);  
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
            $result = curl_exec($ch);  
			curl_close($ch);  
 			 
            $data=json_decode($result,true);  			
            
			$access_token=$data['access_token'];  
			//echo $access_token;
			//echo "<br>";
			$context=str_replace('\"','"',$context);
			$context=str_replace('\\"','"',$context);
			$context=str_replace('\"','"',$context);
		 	$content='
				{
					"touser":"'.$wx_sn.'",
					"msgtype":"text",
					"text":
					{
						 "content":"'.$context.'"
					}
				}
				
			';
			//echo "<br>";
			$url ="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token."";
			$result = vpost($url,$context);
			$result_arr=json_decode($result,TRUE);	
			print_r($result_arr);
	*/
	$weixin_list = weixin_msg_list();
  
	 
  
    $smarty->assign('weixin_list',  $weixin_list['weixin_list']);
    $smarty->assign('filter',       $weixin_list['filter']);
    $smarty->assign('record_count', $weixin_list['record_count']);
    $smarty->assign('page_count',   $weixin_list['page_count']);
	
	$smarty->display('weixin_msg_list.htm');
}
//自定义菜单
 
		
if ($_REQUEST['action'] == 'weixin_menu' ){

 
	 
	if($id!=""){

		//获取access_token
		 $ch = curl_init();
		 $appid="wx002bc6fbf8f56c83";
		 $AppSecret="179b7d69d0d80ce0a38f6dd1f0456dd3";
		 
		  
		 	$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$AppSecret;  
            $ch = curl_init();  
            curl_setopt($ch, CURLOPT_URL,$url);  
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
            $result = curl_exec($ch);  
			curl_close($ch);  
 			 
            $data=json_decode($result,true);  			
            
			$access_token=$data['access_token'];  
			echo $access_token;
			//echo "<br>";
			$context=str_replace('\"','"',$context);
			$context=str_replace('\\"','"',$context);
			$context=str_replace('\"','"',$context);
		 
			//echo "<br>";
			$url ="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token."";
			$result = vpost($url,$context);
			$result_arr=json_decode($result,TRUE);	
			 
			if($result_arr[errmsg]!="ok"){
				print_r($result_arr);
				echo $context;
				exit;
			
			}
		    
	 
	  
 		$sql = "UPDATE " . $ecs->table('weixin_config') . " SET " .
               
                "context = '$context' " .

				"WHERE id=1";	
	 
   		$db->query($sql);	
	}
	$sql = "SELECT * FROM " . $ecs->table('weixin_config') . " WHERE id=1";
    $info = $db->getRow($sql);
	
	$smarty->assign('info', $info);
		 
	$smarty->display('weixin_menu.htm'); 	
}
 
 
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
