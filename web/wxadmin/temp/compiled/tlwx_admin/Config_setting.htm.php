<!-- $Id: goods_info.htm 17126 2010-04-23 10:30:26Z liuhui $ -->
<?php echo $this->fetch('pageheader.htm'); ?>

 



<div id="weixin_content">
 	 
	<div class="right wide">
		 <form method="post" id="save" name="save" action="tlwx.php?m=Config&a=insert_updata&type=setting" >	  
		<div class="head">微信配置</div>
		 
  
 
		<?php echo $this->fetch('tlwx_sysmsg.htm'); ?>
		<div class="content form_coomm">
			<div class="form_item" >
					<label>公众号类型	:</label>
					 
					<span class="input_box" style="border:none;"> 
					<select id="weixin_type" name="data[weixin_type]"> 
							<option value="dingyuehao" <?php if ($this->_var['detail']['weixin_type'] == "dingyuehao"): ?>selected="selected"<?php endif; ?>>订阅号</option>
							 
							<option value="fuwuhao_off" <?php if ($this->_var['detail']['weixin_type'] == "fuwuhao_off"): ?>selected="selected"<?php endif; ?>>服务号（未认证）</option>
							<option value="fuwuhao_on" <?php if ($this->_var['detail']['weixin_type'] == "fuwuhao_on"): ?>selected="selected"<?php endif; ?>>服务号（已认证）</option>
							 
						</select>
					</span>
			</div> 
			<div class="form_item" >
					<label>关注送积分	:</label>
					 
					<span class="input_box"><input type="txt" name="data[points_guanzhu]" id="points_guanzhu"   value="<?php echo $this->_var['detail']['points_guanzhu']; ?>"></span>
			</div> 
			<div class="form_item" >
					<label>签到积分:</label>
					 
					<span class="input_box"><input type="txt" name="data[points_qiandao]" id="points_qiandao"   value="<?php echo $this->_var['detail']['points_qiandao']; ?>"></span>
			</div>
			<div class="button">
				<input name="save" id="subimt" type="button" value="保存" />
			</div>
		</div>
		 
		</form>
	</div>
	<div class="clear"></div>
</div>
<?php echo $this->fetch('tlwx_pagefooter.htm'); ?>
 


<script type="text/javascript">
	
$("#subimt").click( 
		function(){
			 if($("#appsecret").val()==""){
				alert("AppSecret不能为空");
				return false;
			 }
			 if($("#appid").val()==""){
				alert("AppId不能为空");
				return false;
			 }
 
		  
		 	document.save.submit(); 
		 }
);	
 
</script>