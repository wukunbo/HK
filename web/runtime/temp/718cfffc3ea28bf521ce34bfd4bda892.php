<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:64:"D:\xampp\htdocs\HK\web/application/shop\view\Public\showmsg.html";i:1526623367;}*/ ?>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
<title>提示信息</title>
</head>


<style>
body{ background:none;}
 
</style>
<div class="list has-header" style="padding-top:0px; overflow:hidden;">
    <div style=" left:15%; position:relative; margin-top:30px; width:70%;">
        <div style="border:#ddd 1px solid; height:auto; overflow:hidden">
            <div style="line-height:35px; color:#fff; background:#c29e62; padding-left:10px;">提示</div>
            <div style="text-align:center; line-height:100px;"><?php echo $msg; ?></div>
        </div>
    </div>
</div>
<script>
// 调整链接
var url="<?php echo $url; ?>";
window.setTimeout(change_page,2000); 
 
function change_page(){
    if(url){
        location.href=url;
    }else{
        history.back(-1);
    }

}
</script>
