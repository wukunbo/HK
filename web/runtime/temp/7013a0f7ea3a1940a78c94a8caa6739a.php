<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:65:"D:\xampp\htdocs\HK\web/application/shop\view\order\add_order.html";i:1526551667;s:63:"D:\xampp\htdocs\HK\web\application\shop\view\Public\header.html";i:1526377370;s:60:"D:\xampp\htdocs\HK\web\application\shop\view\Public\nav.html";i:1526547439;}*/ ?>
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
    <script src="/HK/web/public/static/shop//lib/js/js.js"></script>
    <script src="/HK/web/public/static/shop//js/jquery.min.js"></script>
    <script src="/HK/web/public/static/shop//js/jquery.js"></script>

    <title><?php echo $page_title; ?></title>

</head>

<style type="text/css">
    .bar .button-clear{
        color: black!important;
        bottom: 7px;
    }
    .bar-positive{
        position: relative;
        background-image: none!important;
    }
    .title{
        color: black!important;
        font-weight: bold!important;
    }
    .item_{
        margin-top: 10px;
    }
    .item_ input{
        height: 20px;
        float: left;
        text-align: center;
        width: 15%;
        border: 1px solid #CCCCCC;
        margin-right: -1px; 
    }
    .item_ button{
        border-width: 0;
        color: #fff;
        border-radius: 3px;
        background-color: #4FD2C2;
        margin-left: 7%;
        height: 20px;
        font-size: 12px;
        padding-left: 5%;
        padding-right: 5%;
        position: relative;
        bottom: 2px;
    }
    .item-thumbnail-left > input:first-child {
        height: 10px;
        width: 10px;
    }
    .item-thumbnail-left > img:first-child {
        max-height: 100px;
        max-width: 100px;
    }
    .item-thumbnail-left{
        padding: 10px 21px 0 131px;
    }
    .good_img{
        position: absolute;
        top: 10px;
        left: 15px;
        max-width: 100px;
        max-height: 100px;
        width: 100%;
        height: 100%;
    }
    .good_img img{
        width: 100%;
        height: 100%;
    }
    .good_select{
        max-width: 30px;
        max-height: 30px;
        text-align: center;
    }
    .mtop_1{
        margin-top: 1px;
        margin-bottom: 10px;
    }
    .item{
        border-right-width: 0px;
    }
    .item-input-inset{
        padding: 0;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        height: 20px;
    }
    .item-input-wrapper{
        background: #FFFFFF;
    }
</style>

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


<div class="container_title back-white">
    <a class="item item-icon-right ion" href="address.html">
        <span>选择地址</span>
        <i class="icon ion-ios-arrow-right size18" style="color: #D6D6D6"></i>
    </a>
</div>


<!-- 购物车商品 -->

<?php if(is_array($data[cart_lists]) || $data[cart_lists] instanceof \think\Collection || $data[cart_lists] instanceof \think\Paginator): $i = 0; $__LIST__ = $data[cart_lists];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>

<div class="content mtop_1">
    <div class="item item-thumbnail-left item-borderless">
        <div class="good_img"><img src="http://192.168.1.215/HK/web/<?php echo $vo['img_orogin']; ?>"/></div>
        <h3><?php echo $vo['goods_name']; ?></h3>
        <div style="margin-top: 10px;">
            <h3 style="color:red;">HKD ￥<?php echo $vo['market_price']; ?></h3>
        </div>
        <div>
            <h4 class="in_block" style="position: absolute;bottom: 0;right: 20px;">
                ×<?php echo $vo['amount']; ?>
            </h4>
        </div>
    </div>
</div>

<?php endforeach; endif; else: echo "" ;endif; ?>


<div style="margin-top:20px;padding-right: 20px;">
    <div class="float-r">
        合计：<span style="color: red;">港币 HKD $<?php echo $data['total_price']; ?></span>
    </div>
    <div class="clear"></div>
</div>


<div class="w100 back-white item" style="margin-top: 20px;">
    <div class="good_select float-l"></div>
    <span style="margin-left: 10px;">折合人民币(80%)</span>
    <div class="float-r">
        <div>
            <span>金额：</span>
            <span style="margin-left: 10px;color: red;"><?php echo $data['rmb_price']; ?></span>
        </div>
    </div>
</div>

<div class="w100 back-white item">
    <div class="good_select float-l"></div>
    <span style="margin-left: 10px;">代购费(15%)</span>
    <div class="float-r">
        <div>
            <span>金额：</span>
            <span style="margin-left: 10px;color: red;"><?php echo $data['purchase_fee']; ?></span>
        </div>
    </div>
</div>




<div style="width: 100%;height: 70px;"></div>
<div class="row back-white fixed-bottom">
    <div class="col col-75" style="padding-top: 15px;padding-left: 40px;">
       实付：<span style="color: red;">￥<?php echo $data['real_fee']; ?></span>（含代购费<?php echo $data['purchase_fee']; ?>元）
    </div>
    <div class="col col-25" style="background-color: #4FD2C2;color: #fff;text-align: center;padding-bottom: 15px;padding-top: 15px;">
        <a style="color: #fff;">确认订单</a>
    </div>
</div>


</body>

</html>