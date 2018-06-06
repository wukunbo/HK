<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:75:"D:\xampp\htdocs\HK\web/application/userweb\view\shop_order\order_lists.html";i:1525849596;s:66:"D:\xampp\htdocs\HK\web\application\userweb\view\Public\layout.html";i:1524540430;s:66:"D:\xampp\htdocs\HK\web\application\userweb\view\Public\header.html";i:1524537495;s:66:"D:\xampp\htdocs\HK\web\application\userweb\view\Public\navbar.html";i:1524644679;s:64:"D:\xampp\htdocs\HK\web\application\userweb\view\Public\left.html";i:1524638402;s:64:"D:\xampp\htdocs\HK\web\application\userweb\view\Public\here.html";i:1524622127;s:66:"D:\xampp\htdocs\HK\web\application\userweb\view\Public\footer.html";i:1524540092;}*/ ?>
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
            

<script type="text/javascript" src="/HK/web/public/static/userweb/tool//My97DatePicker/WdatePicker.js"></script>

<div class="panel panel-default">
    <div class="panel-body">
        <ul class="nav nav-tabs" style="margin-bottom:10px;">

        <?php if($_REQUEST[back_order] == 1): ?>
            
            
            <li  style="display:none1"
            <?php if($_REQUEST[back_status] == -1): ?> class="active"<?php endif; ?>
            ><a href="<?php echo url('order_lists'); ?>?&back_order=<?php echo $_REQUEST[back_order]; ?>&back_status=-1" >待处理售后订单</a>
            </li>

            <li  style="display:none"
            <?php if($_REQUEST[back_status] == 1): ?> class="active"<?php endif; ?>
            ><a href="<?php echo url('order_lists'); ?>?&back_order=<?php echo $_REQUEST[back_order]; ?>&back_status=1" >退款（未发货）</a>
            </li>

            <li 
            style="display:none"
            <?php if($_REQUEST[back_status] == 2): ?> class="active"<?php endif; ?>
            ><a href="<?php echo url('order_lists'); ?>?&back_order=<?php echo $_REQUEST[back_order]; ?>&back_status=2"  >仅退款（已发货）</a>
            </li>
            <li style="display:none"
            <?php if($_REQUEST[back_status] == 3): ?> class="active"<?php endif; ?>
            ><a href="<?php echo url('order_lists'); ?>?&back_order=<?php echo $_REQUEST[back_order]; ?>&back_status=3"   >退货（已发货）</a>
            </li>
        <?php endif; if($_REQUEST[back_order] != 1): ?>
            <li



            <?php if($status == '' or $status == '0'): ?> class="active"<?php endif; ?>
            >
            <a href="<?php echo url('ShopOrder/order_lists'); ?>?&status=0" >所有</a>
            </li>
            
            <li 
        
        
        
            <?php if($status == 8): ?> class="active"<?php endif; ?>
            ><a href="<?php echo url('ShopOrder/order_lists'); ?>?&status=8" >等待发货</a>
            </li>
            
            <li 
        
        
        
            <?php if($status == 4): ?> class="active"<?php endif; ?>
            ><a href="<?php echo url('ShopOrder/order_lists'); ?>?&status=4" >已发货</a>
            </li>
            
            
             
            
            <li 
        
            <?php if($status == 10): ?> class="active"<?php endif; ?>
            ><a href="<?php echo url('ShopOrder/order_lists'); ?>?&status=10" >需要评价的订单</a>
            </li>
             
            <li 
            <?php if($status == 9): ?> class="active"<?php endif; ?>
            ><a href="<?php echo url('ShopOrder/order_lists'); ?>?&status=9" >成功的订单</a>
            </li>
        <?php endif; ?>
        </ul>
        <div style="height:auto; overflow:hidden; padding:10px;">

            <form action="<?php echo url('order_lists'); ?>?&sql=<?php echo $_REQUEST[sql]; ?>&data=<?php echo $_REQUEST[data]; ?>" method="post" name="search_form" id="search_form">
                <input  type="text" name="back"  style="display:none;" value="<?php echo $search[back]; ?>" >
                <input  type="text" name="back_order"  style="display:none;" value="<?php echo $_REQUEST[back_order]; ?>" >
            <?php if($_REQUEST[back_order] != 1): ?>
                <select onChange1="search_order_status()" id="status" name="status" class="form-control_search">
                    <option value="0"  
                    <?php if($status == ''): ?> selected="selected"<?php endif; ?>
                    >全部
                    </option>
                    <option value="8"
                    <?php if($status == 8): ?> selected="selected"<?php endif; ?>
                    >等待发货
                    </option>
                    <option value="4"  
                    <?php if($status == 4): ?> selected="selected"<?php endif; ?>
                    >已发货
                    </option>
                    
                </select>
            <?php endif; ?>
                <input class="Wdate form-control_search"    id="date_1" name="date_1" type="text" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"  placeholder="开始时间" value="<?php echo $_REQUEST[date_1]; ?>" >
                <input class="Wdate form-control_search"  id="date_2" name="date_2" type="text" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"  placeholder="结束时间"  value="<?php echo $_REQUEST[date_2]; ?>">
                <!-- <button class="btn btn-default" onclick='chang_order_status("","2")' style="display:none">修改为收货</button> -->
                <!-- <button class="btn btn-default" style="display:none">一键发货</button> -->
                <input class="form-control_search" id="key_word" type="text" placeholder="关键字" name="keyword" value="<?php echo $_REQUEST[keyword]; ?>" s>
                 
                <button class="btn btn-default" type="submit" style=" float:left; margin-right:10px;"><i class="fa fa-search"></i>检索</button>
                <button class="btn btn-default" type="button" onClick="excel();" style=" float:left; margin-right:10px;">导出excel</button>
                <!-- <button class="btn btn-default" type="button" onclick="fahuo()" style=" float:left; margin-right:10px;">一键发货</button> -->
                <script>
                    function fahuo(){
                        order_id_str=$('#order_lists_form').serialize();
                        show_content('userweb.php?c=ShopOrder&a=shipping_all_lists&order_id_str='+order_id_str);
                    }
                </script>
            </form>
        </div>


        <div style="height:auto; overflow:hidden; padding:10px;">
            <form action="userweb.php?&c=ShopOrder&a=order_import" method="post" name="search_form" id="search_form" enctype="multipart/form-data" >
 
                <!-- <input class="  " style="line-height:30px; height:30px; width:200px;float:left; margin-right:10px;"  name="myfile" type="file" value="上传订单列表"   >
                <button class="btn btn-default" type="submit"   style=" float:left; margin-right:10px;">批量导入发货</button> -->
            </form>
        </div>

        <div class="form-group" style="height:auto; overflow:hidden; padding:10px; display:none;">
            <a href="Uploads/excel/to_excel.xls" target="_blank">
                下载导入表格样式
            </a>  

            <div class="form-group" style="margin-top: 15px">
                <a class="btn btn-primary" onclick="to_apply();" >导入发货</a>
            </div>

            <form id="xlsform"="multipart/form-data">
                <input onchange="submitxls()" id="oncontacts" name="xlsfile" type="file" value="导入名单" style="display: none;" accept="" />
            </form>

        </div>


        <form id="order_lists_form" method="post" >
            <input type='hidden' id="pay_status" name="pay_status" value="">
            <input type='hidden' id="shipping_status" name="shipping_status" value="">
            <?php if(is_array($data['content']) || $data['content'] instanceof \think\Collection || $data['content'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['content'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <div id='order_lists' style="border:1px solid #333; margin-bottom:10px;">
                    <div id="order_title" style="font-size:16px;background-color:#f1f1f1;line-height:30px; padding:5px;">
                        <input type='checkbox' checked="checked" style="display:none" name="chose[]" value="<?php echo $vo['order_id']; ?>">
                        <label>
                        <?php if($user_id == 1): ?><a href="<?php echo url('order_lists'); ?>?&status=<?php echo $_REQUEST[status]; ?>&business_id=<?php echo $vo[business_id]; ?>">【<?php echo $vo[order_detail][shop_title]; ?> 】 </a><?php endif; ?>订单号：</label>
                        <strong style="display:none"> <span><?php echo $vo['order_sn']; ?></span></strong>
                        <span>(<?php echo $vo['weixin_order_sn']; ?>)</span>
                        <label style="margin-left:20px">下订单时间：</label>
                        <span><?php echo date('Y-m-d H:i:s',$vo['addtime']); ?> <?php echo $vo['addtime1']; ?></span>
                        <?php if($vo['paytime'] != ''): ?>
                        <label style="margin-left:20px">付款时间：：</label>
                        <span><?php echo date('Y-m-d H:i:s',$vo['paytime']); ?>  <?php echo $vo['paytime1']; ?></span>
                        <?php endif; ?>
                        <label style="margin-left:20px">用户：</label>
                        <span><?php echo $vo[order_detail][username]; if($user_id == 1): ?>（用户ID：<?php echo $vo[order_detail]['user_id']; ?>）<?php endif; ?></span>
                        <br>
                        <label style="margin-left:0px">订单状态：</label>
                        <span <?php if($vo[back_status] != 0): ?>style=" color:#FF0000;"<?php endif; ?>><?php echo $vo['pay_status_text']; ?><font style="color:#FF0000;"> <?php echo $vo['pintuan_status_text']; ?>  </font> 
                            <?php if($vo[shipping_status] == 1): ?>
                                已发货
                            <?php elseif($vo[shipping_status] == 2): ?>
                                已收货
                            <?php else: endif; ?>
                            <?php echo $vo['shipping_stauts_text']; ?>

                            <?php echo $vo['back_status_text']; ?></span>
                        
                     


    

                        <br>
                        <?php if($vo[back_status] != 0 AND  $vo[back_status] != 3): ?>
                            <label style="margin-left:10px"> 买家发货状态： <?php echo (isset($vo['back_shipping_code']) && ($vo['back_shipping_code'] !== '')?$vo['back_shipping_code']:"暂无"); ?>   <?php echo $vo['back_shipping_id']; ?></label>
                        <?php endif; ?>
                    </div>

                    <div class="" style="height:auto; overflow:hidden; clear:both;">
                        <div id="goods_lists" style="line-height:30px;margin:10px; padding-bottom:5px; float:left; width:70%; ">
                            <?php if(is_array($vo[order_detail][goods_lists]) || $vo[order_detail][goods_lists] instanceof \think\Collection || $vo[order_detail][goods_lists] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo[order_detail][goods_lists];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods_lists): $mod = ($i % 2 );++$i;?>
                                <div id="text" style="height:auto; overflow:hidden;width:100%;border-bottom:1px solid #ddd; margin-bottom:10px; clear:both; " >
                                    <div id="img" style="float:left">
                                        <img src="<?php echo $goods_lists['img_thumb']; ?>" height="100px">
                                    </div>
                                    <div id="goods_name" style="font-size:16px;width:500px;float:left;word-break:break-all; margin-left:10px;">
                                        <a style="color:;">商品名：<?php echo $goods_lists['goods_name']; if($goods_lists['attr'] != ''): ?><font style=" color:#FF0000;" >(<?php echo $goods_lists['attr']; ?>)</font><?php endif; ?></a>
                                    </div>
                                    <div id="goods_price" style="color:;font-size:16px;width:200px;float:left;word-break:break-all; margin-left:10px;">
                                        <p style="color:;">商品金额：￥
                                            <?php if($goods_lists[price] != ''): ?><?php echo $goods_lists['price']; endif; if($goods_lists[price] == ''): ?><?php echo $goods_lists['shop_price']; endif; ?>
                                        </p>
                                        <p >型号：<?php echo $goods_lists['goods_sn']; ?></p>
                                        <p style="color:;">商品数量：<?php echo $goods_lists['amount']; ?></p>
                                    </div>
                                    <a href="javascript:void(0)" style="display:none" onClick="show_content('<?php echo url('kuaidi_form'); ?>?&order_id=<?php echo $vo['order_id']; ?>&order_goods_id=<?php echo $goods_lists['order_goods_id']; ?>')">物流管理</a>
                                    <br>
                                </div>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                        <div style="float:left; width:25%; font-size:14px; padding-left:10px; padding-top:30px;height:auto; overflow:hidden;">
                            <div style="float:left; width:50%; text-align:center; line-height:200%;">
                                订单总额：<?php echo $vo['real_fee']; ?>元<br>
                                <!-- 邮费：<?php echo (isset($vo['shipping_fee']) && ($vo['shipping_fee'] !== '')?$vo['shipping_fee']:"0"); ?>元 <br> -->
                                <!--优惠券抵扣金额：<?php echo (isset($vo['fee_dis_for_coupon']) && ($vo['fee_dis_for_coupon'] !== '')?$vo['fee_dis_for_coupon']:"0"); ?>元 <br />-->
                                <!--余额支付：<?php echo (isset($vo['account_fee']) && ($vo['account_fee'] !== '')?$vo['account_fee']:"0"); ?>元 <br />-->
                                <!--使用积分：<?php echo $vo['point_fee']; ?> <br />-->
                                实付：<?php echo (isset($vo['real_fee']) && ($vo['real_fee'] !== '')?$vo['real_fee']:"0"); ?>元 <br>
                            </div>
                            <div style="float:left; width:50%; text-align:center; line-height:200%;">

                                <?php if(($vo[pay_status] == 1 && $vo[is_pintuan] != 1 )|| ($vo[pintuan_status] == 1  && $vo[is_pintuan] == 1 && $vo[pay_status] == 1)): ?>
                                <a href="<?php echo url('kuaidi_form'); ?>?&order_id=<?php echo $vo['order_id']; ?>" 1onClick="show_content('<?php echo url('kuaidi_form'); ?>?&order_id=<?php echo $vo['order_id']; ?>')">发货</a>
                                <?php endif; if($_REQUEST[back_order] == 1): ?>
                                    <br>
                                    <a href="<?php echo url('back_order_form'); ?>?&order_id=<?php echo $vo['order_id']; ?>&order_back_id=<?php echo $vo['order_back_id']; ?>">退货处理</a>
                                <?php endif; ?>

                                <a onClick="return del_sure()"  href="<?php echo url('order_back_delete'); ?>?&back_id=<?php echo $vo['order_back_id']; ?>&p=$_REQUEST[p]" role="button" data-toggle="modal" style="display:none">订单删除</a>
                                <br>
                                <a href="<?php echo url('order_form'); ?>?&order_id=<?php echo $vo['order_id']; ?>">订单修改</a>
                                <br>
                                <a href="<?php echo url('order_detail'); ?>?&order_id=<?php echo $vo['order_id']; ?>">订单详情</a>
                                <br>
                                <a href="<?php echo url('order_print'); ?>?&order_id=<?php echo $vo['order_id']; ?>">出货单</a>
                                <br>
                                <?php if($vo[is_invoice] == 1): ?>
                                    <a href="<?php echo url('invoice_print'); ?>&order_id=<?php echo $vo['order_id']; ?>">发票</a>
                                    <br>
                                <?php endif; ?>
                               
                                <a href="javascript:display('order_detail_<?php echo $vo['order_id']; ?>')">详情展开</a>
                            </div>
                        </div>
                    <div style="padding:10px; display:none" class="order_detail" id="order_detail_<?php echo $vo['order_id']; ?>">

                    <?php
                    $order_detail=$vo[order_detail];
                    ?>

        <table width="100%" border="1" cellpadding="5" cellspacing="5">
            <tr >
                <td colspan="3">快递：<?php echo (isset($vo['shipping_title']) && ($vo['shipping_title'] !== '')?$vo['shipping_title']:"暂无"); ?>  <?php echo (isset($vo['shipping_id']) && ($vo['shipping_id'] !== '')?$vo['shipping_id']:""); ?> </td>
                  </td>
            </tr>
            <tr>
                <td>收货人姓名：<?php echo $order_detail['address_name']; ?></td>
                <td>联系电话：<?php echo $order_detail['address_phone']; ?></td>
            </tr>
           
            <tr>
                <td  colspan="3">详细地址：<?php echo $vo[address]; ?> </td>

            </tr>

          
        </table>

        <table width="100%" border="1" cellpadding="2" cellspacing="2">
            <tr>
                <td>序号</td>
                <td>宝贝</td>
                <!-- <td>型号</td> -->
                <td>数量</td>
                <td>单价</td>
                <td>型号</td>
            </tr>
            <?php if(is_array($order_detail[goods_lists]) || $order_detail[goods_lists] instanceof \think\Collection || $order_detail[goods_lists] instanceof \think\Paginator): $i = 0; $__LIST__ = $order_detail[goods_lists];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods_lists): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $goods_lists['goods_name']; ?></td>
                    <!-- <td><?php echo $goods_lists['attr']; ?></td> -->
                    <td><?php echo $goods_lists['amount']; ?></td>
                    <td><?php echo $goods_lists['price']; ?></td>
                    <td><?php echo $goods_lists['goods_sn']; ?></td>
                </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
                    </div>
                   
                </div>
                </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </form>
        <include file="Public/pagination" />
    </div>
</div>
</div>
<style>
.order_detail td{ padding:5px;}
</style>
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