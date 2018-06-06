<?php
class ZhuanpanAction extends ZhuanpanMoude{
	public function __construct(){
 
	}
    public function comm(){
		 
	 	$comm[token]=1;
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
	
 
		
		$where=" AND type=1";
		$lists =$this->lists_data($where);
	 
		$GLOBALS['smarty']->assign('lists',   $lists['lists']);
		$GLOBALS['smarty']->assign('filter',       $weixin_reply_list['filter']);
		$GLOBALS['smarty']->assign('record_count', $weixin_reply_list['record_count']);
		$GLOBALS['smarty']->assign('page_count',   $weixin_reply_list['page_count']);
 
 		$this->display(); 
		 
	}
	public function add(){ 
		$request=$this->request();

 
 
 
	
 
			
		$id=$request[id];
		$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('tlwx_menu') . " WHERE parent_id=0";
		$list = $GLOBALS['db']->getAll($sql);
		$GLOBALS['smarty']->assign('lists', $lists);	
	 
		if($id!=""){
			$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('tlwx_menu') . " WHERE id=$id";
			$info = $GLOBALS['db']->getRow($sql);
			$GLOBALS['smarty']->assign('info',       $info);	
			 
		}else{
		 
		}
		$lists=$this->menu_list($get_sub=0,$ajax=1);
		$GLOBALS['smarty']->assign('lists',           $lists);	
		$GLOBALS['smarty']->display('Menu_add.htm');
		 
	}	
	public function insert_updata(){ 
		$request=$this->request();
		$POST=$request[POST];
		$id=$request[id];
		if($id==$POST[parent_id]){
			$this->error("重复");
		}
		if($id!=""){
			$data=$POST;
			 
			$msg=$this->updata($data,"tlwx_menu","Where id=$id");	
			$GLOBALS['smarty']->assign('sysmsg',    "updata");	
		}else{
			$data=$POST;
			 
			$msg=$this->insert($data,"tlwx_menu");
			$GLOBALS['smarty']->assign('sysmsg',    "insert");
		 
		}
		$this->lists();
 
			 
	}	
	public function del(){ 
		$request=$this->request();
		$id=$request[id];
		if($id!=""){
			 $msg=$this->delete("tlwx_menu","Where id=$id");
		} 
		$this->lists();
			 
	}	
	public function function_lists(){ 
		 
		$GLOBALS['smarty']->display('Menu_function_lists.htm');
		 
			 
	}		
	public function create(){ 
		$sql = "SELECT * FROM " . $GLOBALS['ecs']->table('tlwx_config') . " WHERE id=1";
		$detail = $GLOBALS['db']->getRow($sql);
		$url_get='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$detail['appid'].'&secret='.$detail['appsecret'];
		$data_token=json_decode($this->curlGet($url_get));
		if($detail['appid']==false||$detail['appsecret']==false){
			$this->error('必须先填写【AppId】【 AppSecret】',1);
			 
		}
		$sql = "SELECT *  ".
						" FROM " . $GLOBALS['ecs']->table('tlwx_menu') . " " .
						" Where parent_id=0 AND is_show=1".
						" ORDER BY listorder ".
						" LIMIT 0,3";
		$lists = $GLOBALS['db']->getAll($sql);
	 
		$count=count($lists);
		for($i=0;$i<$count;$i++){
			$sql_sub = "SELECT *  ".
						" FROM " . $GLOBALS['ecs']->table('tlwx_menu') . " " .
						" Where parent_id=".$lists[$i][id]."  AND is_show=1 ".
						" ORDER BY listorder ".
						" LIMIT 0,5";
			   
			$lists_sub=$GLOBALS['db']->getAll($sql_sub);
			 
			if($lists_sub){
				 $lists[$i][lists_sub]=$lists_sub;
			}			
				 
		}		
		$i=1;
		$data = '{"button":[';
		foreach($lists as $key=>$val){	
			
			$data.='{"name":"'.$this->utf_substr($val['title'],16).'",';
			//子菜单
	 
			if($val[lists_sub]){
				$data.='"sub_button":[';
					$j=1;
					 
					foreach($val[lists_sub] as $key_sub=>$val_sub){	
					 	$data.='{"name":"'.$this->utf_substr($val['title'],16).'",';
						if($val_sub[keywords]){
							$data.='"type":"click","key":"'.$this->utf_substr($val['keywords'],16).'"';
						}else{
							$data.='"type":"url","key":"'.$val['link'].'"';
						}
						if($j==count($val[lists_sub])){
							$data.='}';
						}else{
							$data.='},';
						}
						$j++;
						 
					}	
				$data.=']';
			}else{
				if($val[keywords]){
					$data.='"type":"click","key":"'.$this->utf_substr($val['keywords'],16).'"';
				}else{
					$data.='"type":"url","key":"'.$val['link'].'"';
				}
				
			}
			if($i==count($lists)){
				$data.='}';
			}else{
				$data.='},';
			}
			$i++;			
		} 
		$data.="]}";
		
		$url ="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$data_token[access_token]."";
		$data_result = vpost($url,$context);
		if($data_result[errmsg]=="ok"){
			$this->error("成功");
		}else{
			$this->error("失败");
		}
	}			 	
}
			 
?>