<!-- $Id: goods_info.htm 17126 2010-04-23 10:30:26Z liuhui $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
 
 



<div id="weixin_content">
 	<div class="left">
		<?php echo $this->fetch('Reply_left.htm'); ?>
		 
	</div>
	<div class="right">
		<div class="head">关键词自动回复</div>
		<form method="post" id="upload" name="upload" action="tlwx.php?m=Keyword&a=insert_updata_keyword" >	 
			 
			<input id="keyword_cata" name="data[keyword_cata]" type="hidden" value="keyword" >
			<input id="msg_cata" name="data[msg_cata]" type="hidden" value="<?php echo $this->_var['detail']['keyword']['0']['msg_cata']; ?>" >
			<input id="msg_id" name="data[msg_id]" type="hidden" value="<?php echo $this->_var['detail']['keyword']['0']['msg_id']; ?>" >
			<input id="rule_id" name="rule_id" type="hidden" value="<?php echo $this->_var['detail']['id']; ?>" >
 
		<div class="tips">当用户回复该该关键词时，系统自动回复该用户的信息。</div>
		<div class="form">
			<div class="form_item" >
					<label>规则名：</label>
					<span class="input_box"><input type="txt" name="rule_title" id="rule_title" value="<?php echo $this->_var['detail']['title']; ?>"></span>
			</div>
		 
			<div class="form_item" >
				 <div class="form_left">
					<label>关键词：<br />
 <a href="javascript:keyword_add()"> 增加关键字</a></label>
				 </div>
				 <div class="form_right" id="keyword_list">
				 <?php if ($this->_var['detail']['id'] == ""): ?>
					 <div id="keyword_0">
						<span class="input_box"><input type="txt" name="title[]" id="title" value="<?php echo $this->_var['detail']['title']; ?>"></span>
						<span class="sel"><input name="match_rule_sel[]" id="match_rule_sel" type="checkbox" value="part" onclick="sel_match_rule('0')"/>部分匹配 </span>
						<input type="hidden" name="keyword_id[]" id="keyword" value="<?php echo $this->_var['detail']['id']; ?>">
						<input type="hidden" name="match_rule[]" id="match_rule_0" value="all">
						<div class="clear"></div>
					 </div>
				 <?php else: ?>
				
				 	<?php $_from = $this->_var['detail']['keyword']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'keyword_list');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['keyword_list']):
?>
						<div id="keyword_<?php echo $this->_var['key']; ?>">
							<span class="input_box"><input type="txt" name="title[]" id="title" value="<?php echo $this->_var['keyword_list']['title']; ?>"></span>
							<span class="sel"><input name="match_rule_sel[]" id="match_rule_sel" type="checkbox" value="part" onclick="sel_match_rule('<?php echo $this->_var['key']; ?>')" <?php if ($this->_var['keyword_list']['match_rule'] == "part"): ?> checked="checked"<?php endif; ?>/>部分匹配 <?php if ($this->_var['key'] > 0): ?><a href="javascript:keyword_del('<?php echo $this->_var['key']; ?>','<?php echo $this->_var['keyword_list']['id']; ?>','<?php echo $this->_var['detail']['id']; ?>')">删除</a><?php endif; ?></span>
							<input type="hidden" name="keyword_id[]" id="keyword" value="<?php echo $this->_var['keyword_list']['id']; ?>">
							<input type="hidden" name="match_rule[]" id="match_rule_<?php echo $this->_var['key']; ?>" value="<?php echo $this->_var['keyword_list']['match_rule']; ?>">
							<div class="clear"></div>
						 </div>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				 <?php endif; ?>
				 
				 </div>
			</div>
			 
		</div>
		<div class="editor">
			 
			<div class="cata" id="cata">
				<a href="javascript:void(0)" class="cur" data-id="txt" id="cata_txt">文字</a>
				<a style="display:none" href="javascript:void(0)" data-url="tlwx.php?m=Material&a=lists&cata=image" data-id="image" id="cata_image">图片</a>
				<a href="javascript:void(0)" data-url="tlwx.php?m=Reply&a=lists_ajax" data-id="article" id="cata_article">图文</a>
				<a style="display:none" href="javascript:void(0)" data-url="tlwx.php?m=Material&a=lists&cata=mp3" data-id="mp3" id="cata_mp3">声音</a>
				<a style="display:none" href="javascript:void(0)" data-url="tlwx.php?m=Material&a=lists&cata=video" data-id="video" id="cata_video">视频</a>	
			</div>
			<div class="context">
				<textarea  cols="60" id="context" name="data[context]" rows="10" onKeyDown="textCounter('context','textCounter',600);" onKeyUp="textCounter('context','textCounter',600);"><?php echo $this->_var['detail']['keyword']['0']['context']; ?></textarea>
				<div id="context_reply" style="display:none">
				 		<?php if ($this->_var['detail']['keyword']['0']['msg_cata'] == 'article'): ?>
								<?php if ($this->_var['detail']['keyword']['0']['msg']['reply_type'] == 'more'): ?>
									<div class="weixin_reply_lists item"  >
								 
										<div class="reply_title" id="reply_time"><?php echo $this->_var['detail']['keyword']['0']['msg']['addtime']; ?></div>
										<div class="reply_image" id="reply_image"><img class="b_image" src="../<?php echo $this->_var['detail']['keyword']['0']['msg']['image']; ?>" width="260" height="144" ></div>
										<div class="reply_title_more" id="reply_title"><?php echo $this->_var['lists']['keyword']['0']['msg']['title']; ?></div>
									</div>
									
								<?php else: ?>
									<div class="weixin_reply_lists item"  >
										<div class="reply_title" id="reply_title"><?php echo $this->_var['detail']['keyword']['0']['msg']['title']; ?></div>
										<div class="reply_title" id="reply_time"><?php echo $this->_var['detail']['keyword']['0']['msg']['addtime']; ?></div>
										<div class="reply_image" id="reply_image"><img class="b_image" src="../<?php echo $this->_var['detail']['keyword']['0']['msg']['image']; ?>" width="260" height="144" ></div>
										<div class="reply_summary" id="reply_summary"><?php echo $this->_var['detail']['keyword']['0']['msg']['summary']; ?></div>
										 
									</div>					
									 
								<?php endif; ?>
						<?php endif; ?>			
							 			
				</div>
			</div>
			<div id="textCounterTxt">你还可以输入<span id="textCounter">600</span>字</div>
			
			<div class="clear"></div>
		</div>
		<div class="button">
			<input name="save" id="save" type="button" value="保存" />
		</div>
	</div>
	</form>
	<div class="clear"></div>
</div>

<?php echo $this->fetch('pagefooter.htm'); ?>
<script type="text/javascript" src="tlwx_templates/js/js_reply.js"></script>  

<script type="text/javascript">

//关键字判断，载入时切换
<?php if ($this->_var['detail']['keyword']['0']['msg_cata'] != ""): ?>
	context_cata="<?php echo $this->_var['detail']['keyword']['0']['msg_cata']; ?>";
	cata_change(context_cata,'cata_'+context_cata);
<?php endif; ?>
 

//获取关键字数
<?php if ($this->_var['detail']['keyword_count'] == ""): ?>
	ids=1;
<?php else: ?>
	ids=<?php echo $this->_var['detail']['keyword_count']; ?>;
<?php endif; ?>



function keyword_reply_dis(obj,id){
	if(document.getElementById("keyword_reply_"+id).style.display==""){
		document.getElementById("keyword_reply_"+id).style.display="none"
		obj.innerHTML="展开";
	}else{
		document.getElementById("keyword_reply_"+id).style.display=""
		obj.innerHTML="收起";		
	}
	
}

 

function keyword_add(){
		 	 
			 
 
	s='<div id="keyword_'+ids+'"><span class="input_box" ><input type="txt" name="title[]" id="title" value=""></span><span class="sel"><input name="match_rule_sel[]" id="match_rule_sel" type="checkbox" value="part" onclick="sel_match_rule('+ids+')"/>部分匹配<input type="hidden" name="keyword_id[]" id="keyword" value=""> <a href="javascript:keyword_del('+ids+')">删除</a> </div></span><input type="hidden" name="match_rule[]" id="match_rule_'+ids+'" value="all"></div>';
				 
	$("#keyword_list").append(s);
	ids++;
		
}
function keyword_del(id,del_id,rule_id){
	if(del_id!=""){
		$.get("weixin_app.php", {id: del_id, rule_id: rule_id, action: "del_keyword" , ajax: "1"},
		  function(data){
				//alert("Data Loaded: " + data);
		 	}
		);
	}
	 
	$("#keyword_"+id).remove();
	ids--;

}
	
function sel_match_rule(id){
		s=$("#match_rule_"+id).val()	 
		if(s == "all"){
			 
			$("#match_rule_"+id).val("part")	 
			 
		}else{	 
			 
			$("#match_rule_"+id).val("all")
		}		
}	
	
$("#cata_words").click( 
	function(){
		$("#context_cata").val(1)
		 
		document.getElementById("context").style.display=""; 
		document.getElementById("textCounterTxt").style.display=""; 
		document.getElementById("context_reply").style.display="none"; 
		$("#cata_words").addClass("cur");
		$("#cata_msg").removeClass("cur");
	}
);	

$("#cata_msg").click( 
	function(){
		$("#context_cata").val(2)
		document.getElementById("context").style.display="none"; 
		document.getElementById("textCounterTxt").style.display="none"; 
 
		document.getElementById("context_reply").style.display=""; 
		$("#cata_msg").addClass("cur");
		$("#cata_words").removeClass("cur");
	}
);	
 
$("#save").click( 
		function(){
			 if($("#context").val()=="" && $("#reply_id").val()==""){
				alert("内容不能为空");
				return false;
			 }
		 	document.getElementById("upload").submit(); 
		 }
);	
 

function textCounter(obj, countfield, maxlimit) { 
   // 函数，3个参数，表单名字，表单域元素名，限制字符； 
   obj=document.getElementById(obj);
   if (obj.value.length > maxlimit) {
   //如果元素区字符数大于最大字符数，按照最大字符数截断； 
   		obj.value = obj.value.substring(0, maxlimit); 
   }else {
   //在记数区文本框内显示剩余的字符数； 
   		document.getElementById(countfield).innerHTML = maxlimit - obj.value.length; 
   }
}  
</script>