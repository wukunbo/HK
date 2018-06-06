 
<?php echo $this->fetch('pageheader.htm'); ?>
 

<div id="weixin_content">
 	<div class="left" id="weixin_content_left">
		<?php echo $this->fetch('Reply_left.htm'); ?>
		 
	</div>
	<div class="right">
		<form method="post" id="upload" name="upload" action="tlwx.php?m=Keyword&a=insert_updata" >	 
		<div class="head">关注时自动回复</div>
		 
			 
			<input id="keyword_cata" name="data[keyword_cata]" type="hidden" value="<?php echo $this->_var['detail']['keyword_cata']; ?>" >
			<input id="msg_cata" name="data[msg_cata]" type="hidden" value="<?php echo $this->_var['detail']['msg_cata']; ?>" >
			<input id="msg_id" name="data[msg_id]" type="hidden" value="<?php echo $this->_var['detail']['msg_id']; ?>" >
			<input id="id" name="id" type="hidden" value="<?php echo $this->_var['detail']['id']; ?>" >
 
		<div class="tips"><?php echo $this->_var['detail']['tips']; ?></div>
		<div class="editor">
			<div class="cata" id="cata">
				<a href="javascript:void(0)" class="cur" data-id="txt" id="cata_txt">文字</a>
				<a style="display:none" href="javascript:void(0)" data-url="tlwx.php?m=Material&a=lists&cata=image" data-id="image" id="cata_image">图片</a>
				<a href="javascript:void(0)" data-url="tlwx.php?m=Reply&a=lists_ajax" data-id="article" id="cata_article">图文</a>
				<a style="display:none" href="javascript:void(0)" data-url="tlwx.php?m=Material&a=lists&cata=mp3" data-id="mp3" id="cata_mp3">声音</a>
				<a style="display:none" href="javascript:void(0)" data-url="tlwx.php?m=Material&a=lists&cata=video" data-id="video" id="cata_video">视频</a>	
			</div>
 
			<div class="context">
				<textarea  cols="60" id="context" name="data[context]" rows="10" onKeyDown="textCounter('context','textCounter',600);" onKeyUp="textCounter('context','textCounter',600);"><?php echo $this->_var['detail']['context']; ?></textarea>
				<div id="context_reply">
				 	<?php if ($this->_var['detail']['msg_cata'] == 'article' && $this->_var['detail']['msg']['id'] != ''): ?>
								<?php if ($this->_var['detail']['msg']['reply_type'] == 'more'): ?>
									<div class="weixin_reply_lists item"  >
								 
										<div class="reply_title" id="reply_time"><?php echo $this->_var['detail']['msg']['addtime']; ?></div>
										<div class="reply_image" id="reply_image"><img class="b_image" src="../<?php echo $this->_var['detail']['msg']['image']; ?>" width="260" height="144" ></div>
										<div class="reply_title_more" id="reply_title"><?php echo $this->_var['detail']['msg']['title']; ?></div>
									</div>
									
								<?php else: ?>
									<div class="weixin_reply_lists item"  >
										<div class="reply_title" id="reply_title"><?php echo $this->_var['detail']['msg']['title']; ?></div>
										<div class="reply_title" id="reply_time"><?php echo $this->_var['detail']['msg']['addtime']; ?></div>
										<div class="reply_image" id="reply_image"><img class="b_image" src="../<?php echo $this->_var['detail']['msg']['image']; ?>" width="260" height="144" ></div>
										<div class="reply_summary" id="reply_summary"><?php echo $this->_var['detail']['msg']['summary']; ?></div>
										 
									</div>					
									 
								<?php endif; ?>
					<?php endif; ?>	
					<?php if ($this->_var['detail']['msg_cata'] == 'article' && $this->_var['detail']['msg']['id'] == ''): ?>
						该图文已被删除。
					<?php endif; ?>	
							 			
				</div>
			</div>
			<div id="textCounterTxt">你还可以输入<span id="textCounter">600</span>字</div>
			
			<div class="clear"></div>
		</div>
		<div class="button">
			<input name="save" id="save" type="submit" value="保存" />
		</div>
		</form>
	</div>
	<div class="clear"></div>
</div>
<script type="text/javascript" src="tlwx_templates/js/js_reply.js"></script>  
<?php echo $this->fetch('pagefooter.htm'); ?>
<script>
//关键字判断，载入时切换
<?php if ($this->_var['detail']['msg_cata'] != ""): ?>
	context_cata="<?php echo $this->_var['detail']['msg_cata']; ?>";
	cata_change(context_cata,'cata_'+context_cata);
<?php endif; ?>
 
</script>
 

 


 