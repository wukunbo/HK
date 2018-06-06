<?php
class MaterialAction extends tlwx{
	public function __construct(){ 
		$this->wx_id=$_SESSION[userweb][wx_id];
		$this->user_id=$_SESSION[userweb][userid];
		$this->wx_where=" AND wx_id='".$this->wx_id."'";
		$this->user_where=" AND user_id='".$this->user_id."'";
		
		 
		$comm=$this->comm();
	}
    public function comm(){
		$comm[m]=$_REQUEST[m];
		$comm[a]=$_REQUEST[a];
		return $comm;
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
	public function lists(){ 
		$request=$this->request();
		$comm=$this->comm();
		$comm[ajax_title]="图片库";
		$where="WHERE 1 ".$this->user_where."";
		if($request[cata]){
			$where.="  AND cata='".$request[cata]."'";
		}
		$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('tlwx_material') . " ".$where."";
		//echo $sql;
		$lists = $GLOBALS['db']->getAll($sql);
		//var_dump($lists);
	 	$GLOBALS['smarty']->assign('comm',    $comm);
		$GLOBALS['smarty']->assign('lists',    $lists);
		if($request[ajax]==1){
			$comm[ajax]="ajax";
			$GLOBALS['smarty']->assign('comm',    $comm);
		}
		if($request[to]){
			if($request[ajax]==1){
				$this->display("Material_lists_".$request[to]."_ajax.htm"); 
			}else{
				$this->display("Material_lists_".$request[to].".htm"); 
			}
		}else{
			$this->display(); 
		}
	}
	public function insert_update(){ 
		$s=$this->Upload("../upload/weixin/","ajax_image");	
		if($s[type]=="jpg" || $s[type]=="png" || $s[type]=="jpge"){
			$data[cata]="image";
		}
		
		if($s[status]){
			$data[img_orogin]=$s[url];
			$data[wx_id]=$this->wx_id;
			$data[user_id]=$this->user_id;
			$data[img_thumb]=$s[url];		
			$id=$this->insert($data,"tlwx_material",1);
			if($id){
				$json='{"status":1,"id":"'.$id.'","url":"'.$s[url].'"}';
			}else{
				$json='{"status":0,"id":"'.$id.'","url":"'.$s[url].'"}';
			}
			 
		}else{
			$json='{"status":2,"id":"'.$id.'","url":"'.$s[url].'"}';
		}		
		echo $json;
	}
	 
	public function del(){
		$request=$this->request();	
		$id =$request[id];
		if($id){
			$WHERE=" WHERE 1 AND id in (".$id.")";
			$this->delete("tlwx_material",$WHERE);
			$data[status]=1;
		}else{
			$data[status]=0;
		}
		echo json_encode($data);

    }	
}
			 
?>