<?php
class tlwx{
	public function sql(){
		return $this->sql; 
	}
	
	function insert($data,$table_name,$id=0){ 
	
		foreach ($data as $key=>$value) { 
			$sqlfield .= $key.","; 
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
	function getRow($table_name,$where){

			$sql = "SELECT * FROM " . $GLOBALS['ecs']->table(''.$table_name.'') . "  $where";
			$row = $GLOBALS['db']->getRow($sql);
			$this->sql=$sql;
		 	return $row;	
	}
	//存在
	function getCount($table_name,$where){

			$sql = "SELECT count(*) AS count FROM " . $GLOBALS['ecs']->table(''.$table_name.'') . "  $where";
			$count = $GLOBALS['db']->getOne($sql);
			$this->sql=$sql;
		 	return $count;	
	}	
		
	function get_config(){
		$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('tlwx_config') . " WHERE id=1";
		$detail = $GLOBALS['db']->getRow($sql);
		 
		return $detail;
	}
	function get_access_token(){
	 
		$detail = $this->get_config();
		$url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$detail['appid'].'&secret='.$detail['appsecret'];
		 
		$data_token=$this->curlGet($url);
	 
		return $data_token;
	}
	
	 // 或取
	function curlGet($url){
	 
		$curl = curl_init();
		$header = "Accept-charset: utf-8";
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		//curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
		//curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		 

		$result = curl_exec($curl);

		$data=json_decode($result,true);  		
			
			
		return $data;
	}	
	//提交资料 post_data
	function post_data($url,$data){ // 模拟提交数据函数
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
		$result = curl_exec($curl); // 执行操作
		if (curl_errno($curl)) {
		   echo 'Errno'.curl_error($curl);//捕抓异常
		}
		curl_close($curl); // 关闭CURL会话
		$data=json_decode($result,true);  		
		return $data;
	}		
	function objectToArray($e){
		$e=(array)$e;
		foreach($e as $k=>$v){
			if( gettype($v)=='resource' ) return;
			if( gettype($v)=='object' || gettype($v)=='array' )
				$e[$k]=(array)$this->objectToArray($v);
		}
		return $e;
	} 	
}
?>