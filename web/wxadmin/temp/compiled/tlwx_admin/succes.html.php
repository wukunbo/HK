 
<style>
body{background:none;}
 
</style>
<div class="list has-header" style="padding-top:0px; overflow:hidden;">
	<div style=" left:15%; position:relative; margin-top:30px; width:70%;">
		<div style="border:#ddd 1px solid; height:auto; overflow:hidden">
			<div style="line-height:35px; color:#fff; background:#c29e62; padding-left:10px;">提示</div>
			<div style="text-align:center; line-height:100px;"><?php echo $this->_var['msg']; ?></div>
		</div>
	</div>
</div>
 
<script>
//延迟跳转
function change_page(url,time){
	setTimeout("location_href('"+url+"')",time);
}
function location_href(url){
	location.href=""+url+"";
}
var url='<?php echo $this->_var['url']; ?>';
if(url!='-1'){
	 change_page(url,2000);
}
</script>
