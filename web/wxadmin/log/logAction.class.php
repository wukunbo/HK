<?php
/*
require('log/logAction.class.php');

$logAction= new logAction;
$logAction->add();
*/

date_default_timezone_set("PRC");
class logAction{
	public function add($filename="",$data=""){
		// 打开b.php文件，这里采用的是a+，也可以用a，a+为可读可写，a为只写，如果b.php不能存在则会创建它
		if($filename){
			$filename=$filename."-".date("Ymd");
		}else{
			$filename=date("Ymd");
		}
		$filename=dirname(__FILE__).'/txt/'.$filename.".txt";
		 
		$file = fopen($filename, 'a'); // a模式就是一种追加模式，如果是w模式则会删除之前的内容再添加
		// 获取需要写入的内容
		$url_self='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
		$s="页面：".$url_self."；时间：".date("Y-m-d h:i:s")."\r\n";
		$r="";
		if(!$data){
			 
			foreach($_REQUEST as $_k=>$_v){
				 if( strlen($_k)>0 && preg_match('/^(cfg_|GLOBALS)/i',$_k) && !isset($_COOKIE[$_k]) ){
					exit('Request var not allow!');
				 }else{
					$r.=$_k.":".$_v."\r\n";
				 } 
			}
			if($r){
				$s.="参数：\r\n";
				$s.=$r;
			} 
		}else{
			if(is_array($data)){
				foreach($data as $_k=>$_v){
					$r.=$_k.":".$_v."\r\n"; 
				}
			}else{
				$r=$data;
			}
			$s.="参数：\r\n";
			$s.=$r;
		}			
		 
		$xml = file_get_contents('php://input');
		if($xml){
			$s.="xml：\r\n";
			$s.=$xml;
		} 
		$s.="－－－－－－－－－－－－－－－－－结束－－－－－－－－－－－－－－－－－－－";
		$s.="\r\n";
		// 写入追加的内容
		 
		fwrite($file, "\xEF\xBB\xBF".$s);
	 
		// 关闭b.php文件
		fclose($file);
		// 销毁文件资源句柄变量
		unset($file);	
	}
}
?>