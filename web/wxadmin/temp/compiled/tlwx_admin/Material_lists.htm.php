<!-- $Id: goods_info.htm 17126 2010-04-23 10:30:26Z liuhui $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<script src="tlwx_templates/js/js_reply.js"></script>	
 <div id="weixin_content">
 	<div class="left">
		<?php echo $this->fetch('Reply_left.htm'); ?>
		 
	</div>
	<div class="right">
		<div class="head">回复素材</div>
		<div class="content">
				 
			 <div class="weixin"> 
				 
				<div class="material">	
					<div class="tag" id="tag">
						<a href="javascript:tag_meterial_dis(this,'lists_img')" id="lists_img_tag"   class="on">素材库</a>
						<a href="javascript:tag_meterial_dis(this,'upload')" id="upload_tag"  class="">上传</a>
					</div>
					 
					<div class="content">
						<div class="lists_img" id="lists_img">
							 
							<?php $_from = $this->_var['lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'lists_0_60358200_1461271421');if (count($_from)):
    foreach ($_from AS $this->_var['lists_0_60358200_1461271421']):
?>
								<div id="item_<?php echo $this->_var['lists_0_60358200_1461271421']['id']; ?>"> 
									<img src="../../<?php echo $this->_var['lists_0_60358200_1461271421']['img_thumb']; ?>" width="100" onclick="photo_sel('<?php echo $this->_var['lists_0_60358200_1461271421']['id']; ?>','<?php echo $this->_var['lists_0_60358200_1461271421']['image_thumb']; ?>')">
									<div class="del_action"  data-id="<?php echo $this->_var['lists_0_60358200_1461271421']['id']; ?>">删除</div>
								</div>
								 
							<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>	
							 
						</div>
						<div id="ajax_upload" style="display:none">
						 <form action="__URL__/insert_update" method="post" id="ajax_save_form"   onSubmit="return insert_material('image','ajax')" enctype="multipart/form-data">
							<input type="file" name="ajax_image" id="ajax_image"/>
							<input type="button" value="上传" id="button" onclick="insert_material('ajax_image','ajax')">
						 </form>	
						</div>
						 
					
						</div>
				</div>	 
							
						   
			</div>				
			<script src="tlwx_templates/js/jquery.ajaxFileUpload.js"></script>	
			 
				
		</div>
			 
		<div class="clear_20"></div>
		</div>
	</div>
 
 
	
 </div>

<script>
//删除
var del_url="tlwx.php?&m=Material&a=del&ajax=1"; 
 
</script>
 
<?php echo $this->fetch('pagefooter.htm'); ?>
 