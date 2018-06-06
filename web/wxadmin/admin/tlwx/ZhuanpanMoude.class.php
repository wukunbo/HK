<?php
class ZhuanpanMoude extends tlwx{
 
	 
	function lists_data($where)
	{
	
			$filter['sort_by']          = 'id';
			$filter['sort_order']       = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
				
			$where=" 1 ";
		 /* 记录总数 */
			$sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('tlwx_lottery'). "   WHERE $where";
			$filter['record_count'] = $GLOBALS['db']->getOne($sql);
	
			/* 分页大小 */
			$filter = $this->page_size($filter);
	
			$sql = "SELECT * ".
						" FROM " . $GLOBALS['ecs']->table('tlwx_lottery') . 
						" WHERE  $where" .
						" ORDER BY $filter[sort_by] $filter[sort_order] ".
						" LIMIT " . $filter['start'] . ",$filter[page_size]";
	
			
			$lists = $GLOBALS['db']->getAll($sql);
	 		 
			 
	
			return array('lists' => $lists, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
	}	
 	 
}
?>