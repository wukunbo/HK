<!-- $Id: goods_info.htm 17126 2010-04-23 10:30:26Z liuhui $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<link href="styles/weixin_app.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/weixin_app.js"></script>
 



<div id="weixin_content">
 	<div class="left">
		<?php echo $this->fetch('Reply_left.htm'); ?>
		 
	</div>
	<div class="right">
		<div class="head">关键词自动回复</div>
 
		<div class="tips">当用户回复该该关键词时，系统自动回复该用户的信息。</div>
		<div class="btn_a"><a href="tlwx.php?m=Keyword&a=add">创建回复的信息</a></div>
 		<div class="clear_05"></div>
 		<?php $_from = $this->_var['lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'lists_0_28754900_1461271416');if (count($_from)):
    foreach ($_from AS $this->_var['lists_0_28754900_1461271416']):
?>
		<div class="weixin_keyword_lists" id="rule_<?php echo $this->_var['lists_0_28754900_1461271416']['id']; ?>">
			<div class="keyword_lists_title" >
					<label>规则名：</label>
					<span class="text"><?php echo $this->_var['lists_0_28754900_1461271416']['title']; ?></span>
					 
					<div class="dis" onclick="keyword_reply_dis(this,<?php echo $this->_var['lists_0_28754900_1461271416']['id']; ?>)">展开</div>
					<div class="dis"  ><a href="tlwx.php?m=Keyword&a=add&rule_id=<?php echo $this->_var['lists_0_28754900_1461271416']['id']; ?>">修改</a></div>
					<div class="dis" onclick="rule_del(<?php echo $this->_var['lists_0_28754900_1461271416']['id']; ?>)">删除</div>
					
			</div>
			<div class="clear"></div>
			<div class="keyword_lists_item" >
				 <div class="keyword_lists_left">
					<label>关键词：</label>
				 </div>
				 <div class="keyword_lists_right" >
				 	<?php $_from = $this->_var['lists_0_28754900_1461271416']['keyword']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'keyword_lists');if (count($_from)):
    foreach ($_from AS $this->_var['keyword_lists']):
?>
					<span class="input_box"><?php echo $this->_var['keyword_lists']['title']; ?></span>
					<span class="sel">
						<?php if ($this->_var['keyword_lists']['match_rule'] == "part"): ?>
							部分匹配
						<?php else: ?>
							完全匹配
						<?php endif; ?>	
					</span>
					<div class="clear"></div>
					 
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				 </div>
			</div>
			<div class="clear"></div>
			<div class="keyword_lists" id="keyword_reply_<?php echo $this->_var['lists_0_28754900_1461271416']['id']; ?>" >
			<div class="keyword_lists_item"   >
				 <div class="keyword_lists_left">
					<label>回复：</label>
				 </div>
				 <div class="keyword_lists_right" >
				  
				 	 <?php if ($this->_var['lists_0_28754900_1461271416']['keyword']['0']['msg_cata'] == 'txt'): ?>
					 	<?php echo nl2br($this->_var['lists_0_28754900_1461271416']['keyword']['0']['context']); ?>	
					 <?php else: ?>	
					 	<?php if ($this->_var['lists_0_28754900_1461271416']['keyword']['0']['msg']['msg_id'] != ''): ?>
							<?php if ($this->_var['lists_0_28754900_1461271416']['keyword']['0']['msg']['reply_type'] == 'more'): ?>
								<div class="weixin_reply_lists item"  >
									  
									<div class="reply_title" id="reply_time"><?php echo $this->_var['lists_0_28754900_1461271416']['keyword']['0']['msg']['addtime']; ?></div>
									<div class="reply_image" id="reply_image"><img class="b_image" src="../<?php echo $this->_var['lists_0_28754900_1461271416']['keyword']['0']['msg']['image']; ?>" width="260" height="144" ></div>
									<div class="reply_title_more" id="reply_title"><?php echo $this->_var['lists_0_28754900_1461271416']['keyword']['0']['msg']['title']; ?></div>
								</div>
								 
							<?php else: ?>
								<div class="weixin_reply_lists item"  >
									<div class="reply_title" id="reply_title"><?php echo $this->_var['lists_0_28754900_1461271416']['keyword']['0']['msg']['title']; ?></div>
									<div class="reply_title" id="reply_time"><?php echo $this->_var['lists_0_28754900_1461271416']['keyword']['0']['msg']['addtime']; ?></div>
									<div class="reply_image" id="reply_image"><img class="b_image" src="../<?php echo $this->_var['lists_0_28754900_1461271416']['keyword']['0']['msg']['image']; ?>" width="260" height="144" ></div>
									<div class="reply_summary" id="reply_summary"><?php echo $this->_var['lists_0_28754900_1461271416']['keyword']['0']['msg']['summary']; ?></div>
									 
								</div>				
								 
							<?php endif; ?>	
						<?php else: ?>	
						 
							该图文已被删除。
						<?php endif; ?>						
					 <?php endif; ?>
 					 
						
				 
					<div class="clear"></div>
					 
				 </div>
			</div>
			</div>
			<div class="clear"></div>
		</div>		
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		
		
		 
	</div>
	 
	<div class="clear"></div>
</div>

<div id="XianShi_NeiRong" style="z-index:9999000; top:50px; position:absolute; width:800px; height:500px;BORDER: #444444 5px solid; height:auto;display:none; background-color:#FFFFFF; padding:15px;"></div>
 
<div id="XianShi_BJ" style="position:absolute; width:100px; height:100%; z-index:999; top:0px; display:none; left:0px; display:none; background-color:#CCCCCC;filter:alpha(opacity=30);-moz-opacity:0.5;opacity: 0.48;"></div>


<script type="text/javascript">

function rule_del(del_id){
	if (confirm("请确认删除，此操作不可恢复。")==true){
			 
 
		if(del_id!=""){
			$.get("tlwx.php?m=Keyword&a=del_rule&id="+del_id,
			  function(data){
					//alert("Data Loaded: " + data);
				}
			);
		}
		 
		$("#rule_"+del_id).remove();
	}else{
		 return false;
	}
 
}

 

function keyword_reply_dis(obj,id){
	if(document.getElementById("keyword_reply_"+id).style.display==""){
		document.getElementById("keyword_reply_"+id).style.display="none"
		
		obj.innerHTML="展开";
	}else{
		document.getElementById("keyword_reply_"+id).style.display=""
		obj.innerHTML="收起";		
	}
	
}
 
 
 
 
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
    

 //$(".keyword_lists").css( {"display": "none"});
 
</script>