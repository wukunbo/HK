<?php
class ReplyAction extends ReplyMoude{
	public function __construct(){ 
 		$this->wx_id=$_SESSION[userweb][wx_id];
		$this->wx_where=" AND wx_id='".$this->wx_id."'";
	}
    public function comm(){
 		 
		$comm[m]=$_REQUEST[m];
		$comm[a]=$_REQUEST[a];
		return $comm;
    }	
	public function add(){ 
		$request=$this->request();
		$comm=$this->comm();
		$comm[item_id]=$request[item_id];
		$id=$request[id];
		$reply_type=$request[reply_type];
		$ajax=$request[ajax];
		$obj=$request[obj];
		
		 $editor=$this->tep_draw_textarea_fck('data[context]','data[context]','soft','100%','400','');
		 $GLOBALS['smarty']->assign('editor', $editor);
 
		$GLOBALS['smarty']->assign('comm', $comm);
		$GLOBALS['smarty']->assign('id', $id);
		 
		if($ajax==1){
			 
			$GLOBALS['smarty']->display('Reply_add_ajax.htm');
		}else{
		
			if($id!=""){
				$detail=$this->reply_detail($id);
	 			$editor=$this->tep_draw_textarea_fck('data[context]','data[context]','soft','100%','400',''.$detail[context].'');
				$GLOBALS['smarty']->assign('editor', $editor);
				print_r($detail[content]);
				$GLOBALS['smarty']->assign('detail', $detail);
				 
			}			
			$GLOBALS['smarty']->display('Reply_add_'.$reply_type.'.htm');
		}
		 
	}	
	
	public function content_add(){ 
		$request=$this->request();
		$comm=$this->comm();
		$comm[item_id]=$request[item_id];
		$id=$request[id];
	 
		$ajax=$request[ajax];
 		 
 		 
 		 
		if($id!=""){
			$detail=$this->content_detail($id);
		 	 
			 
	 		$editor=$this->tep_draw_textarea_fck('data[context_ajax]','context_ajax','soft','100%','400',$detail[context]);
			$GLOBALS['smarty']->assign('editor', $editor);
			$GLOBALS['smarty']->assign('detail', $detail);
		}else{
			$editor=$this->tep_draw_textarea_fck('data[context_ajax]','context_ajax','soft','100%','400','');
			$GLOBALS['smarty']->assign('editor', $editor);
		}
		 
		$GLOBALS['smarty']->assign('comm', $comm);
		 
		$GLOBALS['smarty']->assign('id', $id);
		$GLOBALS['smarty']->display('Reply_add_ajax_content.htm');
		 
	}	
	public function goods_add(){ 
		$request=$this->request();
		$comm=$this->comm();
		$comm[item_id]=$request[item_id];
		$id=$request[id];
		$item_id=$request[item_id];
		
		require_once(ROOT_PATH . '/' . ADMIN_PATH . '/includes/lib_goods.php');
		
		$goods_lists = $this->goods_lists();
		 
		 
		$GLOBALS['smarty']->assign('goods_lists',   $goods_lists['goods_lists']);
		$GLOBALS['smarty']->assign('filter',       $goods_lists['filter']);
		$GLOBALS['smarty']->assign('record_count', $goods_lists['record_count']);
		$GLOBALS['smarty']->assign('page_count',   $goods_lists['page_count']);
		$GLOBALS['smarty']->assign('item_id',   $item_id);
	 
		 
		$this->display('Reply_goods_lists_ajax.htm'); 
	}			
 
	public function lists(){
		$comm=$this->comm();
		$lists =$this->reply_list(1);
	 
		 
		$GLOBALS['smarty']->assign('lists',   $lists['lists']);
		$GLOBALS['smarty']->assign('filter',       $weixin_reply_list['filter']);
		$GLOBALS['smarty']->assign('record_count', $weixin_reply_list['record_count']);
		$GLOBALS['smarty']->assign('page_count',   $weixin_reply_list['page_count']);
		$GLOBALS['smarty']->assign('comm', $comm);
		$this->display("Reply_lists.htm"); 
	}	
	public function lists_ajax(){
		
		$lists =$this->reply_list(1);
	 
	 
		 
		$GLOBALS['smarty']->assign('lists',   $lists['lists']);
		$GLOBALS['smarty']->assign('filter',       $weixin_reply_list['filter']);
		$GLOBALS['smarty']->assign('record_count', $weixin_reply_list['record_count']);
		$GLOBALS['smarty']->assign('page_count',   $weixin_reply_list['page_count']);
		 
		$this->display(); 
	}		
	 
	//插入图文素材
	function insert_updata($num=2)
	{
		$content_id=$this->content_insert_updata($summary=0);
		$request=$this->request();
		$item_id=$request[item_id];
		$msg_id=$request[msg_id];
		$item_cata=$request[item_cata];
		 
		//多图文
	 	
		if($request[reply_type]=='more'){
			  
			 //重新建立 ID 数组
			 for($i=0;$i<count($item_cata);$i++){
			 	if($item_cata[$i]==2 ){
					//商品 删除 并创建
					$sql = "SELECT id FROM " .$GLOBALS['ecs']->table('tlwx_msg_content'). " WHERE 1 AND goods_id=$item_id[$i]";
					$msg_content_id= $GLOBALS['db']->getOne($sql);
					 
					if($msg_content_id==""){
						$sql = "INSERT INTO " . $GLOBALS['ecs']->table('tlwx_msg_content') . " (goods_id, cata)" .
								 "VALUES ('$item_id[$i]','$item_cata[$i]')";
						$GLOBALS['db']->query($sql);	
						$item_id[$i]=mysql_insert_id();
					}else{
						$item_id[$i]=$msg_content_id;
					}		
				}
			 }
			 $item_id_str=implode(",",$item_id);
			 $content_id=$content_id.",".$item_id_str;
			 
		}
		 
		//清空$data
		$data="";
		$data[wx_id]=$this->wx_id;
		$data[content_id_str]=$content_id;
		$data[reply_type]=$request[reply_type];
		 
		if($msg_id!=""){
			$msg=$this->updata($data,"tlwx_msg","Where id=$msg_id",1);	
		}else{
			$msg=$this->insert($data,"tlwx_msg",1);
		}	
		 
	 	 
		 
		$this->lists();

			 
	}	
	//多图文中的图文素材
	function reply_insert_ajax()
	{
		$request=$this->request();
		$data=$request[data];
		$data[context]=$data[context_ajax];
		unset($data[context_ajax]);
	 	 
		$id=$request[id];
		if($data[title]==""){
			$this->json("","标题不能为空",0);
		}
		if($data[context]==""){
			$this->json("","内容不能为空",0);
		}
		
		 
			
		if($data[image]==""){
			 
			$this->json("","图片不能为空",0);
		}
	 
		if($id!=""){
			$msg=$this->updata($data,"tlwx_msg_content","Where id=$id");				 
		}else{
			$msg=$this->insert($data,"tlwx_msg_content",1);
			$id=$msg;
		}	
		 
		$json_data[id]=$id;
		$json_data[title]=$data[title];		
		$json_data[image]=$data[image];	
		$json_data[status]=1;	
		echo json_encode($json_data);	
		exit;		

	}	
	//插入图文素材,主素材
	function content_insert_updata($summary=1)
	{
		$request=$this->request();
		$data=$request[data];
		$id=$request[id];
		if($data[title]=""){
			$this->error("标题不能为空");
		}
		if($data[image]==""){
			 $this->error("图片不能为空");
		}
		if($data[summary]=="" && $summary==1){
			$this->error("摘要不能为空");
		}
		if($data[context]==""){
		 
			$this->error("正文不能为空");;
		}
 
		 
 		$data=$request[data];
		 
		if($id!=""){
			 
			$msg=$this->updata($data,"tlwx_msg_content","Where id=$id");	
			return $id;
		}else{
			 
			$msg=$this->insert($data,"tlwx_msg_content",1);
			return $msg;
		 
		}			 
	}		
	 
	 
	//删除	
	public function del(){ 
		$request=$this->request();
		$id=$request[id];
		$where="  id=$id ".$this->wx_where."";
		
		$sql = "SELECT content_id_str 	 ".
				" FROM " . $GLOBALS['ecs']->table('tlwx_msg') . "  WHERE  $where";
			 
		$content_id_str = $GLOBALS['db']->getOne($sql);
					
		if($id!=""){
			 $msg=$this->delete("tlwx_msg","Where id=$id ".$this->wx_where."");
			 if($content_id_str){
			 	$msg=$this->delete("tlwx_msg_content","Where id in (".$content_id_str.")");
			 }
		} 
		$this->lists();
			 
	}		
 
}
			 
?>