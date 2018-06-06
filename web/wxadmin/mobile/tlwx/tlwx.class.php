<?php

/**
 * 获取信息类
 * ============================================================================
 
*/

class tlwx{
	//全部信息列表，无第一条
	function reply_detail($id=-1)
	{
	
			global $config;
				
			$where=" 1 AND id=$id";
	
			$sql = "SELECT id AS msg_id,reply_type,addtime AS msg_addtime,content_id_str ".
						" FROM " . $GLOBALS['ecs']->table('tlwx_msg') . " WHERE  $where" ;
						 
			
			$detail = $GLOBALS['db']->getRow($sql);
			
	 		$content_id_arr=explode(',',$detail[content_id_str]);
	 		$count=count($content_id_arr);
	 		if($num==1){
 
	 		}else{
	 			for($j=0;$j<$count;$j++){
	 				if($content_id_arr[$j]!=""){
						//获取多圖文信息
	 					$lists[]=$this->content_detail($content_id_arr[$j]);
	 				}
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
						$row[url]  =$config[url_mobile]."tlwx.php?m=arctilce&a=detail&id=".$row[id];
					}
					$row[image]  =$config[domain].$row[image];
				}
			return $row;
	}		
	/**
	 *通过 获得圖文信息
	 */	
	function keyword_search_reply($title){
		//$sql = "INSERT INTO " . $ecs->table('tlwx_msg') . " (user_id, wx_sn, context)" . 	 "VALUES ('".$_COOKIE[wx_user_id]."', '$FromUsername', '$Keyword')";
		//$db->query($sql);
		//$Keyword=1;
		//优先完全匹配
		$sql="SELECT * FROM " . $ecs->table('tlwx_keyword') . " WHERE title='".$title."' AND match_rule='all' AND keyword_cata='keyword' ORDER BY id desc LIMIT 1";
		$detail= $db->getRow($sql);
		if($detail){
			//优先部分匹配
			$sql="SELECT * FROM " . $ecs->table('tlwx_keyword') . "WHERE title LIKE '%".$Keyword."%' AND match_rule='part' AND keyword_cata='keyword' ORDER BY id desc LIMIT 1";
			$detail= $db->getRow($sql);
			if($detail){
				//优先自动回复
				$sql="SELECT * FROM " . $ecs->table('tlwx_keyword') . " WHERE id=2 AND keyword_cata='all'";
				$detail= $db->getRow($sql);			
			}
		}	
		if($detail[msg_cata]=='txt'){
			$r[data]=$detail[msg_cata];
			$r[cata]='txt';
			 
			
		}
		if($detail[context_cata]=='article'){
			$tlwx=new tlwx();
			$r[data]=$tlwx->reply_detail($detail[msg_id],$num=0);
			$r[cata]='txt';
			 
		}		
		return $r;
		//或取
	
	}	

}	
?>