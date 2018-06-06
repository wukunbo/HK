<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:74:"D:\xampp\htdocs\HK\web/application/userweb\view\Config\material_lists.html";i:1524723801;s:66:"D:\xampp\htdocs\HK\web\application\userweb\view\Public\layout.html";i:1524540430;s:66:"D:\xampp\htdocs\HK\web\application\userweb\view\Public\header.html";i:1524537495;s:66:"D:\xampp\htdocs\HK\web\application\userweb\view\Public\navbar.html";i:1524644679;s:64:"D:\xampp\htdocs\HK\web\application\userweb\view\Public\left.html";i:1524638402;s:64:"D:\xampp\htdocs\HK\web\application\userweb\view\Public\here.html";i:1524622127;s:66:"D:\xampp\htdocs\HK\web\application\userweb\view\Public\footer.html";i:1524540092;}*/ ?>
<!-- 包含头部模版header -->
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
<div class="wrapper">

    <header class="main-header" style=" margin:0px;">
    <!-- Logo -->
    
    <a href="#" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><?php echo $page_title; ?></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><?php echo $page_title; ?></span> </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" style=" height:50px;  ">
        
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                
             
                <li class="dropdown messages-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span class="hidden-xs"><?php echo $userweb_username; ?></span> </a>
                    <ul class="dropdown-menu">
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li> <a href="<?php echo url('Admin/edit_pwd'); ?>"> 密码修改</a> </li>
                                <li> <a href="<?php echo url('Login/logout'); ?>"> 退出</a> </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                
            </ul>
        </div>
    </nav>
</header>
<style>
.messages-menu .menu, .slimScrollDiv {
    height:80px!important;
    width:150px!important;
}
.dropdown-menu {
    width:150px!important;
}
</style>



    <style>
.sidebar-menu .treeview .treeview-menu a{   padding-left:25px;}
.sidebar-menu .treeview .treeview-menu a:hover{ 1background:#0866c6!important; color:#fff!important;}
.sidebar-menu .treeview .treeview-menu .active{ 1background:#0866c6!important; color:#fff!important;}
.sidebar-menu .treeview .treeview-menu .active a{ 1background:#0866c6!important; color:#fff!important;}
.skin-blue .wrapper, .skin-blue .main-sidebar, .skin-blue .left-side{ background:#2c3b41;}
.content-wrapper, .right-side{ background:#f8f8f8;}
.app_lists{ background:#222d32; height:500px; width:70px;}  
.app_lists a{ height:70px!important;; color:#fff!important;; padding-top:15px;    display:block!important; text-align:center;;}
.app_lists a.cur{ background:#1a3d7f!important;;color:#fff!important;;}
.app_lists a i{ display:block; font-size:18px;}
.app_menu_lists { width:180px; padding-left:0px;}

.main-sidebar, .left-side{ width:250px;}
.content-wrapper, .right-side, .main-footer{ margin-left:250px; }
.main-header .logo{ width:250px;}
.main-header .navbar{margin-left:250px;}
.treeview > a{ color:#b8c7ce!important;  font-size:14px;}
.sidebar-menu > div > li > a{ padding:12px 5px 12px 10px;   display:block;}
.treeview-menu {  background:#34464E!important;}    
.sidebar-menu .treeview-menu{ padding-left:0px;  }  
</style>


<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <div class="app_lists nav_main" style="   float:left;">
                <!-- l第一级目录 -->
                <?php if(is_array($left['app_lists']) || $left['app_lists'] instanceof \think\Collection || $left['app_lists'] instanceof \think\Paginator): $i = 0; $__LIST__ = $left['app_lists'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lists): $mod = ($i % 2 );++$i;?>
                    <a href="javascript:selecte_app('<?php echo $lists['val']; ?>')" id="nav_<?php echo $lists['val']; ?>" data="<?php echo $lists['val']; ?>">
                        <i class="fa <?php echo $lists['icon']; ?>"></i><?php echo $lists['title']; ?>
                    </a>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                <!-- END第一级目录 -->
            </div>

            <div class="app_menu_lists" style=" float:right; ">
                <!-- l第二级目录 -->
                <?php if(is_array($auth) || $auth instanceof \think\Collection || $auth instanceof \think\Paginator): $i = 0; $__LIST__ = $auth;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['is_show'] == 1): ?>
                    <li class="<?php echo $vo['app']; ?> app_menu treeview <?php if($vo['cur'] == 1): ?>active<?php endif; ?>"> 
                        <a href="#"> 
                            <i class="fa fa-laptop"></i> <span><?php echo $vo['auth_name']; ?></span> 
                            <span class="pull-right-container"><span class="fa fa-angle-down pull-right"></span></span>
                        </a>
                        <?php if($vo['sub']): ?>
                        <ul class="treeview-menu <?php if($vo['cur'] == 1): ?>tree_cur<?php endif; ?>" >

                            <!-- l第三级目录 -->
                            <?php if(is_array($vo['sub']) || $vo['sub'] instanceof \think\Collection || $vo['sub'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['sub'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if($v['is_show'] == 1): ?>
                                    <li class="<?php if($v['cur'] == 1): ?>active<?php endif; ?>"><a href="http://192.168.1.215/HK/web/userweb.php/<?php echo $v['auth_c']; ?>/<?php echo $v['auth_a']; ?>?<?php echo $v['parameters']; ?>&menu_app=<?php echo $vo['app']; ?>"><i class="fa fa-laptop"></i><?php echo $v['auth_name']; ?></a></li>
                                <?php endif; endforeach; endif; else: echo "" ;endif; ?>            
                        </ul>
                        <?php endif; ?>            
                    </li>
                    <?php endif; ?>
                <!-- END第二级目录 -->
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </ul>
    </section>
</aside>

<script>
    h=$(window).height();

    $(".app_lists").height(h-60);

    $(".basic").show();

    function selecte_app(app){
        $(".app_menu").hide();
        $("."+app+"").show();
        $(".nav_main > a").removeClass("cur");
        $("#nav_"+app+"").addClass("cur");
    }

    selecte_app("<?php echo $auth_all["cur"]["app"]; ?>")
    h=$(window).height();
     
    
</script>
    
    <div class="content-wrapper">
        <script>
$("title").html("<?php echo $cur['ACTION_NAME']; ?>");

</script>

<section class="content-header" style=" margin-top:0px;">
    <h1> <?php echo $page_title; ?> <small><?php echo $cur['ACTION_NAME']; ?></small> </h1>
    <ol class="breadcrumb">
        <li><?php echo $cur['CONTROLLER_NAME']; ?></li>
        <li><?php echo $cur['ACTION_NAME']; ?></li>
    </ol>
</section>


        <section class="content">
            


<div class="panel panel-default">
    <div class="panel-heading">
        <h2><i class="fa fa-th red"></i><strong>素材上传</strong></h2>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <form class="form-horizontal " enctype="multipart/form-data" method="post"  action="<?php echo url('Config/material_add_action'); ?>" id="sava_form" onsubmit="return check();">
                <div class="col-md-2">
                    <select size="1" class="form-control" name="post[cate_id]" id="select">

                        <?php if(is_array($data[cate_lists][content]) || $data[cate_lists][content] instanceof \think\Collection || $data[cate_lists][content] instanceof \think\Paginator): $i = 0; $__LIST__ = $data[cate_lists][content];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lists): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $lists['id']; ?>"><?php echo $lists['title']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="col-md-10">
                    <img alt="Sample Image" src="" style="display:none; width:100px" id="UploadImg_src" class="img-thumbnail">
                    <div id=img_text></div>
                    <button class="btn btn-sm btn-info" id="UploadImg" type="button">选择图片</button>
                    <button class="btn btn-sm btn-success" type="submit"> 提交</button>
                </div>
                <input type="hidden" name="post[img_thumb]" id="material_img_thumb_hidden" value="<?php echo $data['detail']['img_thumb']; ?>">
                <input type="hidden" name="post[img_orogin]" id="material_img_orogin_hidden" value="<?php echo $data['detail']['img_orogin']; ?>">
            </form>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div data-original-title="" class="panel-heading">
        <h2><i class="fa fa-picture-o red"></i><strong>素材列表</strong></h2>
    </div>
    <form action="userweb.php?c=Config&a=change_all" method="post" name="search_form" id="search_form">
        <div class="panel-body">

            <div style="margin-bottom:10px; clear:both; height:auto; overflow:hidden; width:100%; ">
                <a class="btn btn-default"  href="<?php echo url('Config/material_lists'); ?>" style="float:left; margin-right:10px;" type="button">全部</a>
                
                <?php if(is_array($data[cate_lists][content]) || $data[cate_lists][content] instanceof \think\Collection || $data[cate_lists][content] instanceof \think\Paginator): $i = 0; $__LIST__ = $data[cate_lists][content];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lists): $mod = ($i % 2 );++$i;?>
                    <a class="btn btn-default <?php if($search[cate_id] == $lists[id]): ?>btn-primary<?php endif; ?>"  href="<?php echo url('Config/material_lists'); ?>?&return_fn=<?php echo $return_fn; ?>&cate_id=<?php echo $lists[id]; ?>" style="float:left;margin-right:10px;" type="button"><?php echo $lists['title']; ?></a>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div class="row">
                 
                <?php if(is_array($data[lists][content]) || $data[lists][content] instanceof \think\Collection || $data[lists][content] instanceof \think\Paginator): $i = 0; $__LIST__ = $data[lists][content];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lists): $mod = ($i % 2 );++$i;?>
                    <div class="col-md-2" style="margin-bottom:25px; height:120px; overflow:hiddena; text-align: center;">
                        <img alt="Sample Image" src="<?php echo $lists[img_thumb]; ?>" class="img-thumbnail" style="max-height:100px; max-width:100%;">
                        <div style="text-align:center; cursor:pointer" >
                            <input type="checkbox" class="goods_id_check_all" name="post[id_arr][]" value="<?php echo $lists['id']; ?>">
                        </div>
                        <?php if(($lists[cate_id] == -1 and $user_id == 1) OR $lists[cate_id] != -1): ?>
                            <div style="text-align:center; cursor:pointer" onclick="confirm_del('<?php echo url("Config/material_del"); ?>?&id=<?php echo $lists[id]; ?>')">删除</div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
        <div class="panel-footer">
        <div class="row" style="display: none;">
            <div class="col-lg-2 col-md-2"  >
            <input type="checkbox" name="" id="check_all" onclick="check_all_public('goods_id_check_all','check_all')" value="">
                全选
            </div>
            <div class="col-lg-2 col-md-2"  >
                 
                <select   style="float:left" id="post[cate_id]"  name="post[cate_id]"  class="form-control">
                    <?php if(is_array($data[cate_lists][content]) || $data[cate_lists][content] instanceof \think\Collection || $data[cate_lists][content] instanceof \think\Paginator): $i = 0; $__LIST__ = $data[cate_lists][content];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lists): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $lists['id']; ?>"><?php echo $lists['title']; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
            <button class="btn btn-default" type="submit"  style=" float:left; margin-right:10px;"><i class="fa fa-search"></i>批量分类转移</button>
            </div>
        </div>
    </form>
</div>
<include file="Public/pagination" />


<script type="text/javascript">
    var upload_url="http://192.168.1.215/HK/web/plus.php/Image/upload_img?josn=1";

    function check(){
        var img=$("#material_img_thumb_hidden").val();
        if(!img){
            alert("请上传图片");
            return false;
        }
    }
</script>


<script>
    //上传成功
    function ajaxupload_return(data,type){
        console.log(data);
        $("#UploadImg_src").show();
        $("#UploadImg_src").attr("src",data.img_thumb)
        $("#material_img_thumb_hidden").val(data.img_thumb);
        $("#material_img_orogin_hidden").val(data.img_orogin);
        $("#img_text").html("");
    }
    //上传中
    function ajaxupload_ing(type){
        $("#img_text").html("上传中……");
    }
 
</script>
<!--图片上传-->



<!--图片上传-->
<script src="/HK/web/public/static/userweb/tool//ajaxupload/js/ajaxupload.js" type="text/javascript"></script>
<script src="/HK/web/public/static/userweb/static//public/js/ajaxupload_common.js"></script>

<script type="text/javascript">
    ajaxupload_int("UploadImg",'1');
</script>


        </section>

    </div>

</div>

<!-- 包含尾部模版footer -->

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