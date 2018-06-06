<!-- $Id: goods_info.htm 17126 2010-04-23 10:30:26Z liuhui $ -->
<?php echo $this->fetch('pageheader.htm'); ?>


 



<div id="weixin_content">
 	 
	<div class="right wide">
		 <form method="post" id="save" name="save" action="tlwx.php?m=Config&a=insert_updata"  enctype="multipart/form-data" >	  
		<div class="head">微信接口</div>
		 
  
 
		<?php echo $this->fetch('tlwx_sysmsg.htm'); ?>
		<div class="content form_coomm">
			<div class="form_item" >
					<label>微信社区首页:</label>
					<span class="txt" style="display:none1"><?php echo $this->_var['url_mobile']; ?>home.php?wx_id=<?php echo $this->_var['detail']['id']; ?></span>
					<span class="input_box" style="display:none"><input type="txt" name="data[url]" id="token" readonly=""   value="<?php echo $this->_var['url_mobile']; ?>weixin.php?wx_id=<?php echo $this->_var['detail']['id']; ?>"></span>
					<span class="input_box" style="display:none"><input type="txt" name="data[domain]" id="token" readonly=""   value="<?php echo $this->_var['url_mobile']; ?>"></span>
					 
			</div>
			
			<div class="form_item" >
					<label>网页基本授权域名:</label>
					<span class="txt" style="display:none1"><?php echo $this->_var['DOMAIN']; ?></span>
					 
					 
			</div>
			<div class="form_item" >
					<label>支付目录:</label>
					<span class="txt" style="display:none1"><?php echo $this->_var['DOMAIN']; ?></span>
					 
					 
			</div>
			 
			<div class="form_item" >
					<label>公众号名称:</label>
					 
					<span class="input_box"><input type="txt" name="data[title]" id="token"   value="<?php echo $this->_var['detail']['title']; ?>"></span>
			</div>
			<div class="form_item" >
					<label>token:</label>
					 
					<span class="input_box"><input type="txt" name="data[token]" id="token"   value="<?php echo $this->_var['detail']['token']; ?>"></span>
			</div>
			<div class="form_item" >
					<label>接口地址:</label>
					<span class="txt" style="display:none1"><?php echo $this->_var['url_mobile']; ?>weixin.php?wx_id=<?php echo $this->_var['detail']['id']; ?></span>
					<span class="input_box" style="display:none"><input type="txt" name="data[url]" id="token" readonly=""   value="<?php echo $this->_var['url_mobile']; ?>weixin.php?wx_id=<?php echo $this->_var['detail']['id']; ?>"></span>
					<span class="input_box" style="display:none"><input type="txt" name="data[domain]" id="token" readonly=""   value="<?php echo $this->_var['url_mobile']; ?>"></span>
					 
			</div>
			<div class="form_item" >
		 			<label>AppId :</label>
					<span class="input_box"><input type="txt" name="data[appid]" id="appid"   value="<?php echo $this->_var['detail']['appid']; ?>"></span>
			</div>
			<div class="form_item" >
					<label>AppSecret  :</label>
					<span class="input_box"><input type="txt" name="data[appsecret]" id="appsecret"   value="<?php echo $this->_var['detail']['appsecret']; ?>"></span>
			</div>
			<div class="form_item" >
					<label>商户id:</label>
					<span class="txt" style="display:none"><?php echo $this->_var['detail']['mchid']; ?></span>
					<span class="input_box"><input type="txt" name="data[mchid]" id="mchid"   value="<?php echo $this->_var['detail']['mchid']; ?>"></span>
					 
			</div>
			<div class="form_item" >
					<label>支付密钥:</label>
					<span class="txt" style="display:none"><?php echo $this->_var['detail']['pay_key']; ?></span>
					<span class="input_box"><input type="txt" name="data[pay_key]" id="pay_key"   value="<?php echo $this->_var['detail']['pay_key']; ?>"></span>
					 
			</div>
			<div class="form_item" style="display:none" >
					<label>JSAPI路径:</label>
					<span class="txt" style="display:none"><?php echo $this->_var['detail']['js_api_call_url']; ?></span>
					
					<span class="input_box" ><input type="txt" name="data[js_api_call_url]" id="js_api_call_url"   value="<?php echo $this->_var['detail']['js_api_call_url']; ?>"></span>
			</div>
			<div class="form_item" >
					<label>证书CERT:</label>
					<span class="txt" style="display:none1"><?php echo $this->_var['detail']['sslcert_path']; ?></span>
					<span class="input_box1">
					<input type="file" name="sslcert_path" id="sslcert_path"/>
					<input type="txt"  style="display:none"  name="11data[sslcert_path]" id="sslcert_path"   value="<?php echo $this->_var['detail']['sslcert_path']; ?>"></span>
			</div>
			<div class="form_item" >
					<label>证书KEY:</label>
					<span class="txt" style="display:none1"><?php echo $this->_var['detail']['sslkey_path']; ?></span>
					
					<span class="input_box1" >
					<input type="file" name="sslkey_path" id="sslkey_path"/>
					<input type="txt"  style="display:none"  name="11data[sslkey_path]" id="sslkey_path"   value="<?php echo $this->_var['detail']['sslkey_path']; ?>"></span>
			</div>
			<div class="form_item" >
					<label>ca证书:</label>
					<span class="txt" style="display:none1"><?php echo $this->_var['detail']['ca_path']; ?></span>
					
					<span class="input_box1" >
					<input type="file" name="ca_path" id="ca_path"/>
					<input type="txt" style="display:none" name="11data[sslkey_path]" id="ca_path"   value="<?php echo $this->_var['detail']['ca_path']; ?>"></span>
					
			</div>
			<div class="form_item" style="display:none" >
					<label>NOTIFY_URL:</label>
					<span class="txt" style="display:none"><?php echo $this->_var['detail']['notify_url']; ?></span>
					<span class="input_box"><input type="txt" name="data[notify_url]" id="notify_url"   value="<?php echo $this->_var['detail']['notify_url']; ?>"></span>
			</div>
			<div class="form_item" style="display:none" >
					<label>域名回调地址:</label>
					<span class="txt" style="display:none"><?php echo $this->_var['detail']['call_back_url']; ?></span>
					<span class="input_box"><input type="txt" name="data[call_back_url]" id="call_back_url"   value="<?php echo $this->_var['detail']['call_back_url']; ?>"></span>
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