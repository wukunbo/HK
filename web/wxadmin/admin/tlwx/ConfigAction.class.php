<?php
class ConfigAction extends tlwx{
	public function __construct(){ 
		$this->user_id=$_SESSION[userweb][userid];
		$this->user_where=" AND user_id='".$this->user_id."'";
	}
	public function index(){ 
 		 
		$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('tlwx_config') . " WHERE 1 ".$this->user_where.""; 
		 
		$info = $GLOBALS['db']->getRow($sql);
		if($info[id]==""){
			$token=token_rand(12);
			$sql = "INSERT INTO " . $GLOBALS['ecs']->table('tlwx_config') . "(token,user_id)" .
							 "VALUES ('".$token."','".$this->user_id."')";
			
			$GLOBALS['db']->query($sql);
					 
		}
		$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('tlwx_config') . " WHERE 1 ".$this->user_where."";
		$detail = $GLOBALS['db']->getRow($sql);
		
		
		$GLOBALS['smarty']->assign('detail',       $detail);	
		$GLOBALS['smarty']->display('Config_index.htm');
		 
	}
	public function setting(){ 
 
		$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('tlwx_config') . " WHERE 1 ".$this->user_where."";
		$info = $GLOBALS['db']->getRow($sql);
		if($info[id]==""){
			$token=token_rand(12);
			$sql = "INSERT INTO " . $GLOBALS['ecs']->table('tlwx_config') . "(token)" .
							 "VALUES ('".$token."')";
			$GLOBALS['db']->query($sql);
					 
		}
		$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('tlwx_config') . " WHERE 1 ".$this->user_where."";
		$detail = $GLOBALS['db']->getRow($sql);
		$GLOBALS['smarty']->assign('detail',       $detail);	
		$GLOBALS['smarty']->display('Config_setting.htm');
		 
	}	
	public function insert_updata(){
		$request=$this->request();
		$data=$request[data];
		//var_dump($_FILES);
		$s1=$this->Upload("../../Uploads/weixin/","sslcert_path");	
		$s2=$this->Upload("../../Uploads/weixin/","sslkey_path");
		$s3=$this->Upload("../../Uploads/weixin/","ca_path");	
		
		if($s1[url]){
			$data[sslcert_path]="".$s1[url];
		}
		if($s2[url]){
			$data[sslkey_path]="".$s2[url];
		}
		if($s3[url]){
			$data[ca_path]="".$s3[url];
		}
		
 
		
		 
	 	$s=$this->updata($data,"tlwx_config","where 1 ".$this->user_where."",1);
		if($request[type]){
			$a=$request[type];
		}else{
			$a="index";
		}
 
		//更新缓存
		$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('tlwx_config') . " WHERE 1 ".$this->user_where."";
		$detail = $GLOBALS['db']->getRow($sql);
		write_static_cache('tlwx_config', $detail);
		
		$this->succes("修改成功","tlwx.php?m=Config&a=".$a."");
		 
	}	 	
}
			 
?>