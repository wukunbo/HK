<?php
class ReplyMoude extends tlwx{
/**
	 * 获得商品列表
	 *
	 * @access  public
	 * @params  integer $isdelete
	 * @params  integer $real_goods
	 * @params  integer $conditions
	 * @return  array
	 */
	function goods_lists()
	{
	
			$filter['sort_by']          = empty($_REQUEST['sort_by']) ? 'goods_id' : trim($_REQUEST['sort_by']);
			$filter['sort_order']       = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
				
			$where=" 1 AND is_on_sale =1";
		 /* 记录总数 */
			$sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('goods'). " AS g WHERE $where";
			$filter['record_count'] = $GLOBALS['db']->getOne($sql);
	
			/* 分页大小 */
			$filter = $this->page_size($filter);
	
			$sql = "SELECT goods_id , goods_name , goods_thumb  ".
						" FROM " . $GLOBALS['ecs']->table('goods') . "   WHERE  $where" .
						" ORDER BY $filter[sort_by] $filter[sort_order] ".
						" LIMIT " . $filter['start'] . ",$filter[page_size]";
	
	
			$row = $GLOBALS['db']->getAll($sql);
	
			return array('goods_lists' => $row, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
	} 	 
	//回复内容,含多圖文
	/*
	返回多数组
		data[msg_id]
		data[id]		
		data[content]
	*/
	function reply_detail($id=-1,$num=0)
	{
	
			 
				
			$where=" 1 AND id=$id";
	
			$sql = "SELECT id AS msg_id,reply_type,addtime AS msg_addtime,content_id_str ".
						" FROM " . $GLOBALS['ecs']->table('tlwx_msg') . " WHERE  $where" ;
						 
			
			$detail = $GLOBALS['db']->getRow($sql);
			
	 		$content_id_arr=explode(',',$detail[content_id_str]);
	 		$t_count=count($content_id_arr);
 
	 		$s=$detail;
			//第一条信息
	 		$detail=$this->content_detail($content_id_arr[0]);
	 		$detail[msg_id]=$s[msg_id];
	 		$detail[msg_addtime]=$s[msg_addtime];	
			$detail[reply_type]=$s[reply_type];		
	 		$detail[num]=$t_count;		
	 		  
	 		if($num==1){
 
	 		}else{
	 			for($j=1;$j<$t_count;$j++){
	 				if($content_id_arr[$j]!=""){
						//获取多圖文信息
	 					$detail[content][]=$this->content_detail($content_id_arr[$j]);
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
		if($id){
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
				    $row[image]	=$goods_row[goods_thumb];
					$row[goods_id]	=$goods_row[goods_id];
					$row[url]	="goods.php?id=".$row[goods_id];
				}
			return $row;
		}else{
			return false;
		}
	}		
	//回复列表
	/*
	样式
	Array ( [lists] => Array ( [0] => Array ( [id] => 108 [goods_id] => [title] => asdfasddf [author] => asdfasd [summary] => asdfsadf [image] => upload//20140524041605.jpg [image_thumb] => [context] =>asdfasdf
	[cata] => [url] => [addtime] => 2014-05-26 14:10:57 [msg_id] => 56 [msg_addtime] => 2014-05-26 14:41:56 [reply_type] => more [num] => 4 ) ) [page_count] => 1 [record_count] => 1 ) 
	*/
	function reply_list($num=2)
	{
	
			$filter['sort_by']          = 'id';
			$filter['sort_order']       = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
				
			$where=" 1 ";
		 /* 记录总数 */
				$sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('tlwx_msg'). " AS g WHERE $where";
			$filter['record_count'] = $GLOBALS['db']->getOne($sql);
	
			/* 分页大小 */
			$filter = $this->page_size($filter);
	
			$sql = "SELECT id AS msg_id,reply_type AS reply_type,addtime AS msg_addtime,content_id_str ".
						" FROM " . $GLOBALS['ecs']->table('tlwx_msg') . " WHERE  $where" .
						" ORDER BY $filter[sort_by] $filter[sort_order] ".
						" LIMIT " . $filter['start'] . ",$filter[page_size]";
	
			
			$row = $GLOBALS['db']->getAll($sql);
	 		 
			for($i=0;$i<count($row);$i++){
				 
					$content_id_arr=explode(',',$row[$i][content_id_str]);
					$t_count=count($content_id_arr);
					if($num>1){
						$count=count($content_id_arr);
						 
					}else{
						$count=$num;
					}
					$s=$row[$i];
					$row[$i]=$this->content_detail($content_id_arr[0]);
					$row[$i][msg_id]=$s[msg_id];
					$row[$i][msg_addtime]=$s[msg_addtime];		
					$row[$i][reply_type]=$s[reply_type];		
					$row[$i][num]=$t_count;		
			 
					if($count==1){
 
					}else{
						for($j=1;$j<$count;$j++){
							if($content_id_arr[$j]!=""){
								$row[$i][content][]=$this->content_detail($content_id_arr[$j]);
							}
						}
					}
					 
				 	
			}
	 
	
			return array('lists' => $row, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
	}	
	 	
}
?>