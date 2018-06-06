<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:67:"D:\xampp\htdocs\HK\web/application/shop\view\Index\goods_lists.html";i:1526553519;s:63:"D:\xampp\htdocs\HK\web\application\shop\view\Public\header.html";i:1526612616;s:60:"D:\xampp\htdocs\HK\web\application\shop\view\Public\nav.html";i:1526547439;}*/ ?>
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


    .container_title{
        width: 100%;
        text-align: center;
        border-top: 1px solid #E6E6E6;
        border-bottom: 1px solid #E6E6E6;
    }
    .container_title a{
        width: 30%;
        display: inline-block;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .active{
        color:#31B5A8;
        border-bottom:2px solid #31B5A8;
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
    <a class="container_title_bg" href="<?php echo url('goods_lists'); ?>?<?php echo $param; ?>&order=sell_number">销量排序</a>
    <a class="container_title_bg" href="<?php echo url('goods_lists'); ?>?<?php echo $param; ?>&order=market_price">价格排序</a>
    <a class="container_title_bg" href="<?php echo url('goods_lists'); ?>?<?php echo $param; ?>&order=count_view">浏览排序</a>
</div>


<div class="content cen">


    <div class="con" style="width:98%;margin: 10px auto;" id="goods_conent">
        
    <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>

        <div class="w48 float-l border-1p-ddd m-r-b border-shadow" style="margin-right: 5px;">
                <a href="<?php echo url('goods/detail',array('id'=>$vo['goods_id'])); ?>">
                    <div class="content_img">
                        <img src="http://test.tuolve.com/HK/web/<?php echo $vo['img_orogin']; ?>"/>
                    </div>
                    <div class="content_detail">
                        <p style="overflow: hidden;text-overflow: ellipsis;white-space:nowrap;"><?php echo $vo['goods_name']; ?></p>
                        <p>
                            <span class="jifen">HKD ￥<?php echo $vo['market_price']; ?></span>
                        </p>
                    </div>
                    <div class="clear"></div>
                </a>
        </div>

        <!-- <div style="height: 256px;width: 1%;float: left;"></div> -->

        
    <?php endforeach; endif; else: echo "" ;endif; ?>
        
        
    </div>

    <div class="clear"></div>
</div>


<div class="row" id="more_btn">
    

    <div onclick="get_more_goods()" class="col-75 center" style="margin:10px auto;margin-bottom:20px;background-color: #4FD2C2;color: #fff;text-align: center;padding-bottom: 15px;padding-top: 15px;">
        <a style="color: #fff;">加载更多</a>
    </div>

</div>


</body>
</html>


<script type="text/javascript">
var page=1;

function get_more_goods(){
    page=page+1;
    var url="<?php echo url('goods_lists'); ?>?<?php echo $param; ?>&ajax=1&page="+page;

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success:function(data) {  
            if(data.status==10001){
                $("#goods_conent").append(data.html);
            }

            if(data.status==20001){
                $("#more_btn").hide();
            }
        },  
        error : function() {  
            alert("失败");
        }  
    });

}

</script>