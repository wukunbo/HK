<?php
class KeywordMoude extends tlwx{
	public function __construct(){
		$this->wx_id=$_SESSION[userweb][wx_id];
		$this->wx_where=" AND wx_id='".$this->wx_id."'";
	 
	}
 /**
	 * 获得回复规则
	 *
	 * @access  public
	 * @params  integer $isdelete
	 * @params  integer $real_goods
	 * @params  integer $conditions
	 * @return  array
	 */
	function rule_list($where)
	{
		
			$filter['sort_by']          = empty($_REQUEST['sort_by']) ? 'id' : trim($_REQUEST['sort_by']);
			$filter['sort_order']       = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
			 
		 /* 记录总数 */
			$sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('tlwx_rule'). " AS g WHERE 1 $where";
			$filter['record_count'] = $GLOBALS['db']->getOne($sql);
	
			/* 分页大小 */
			$filter = $this->page_size($filter);
	
			$sql = "SELECT * ".
						" FROM " . $GLOBALS['ecs']->table('tlwx_rule') . " WHERE  1 $where" .
						" ORDER BY $filter[sort_by] $filter[sort_order] ".
						" LIMIT " . $filter['start'] . ",$filter[page_size]";
	
			
			$row = $GLOBALS['db']->getAll($sql);
		 
			for($i=0;$i<count($row);$i++){
					$keyword_id_arr=explode(',',$row[$i][keyword_id_str]);
					$row[$i][keyword_count]=count($keyword_id_arr);
					for($j=0;$j<count($keyword_id_arr);$j++){
						if($keyword_id_arr[$j]!=""){
							//获取关键字信息，及回复内容
							$row[$i][keyword][]=$this->keyword_detail($keyword_id_arr[$j]); 
						}
					}
			}
	 
	
			return array('lists' => $row, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
	}
	function keyword_detail($id)
	{
		if($id!=""){
			$where=" 1 AND id=$id";
			$sql = "SELECT * ".
						" FROM " . $GLOBALS['ecs']->table('tlwx_keyword') . " WHERE  $where";
			$detail = $GLOBALS['db']->getRow($sql);
		 	//多图文列表
			if($detail[msg_cata]=='article'){
				 
				 
				require_once(ROOT_PATH . '/' . ADMIN_PATH . '/tlwx/ReplyMoude.class.php');
				$relpy=new ReplyMoude();
				$detail[msg]=$relpy->reply_detail($detail[msg_id],$num=1);
			} 
			return $detail;
		}else{
			return false;
		}
	}	
}
?>