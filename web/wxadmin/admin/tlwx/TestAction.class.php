<?php
class TestAction extends TestMoude{
	public function __construct(){
	 	parent::__construct();
		$this->wx_id=$_SESSION[userweb][wx_id];
		$this->wx_where=" AND wx_id='".$this->wx_id."'";
		$this->url=url_mobile."weixin.php?wx_id=".$this->wx_id."";
	 
	}
	public function add(){ 
		$GLOBALS['smarty']->assign('url', $this->url);
		$GLOBALS['smarty']->display("Test_add.htm");
	}
    
}
			 
?>