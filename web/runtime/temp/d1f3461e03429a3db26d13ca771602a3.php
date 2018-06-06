<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:67:"D:\xampp\htdocs\HK\web/application/shop\view\Order\order_lists.html";i:1526629784;s:63:"D:\xampp\htdocs\HK\web\application\shop\view\Public\header.html";i:1526612616;s:60:"D:\xampp\htdocs\HK\web\application\shop\view\Public\nav.html";i:1526547439;}*/ ?>
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
    .bar .button-clear{
        color: black!important;
        bottom: 7px;
    }
    .bar-positive{
        background-color: #FAFAFA!important;
        position: relative;
        background-image: none!important;
    }
    .title{
        color: black!important;
        font-weight: bold!important;
    }
    .container_title{
        width: 100%;
        text-align: center;
        border-top: 1px solid #E6E6E6;
        border-bottom: 1px solid #E6E6E6;
    }
    .container_title span{
        width: 19%;
        display: inline-block;
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .float-l p{
        margin: 0;
    }
    .time{
        border-top: 1px solid #E6E6E6;
        padding: 5px 10px 0 10px;
    }
    .float-r span{
        color: #31B5A8;
        font-size: 18px;
        height: 50px;
        line-height: 50px;
    }
    .good_img{
        position: absolute;
        top: 10px;
        left: 20px;
        max-width: 100px;
        max-height: 100px;
        margin-bottom: 10px;
    }
    .good_img img{
        width: 100%;
        height: 100%;
    }
    .item{
        background-color: #FAFAFA!important;
    }
    .item-thumbnail-left{
        padding: 10px 16px 0 146px;
    }
    .money{
        border-bottom: 1px solid #E6E6E6;
        padding: 5px 10px 0 10px;
        margin-top: 10px;
    }
    .money div{
        padding-top: 10px;
        padding-bottom: 10px;
        text-align: right;
    }
    .pay{
        border-bottom: 1px solid #E6E6E6;
        padding: 10px;
    }
    .pay span{
        width: 50%;
        padding: 5px;
        border:1px solid #31B5A8;
        border-radius: 5px;
        float: right;
        text-align: center;
        margin-right: 5px;
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


<!-- 订单列表 -->

<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>

<div style="margin-top: 0px;">
    <div class="back-white time">
        <div class="float-l setcol">
            <p style="margin-bottom: 5px;">订单日期：<span><?php echo date("Y-m-d",$vo['addtime']); ?></span></p>
            <p>订单编号：<span><?php echo $vo['order_sn']; ?></span></p>
        </div>
        <div class="float-r">
            <?php if($vo['pay_status'] == 1): ?>
                <span>已付款</span>

                <?php if($vo['shipping_status'] == 1): ?>
                <span>,已发货</span>
                <?php else: ?>
                    <span>,未发货</span>
                <?php endif; else: ?>
                <span>未付款</span>
            <?php endif; ?>

            


        </div>
        <div class="clear"></div>
    </div>
    
    <!-- 商品列表 -->
    <?php if(is_array($vo['goods_lists']) || $vo['goods_lists'] instanceof \think\Collection || $vo['goods_lists'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['goods_lists'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
    <div class="w100 item item-thumbnail-left item-borderless">
        <div class="good_img"><img src="http://test.tuolve.com/HK/web/<?php echo $v['img_orogin']; ?>"/></div>
        <h3 class="in_block"><?php echo $v['goods_name']; ?></h3>
        <div style="margin-top: 10px;">
            <h3 style="color:red;">HKD ￥<?php echo $v['market_price']; ?></h3>
        </div>
        <div style="position: relative;top: 25px;">
            <h4 class="in_block float-r" style="font-size: 18px;margin: 0;">×<?php echo $v['amount']; ?></h4>
        </div>
        <div class="clear"></div>
    </div>
    <?php endforeach; endif; else: echo "" ;endif; ?>



    <div class="back-white money">
        <div>
            <p>港币总金额：<span style="font-size: 12px;">HKD ￥<?php echo $vo['total_fee']; ?></span></p>

            <p>实付：<span style="font-size: 14px;color: red;">HKD ￥<?php echo $vo['real_fee']; ?></span>(含代购费￥<span><?php echo $vo['purchase_fee']; ?></span>)</p>
        </div>
    </div>

    <?php if($vo['pay_status'] == 0): ?>
    <div class="back-white pay">
        <span>请联系我付款哦！！</span>
        <div class="clear"></div>
    </div>
    <?php endif; if($vo['shipping_status'] == 1): ?>
    <div class="back-white pay">
    <span><a href="http://m.kuaidi100.com/index_all.html?type=<?php echo $vo[shipping_code]; ?>&postid=<?php echo $vo[shipping_id]; ?>">查看物流</a></span>
        <div class="clear"></div>
    </div>
    <?php endif; ?>

</div>

<?php endforeach; endif; else: echo "" ;endif; ?>


</body>
</html>