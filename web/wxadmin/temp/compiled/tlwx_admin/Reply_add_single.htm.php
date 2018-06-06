<?php echo $this->fetch('pageheader.htm'); ?>


 <div id="weixin_content">
 	<div class="left">
		<?php echo $this->fetch('Reply_left.htm'); ?>
		 
	</div>
	<div class="right">
		<div class="head">单图文添加修改</div>
		<div class="content">
			<form method="post" id="upload" name="upload" action="tlwx.php?m=Reply&a=insert_updata&reply_type=single" >	 
			<input id="reply_type" name="reply_type" type="hidden" value="single" >
			<input id="msg_id" name="msg_id" type="hidden" value="<?php echo $this->_var['detail']['msg_id']; ?>" >
			<input id="id" name="id" type="hidden" value="<?php echo $this->_var['detail']['id']; ?>" >
			 
			<div class="reply_add"> 
				<div class="reply_item" >
					<label>标题</label>
					<span class="reply_input_box"><input type="txt" name="data[title]" id="title" oninput="OnInput (event)" onpropertychange="OnPropChanged (event)" value="<?php echo $this->_var['detail']['title']; ?>"></span>
				</div>
				<div class="reply_item" >
					<label>作者（选填）</label>
					<span class="reply_input_box"><input type="txt" name="data[author]" value="<?php echo $this->_var['detail']['title']; ?>"></span>
				</div>
				<div class="reply_item" >
					<label>图片(大图片建议尺寸：360像素 * 200像素)</label>
					<span class="reply_input_box"> <a href="javascript:XianShi_NeiRong('tlwx.php?m=Material&a=lists&cata=image&to=to_reply')">上传</a></span>
			 
					<input id="image_data" name="data[image]" type="hidden" value="<?php echo $this->_var['detail']['image']; ?>" >
			 
					<div id="image_thumb" class="image_thumb"><?php if ($this->_var['detail']['image'] != ""): ?><img src="../<?php echo $this->_var['detail']['image']; ?>" width="80" height="80" ><?php endif; ?></div>
				</div>
				<div class="reply_item" >
					<label>摘要</label>
					<span class="reply_input_txt"><textarea class="textarea" id="summary" name="data[summary]" oninput="OnInput (event)" onpropertychange="OnPropChanged (event)"><?php echo $this->_var['detail']['summary']; ?></textarea></span>
				</div>
				<div class="reply_item" >
					<label>正文</label>
					<span class=""><?php echo $this->_var['editor']; ?></span>
				</div>
				<div class="reply_item" >
					<label><input name="url_sel"  id="url_sel" type="checkbox" value=""   <?php if ($this->_var['detail']['url'] != ""): ?>  checked="checked"<?php endif; ?> />自定义链接</label>
					<span class="reply_input_box"><input type="txt"  id="url" name="data[url]" value="<?php echo $this->_var['detail']['url']; ?>" <?php if ($this->_var['detail']['url'] == ""): ?> disabled="disabled"<?php endif; ?>></span>
				</div>
				<div class="reply_item">
					<input name="save" id="save" type="button" value="保存" />
				</div>
			</div>
			</form>
			<div class="reply_display">
				<div class="reply_title" id="reply_title"><?php echo $this->_var['detail']['title']; ?></div>
				<div class="image_cover" id="image_cover"  ><?php if ($this->_var['detail']['image'] != ""): ?><img src="../<?php echo $this->_var['detail']['image']; ?>" class="b_image"><?php else: ?>封面图片<?php endif; ?></div>
				<div class="reply_summary" id="reply_summary"><?php echo $this->_var['detail']['summary']; ?></div>
			</div>
			 
			 
 
			
			<div class="clear"></div>
			
		</div>
	</div>
	<div class="clear"></div>
 
 
 </div>
 
<script type="text/javascript" src="tlwx_templates/js/js_reply.js"></script>   
 
 
 
<script type="text/javascript">
 
	function fuasdnfsdaf(){
		var htmlData=CKEDITOR.instances.myEditor.getData();
		var appEndData="追加的内容";
		var theData=appEndData;
		CKEDITOR.instances.myEditor.setData(theData);
	}	 

</script>
 
<script language="JavaScript"> 
 
	$("#tupian").blur(
		function (){
			s=$("#tupian").val()
			 
		}
	);
	$("#save").click( 
		function(){
		 if($("#title").val()==""){
		 	alert("标题不能为空");
		 	return false;
		 }
		 if($("#image").val()==""){
		 	alert("图片不能为空");
		 	return false;
		 }
		 if($("#summary").val()==""){
		 	alert("摘要不能为空");
		 	return false;
		 }
		 
		 document.getElementById("upload").submit(); 
	});	

	$("#url_sel").click( 
	
		function(){
			if(document.getElementById("url").disabled == false){
				 
				document.getElementById("url").disabled = true
				$("#url").val("")	 
			}else{	 
				document.getElementById("url").disabled = false
				 
			}
		}
	);	
	
		
	$('#title').bind('input propertychange', function() {
		$('#reply_title').html($(this).val());
	});	
 
 	$('#summary').bind('input propertychange', function() {
		$('#reply_summary').html($(this).val());
	});	
	

  
  
 
	 
 
 
</script>
 
<?php echo $this->fetch('pagefooter.htm'); ?>
