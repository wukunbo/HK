<!-- $Id: goods_info.htm 17126 2010-04-23 10:30:26Z liuhui $ -->
<?php echo $this->fetch('pageheader.htm'); ?>

 



<div id="weixin_content">
 	 
	<div class="right wide">
		 <form method="post" id="save" name="save" action="tlwx.php?m=Config&a=insert_updata&type=setting" >	  
		<div class="head">微信配置</div>
		 
  
 
		<?php echo $this->fetch('tlwx_sysmsg.htm'); ?>
		<div class="content form_coomm">
			<div class="form_item" >
					<label>公众号类型	:</label>
					 
					<span class="input_box" style="border:none;"> 
					<select id="weixin_type" name="post[weixin_type]"> 
							<option value="text"   >普通回复</option>
							 
							<option value="subscribe" >关注回复</option>
							<option value="CLICK" >点击事件</option>
						</select>
					</span>
			</div> 
			<div class="form_item" >
					<label>关键字:</label>
					 
					<span class="input_box"><input type="txt" name="post[keywords]" id="points_guanzhu"   value=""></span>
			</div> 
			 
			<div class="button">
				<input name="save" id="subimt" onclick="sava()" type="button" value="保存" />
			</div>
		</div>
		<div id="res" style="padding:10px; font-size:16px;">
		
		</div>
		</form>
	</div>
	<div class="clear"></div>
</div>
 
<?php echo $this->fetch('tlwx_pagefooter.htm'); ?>
 


<script type="text/javascript">
	
function sava(){
	$.ajax({        
      //  url: "vote.php?c=Vote&a=vote_log&id_str="+id_str,
	  	url: "<?php echo $this->_var['url']; ?>&test=1",
        type: "post",
		data:$("#save").serialize(),
        dataType: "text", 
        success:function(re){   
			 
			 $("#res").html(html_encode(re));
		},
		error:function(e){
			 
			alert(JSON.stringify(e));
		}
	})
}	
//解码
  function html_decode(str)
  {
    var s = "";
    if (str.length == 0) return "";
    s = str.replace(/>/g, "&");
    s = s.replace(/</g, "<");
    s = s.replace(/>/g, ">");
    s = s.replace(/ /g, " ");
    s = s.replace(/'/g, "\'");
    s = s.replace(/"/g, "\"");
    s = s.replace(/<br>/g, "\n");
    return s;
  }
  function html_encode(str)
  {
    var s = "";
    if (str.length == 0) return "";
    s = str.replace(/&/g, ">");
    s = s.replace(/</g, "&lt;");
    s = s.replace(/>/g, "&gt;");
    s = s.replace(/ /g, " ");
    s = s.replace(/\'/g, "'");
    s = s.replace(/\"/g, '"');
    s = s.replace(/\n/g, "<br>");
    return s;
  }
 
</script>