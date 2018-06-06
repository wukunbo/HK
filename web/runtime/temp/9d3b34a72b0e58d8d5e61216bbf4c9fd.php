<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:67:"D:\xampp\htdocs\HK\web/application/userweb\view\Public\showmsg.html";i:1524627727;s:66:"D:\xampp\htdocs\HK\web\application\userweb\view\Public\header.html";i:1524537495;s:66:"D:\xampp\htdocs\HK\web\application\userweb\view\Public\footer.html";i:1524540092;s:66:"D:\xampp\htdocs\HK\web\application\userweb\view\Public\dailog.html";i:1524558591;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $page_title; ?></title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="/HK/web/public/static/userweb/static//lte/bootstrap/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="/HK/web/public/static/userweb/static//lte/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="/HK/web/public/static/userweb/static//lte/dist/css/skins/_all-skins.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="/HK/web/public/static/userweb/static//lte/plugins/iCheck/flat/blue.css">
<!-- Morris chart -->
<link rel="stylesheet" href="/HK/web/public/static/userweb/static//lte/plugins/morris/morris.css">
<!-- jvectormap -->
<link rel="stylesheet" href="/HK/web/public/static/userweb/static//lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
<!-- Date Picker -->
<link rel="stylesheet" href="/HK/web/public/static/userweb/static//lte/plugins/datepicker/datepicker3.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="/HK/web/public/static/userweb/static//lte/plugins/daterangepicker/daterangepicker.css">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="/HK/web/public/static/userweb/static//lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<!-- jQuery 2.2.3 -->
<script src="/HK/web/public/static/userweb/static//lte/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript">
            window.jQuery || document.write("<script src='/HK/web/public/static/userweb/static//lte/plugins/js/jquery-2.1.1.min.js'>"+"<"+"/script>");
</script>

<link rel="stylesheet" href="/HK/web/public/static/userweb/tool//bootstrapvalidator-master/dist/css/bootstrapValidator.css"/>

   
<script type="text/javascript" src="/HK/web/public/static/userweb/tool//bootstrapvalidator-master/vendor/jquery/jquery-1.10.2.min.js"></script>
 
<script type="text/javascript" src="/HK/web/public/static/userweb/tool//bootstrapvalidator-master/dist/js/bootstrapValidator.js"></script>


<!---弹窗-->
<link rel="stylesheet" href="/HK/web/public/static/userweb/tool//lobibox-master/font-awesome/css/font-awesome.min.css"/>
<link rel="stylesheet" href="/HK/web/public/static/userweb/tool//lobibox-master/dist/css/Lobibox.min.css"/>
<script src="/HK/web/public/static/userweb/tool//lobibox-master/js/Lobibox.js"></script>
<link href="/HK/web/public/static/userweb/static//public/css/style.css" rel="stylesheet">
<script src="/HK/web/public/static/userweb/static//public/js/public.js"></script>
<script src="/HK/web/public/static/userweb/tool//public_js/js.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body class="hold-transition skin-blue sidebar-mini" style="padding-top:0px!important;">
 

<link rel="shortcut icon" href="favicon.ico">

<style>
.panel-default{border-top-color:#00c0ef}
</style>

<style>
.form-control_search{line-height:34px; height:34px; width:200px;float:left; margin-right:10px;border: 1px solid #ccc;padding: 6px 12px;font-size: 14px; float:left;}
</style>
<style>
body,html{ font-family:"微软雅黑"!important;padding-top:0px!important;}
 
.panel .panel-heading h2{ height:auto;}
.main{background:#f9f9f9!important;} 
.breadcrumb{ background:#1a3d7f; color:#fff;}
.navbar{background:#f8f8f8; border-bottom:#666 1px solid;box-shadow:2px 2px 2px #ccc; height:60px;  }
 
 .breadcrumb a{ color:#fff;}
.input-group[class*="col-"]{ float:left!important;}
.form-group{ clear:both; margin-bottom:10px; height: auto; overflow: hidden;}
.panel-heading{ background:#fff!important; border-bottom:1px solid #f4f4f4;}
.panel-heading h2{ font-size:16px!important; margin:5px;  font-weight:normal;}
.panel-heading h2 strong{ margin-left:10px;}
</style>
<style>
body{ background:none;}
 
</style>
<div class="list has-header" style="padding-top:0px; overflow:hidden;">
    <div style=" left:15%; position:relative; margin-top:30px; width:70%;">
        <div style="border:#ddd 1px solid; height:auto; overflow:hidden">
            <div style="line-height:35px; color:#fff; background:#000; padding-left:10px;">提示</div>
            <div style="text-align:center; line-height:100px;"><?php echo $msg; ?></div>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<div id="auto_msg" style="position: absolute; display:none; width:250px; z-index:9999999; height:150px; line-height:100%; background:#fff; border:#CCCCCC 1px solid; right:0px; bottom:0px; text-align:center; padding:10px;">
    <a href="javascript:auto_msg_close()" style="display:block; float:right;">关闭</a>
    <a href="userweb.php?c=CashierCashier&a=order_lists&menu_app=Cashier" style="display:block; margin-top:50px;">您有新的订单消息</a>
</div>


<script>
function auto(){
    $.ajax({
        type: "get",
        url: "userweb.php?c=Index&a=auto",
        dataType: "json",       
        success: function(data) {   
            //alert(JSON.stringify(data))
            if(data.status==10001){
                //alert("网络繁忙");
                $("#auto_msg").css("display","block");
                 $("#auto_msg").slideDown("slow");
            }
            //setTimeout("auto()",3000);  
        },
        error:function(e){
            //alert(JSON.stringify(e))
        }
    })
     
}

function auto_msg_close(){
    $("#auto_msg").css("display","none");
     
}

function update(type_tb,field_val,id){
    $.ajax({
        type: "get",
        url: "userweb.php?c=Base&a=update_action&type_tb="+type_tb+"&field_val="+field_val+"&id="+id+"",
        dataType: "json",       
        success: function(data) {   
            //alert(JSON.stringify(data))
            if(data.status==10001){
                 show_tips_time('修改成功',1000);
            }
            //setTimeout("auto()",3000);  
        },
        error:function(e){
            //alert(JSON.stringify(e))
        }
    })  
}

//密码修改
function reset_password(user_id,type_id,type){
    $.ajax({
        type: "get",
        url: "userweb.php?c=UserDetail&a=reset_password&user_id="+user_id+"&type_id="+type_id+"&type="+type+"",
        dataType: "json",       
        success: function(data) {   
            //alert(JSON.stringify(data))
            if(data.status==10001){
                 show_tips_time('修改成功',1000);
            }
            if(data.status==10000){
                 show_tips_time('修改失败',1000);
            }
            //setTimeout("auto()",3000);  
        },
        error:function(e){
            //alert(JSON.stringify(e))
        }
    })  
}

 
</script>


<!-- jQuery 2.2.3 -->
 

<!-- jQuery UI 1.11.4 -->
 <script src="/HK/web/public/static/userweb/static//lte//dist/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="/HK/web/public/static/userweb/static//lte/bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="/HK/web/public/static/userweb/static//lte//dist/raphael-min.js"></script>
<script src="/HK/web/public/static/userweb/static//lte/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="/HK/web/public/static/userweb/static//lte/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/HK/web/public/static/userweb/static//lte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/HK/web/public/static/userweb/static//lte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="/HK/web/public/static/userweb/static//lte/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="/HK/web/public/static/userweb/static//lte/dist/moment.min.js"></script>
<script src="/HK/web/public/static/userweb/static//lte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="/HK/web/public/static/userweb/static//lte/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="/HK/web/public/static/userweb/static//lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="/HK/web/public/static/userweb/static//lte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/HK/web/public/static/userweb/static//lte/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/HK/web/public/static/userweb/static//lte/dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/HK/web/public/static/userweb/static//lte/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/HK/web/public/static/userweb/static//lte/dist/js/demo.js"></script>



</body></html>
<link href="/HK/web/public/static/userweb/tool//dailog/dailog.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/HK/web/public/static/userweb/tool//dailog/dailog.js"></script>
<div style="display: none; height: 591px;" id="show_tips_bg"></div>
<div style="display: none; height: 591px;" id="show_content_bg"></div>
<div id="show_tips" class="box" style="display: none; top: 213px;">
    <h2 style="cursor:pointer;" onClick="show_tips_close()"><a href="javascript:void(0);" class="close">关闭</a>
    </h2>
    <div class="show_tips_title">温馨提示</div>
    <div id="show_tips_msg" class="mainlist">
    </div>
</div>
<div id="show_content" class="show_content_box" style="display: none; left: 320px; top: 213px;   z-index:100000;">
    <h2 style="cursor:pointer;" onClick="show_content_close()"><a href="javascript:void(0);" class="close">关闭</a>
    </h2>
    <div id="show_content_msg" class="mainlist" style="overflow-x:hidden;">
    </div>
</div>
<div style="height: 1324px; display:none; opacity: 0;" id="show_loading_bg" class="overlay"></div>
<div style="opacity:0;display:none;"   id="show_loading"  class="showbox">
    <div class="loadingWord"><img src="/HK/web/public/static/userweb/tool//dailog/waiting.gif">加载中，请稍候...</div>
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
