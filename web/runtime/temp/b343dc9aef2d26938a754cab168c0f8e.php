<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:60:"D:\xampp\htdocs\HK\web/application/shop\view\Cms\detail.html";i:1526638240;s:63:"D:\xampp\htdocs\HK\web\application\shop\view\Public\header.html";i:1526612616;s:60:"D:\xampp\htdocs\HK\web\application\shop\view\Public\nav.html";i:1526547439;}*/ ?>
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
<style>
  .content_img img{
  width:100% !important; height:auto!important;
  }

  .item-avatar{
        padding-left: 72px;
        min-height: 100px;
    }
    .img-avatar >img:first-child{
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
    .img-avatar{
        min-height: 72px;
        position: relative;
    }
    p{
        margin-bottom: 0;
    }
    .row + .row {
        margin-top: 0;
        padding-top: 0;
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






<div class="list" style="padding-top:0px;margin-bottom: 50px;margin-top: 44px">
    <h2 class="dark-gray font-size-18" style="padding:10px; padding-bottom:0px; line-height:150%; font-size:24px!important; font-weight:bold; display:none1; "><?php echo $data[title]; ?></h2>
    
    <div class="item-body padding content_img" style="padding:0px!important;">
          <?php echo $data[context]; ?>  
    </div>

</div>

</body>

</html>