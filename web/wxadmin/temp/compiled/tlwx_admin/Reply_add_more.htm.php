<!-- $Id: goods_info.htm 17126 2010-04-23 10:30:26Z liuhui $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
 
 
 



 <div id="weixin_content">
 	<div class="left">
		<?php echo $this->fetch('Reply_left.htm'); ?>
		 
	</div>
	<div class="right">
		<div class="head">多图文添加修改</div>
		<div class="content"  >
			<form method="post" id="upload" name="upload" action="tlwx.php?m=Reply&a=insert_updata&reply_type=more" >	 
				<input id="reply_type" name="reply_type" type="hidden" value="more" >
				<input id="msg_id" name="msg_id" type="hidden" value="<?php echo $this->_var['detail']['msg_id']; ?>" >
				<input id="id" name="id" type="hidden" value="<?php echo $this->_var['detail']['id']; ?>" >
				 
			 
			<div class="reply_add" > 
				<div class="reply_item" >
					<label>标题</label>
					<span class="reply_input_box"><input type="txt" name="data[title]" id="title" oninput="OnInput (event)" onpropertychange="OnPropChanged (event)" value="<?php echo $this->_var['detail']['title']; ?>"></span>
				</div>
				<div class="reply_item" >
					<label>作者（选填）</label>
					<span class="reply_input_box"><input type="txt" name="data[author]" value="<?php echo $this->_var['detail']['author']; ?>"></span>
				</div>
				  
				<div class="reply_item" >
					<label>图片(大图片建议尺寸：360像素 * 200像素)</label>
					<span class="reply_input_box"><a href="javascript:XianShi_NeiRong('tlwx.php?m=Material&a=lists&cata=image&to=to_reply')">上传</a></span>
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
					<label><input name="url_sel"  id="url_sel" type="checkbox" value="" <?php if ($this->_var['detail']['url'] != ""): ?> checked="checked"<?php endif; ?> />自定义链接</label>
					<span class="reply_input_box"><input type="txt"  id="url" name="url" value="<?php echo $this->_var['detail']['url']; ?>" <?php if ($this->_var['detail']['url'] == ""): ?>disabled="disabled"<?php endif; ?>></span>
				</div>
				<div class="reply_item">
					<input name="save" id="save" type="button" value="保存" />
					 
				</div>
			</div>
			 
			<div class="reply_display">
				 
					<div class="image_cover" id="image_cover"  ><?php if ($this->_var['detail']['image'] != ""): ?><img src="../<?php echo $this->_var['detail']['image']; ?>" class="b_image"><?php else: ?>封面图片<?php endif; ?></div>
					<div class="reply_title_more" id="reply_title"><?php if ($this->_var['detail']['image'] != ""): ?><?php echo $this->_var['detail']['title']; ?><?php else: ?>标题<?php endif; ?></div>
					<div id="reply_lists_item_div">
					<?php if ($this->_var['detail']['id'] == ""): ?>

						<div id="reply_lists_item">
							<div class="reply_lists_item" id="item_0" onmouseover="editor_div(0,this)">
								<div class="item_title" id="item_title_0" >
									标题
								</div>
								<div class="item_image" id="item_image_0" >
									缩略图
								</div>
								<div class="clear"></div>
								<input id="item_id_0" name="item_id[]" type="hidden" value="" >
								<input id="item_cata_0" name="item_cata[]" type="hidden" value="" >
							
							</div>
							<div id="editor_div_0" class="editor_div_time" style="display:none" onmouseout="editor_div_none(this)"><a href="javascript:reply_add_ajax_NeiRong('tlwx.php?m=Reply&a=content_add&ajax=1&item_id=0',0)">图文信息</a> <a href="javascript:XianShi_NeiRong('tlwx.php?m=Reply&a=goods_add&ajax=1&item_id=0',0)">商品信息</a> <a href="javascript:imagelists_del(0)">删除</a> </div>
							 
						</div>			
					<?php else: ?>		
						<?php $_from = $this->_var['detail']['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'content');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['content']):
?>
							 
							 
						<div id="reply_lists_item">
							<div class="reply_lists_item" id="item_<?php echo $this->_var['key']; ?>" onmouseover="editor_div(<?php echo $this->_var['key']; ?>,this)">
								<div class="item_title" id="item_title_<?php echo $this->_var['key']; ?>" >
									<?php echo $this->_var['content']['title']; ?>
								</div>
								<div class="item_image" id="item_image_<?php echo $this->_var['key']; ?>" >
									<img class="s_image" src="../<?php echo $this->_var['content']['image']; ?>" >
								</div>
								<div class="clear"></div>
								<input id="item_id_<?php echo $this->_var['key']; ?>" name="item_id[]" type="hidden" value="<?php if ($this->_var['content']['cata'] == 2): ?><?php echo $this->_var['content']['goods_id']; ?><?php else: ?><?php echo $this->_var['content']['id']; ?><?php endif; ?>" >
								<input id="item_cata_<?php echo $this->_var['key']; ?>" name="item_cata[]" type="hidden" value="<?php echo $this->_var['content']['cata']; ?>" >
							
							</div>
							<div id="editor_div_<?php echo $this->_var['key']; ?>" class="editor_div_time" style="display:none" onmouseout="editor_div_none(this)"><a href="javascript:reply_add_ajax_NeiRong('tlwx.php?m=Reply&a=content_add&ajax=1&item_id=<?php echo $this->_var['key']; ?>&id=<?php echo $this->_var['content']['id']; ?>',<?php echo $this->_var['key']; ?>)">图文信息</a> <a href="javascript:XianShi_NeiRong('tlwx.php?m=Reply&a=goods_add&ajax=1&item_id=<?php echo $this->_var['key']; ?>&id=<?php echo $this->_var['content']['id']; ?>',<?php echo $this->_var['key']; ?>)">商品信息</a> <a href="javascript:imagelists_del(<?php echo $this->_var['key']; ?>)">删除</a> </div>
							 
						</div>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					<?php endif; ?>
					</div>
				 	<div class="reply_lists_item add" id="tiem"  >
						<a href="javascript:imagelists_add()"> 新增</a>
					</div>
				 
				
				
			</div>
			 
			 
			<div class="clear"></div>
			
		</form>
		</div>
	</div>
	<div class="clear"></div>
 
 
 </div>
<script type="text/javascript" src="tlwx_templates/js/js_reply.js"></script>   
<div id="reply_add_ajax_NeiRong" style="z-index:9999000; top:50px; position:absolute; width:442px; height:780px;BORDER: #444444 5px solid; display:none; background-color:#FFFFFF; padding:15px;">

</div>
 
<div id="reply_add_ajax_BJ" style="position:absolute; width:100px; height:100%; z-index:999; top:0px; display:none; left:0px; display:none; background-color:#CCCCCC;filter:alpha(opacity=30);-moz-opacity:0.5;opacity: 0.48;">
</div>
 
 	
 
 
 
 
<script type="text/javascript">

 
	
	 
	$("#url_sel").click( 
	
	
		function(){
			if(document.getElementById("url_sel").disabled == false){
				 
				document.getElementById("url_sel").disabled = true
				$("#url_sel").val("")	 
			}else{	 
				document.getElementById("url_sel").disabled = false
				 
			}
		}
	);	
	
  

</script>
 
 
<script language="JavaScript"> 
 
 	 
	 //多个图片追加
	 
	<?php if ($this->_var['detail']['num'] != ""): ?>
		ids=<?php echo $this->_var['detail']['num']; ?>-1;
	<?php else: ?>
		ids=1;
	<?php endif; ?>
	
	function imagelists_add(){
		 	 
		 	 
			  
			 if(ids<=7){
				 
			    s='<div class="reply_lists_item" id="item_'+ids+'" onmouseover="editor_div('+ids+',this)"><div class="item_title" id="item_title_'+ids+'" >标题</div><div class="item_image" id="item_image_'+ids+'" >缩略图</div><div class="clear"></div></div><div id="editor_div_'+ids+'" class="editor_div_time" style="display:none" onmouseout="editor_div_none(this)"><a href="javascript:reply_add_ajax_NeiRong(\'tlwx.php?m=Reply&a=content_add&ajax=1&item_id='+ids+'\','+ids+')">图文信息</a> <a href="javascript:XianShi_NeiRong(\'tlwx.php?m=Reply&a=goods_add&ajax=1&item_id='+ids+'\')">商品信息</a><a href="javascript:imagelists_del(1)">删除</a> </div><input id="item_id_'+ids+'" name="item_id[]" type="hidden" value="" > <input id="item_cata_'+ids+'" name="item_cata[]" type="hidden" value="" >';
				 
				$("#reply_lists_item_div").append(s);
				ids++;
			 }else{
				 
				alert("最多添加8条")	 
			}
	}
	function imagelists_del(key,item_id){
		 
		 
		 
		 if(ids>1){
			 $("#item_"+id).remove();
			 $("#editor_div_"+id).remove();
			 ids--;
			 
		 }else{
			 alert("最少添加2条")	 
				 
		}
		  
		 
		 
	}
 	function editor_div(id,obj){
	 
			t=obj.offsetTop
			l=obj.offsetLeft
			w=obj.offsetWidth
			h=obj.offsetHeight
			 
			document.getElementById('editor_div_'+id).style.top=t+"px";
			document.getElementById('editor_div_'+id).style.left=l+"px";
			document.getElementById('editor_div_'+id).style.width=w+"px";
			document.getElementById('editor_div_'+id).style.height=h+"px";
			 
			document.getElementById('editor_div_'+id).style.display='';
			  
		 
	}
	function editor_div_none(obj){
		obj.style.display='none';
	}
 
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
		 if($("#item_id_1").val()==""){
		 	alert("最少需要添加两条信息");
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
	

  
 	$(function(){
		$(".b_image").each(function(i){
		 
			var w = $(this).width();
			var h = $(this).height();
			var s_w=360;
			var s_h=h*s_w/w 
			$(this).attr({width:s_w, height:s_h});
		});
		$(".s_image").each(function(i){
		 
			var w = $(this).width();
			var h = $(this).height();
			var s_w=80;
			var s_h=h*s_w/w 
			$(this).attr({width:s_w, height:s_h});
		});
	});


 
 
 
</script>
 
<?php echo $this->fetch('pagefooter.htm'); ?>
