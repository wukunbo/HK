<div class="weixin"> 
		<div class="ajax_title">
			<div class="left">选择图文</div>
			<div class="right"><a href="javascript:XianShi_GuanBi()">关闭</a></div>
			 <div class="clear"></div>	
		</div>
		<div class="ajax_content" id="ajax_content">

			<?php $_from = $this->_var['lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'lists_0_12241700_1469515683');if (count($_from)):
    foreach ($_from AS $this->_var['lists_0_12241700_1469515683']):
?>
				<?php if ($this->_var['lists_0_12241700_1469515683']['reply_type'] == 'more'): ?>
					<div class="weixin_reply_lists item" id="reply_sel_<?php echo $this->_var['lists_0_12241700_1469515683']['msg_id']; ?>" onmouseover="sel_div(<?php echo $this->_var['lists_0_12241700_1469515683']['msg_id']; ?>,this)">
						 
						<div class="reply_title" id="reply_time"><?php echo $this->_var['lists_0_12241700_1469515683']['addtime']; ?></div>
						<div class="reply_image" id="reply_image"><img class="b_image" src="../<?php echo $this->_var['lists_0_12241700_1469515683']['image']; ?>" width="260" height="144" ></div>
						<div class="reply_title_more" id="reply_title"><?php if ($this->_var['lists_0_12241700_1469515683']['image'] != ""): ?><?php echo $this->_var['lists_0_12241700_1469515683']['title']; ?><?php else: ?>标题<?php endif; ?></div>
											
						 
					</div>
					<div id="sel_div_<?php echo $this->_var['lists_0_12241700_1469515683']['msg_id']; ?>" class="sel_div" style="display:none" onmouseout="sel_div_none(this)" onclick="javascript:reply_sel('<?php echo $this->_var['lists_0_12241700_1469515683']['msg_id']; ?>')"><a href="#">选择</a></div>
				<?php else: ?>
					<div class="weixin_reply_lists item" id="reply_sel_<?php echo $this->_var['lists_0_12241700_1469515683']['msg_id']; ?>"  onmouseover="sel_div(<?php echo $this->_var['lists_0_12241700_1469515683']['msg_id']; ?>,this)">
						<div class="reply_title" id="reply_title"><?php echo $this->_var['lists_0_12241700_1469515683']['title']; ?></div>
						<div class="reply_title" id="reply_time"><?php echo $this->_var['lists_0_12241700_1469515683']['addtime']; ?></div>
						<div class="reply_image" id="reply_image"><img class="b_image" src="../<?php echo $this->_var['lists_0_12241700_1469515683']['image']; ?>" ></div>
						<div class="reply_summary" id="reply_summary"><?php echo $this->_var['lists_0_12241700_1469515683']['summary']; ?></div>
						 
					</div>				
					<div id="sel_div_<?php echo $this->_var['lists_0_12241700_1469515683']['msg_id']; ?>" class="sel_div" style="display:none" onmouseout="sel_div_none(this)" onclick="javascript:reply_sel('<?php echo $this->_var['lists_0_12241700_1469515683']['msg_id']; ?>')"><a href="#">选择</a></div>
				<?php endif; ?>
				
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			   <div class="clear"></div>	
		</div>				
</div>			   
			   
<script>

	
	function reply_sel(id){	
		$("#msg_cata").val('article')
		$("#msg_id").val(id)
		s=$("#reply_sel_"+id);
		$("#context_reply").html(s);
		document.getElementById("context_reply").style.display=""; 
		document.getElementById("context").style.display="none"; 
		document.getElementById("textCounterTxt").style.display="none"; 
					
		XianShi_GuanBi();
		 
	}
 
 	function sel_div(id,obj){
	 
			t=obj.offsetTop
			l=obj.offsetLeft
			w=obj.offsetWidth
			h=obj.offsetHeight
			 
			document.getElementById('sel_div_'+id).style.top=t+"px";
			document.getElementById('sel_div_'+id).style.left=l+"px";
			document.getElementById('sel_div_'+id).style.width=w+"px";
			document.getElementById('sel_div_'+id).style.height=h+"px";
			 
			document.getElementById('sel_div_'+id).style.display='';
			
			document.getElementById('sel_div_'+id).style.lineHeight=h+"px";
			 

	}
	function sel_div_none(obj){
		obj.style.display='none';
	}	
</script>