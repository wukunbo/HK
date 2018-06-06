<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:65:"D:\xampp\htdocs\HK\web/application/shop\view\User\wish_lists.html";i:1526624255;s:63:"D:\xampp\htdocs\HK\web\application\shop\view\Public\header.html";i:1526612616;s:60:"D:\xampp\htdocs\HK\web\application\shop\view\Public\nav.html";i:1526547439;}*/ ?>
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


<style type="text/css">
    .content{
        width: 100%;
    }
    .content_title span{
        font-size: 16px;
        width: 24%;
        display: inline-block;
    }
    .content_img{
        height: 200px;
    }
    .content_img img{
        width: 100%;
        height:100%;
    }
    .content_detail{
        background-color: #F2F2F2;
        padding-left: 5px;
        padding-top: 5px;
    }
    .content_detail p{
        margin: 0;
        padding-right: 5px;
        padding-bottom: 5px;
    }
    .border-shadow{
        margin-bottom: 10px;
    }
    .jifen{
        font-size: 16px!important;
        color: red;
        font-weight: bold;
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


<div id="lists_content" class="goods_lists">
    <div class="row row-wrap ">
        <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lists): $mod = ($i % 2 );++$i;?>
        <div class="col col-47"  style="border-right: #e6e8ea 1px solid;border-bottom:#e6e8ea 1px solid; background:#fff;padding: 0;" >
            <a  href="<?php echo url('Goods/detail'); ?>?&id=<?php echo $lists['goods_id']; ?>" class="img_div" ><img style="width: 100%;height: 100%"  src="http://test.tuolve.com/HK/web/<?php echo $lists['img_orogin']; ?>"></a>
            <p style=" overflow:hidden; height:40px;font-size: 13px;margin:0;"><?php echo $lists['goods_name']; ?></p>
            <p style="text-align:left;margin: 0;">
                <span class="xianjia" style="color: red;">HKD ￥<span style="font-size: 16px;font-weight: bold;"><?php echo $lists['market_price']; ?></span></span>
            </p>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div>


<style>.goods_lists .img_div{ overflow:hidden; display:block}</style>
<style type="text/css">
    .col-47  {
        -webkit-box-flex: 0;
        -webkit-flex: 0 0 47.5%;
        -moz-box-flex: 0;
        -moz-flex: 0 0 47.5%;
        -ms-flex: 0 0 47.5%;
        flex: 0 0 47.5%;
        max-width: 47.5%;
    }
    .goods_lists .col {
        background: #fff none repeat scroll 0 0;
        border: 1px solid #ddd;
        display: block;
        float: left;
        margin: 1%;
        padding: 5px;
        position: relative;
        width: 48%;
    }

</style>

</body>
</html>