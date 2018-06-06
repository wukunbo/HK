<?php

/**
 * 获取信息类
 * ============================================================================
 
*/

class TlwxReplyAction{
	 
	function reply($Keyword,$Event,$FromUsername,$MsgId="",$weixin="")
	{
		global $config;
		
		$weixin = new WeixinAction;
		
	 	$tlwxmsg=new TlwxMsgAction;
		//插入记录
		$tlwxmsg->insert_log($Keyword,$Event,$FromUsername,$MsgId);
		//绑定 注册步骤，1，开始，2，用户名已填，3，密码已填。steptime，时间，10分钟
		$user = $GLOBALS['db']-> getRow("SELECT step,steptime FROM ".$GLOBALS['ecs']->table('tlwx_user')." WHERE `openid` = '$FromUsername' AND (step>0 AND step <3 )" );
		$step=$user[step];
		 
		if($user){
			//十分钟有效
			$t=$user[steptime]+6000;
			 
			if($t<time()){
				$data="时间已失效，请重新输入“绑定”";
				 
			}else{
				//用户名绑定
				if($step==1){				 
					$user_name = $GLOBALS['db']-> getOne("SELECT user_name FROM ".$GLOBALS['ecs']->table('users')." WHERE `user_name` = '$Keyword'" );
					if(empty($user_name)){
                        $data = '您输入的用户名不存在，检查之后请重新输入：' . $Keyword;
                    }else{
						$r = $GLOBALS['db']-> getOne("SELECT `user_name` FROM ".$GLOBALS['ecs']->table('users')." WHERE `user_name` = '$Keyword' AND wechat_id='$FromUsername'");
                        if($r){
                            $data = $Keyword . '已经被其他用户绑定了，请绑定其他账号';
                        }else{
							//用户名绑定成功
                       	 	$GLOBALS['db']-> query("UPDATE  ".$GLOBALS['ecs']->table('tlwx_user')."  SET `step`=`step`+1,steptime=".time()." WHERE `openid`= '$FromUsername' ");
							//绑定OPENID
							$GLOBALS['db']-> query("UPDATE  ".$GLOBALS['ecs']->table('users')."  SET `wechat_id`='$FromUsername' WHERE `user_name`= '$Keyword' ");
							$data = '请输入密码';
						} 
					}				
				}
				//密码验证
				if($step==2){
					 $password = md5(trim($Keyword));
					 $user_name = $GLOBALS['db']-> getOne("SELECT user_name FROM ".$GLOBALS['ecs']->table('users')." WHERE `password` = '$password' AND wechat_id='$FromUsername'" );
					 if(empty($user_name)){
					 	//失败
						$data = '您输入的密码不正确，请重新输入';
					 }else{
					 	//密码验证成功
						$GLOBALS['db']-> query("UPDATE  ".$GLOBALS['ecs']->table('tlwx_user')."  SET `step`=`step`+1 WHERE `openid`= '$FromUsername' ");
						$data = $user_name . '，您的账号已经绑定成功！,若需解除绑定，请输入"解除"';
					 }
				}
			}
			//返回信息
			$weixin->responseText($data);
			exit;
		}
		
		switch ($Keyword){
			//我的积分
			case 'ZDST_JF':
				$integral=$tlwxmsg->integral($FromUsername);
				if($integral){
					$data="你的积分是".$integral;
				}else{
					$data="你的积分是0";
					//$data="你尚未绑定帐号，请输入“绑定”";
				} 
				$weixin->responseText($data);
				 break;	
			//自动获取热卖商品信息
			case 'ZDST_HOT':
				$data=$tlwxmsg->goods_lists("ZDST_HOT");
				$weixin->responseMsg($data);
				 break;	
			//自动获取推荐商品信息 
			case 'ZDST_PROMOTE':
				$data=$tlwxmsg->goods_lists("ZDST_PROMOTE");
				$weixin->responseMsg($data);
				 break;	
			//自动获取精品商品信息 
			case 'ZDST_BEST':
				$data=$tlwxmsg->goods_lists("ZDST_BEST");
				$weixin->responseMsg($data);
				 break;	
			//自动获取新品商品信息 
			case 'ZDST_NEW':
				$data=$tlwxmsg->goods_lists("ZDST_NEW");
				$weixin->responseMsg($data);
				 break;	
			//自动签到送积分
			case 'ZDST_QD':
				//判断今天是否获取了签到积分
				$is=$tlwxmsg->is_qiandao_action($FromUsername);
				if($is){
					$data="今天，您已签到。";
				}else{
					$points=$config[points_qiandao];
					 
					if($points){
						$data=$tlwxmsg->plusPoint($FromUsername,$points,$type="qiandao");
						$data="恭喜你获得了".$points. " ".$GLOBALS['_CFG']['integral_name'];
					}else{
						$data="系统尚未设置签到积分。";
					}
				}
				$weixin->responseText($data);
				break;	
			//自动注册
			case '绑定':
				$user = $GLOBALS['db']-> getRow("SELECT step,steptime FROM ".$GLOBALS['ecs']->table('tlwx_user')." WHERE `openid` = '$FromUsername' " );
				 if(empty($user)){
				 	 $GLOBALS['db']-> query("INSERT INTO  ".$GLOBALS['ecs']->table('tlwx_user')."  (openid,step,steptime) VALUES ('".$FromUsername."','1',".time()." ) ");
				 	 $data = '您已进入会员绑定流程，想要退出绑定流程请回复 取消,继续请输入网站会员昵称';
				 }else{
				 	if($user[step]==3){
						$data = '该微信号已绑定。';
					}else{
						$GLOBALS['db']-> query("UPDATE  ".$GLOBALS['ecs']->table('tlwx_user')."  SET `setp`=1, steptime=".time()." WHERE `openid`= '$FromUsername' ");
						$data = '您已进入会员绑定流程，想要退出绑定流程请回复 取消,继续请输入网站会员昵称';
					}
				 }
                 
               //返回信息
				$weixin->responseText($data);
                break;		
			//取消绑定流程
			case '取消':
				$GLOBALS['db']-> query("UPDATE  ".$GLOBALS['ecs']->table('tlwx_user')."  SET `setp`=0, steptime=".time()." WHERE `openid`= '$FromUsername' ");
                 break;	
			case '解除':
				$GLOBALS['db']-> query("UPDATE  ".$GLOBALS['ecs']->table('tlwx_user')."  SET `setp`=0, steptime=".time()." WHERE `openid`= '$FromUsername' ");
				$GLOBALS['db']-> query("UPDATE  ".$GLOBALS['ecs']->table('users')."  SET `wechat_id`=NULL  WHERE `openid`= '$FromUsername' ");
                 break;
			//关键字回复
			default:
			  
				$data=$tlwxmsg->keyword_search_reply($title=$Keyword);
			 	var_dump($data);
				 print_r($data);				
				if($data[msg_cata]=='txt'){
					$weixin->responseText($data[data]);
				}
				if($data[msg_cata]=='article'){
					$weixin->responseMsg($data[data]);
				}
				
				 
				//抽奖结束
		} 
		  
	}	
 
	 

}	
?>