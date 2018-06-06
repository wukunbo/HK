<?php
class MenuMoude extends tlwx{
 /*
	 * 获得自定义菜单列表
 	 get_sub=1;
	 */ 
	 function menu_list($get_sub=1,$ajax=0,$wx_id=0){
	 	$this->wx_id=$_SESSION[userweb][wx_id];
	 
		$this->wx_where=" AND wx_id='".$wx_id."'";
	 	 
			$sql = "SELECT *  ".
						" FROM " . $GLOBALS['ecs']->table('tlwx_menu') . " " .
						" Where parent_id=0 ".$this->wx_where."".
						" ORDER BY listorder ";
			$row = $GLOBALS['db']->getAll($sql);
	 	//	echo $sql;
			$count=count($row);
			for($i=0;$i<$count;$i++){
				$row[$i][parent_title]=$this->getOne("title",'tlwx_menu',"Where id=".$row[$i][id]."");
				if($get_sub==1){
					$sql = "SELECT *  ".
								" FROM " . $GLOBALS['ecs']->table('tlwx_menu') . " " .
								" Where parent_id=".$row[$i][id].
								" ORDER BY listorder ";		 
					$row_sub = $GLOBALS['db']->getAll($sql);
					if(count($row_sub)!=""){
						$row[$i][sub]=$row_sub;
					}
				}			
				 
			}
			return  $row;
	 }
 	 
}
?>