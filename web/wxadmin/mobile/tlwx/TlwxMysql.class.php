<?php
class TlwxMysqlAction{
	public function sql(){
		return $this->sql; 
	}
	
	function insert($data,$table_name,$id=0){ 
	
		foreach ($data as $key=>$value) { 
			$sqlfield .= strtolower($key).","; 
			$sqlvalue .= "'".$value."',"; 
		} 
		$sql="INSERT INTO ".$GLOBALS['ecs']->table($table_name)." (".substr($sqlfield, 0, -1).") VALUES (".substr($sqlvalue, 0, -1).")";;	
	   
		$msg=$GLOBALS['db']->query($sql);
		if($id==1){
			$msg=mysql_insert_id(); 
		}
		$this->sql=$sql;
		
		return $msg;
		  
	} 	
	//新修改一条记录 
	function updata($data,$table_name,$where,$sql=0){ 
	
		foreach ($data as $key=>$value) { 
			$sqlud .= $key."= '".$value."',"; 
		} 
		$sql="UPDATE ".$GLOBALS['ecs']->table($table_name)." SET ".substr($sqlud, 0, -1)." ".$where; 
		$this->sql=$sql;
				 
		return $GLOBALS['db']->query($sql);
	} 
	//删除一条记录 
	function delete($table_name,$where){ 
 
		$sql="DELETE FROM ".$GLOBALS['ecs']->table($table_name)."  ".$where; 
		return $GLOBALS['db']->query($sql);
		$this->sql=$sql;
	} 		
	
	
	//获得单行
	function getRow($table_name,$where=""){

			$sql = "SELECT * FROM " . $GLOBALS['ecs']->table(''.$table_name.'') . "  $where";
			$row = $GLOBALS['db']->getRow($sql);
			$this->sql=$sql;
		 	return $row;	
	}
	//存在
	function getCount($table_name,$where=""){

			$sql = "SELECT count(*) AS count FROM " . $GLOBALS['ecs']->table(''.$table_name.'') . "  $where";
			$count = $GLOBALS['db']->getOne($sql);
			$this->sql=$sql;
		 	return $count;	
	}	
 
 
 
 
 
}
?>