<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:61:"D:\xampp\htdocs\HK\web/application/shop\view\index\index.html";i:1526461362;s:63:"D:\xampp\htdocs\HK\web\application\shop\view\Public\header.html";i:1526377370;s:63:"D:\xampp\htdocs\HK\web\application\shop\view\Public\footer.html";i:1526547461;}*/ ?>
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


<body>


<div class="bar-positive">
    <div class="buttons">
        <img src="/HK/web/public/static/shop//img/hklogo.png">
    </div>
    <div class="search">
        <input id="search_keyword" type="text" placeholder="输入关键字搜索商品" style="width: 80%;height: 30px"/>
        <img src="/HK/web/public/static/shop//img/sousuo.png" class="magnifier" onclick="search_goods()" />
    </div>
    <div class="clear"></div>
</div>

<div class="swiper-container swiper1" style="margin: 10px auto;">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <img src="/HK/web/public/static/shop//img/2.jpg" style="width: 100%;height: 100%"/>
        </div>

        <div class="swiper-slide">
            <img src="/HK/web/public/static/shop//img/index.jpg" style="width: 100%;height: 100%"/>
        </div>
    </div>
</div>

<div class="content text-center">
    <span style="font-size: bold">每周过港</span>
    <hr style="height: 1px;width: 60%;background-color:#B8BCBD;border: none;"></hr>
    <img src="img/down.jpg" style="width: 5%;">
    <div class="row">
        <div class="row1"><img src="img/index.jpg"></div>
        <div class="row1"><img src="img/index.jpg"></div>
        <div class="row1"><img src="img/index.jpg"></div>
        <div class="row1"><img src="img/index.jpg"></div>
    </div>
    <div class="row clear_pm" style="padding-top: 30px;">
        <div class="col col-50 clear_p">
            <img src="img/con2.jpg"/>
        </div>
        <div class="col col-50 clear_p">
            <img src="img/con2.jpg"/>
        </div>
    </div>
    <div class="row clear_pm">
        <div class="col col-50 clear_p">
            <img src="img/con2.jpg"/>
        </div>
        <div class="col col-50 clear_p">
            <img src="img/con2.jpg"/>
        </div>
    </div>
</div>

<div style="width: 100%;height: 10px;background-color: #E6E6E6;"></div>

<div class="content text-center cen">
    <div>
        <img class="img1" src="img/ye_left.jpg">
        <div class="tit">夏秋精选</div>
        <img class="img2" src="img/ye_right.jpg">
        <div class="clear"></div>
    </div>
    <P>SUMMER  AND  FALL  SELECTED</P>
    <img src="img/con1.jpg" style="width: 100%;">
    <div class="ad">
        <div class="float-l adv1">
            <img src="img/con3.jpg">
        </div>
        <div class="float-l adv2" style="margin-bottom: 8px;">
            <img src="img/con4.jpg">
        </div>
        <div class="float-l adv2">
            <img src="img/con4.jpg">
        </div>
    </div>
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


<script type="text/javascript">
function search_goods(){
    var search_keyword=$("#search_keyword").val();
    if(!search_keyword){
        alert("请输入商品名");
        return;
    }

    window.location.href="<?php echo url('goods_lists'); ?>?&search_keyword="+search_keyword;
}


$(function () {
    var swiper1 = new Swiper('.swiper1', {
        pagination: '.pagination1',
        paginationClickable: true,
        mode: 'horizontal',
        roundLengths: true,
        loop: true,
        visiblilityFullfit: true,
        preventLinks: false,
        autoplay: 4000,
        initialSlide: 0,
        slidesPerView: 1,
        calculateHeight: true,
        DOManimation: true,
    });

});

</script>