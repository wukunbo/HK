<?php

/**
 * 获取信息类
 * ============================================================================
 
*/

class TlwxMsgAction{
	/*
	function insert_log($Keyword,$Event,$FromUsername,$MsgId=""){
		//记录到信息表
		if($MsgId){
			$sql = "SELECT id FROM " . $GLOBALS['ecs']->table('tlwx_info') . "  WHERE 1 AND msgid='".$MsgId."'";
			$id=$GLOBALS['db']->getOne($sql); 
			if(!$id){
				$sql = "INSERT INTO " . $GLOBALS['ecs']->table('tlwx_info') . " (context, type, wechat_id,msgid,addtime)" .  "VALUES ('".$Keyword."', '".$Event."', '".$FromUsername."','".$MsgId."','".time()."')";
				$GLOBALS['db']->query($sql); 
			}
		}
		 
	}
	*/
	//获取积分
	function integral($wechat_id){
		$sql = "SELECT pay_points FROM " .$GLOBALS['ecs']->table('users'). " WHERE wechat_id = '$wechat_id'";
   		$detail = $GLOBALS['db']->getRow($sql);
		if($detail){
			 $integral= $$detail['pay_points'] . "  ".$GLOBALS['_CFG']['integral_name'];
		}else{
			$integral="";
		}
		return $integral;
	}
	//送积分
	function plusPoint($wechat_id,$points=0,$type="qiandao",$is_add=1){
		$sql = "UPDATE " .$GLOBALS['ecs']->table('users'). " SET `pay_points` = pay_points+$points WHERE `wechat_id` ='$wechat_id';";
   		$GLOBALS['db']->query($sql);
		$sql = "UPDATE " .$GLOBALS['ecs']->table('tlwx_qiandao_action'). " SET `addtime` = ".time()." WHERE `wechat_id` ='$wechat_id';";
   		$GLOBALS['db']->query($sql);
		
		$GLOBALS['db']-> query("INSERT INTO  ".$GLOBALS['ecs']->table('tlwx_points_log')."  (wechat_id,points,type,is_add,addtime) VALUES ('".$wechat_id."','".$points."','".$type."','".$is_add."',".time()." ) ");
		return true;
	}
	//判断今天是否获取签到积分哦
	function is_qiandao_action($wechat_id){
		$sql = "SELECT addtime FROM " .$GLOBALS['ecs']->table('tlwx_qiandao_action'). "    WHERE `wechat_id` ='$wechat_id'  ";
   		$addtime = $GLOBALS['db']->getOne($sql);
	 	
		if(!$addtime){
			$GLOBALS['db']-> query("INSERT INTO  ".$GLOBALS['ecs']->table('tlwx_qiandao_action')."  (wechat_id,addtime) VALUES ('".$wechat_id."',".time()." ) ");
			return 0;
		}else{
			$dateStr = date("Y-m-d",$addtime);
		 
			$addDate = strtotime($dateStr);
	
			$todayStr = date("Y-m-d",time());
			$toDate = strtotime($todayStr);
			 
			 
			if($addDate==$toDate){
				return 1;
			}else{
				return 0;
			}
		}
	}	
 
 /**
	 * 获得商品信息
	 */	
	function goods_lists($type)
	{
		global $config;
		if($type=="ZDST_HOT"){
			$WHERE_type=" AND `is_hot` = 1  ";
		}
		if($type=="ZDST_PROMOTE"){
			$WHERE_type="  AND `is_promote` = 1 AND promote_start_date <= '".time()."' AND promote_end_date >= '".time()."'  ";
		}
		if($type=="ZDST_BEST"){
			$WHERE_type=" AND `is_best` = 1  ";
		}
		if($type=="ZDST_NEW"){
			$WHERE_type=" AND `is_new` = 1  ";
		}
		 
		  
		$sql= "SELECT goods_name,goods_thumb,goods_id FROM  ".$GLOBALS['ecs']->table('goods')." WHERE `is_on_sale` = 1 AND `is_alone_sale` = 1 AND `is_delete` = 0 ".$WHERE_type." ORDER BY sort_order,last_update DESC LIMIT 0 , 5";
		$lists = $GLOBALS['db']->  getAll($sql);
		if($lists){
			for($i=0;$i<count($lists);$i++){
				$lists[$i][title]	=$lists[$i][goods_name];
				$lists[$i][image]	=$config[domain].$lists[$i][goods_thumb];
				$lists[$i][url]	=$config[url_mobile]."goods.php?id=".$lists[$i][goods_id];
			}
		}
		return $lists;
	}	
	//全部信息列表，无第一条
	function reply_detail($id=-1)
	{
			global $config;	
			$where=" 1 AND id=$id";
			$sql = "SELECT content_id_str ".
						" FROM " . $GLOBALS['ecs']->table('tlwx_msg') . " WHERE  $where" ;
			$detail = $GLOBALS['db']->getRow($sql);
			
	 		$content_id_arr=explode(',',$detail[content_id_str]);
	 		$count=count($content_id_arr);
			$detail="";
	 		for($j=0;$j<$count;$j++){
	 			if($content_id_arr[$j]!=""){
					//获取多圖文信息
	 				$detail[]=$this->content_detail($content_id_arr[$j]);
	 			}
	 		}		 
			return $detail;
	}	
 
/**
	 * 获得圖文信息
	 */	
	function content_detail($id)
	{
			global $config;
			$where=" 1 AND id=".$id."";
			$sql = "SELECT * ".
						" FROM " . $GLOBALS['ecs']->table('tlwx_msg_content') . "  WHERE  $where";
		 
			$row = $GLOBALS['db']->getRow($sql);
			 
				if($row[cata]==2){
					$where=" 1 AND goods_id=".$row[goods_id]."";
					$goods_sql = "SELECT goods_name,goods_thumb,goods_id ".
							" FROM " . $GLOBALS['ecs']->table('goods') . "   WHERE  $where";
				    $goods_row = $GLOBALS['db']->getRow($goods_sql);
				    $row[title]	=$goods_row[goods_name];
				    $row[image]	=$config[domain].$goods_row[goods_thumb];
					$row[goods_id]	=$goods_row[goods_id];
					$row[url]	=$config[url_mobile]."goods.php?id=".$row[goods_id];
				}else{
					if(!$row[url]){
						$row[url]  =$config[domain]."cms.php?&a=detail&id=".$row[id];
					}
					$row[image]  =$config[domain]."wxadmin/".$row[image];
				}
			return $row;
	}		
	/**
	 *通过 获得圖文信息
	 */	
	function keyword_search_reply($title){
 		global $config;
		//优先完全匹配
		
		$wx_id=$_REQUEST["wx_id"];
	 
		$sql="SELECT * FROM " . $GLOBALS['ecs']->table('tlwx_keyword') . " WHERE title='".$title."' AND wx_id='".$wx_id."'  AND match_rule='all' AND keyword_cata='keyword' ORDER BY id desc LIMIT 1";
		 // echo $sql;
		$detail= $GLOBALS['db']->getRow($sql);
		 
		if(!$detail){
			//优先部分匹配
			$sql="SELECT * FROM " . $GLOBALS['ecs']->table('tlwx_keyword') . "WHERE title LIKE '%".$title."%' AND wx_id='".$wx_id."' AND match_rule='part' AND keyword_cata='keyword' ORDER BY id desc LIMIT 1";
			$detail=$GLOBALS['db']->getRow($sql);
			if(!$detail){
				//优先其他类型的回复
				$sql="SELECT * FROM " . $GLOBALS['ecs']->table('tlwx_keyword') . " WHERE title='".$title."' ";
				//echo $sql;
				$detail= $GLOBALS['db']->getRow($sql);	
				if(!$detail){
					//优先其他类型的回复
					$sql="SELECT * FROM " . $GLOBALS['ecs']->table('tlwx_keyword') . " WHERE   keyword_cata='all' AND wx_id='".$wx_id."' ";
					$detail= $GLOBALS['db']->getRow($sql);			
				}		
			}
		}	
		// echo $sql;
	 //	var_dump($detail);
		if($detail[msg_cata]=='txt'){
			$r[data]=$detail[context];
			$r[msg_cata]='txt';
			 
			
		}
		if($detail[msg_cata]=='article'){
			 
			$r[data]=$this->reply_detail($detail[msg_id],$num=0);
			$r[msg_cata]='article';
			 
		}		
		 
		 
		//抽奖
		if($detail[msg_cata]=='Lottery' || $detail[msg_cata]=='Guajiang' || $detail[msg_cata]=='Coupon' || $detail[msg_cata]=='Zadan'){
					 
				$info = $GLOBALS['db']-> getRow("SELECT * FROM ".$GLOBALS['ecs']->table('tlwx_yx_lottery')." WHERE `id` = '$detail[msg_id]' " );
				if ($info == false || $info['status'] == 3) {
					$context="活动可能已经结束或者被删除了";
					$r[data]=$context;
					$r[msg_cata]='txt';
						 
				}else{
					 
					switch ($info['type']) {
						case 1:
							$model = 'Lottery';
							break;
						case 2:
							$model = 'Guajiang';
							break;
						case 3:
							$model = 'Coupon';
							break;
						case 4:
							$model = 'Zadan';
					}
					$id   = $info['id'];
					$type = $info['type'];
					if ($info['status'] == 1) {
						$picurl = $info['starpicurl'];
						$title  = $info['title'];
						$id     = $info['id'];
						$summary   = $info['info'];
					} else {
						$picurl = $info['endpicurl'];
						$title  = $info['endtite'];
						$summary   = $info['endinfo'];
					}
					$data[data][0][title]=$title;
					$data[data][0][image]=$picurl;
					$data[data][0][summary]=$summary;
					$data[data][0][url]=$config[domain]."/market/index.php?g=Wap&m=".$model."&a=index&type=".$info[type]."&id=".$info[id]."&token=".$info[token]."";
					$r[data]=$data[data];
					$r[msg_cata]='article';
				}
					 
		}		
		/*
		搜索商品
		$thistable = $db -> prefix . 'goods';
                $goods_name = $keyword;
                $ret = $db -> getAll("SELECT * FROM  `$thistable` WHERE  `goods_name` LIKE '%$goods_name%' LIMIT 0,5");
                $ArticleCount = count($ret);
                if($ArticleCount >= 1){
                    foreach($ret as $v){
                        $v['thumbnail_pic'] = $base_url . $v['goods_img'];
                        $goods_url = $m_url . build_uri('goods', array('gid' => $v['goods_id']), $v['goods_name']);
                        $items .= "<item>
                 <Title><![CDATA[" . $v['goods_name'] . "]]></Title>
                 <PicUrl><![CDATA[" . $v['thumbnail_pic'] . "]]></PicUrl>
                 <Url><![CDATA[" . $goods_url . "]]></Url>
                 </item>";
                    }
                    $msgType = "news";
                }else{
                    $msgType = "text";
                    $thistable = $db -> prefix . 'goods';
                    $ret = $db -> getAll("SELECT * FROM  `$thistable` WHERE  `is_best` =1");
                    $tj_count = count($ret);
                    $tj_key = mt_rand(0, $tj_count);
                    $tj_goods = $ret[$tj_key];
                    $tj_str = $this -> plusTj($db, $m_url);
                    $contentStr = '没有搜索到"' . $goods_name . '"的商品' . $tj_str;
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                    exit;
                }
                $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType, $ArticleCount, $items);
                echo $resultStr;
                exit;
				*/
		return $r;
		//或取
	
	}	

}	
?>