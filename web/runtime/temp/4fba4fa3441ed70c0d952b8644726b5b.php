<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:68:"D:\xampp\htdocs\HK\web/application/shop\view\User\address_lists.html";i:1526619233;s:63:"D:\xampp\htdocs\HK\web\application\shop\view\Public\header.html";i:1526612616;s:60:"D:\xampp\htdocs\HK\web\application\shop\view\Public\nav.html";i:1526547439;}*/ ?>
<!-- 包含头部模版header -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="initial-scale=1,maximum-scale=1,user-scalable=no,width=device-width,height=device-height">
    <link rel="stylesheet" href="/HK/web/public/static/shop//lib/ionic/css/ionic.min.css"/>
    <link rel="stylesheet" href="/HK/web/public/static/shop//css/style.css"/>
    <link rel="stylesheet" href="/HK/web/public/static/shop//lib/swipe/swiper.min.css"/>
    <script src="/HK/web/public/static/shop//lib/jquery/jquery-1.11.3.min.js"></script>
    <script src="/HK/web/public/static/shop//lib/swipe/swiper.min.js"></script>
    <script src="/HK/web/public/static/shop//js/jquery.min.js"></script>
    <script src="/HK/web/public/static/shop//js/jquery.js"></script>

    <title><?php echo $page_title; ?></title>

</head>


<body>





<div class="bar bar-header bar-positive">
    <a class="button icon ion-ios-undo-outline button-clear" href="javascript:history.back(-1);"></a>
    <h1 class="title"><?php echo $page_title; ?></h1>
    <button class="button icon-right ion-navicon button-clear"></button>
</div>


<div id="topright" style="display:none;width:auto;position:absolute;top: 44px;;z-index: 99999;padding: 5px;"
     class="back-white">
    <div style="padding: 5px;border-bottom: 1px solid #ddd;text-align: center;"><a href="<?php echo url('index/index'); ?>">首页</a></div>
    <div style="padding: 5px;border-bottom: 1px solid #ddd;text-align: center;"><a href="<?php echo url('index/cart'); ?>">购物车</a></div>
    <div style="padding: 5px;border-bottom: 1px solid #ddd;text-align: center;"><a href="<?php echo url('user/index'); ?>">我的</a></div>
   
</div>


<script type="text/javascript">
  var con=0;
    $('.ion-navicon').click(function () {
        if(con==0){
        $('#topright').slideDown();
            con++;
        }else{
        $('#topright').slideUp();
            con--;
        }
    });

  
    var winW = $(window).width();//获取窗口可视宽度
    var topleft = $('#topright').width();//获取topright宽度
    $('#topright').css({'left': winW - topleft -10+ 'px'});//定位topright left左偏离,10为内容边距
</script>

<div class="list address_lists" >
    <!--content start-->
    <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <div class="item  item-icon-right" style="padding-left:48px;padding-bottom: 50px" >

            <?php if($vo['type'] == 1): ?>
                <span class="  ion-checkmark-circled assertive" style="position: absolute;left:6px;"></span>
            <?php endif; ?>
            <a

                <?php if($cart_ids): ?>href="<?php echo url('Order/add_order'); ?>?&address_id=<?php echo $vo['id']; ?>&cart_ids=<?php echo $cart_ids; ?>"<?php endif; ?>
             
            >
            <h2><?php echo $vo['name']; ?> <span class="green font-size-14">&nbsp;<?php echo $vo['phone']; ?></span></h2>
            <p class="margin-top"><?php echo $vo['address']; ?> </p>
            </a>
            <a class="icon ion-ios-compose-outline dark-gray" style="height: 32px;right: 9px;top:6px;" href="<?php echo url('User/add_address'); ?>?&id=<?php echo $vo['id']; ?>&cart_ids=<?php echo $cart_ids; ?>"></a>
            <a class="icon ion-ios-trash-outline gray" style="  height: 32px;top:46px;" href="<?php echo url('User/address_delete'); ?>?id=<?php echo $vo['id']; ?>"></a>
        </div>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    <div class="item    add" >
        <i class="ion-ios-plus-outline"></i>
        <a href="<?php echo url('User/add_address'); ?>?cart_ids=<?php echo $cart_ids; ?>"> 新增收货地址 </a>
    </div>
</div>

</body>

</html>