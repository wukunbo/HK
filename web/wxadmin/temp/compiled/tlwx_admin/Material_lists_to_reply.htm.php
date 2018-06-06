 <div class="weixin"> 
		<div class="ajax_title">
			<div class="left"><?php echo $this->_var['comm']['ajax_title']; ?></div>
			<div class="right"><a href="javascript:XianShi_GuanBi()">关闭</a></div>
			 <div class="clear"></div>	
		</div>

		<div class="material">	
			<div class="tag" id="tag">
				<a href="javascript:tag_meterial_dis(this,'lists_img')" id="lists_img_tag" class="on">素材库</a>
				<a href="javascript:tag_meterial_dis(this,'upload')" id="upload_tag" class="">上传</a>
			</div>
			<div class="clear"></div>
			
			<div class="content">
				<div class="lists_img" id="lists_img">
					 
					<?php $_from = $this->_var['lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'lists_0_93154100_1502939913');if (count($_from)):
    foreach ($_from AS $this->_var['lists_0_93154100_1502939913']):
?>
						<div><img src="../<?php echo $this->_var['lists_0_93154100_1502939913']['image_thumb']; ?>" width="100" onclick="photo_sel_to_reply('<?php echo $this->_var['lists_0_93154100_1502939913']['image_thumb']; ?>')"></div>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>	
					 
				</div>
				<div id="ajax_upload" style="display:none">
				 <form action="__URL__/insert_update" method="post" id="ajax_save_form"   onSubmit="return insert_material('ajax_image','ajax')" enctype="multipart/form-data">
					<input type="file" name="ajax_image" id="ajax_image"/>
					<input type="button" value="上传" id="button" onclick="javascript:insert_material('ajax_image','to_reply')">
				 </form>	
				</div>
				 
			
			</div>
		</div>	 
 				
			   
</div>				
<script src="tlwx_templates/js/jquery.ajaxFileUpload.js"></script>	 	   
 