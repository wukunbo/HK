<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:62:"D:\xampp\htdocs\HK\web/application/shop\view\goods\detail.html";i:1526550288;s:63:"D:\xampp\htdocs\HK\web\application\shop\view\Public\header.html";i:1526377370;s:60:"D:\xampp\htdocs\HK\web\application\shop\view\Public\nav.html";i:1526547439;}*/ ?>
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

    body{
        background-color: #fff;
    }
    .bar .button-clear{
        color: black!important;
        bottom: 7px;
    }
    .bar-positive{
        background-color: #FAFAFA!important;
        position: relative;
        border-bottom: 1px solid #E7E7E7!important;
        background-image: none!important;
    }
    .title{
        color: black!important;
        font-weight: bold!important;
    }
    .content_title{
        margin: 10px 10px 5px 10px;
    }
    .content_title_left{
        float: left;
        width: 70%;
    }
    .content_title_left h4{
        margin-top: 0;
    }
    .content_title_right{
        float: right;
        width: 30%;
        color: #999999;
    }
    .content_title_right img{
        max-width: 20px;
        max-height: 20px;
        position: relative;
        left: 3px;
        cursor: pointer;
    }
    .content_title_bottom{
        float: left;
        color: #999999;
        width: 100%;
        margin-top: 20px;
    }
    .content_title_bottom span{
       width: 32%;
       display: inline-block;
    }
    .content_detail,
    .content_detail_extra,
    .content_detail_item{
        margin: 10px;
    }
    .colll{
        background-color: #E6E6E6;
        border-radius: 5px;
        text-align: center;
        margin-bottom: 10px;
        margin-right: 5px;
    }
    .content_detail_item p{
        margin-bottom: 0px;
    }
    .content_detail_item span{
        border: 1px solid #CCCCCC;
        background-color: #E6E6E6;
        float: right;
        height: 20px;
        line-height: 20px;
        margin-right: -1px;
        padding: 0 5px;
    }
    .content_detail_item input{
        height: 20px;
        float: right;
        text-align: center;
        width: 15%;
        border: 1px solid #CCCCCC;
        margin-right: -1px; 
    }
    .w40 {
        background-color: #31B5AA;
        color: #fff;
        border: none;
        width: 50%;
        height: 50px;
        color: #fff;
        line-height: 50px;
    }
    .fixed_top{
        width: 100%;
        text-align: center;
        border-bottom: 1px solid #E6E6E6;
    }
    .fixed_top span{
        width: 33%;
        display: inline-block;
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .sc{
        float: right;
        margin-right: 10px;
    }
    .coll{
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        -moz-box-flex: 1;
        -moz-flex: 1;
        -ms-flex: 1;
        flex: 1;
        display: block;
        padding: 5px;
        width: 100%;
    }

    .item-avatar{
        padding-left: 72px;
        min-height: 100px;
    }
    .img-avatar >img:first-child{
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }
    .img-avatar{
        position: relative;
    }
    .con_cs_2_xq .float-l,
    .con_cs_3_xq .float-l{
        width: 10%;
    }
    .con_cs_2_xq .float-l img,
    .con_cs_3_xq .float-l img{
        height: 100%;
        width: 100%;
    }
    .con_cs_2_xq .float-r,
    .con_cs_3_xq .float-r{
        width: 90%;
        line-height: 30px;
    }
    .con_cs_3_xq{
        margin-bottom: 30px;
    }
    .pj_title_bg{
        padding-top: 5px!important;
        padding-bottom: 5px!important;
    }
    .pj_title_bg p{
        margin: 0!important;
    }
    .one{
        width: 30%;
        margin-left: 2.5%;
    }
    .one p{
        background-color: #EEF2F3;
        border-radius: 5px;
        padding:5px 5px;
        margin: 0;
    }
    p{
        margin: 0;
    }
    .xx img,
    .zan,
    .pl{
        max-width: 20px;
        max-height: 20px;
        cursor: pointer;
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

    <!-- 商品 -->
    <div id="con_xq_1">
        
        <!-- 主图 -->
        <div class="swiper-container swiper1">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="http://192.168.1.215/HK/web/<?php echo $data['img_orogin']; ?>"/>
                </div>
                
            </div>
            <div class="swiper-pagination"></div>
        </div>
        
        <!-- 商品信息 -->
        <div class="content_title">
            <div class="content_title_left">
                <h4><?php echo $data['goods_name']; ?></h4>
                <!-- <s class="setcol">港币 HKD￥<?php echo $data['market_price']; ?></s> -->
                <span style="color: red;font-weight: bold;font-size: 18px;">港币 HKD￥<?php echo $data['market_price']; ?></span>
            </div>
            <div class="content_title_right">
               
                <div class="sc">
                    <img class="shoucang" src="/HK/web/public/static/shop//img/shoucang.png"></br>
                    <span>收藏</span>
                </div>


            </div>
            <div class="content_title_bottom">
                <span>销量&nbsp;&nbsp;<?php echo $data['sell_number']; ?>件</span>
            </div>
            <div class="clear"></div>
        </div>


        <div class="content_detail_item">
            <div class="row">
                <div class="coll"><p style="color: #999999;">购买数量</p></div>
                <div class="coll">
                    <span style="border-radius:  0 5px 5px 0;" onclick="add_amount()">＋</span>
                    <input type="number" value="1" id="goods_amount"/>
                    <span style="border-radius: 5px 0 0 5px;" onclick="del_amount()">－</span>
                    <div class="clear"></div>
                </div>
            </div>
        </div>


    </div>


    <div style="width: 100%;height: 70px;"></div>

    <div class="row fixed-bottom row-center" style="padding:0;border-top: 1px solid #e0e0e0;background-color: #fff;">
        <div class="w20"><img class="shoucang" src="/HK/web/public/static/shop//img/shoucang.png"></div>
        <div class="w40" style="background-color: #D5F9F5;" onclick="add_cart(<?php echo $data['goods_id']; ?>)"><a>加入购物车</a></div>
        <div class="w40"><a style="color: #fff;" onclick="add_order(<?php echo $data['goods_id']; ?>)">立即购买</a></div>
    </div> 


    
</body>

</html>


<script type="text/javascript">

function add_cart(goods_id){
    var amount=$("#goods_amount").val();
    amount=parseInt(amount);

    var url="<?php echo url('cart/add_cart'); ?>?ajax=1"

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        data: {goods_id: goods_id,amount:amount},
        success:function(data) {  
            if(data.status==10001){
                alert("加入购物车成功");
            }else{
                alert("失败");
            }

        },  
        error : function() {  
            alert("失败");
        }  
    });
}

function add_order(goods_id){

    var amount=$("#goods_amount").val();
    amount=parseInt(amount);

    var url="<?php echo url('cart/add_cart'); ?>?ajax=1"

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        data: {goods_id: goods_id,amount:amount},
        success:function(data) {  
            if(data.status==10001){
                window.location.href="<?php echo url('order/add_order'); ?>?&cart_ids="+data.cart_id;
            }else{
                alert("失败");
            }

        },  
        error : function() {  
            alert("失败");
        }  
    });

}


function add_amount(){
    var amount=$("#goods_amount").val();
    amount=parseInt(amount);
    amount=amount+1;
    $("#goods_amount").val(amount);
}

function del_amount(){
    var amount=$("#goods_amount").val();
    amount=parseInt(amount);
    if(amount>1){
        amount=amount-1;
    }

    $("#goods_amount").val(amount);

}
</script>