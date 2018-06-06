<!-- $Id: goods_info.htm 17126 2010-04-23 10:30:26Z liuhui $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
 
 <div id="weixin_content">
 	<div class="left">
		<?php echo $this->fetch('Reply_left.htm'); ?>
		 
	</div>
	<div class="right">
		<div class="head">回复素材</div>
		<div class="content">
				<div class="reply_display_lists">
					<div class="reply_image" id="reply_image" onmouseover="editor_div(0,this)" >封面图片</div>
					<div class="reply_title_more" id="reply_title">标题</div>
					<div id="editor_div_0" class="editor_div_0" style="display:none" onmouseout="editor_div_none(this)">
					
					<a href="tlwx.php?m=Reply&a=add&reply_type=single"  > 
					+  单图文
					</a>
					<a  href="tlwx.php?m=Reply&a=add&reply_type=more"  > 
						+  多图文
					</a>
					</div>
					 

					 
				</div>
						
 
			 
			<div id="brand-waterfall">
			 
			<?php $_from = $this->_var['lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'lists_0_19250900_1461271419');if (count($_from)):
    foreach ($_from AS $this->_var['lists_0_19250900_1461271419']):
?>
					<div class="weixin_reply_lists item">
						<div class="reply_title" id="reply_title"><?php echo $this->_var['lists_0_19250900_1461271419']['title']; ?></div>
						<div class="reply_time" id="reply_time"><?php echo $this->_var['lists_0_19250900_1461271419']['addtime']; ?></div>
						<div class="reply_image" id="reply_image"><img class="b_image" src="../<?php echo $this->_var['lists_0_19250900_1461271419']['image']; ?>"   ></div>
						<div class="reply_summary" id="reply_summary"><?php echo $this->_var['lists_0_19250900_1461271419']['summary']; ?></div>
						<div class="reply_button">
							<a href="tlwx.php?m=Reply&a=add&reply_type=<?php echo $this->_var['lists_0_19250900_1461271419']['reply_type']; ?>&id=<?php echo $this->_var['lists_0_19250900_1461271419']['msg_id']; ?>">编辑</a>
							<a href="javascript:drop_confirm('您确定要删除吗?', 'tlwx.php?m=Reply&a=del&id=<?php echo $this->_var['lists_0_19250900_1461271419']['msg_id']; ?>');">删除</a>
							<div class="clear"></div>
						</div>
					</div>				
				 
				
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
			 
				
			</div>
			 
			<div class="clear_20"></div>
		</div>
	</div>
 
 
	
 </div>


<script language="JavaScript"> 
 
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
	
	 
	$("#cata_words").click(
		function (){
			 
		}
	);
	$("#word_image_add").mouseover(
		 
	);
  $(function(){
		$(".b_image").each(function(i){
		 
			var w = $(this).width();
			var h = $(this).height();
			var s_w=260;
			var s_h=h*s_w/w 
			$(this).attr({width: s_w, height:s_h});
			
		});
		
		$(".s_image").each(function(i){
		 
			var w = $(this).width();
			var h = $(this).height();
			var s_w=80;
			var s_h=h*s_w/w 
			$(this).attr({width: s_w, height:s_h});
			
		});	
	
	
   })
   
</script>
 
<?php echo $this->fetch('pagefooter.htm'); ?>
 