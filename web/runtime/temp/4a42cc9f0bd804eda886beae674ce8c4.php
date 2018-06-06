<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:60:"D:\xampp\htdocs\HK\web/application/shop\view\user\index.html";i:1526547951;s:63:"D:\xampp\htdocs\HK\web\application\shop\view\Public\header.html";i:1526377370;s:63:"D:\xampp\htdocs\HK\web\application\shop\view\Public\footer.html";i:1526547461;}*/ ?>
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
    .back{
        background: linear-gradient(89deg, #79d9cb, #51ccca, #20b9c9, #07afc9);
        background-size: 800% 800%;
        -webkit-animation: AnimationName 8s ease infinite;
        -moz-animation: AnimationName 8s ease infinite;
        animation: AnimationName 8s ease infinite;
        color: #fff;
    }
    @-webkit-keyframes AnimationName {
        0%{background-position:0% 26%}
        50%{background-position:100% 75%}
        100%{background-position:0% 26%}
    }
    @-moz-keyframes AnimationName {
        0%{background-position:0% 26%}
        50%{background-position:100% 75%}
        100%{background-position:0% 26%}
    }
    @keyframes AnimationName { 
        0%{background-position:0% 26%}
        50%{background-position:100% 75%}
        100%{background-position:0% 26%}
    }
    .item-avatar{
        padding-left: 72px;
        min-height: 100px;
    }
    .img-avatar >img:first-child{
        width: 70px!important;
        height: 70px!important;
        border-radius: 50%;
        border: 1px solid #fff;
    }
    .img-avatar{
        min-height: 72px;
        position: relative;
    }
    p{
        margin-bottom: 0;
    }
    .text-center{
        margin: 0 3%!important;
    }
    .person_num{
        float: right;
        border: 1px solid #15A5A6;
        background-color: rgba(21,165,166,0.5);
        border-radius: 25px;font-size: 1px;
        padding-right: 10px;
        padding-left: 10px;
        height: 16px;
        display: inline-table;
        line-height: 16px;
        margin-top: 5px;
        margin-right: 5px;
        margin-bottom: -5px;
    }
    .ion img{
        max-height: 30px;
        max-width: 30px;
    }
    .ion img{
        max-width: 20px;
        max-height: 20px;
    }
    .item-icon-right span{
        position: relative;
        left: 10px;
        bottom: 4px;
    }
</style>

<body>


<div class="back border-1p-ddd">
    <div class="person_num">
        <span>会员ID：15</span>
    </div>
    <div class="clear"></div>
    <div class="row">    
        <div class="col  img-avatar text-center  margin-b-5px mtop_5">
            <img src="/HK/web/public/static/shop//img/bo2.jpg">
            <p style="margin-bottom: 10px">彩云之南</p>
        </div>
    </div>
</div>

<div style="height: 5px;width: 100%;background-color: #F2F2F2;"></div>


<div class="back-white">
    
    

    <div style="height: 10px;background: #F2F2F2;width: 100%"></div>

    <div class="row text-center ion">

        <a class="col" href="<?php echo url('index/cart'); ?>">
            <img src="/HK/web/public/static/shop//img/car.png"> <br/>
            购物车
        </a>
       
        <a class="col" href="#">
            <img src="/HK/web/public/static/shop//img/order.png"> <br/>
            订单
        </a>
        
    </div>

    <div style="height: 10px;background: #F2F2F2;width: 100%"></div>

    <a class="item item-icon-right ion">
        <img src="/HK/web/public/static/shop//img/shoucang.png">
        <span>我的收藏</span>
        <i class="icon ion-ios-arrow-right size18" style="color: #D6D6D6"></i>
    </a>


    <a class="item item-icon-right ion">
        <img src="/HK/web/public/static/shop//img/chongzhi.png">
        <span>我的浏览</span>
        <i class="icon ion-ios-arrow-right size18" style="color: #D6D6D6"></i>
    </a>
    
   
</div>







<!-- 包含尾部模版footer -->



<div style="width: 100%;height: 30px;"></div>

<div class="row fixed-bottom row-center" style="padding:5px 0 0 0;border-top: 1px solid #666;background: #fff">
    <a class="col" href="<?php echo url('index/index'); ?>" style="color:#45BBAF;">
        <img src="/HK/web/public/static/shop/img/index.png"> <br/>
        首页
    </a>
    <a class="col" href="<?php echo url('index/cate_lists'); ?>">
        <img src="/HK/web/public/static/shop//img/classify.png"> <br/>
        分类
    </a>
    <a class="col" href="<?php echo url('index/cart'); ?>">
        <img src="/HK/web/public/static/shop//img/car1.png"> <br/>
        购物车
    </a>
    <a class="col" href="<?php echo url('user/index'); ?>">
        <img src="/HK/web/public/static/shop//img/personal.png"> <br/>
        我
    </a>
</div>


</body>

</html>