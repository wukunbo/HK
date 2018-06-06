<!-- $Id: goods_info.htm 17126 2010-04-23 10:30:26Z liuhui $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
 



<div id="weixin_content">
 	 
	<div class="right wide">
		 <form method="post" id="save" name="save" action="tlwx.php?m=Menu&a=insert_updata" >	  
		<div class="head">填加菜单</div>
		 <input type="txt" name="id" id="title" style="display:none"   value="<?php echo $this->_var['info']['id']; ?>">
 
 
		<?php echo $this->fetch('tlwx_sysmsg.htm'); ?>
		<div class="content form_coomm">
		
			<div class="form_item" >
					<label>父级菜单：</label>
					<span class="sle_box">
						<select id="parent_id" name="POST[parent_id]">
							<option value="0" <?php if ($this->_var['info']['parent_id'] == ""): ?>selected="selected"<?php endif; ?>>请选择菜单</option>
							<?php $_from = $this->_var['lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'lists_0_81988500_1457283933');if (count($_from)):
    foreach ($_from AS $this->_var['lists_0_81988500_1457283933']):
?>
								<option value="<?php echo $this->_var['lists_0_81988500_1457283933']['id']; ?>" <?php if ($this->_var['lists_0_81988500_1457283933']['id'] == $this->_var['info']['parent_id']): ?>selected="selected"<?php endif; ?>><?php echo $this->_var['lists_0_81988500_1457283933']['title']; ?></option>
							<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
						</select>
					</span>
			</div>
			<div class="form_item" >
					<label>主菜单名称：</label>
					<span class="input_box"><input type="txt" name="POST[title]" id="title"   value="<?php echo $this->_var['info']['title']; ?>"></span>
			</div>
			<div class="form_item" >
					<label>关联关键词：</label>
					<span class="input_box"><input type="txt" name="POST[keywords]" id="keywords"   value="<?php echo $this->_var['info']['keywords']; ?>"></span>
					<tpis ><?php if ($this->_var['info']['context'] != ""): ?><?php echo $this->_var['info']['context']; ?><?php endif; ?>
					<a title="修改主菜单" href="javascript:XianShi_NeiRong('tlwx.php?m=Menu&a=function_lists');" class="ajax btnGreen  cboxElement">功能回复</a></tpis>
				 	
					<input type="hidden" name="POST[context]" id="context"   value="<?php echo $this->_var['info']['context']; ?>">
			</div>
			<div class="form_item" >
					<label>外链接 ：</label>
					<span class="input_box"><input type="txt" name="POST[link]" id="link"   value="<?php echo $this->_var['info']['link']; ?>"></span>
			</div>
			<div class="form_item" >
					<label>显示 ：</label>
					<span class="radio_box"><input type="radio" value="1" checked="checked"  name="POST[is_show]">是 <input type="radio" value="0"  name="POST[is_show]">否  </span>
			</div>
			<div class="form_item" >
					<label>排序 ：</label>
					<span class="input_box"><input type="txt" name="POST[listorder]" id="listorder"   value="<?php echo $this->_var['info']['listorder']; ?>"></span>
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