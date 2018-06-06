<?php
class KeywordAction extends KeywordMoude{
	public function __construct(){
	 	parent::__construct();
		$comm[m]=$_REQUEST[m];
		$comm[a]=$_REQUEST[a];
		$comm[keyword_cata]=$_REQUEST[keyword_cata];
		  
		$this->wx_id=$_SESSION[userweb][wx_id];
		$this->wx_where=" AND wx_id='".$this->wx_id."'";
		$GLOBALS['smarty']->assign('comm',  $comm);
	}
    public function comm(){
		 
	 	 
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
	public function lists($get_sub=1,$ajax=0){ 
			 
			 
	 
		$lists = $this->rule_list($where);
	   
		$GLOBALS['smarty']->assign('lists',  $lists['lists']);
		$GLOBALS['smarty']->assign('filter',       $lists['filter']);
		$GLOBALS['smarty']->assign('record_count', $lists['record_count']);
		$GLOBALS['smarty']->assign('page_count',   $lists['page_count']);
 
				 
		$this->display();
		 
	}
	public function add(){ 
		 
		$request=$this->request();
		if($request[rule_id]){
			$where=" AND id=".$request[rule_id]." ".$this->wx_where."";
			$lists = $this->rule_list($where);
			//从列表到单行
			$detail=$lists[lists][0];
			 
			$GLOBALS['smarty']->assign('detail',  $detail);
		}
		$this->display();
	}	
 
	public function auto_all($keyword_cata=false){ 
		$request=$this->request();
		if(!$keyword_cata){
			$keyword_cata=$request[keyword_cata];
		}
		 
 	 	$where=$this->wx_where;
		if($keyword_cata){
			$where.=" AND keyword_cata='".$keyword_cata."'";
		}
		$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('tlwx_keyword') . " WHERE 1 $where";
		 
		$detail = $GLOBALS['db']->getRow($sql);
		 
		if(!$detail){
			$sql = "INSERT INTO " . $GLOBALS['ecs']->table('tlwx_keyword') . "(wx_id,keyword_cata)" .
							 "VALUES ('".$this->wx_id."','".$keyword_cata."')";
			$GLOBALS['db']->query($sql);
			$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('tlwx_keyword') . " WHERE 1 $where";
			$detail = $GLOBALS['db']->getRow($sql);
		}
		$detail=$this->keyword_detail($detail[id]);
		 
	 
		 
		if($keyword_cata=="all"){
			$detail[tips]="当用户向公众帐号发送信息时，且该信息没有设置相关回复，则采用本次回复内容。";
		}else{
			$detail[tips]="当用户关注公众帐号时，回复本内容。";
		}
		$GLOBALS['smarty']->assign('detail',       $detail);
	 
		
		$this->display("Keyword_auto_all.htm"); 
	}		
	public function insert_updata(){
		$request=$this->request();
		$data=$request[data];
		$data[wx_id]=$this->wx_id;
		$id=$request[id];
		if($data[msg_cata]==""){
			$data[msg_cata]="txt";
		}
		
		if($data[context]=="" && $data[msg_cata]=="txt"){
			$this->error("内容不能为空");
		}
		if($id=="") {
			$s=$this->insert($data,"tlwx_keyword",1,1);
		 
		}else{
			$s=$this->updata($data,"tlwx_keyword","where 1 AND id=".$id."",1);
 
		}
		 
		if($s){
			 
			$this->succes("添加成功","tlwx.php?m=Keyword&a=auto_all&keyword_cata=".$data[keyword_cata]);
			 
		}else{
			$this->error("内容不能为空");
		}
	  
	}
	public function insert_updata_keyword(){
		$request=$this->request();
		$data=$request[data];
		$data[wx_id]=$this->wx_id;
		if($data[context]=="" && $data[msg_id]==""){
			$this->error("内容不能为空");
		}
		if($data[msg_cata]==""){
			$data[msg_cata]='txt';
		}
		$title=$request[title];
		$match_rule=$request[match_rule];
		$keyword_id=$request[keyword_id];
		//批量加入关键字
		for($i=0;$i<count($title);$i++){
	
				if($keyword_id[$i]==""){
					$data[title]=$title[$i];
					$data[match_rule]=$match_rule[$i];
					$id=$this->insert($data,'tlwx_keyword',1);
					$keyword_id[$i]=$id;
				}else{
					$data[title]=$title[$i];
					$data[match_rule]=$match_rule[$i];
					$this->updata($data,'tlwx_keyword',"WHERE 1 AND id=".$keyword_id[$i]."");
				}
				
			 
		}
	 	 
		$keyword_id_str=implode(",",$keyword_id);
	 	//加入RULE
		$data_rule[title]=$request[rule_title];
		$data_rule[keyword_id_str]=$keyword_id_str;		
		$data_rule[wx_id]=$this->wx_id;
		$rule_id=$request[rule_id];
		if($rule_id=="") {
 
			$s=$this->insert($data_rule,'tlwx_rule',1);

		}else{
			$s=$this->updata($data_rule,'tlwx_rule',"WHERE 1 AND id=".$rule_id."");
 
		}
		header("Location: tlwx.php?m=Keyword&a=lists"); 
		exit;
	}
	public function del(){ 
		$request=$this->request();
		$id=$request[id];
		if($id!=""){
			 $msg=$this->delete("tlwx_menu","Where id=$id ".$this->wx_where."");
		} 
		$this->lists();
			 
	}	
	public function del_rule(){ 
		$request=$this->request();
		$id=$request[id];
		 
		if($id!=""){
			 
			 $msg=$this->delete("tlwx_rule","Where id=$id ".$this->wx_where."");
		} 
		echo $this->sql;
		
		//$this->succes("内容不能为空","tlwx.php?m=Keyword&a=auto_all&keyword_cata=".$data[keyword_cata]);
			 
	}		
	public function function_lists(){ 
		 
		$GLOBALS['smarty']->display('Menu_function_lists.htm');
		 
			 
	}		
	 
}
			 
?>