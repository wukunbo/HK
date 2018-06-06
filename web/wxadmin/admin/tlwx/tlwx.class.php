<?php
class tlwx{
	public function __construct(){
		//$sql = "SELECT web_name FROM tl_config where id=1";
		//$row = $GLOBALS['db']->getRow($sql);
	//	$config[page_title]=$row['web_name'];
		$GLOBALS['smarty']->assign("config",$config);
	}
	public function sql(){
		return $this->sql; 
	}
 	public function request(){
		//接收参数值
	 	foreach($_REQUEST as $_k=>$_v){
			 if( strlen($_k)>0 && preg_match('(cfg_|GLOBALS)',$_k) && !isset($_COOKIE[$_k]) ){
				exit('Request var not allow!');
			 }else{
			 	$request[$_k]=$_v;
			 }
		}
		return $request;
    }
 	public function display($tpl=0){
		if($tpl){
			$GLOBALS['smarty']->display($tpl);
		}else{
		 
			$GLOBALS['smarty']->display($GLOBALS['m'].'_'.$GLOBALS['a'].'.htm');			 
		}
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
		 	return $row;	
	}
	//获得多行
	function getListAll($table_name,$where){

			$filter['sort_by']          = empty($_REQUEST['sort_by']) ? 'id' : trim($_REQUEST['sort_by']);
			$filter['sort_order']       = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
				
			$where=" 1 AND type =$type";
		 /* 记录总数 */
			$sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('$table_name'). " AS g WHERE $where";
			$filter['record_count'] = $GLOBALS['db']->getOne($sql);
	
			/* 分页大小 */
			$filter = $this->page_size($filter);
	
			$sql = "SELECT * ".
						" FROM " . $GLOBALS['ecs']->table('$table_name') . "   WHERE  $where" .
						" ORDER BY $filter[sort_by] $filter[sort_order] ".
						" LIMIT " . $filter['start'] . ",$filter[page_size]";
	
	
			$row = $GLOBALS['db']->getAll($sql);
 
	
			return array('list' => $row, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
	}	
	/*JSON转化 
		$data:数据
		$info:信息
		$result：状态 0 失败，1成功
	*/
	function json($data,$info,$result){ 
 		header('Content-Type:text/html; charset=utf-8');
		$arr[data]=$data;
		$arr[info]=$info;
		$arr[status]=$result;
		exit(json_encode($arr));
		 
	} 		
	
// 编辑器
	 
	function tep_draw_textarea_fck($name,$id, $wrap, $width, $height, $text = '', $parameters = '', $reinsert_value = true) {
			require("tlwx_templates/FCK/fckeditor.php"); 
			$sBasePath = $_SERVER['PHP_SELF'] ;
			$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;
			
			$oFCKeditor = new FCKeditor($name,$id) ;
			$oFCKeditor->BasePath	= "tlwx_templates/FCK/" ;
			
			$oFCKeditor->Height		= $height ;
			$oFCKeditor->Width		= $width ;
			$oFCKeditor->Value		= $text ;
			return $oFCKeditor->CreateHtml() ;
	}			
	 
	  
	/**
	 * 获取单字段
	 *
	 */ 
	 function getOne($item,$tbname,$where){
			$sql = "SELECT $item  ".
						" FROM " . $GLOBALS['ecs']->table($tbname) . " " .
						$where ;
			$info = $GLOBALS['db']->getOne($sql);
			return $info;
	 }	 
	/**
	 * 分页的信息加入条件的数组
	 *
	 */
	function page_size($filter)
	{
		if (isset($_REQUEST['page_size']) && intval($_REQUEST['page_size']) > 0)
		{
			$filter['page_size'] = intval($_REQUEST['page_size']);
		}
		elseif (isset($_COOKIE['ECSCP']['page_size']) && intval($_COOKIE['ECSCP']['page_size']) > 0)
		{
			$filter['page_size'] = intval($_COOKIE['ECSCP']['page_size']);
		}
		else
		{
			$filter['page_size'] = 15;
		}
	
		/* 每页显示 */
		$filter['page'] = (empty($_REQUEST['page']) || intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);
	
		/* page 总数 */
		$filter['page_count'] = (!empty($filter['record_count']) && $filter['record_count'] > 0) ? ceil($filter['record_count'] / $filter['page_size']) : 1;
	
		/* 边界处理 */
		if ($filter['page'] > $filter['page_count'])
		{
			$filter['page'] = $filter['page_count'];
		}
	
		$filter['start'] = ($filter['page'] - 1) * $filter['page_size'];
	
		return $filter;
	}
	
	function error($msg,$time=1)
	{	
			echo $msg;
			 
			exit;
	 
	}	
	function succes($msg,$url=-1,$time=1)
	{	
			  
			$url = $url;  
			$GLOBALS['smarty']->assign('msg',       $msg);	
			$GLOBALS['smarty']->assign('url',       $url);	
   			$GLOBALS['smarty']->display('succes.html');
			exit;
			 
	 
	}		
	/******************************************************************
	* PHP截取UTF-8字符串，解决半字符问题。
	* 英文、数字（半角）为1字节（8位），中文（全角）为3字节
	* @return 取出的字符串, 当$len小于等于0时, 会返回整个字符串
	* @param $str 源字符串
	* $len 左边的子串的长度
	****************************************************************/
	function utf_substr($str,$len,$LeiXing=0)
	{
		if($len<strlen($str) && $LeiXing==1) $len=$len-4;
		for($i=0;$i<$len;$i++){
			$temp_str=substr($str,0,1);
			if(ord($temp_str) > 127){
				$i++;
				if($i<$len){
					$new_str[]=substr($str,0,3);
					$str=substr($str,3);
				}
			}else{
				$new_str[]=substr($str,0,1);
				$str=substr($str,1);
			}
		}
		$s=join($new_str);
		if($len<strlen($str) && $LeiXing==0) $s.="…";
		return $s;
	}	
	
/*简单图片上传
	调用的地方直接用这个：
	$image = Upload('../images/photo/');就可以了！
*/	
	function Upload($uploaddir,$file){
	        $tmp_name =$_FILES[$file]['tmp_name'];  // 文件上传后得临时文件名
	        $name     =$_FILES[$file]['name'];     // 被上传文件的名称
	        $size     =$_FILES[$file]['size'];    //  被上传文件的大小
	        $type     =$_FILES[$file]['type'];   // 被上传文件的类型
			$dir      = $uploaddir.$type."/".date("Ym");
			
			$s=explode(".",$name);
			$count=count($s)-1;
			$extendname = $s[$count]; 	
			 
			$dir	  = $uploaddir;
			if(!file_exists($dir)){
				mkdir($dir);		
			}
			 		
			$s=rand();
	        //$name= date("YmdHis").$s.".".$extendname;
			$name= $file."-".date("YmdHis")."-".uniqid().".".$extendname;
		 
	     //   @chmod($dir,0777);//赋予权限
	       // @is_dir($dir) or mkdir($dir,0777);
	        //chmod($dir,0777);//赋予权限
			 
	        $s=move_uploaded_file($_FILES[$file]['tmp_name'],$dir."/".$name);
			//var_dump($_FILES[$file]['tmp_name']);
			//move_uploaded_file($_FILES['post_image_0']['tmp_name'][$i],$TuPian_ab[$i]);
	        $type = explode(".",$name);
	        $type = @$type[1];
	        $date   = date("YmdHis");
	        //$rename = @rename($dir."/".$name,$dir."/".$date.".".$type);
	        if($s)
	        {
	         	$data[url]=str_replace("../","",$dir."/".$name);
				$data[type]=$type;
				$data[status]=1;
				return $data;
	        }else{
				$data[status]=0;
				return $data;
			}
	}
 	
// 或取
	function curlGet($url){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			$data=json_decode($result,true);
			return $data;	
		/*$ch = curl_init();
		$header = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		$data=json_decode($result,true);  		
		return $data;
		*/
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
}
?>