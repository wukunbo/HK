<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:60:"D:\xampp\htdocs\HK\web/application/shop\view\index\cart.html";i:1526467144;s:63:"D:\xampp\htdocs\HK\web\application\shop\view\Public\header.html";i:1526377370;s:60:"D:\xampp\htdocs\HK\web\application\shop\view\Public\nav.html";i:1526547439;}*/ ?>
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
    h3{
        display: inline-block;
    }
    .item{
        background-color: #FAFAFA!important;
    }
    .item_{
        margin-top: 10px;
    }
    .item_ span{
        border: 1px solid #CCCCCC;
        background-color: #E6E6E6;
        float: left;
        height: 20px;
        line-height: 20px; 
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
        padding: 10px 16px 0 156px;
    }
    .good_img{
        position: absolute;
        top: 10px;
        left: 40px;
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
        position: absolute;
        top: 10px;
        left: 10px;
        max-width: 30px;
        max-height: 100px;
        width: 100%;
        height: 100%;
        text-align: center;
        line-height: 100px
    }
    .row{
        padding: 0;
    }
    .mtop_1{
        margin-bottom: 10px;
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

<div style="width: 100%;height: 10px;"></div>

<div id="cart_content">
    
    <!-- 商品 -->
    

<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>

    <div class="content mtop_1">
        <div class="item item-thumbnail-left item-borderless">
            <div class="good_select"><input type="checkbox" name="goods_checkbox" value="<?php echo $vo['cart_id']; ?>" onchange="deal_price()"></input></div>
            <div class="good_img"><img src="http://192.168.1.215/HK/web/<?php echo $vo['img_orogin']; ?>"/></div>
            <h3><?php echo $vo['goods_name']; ?></h3>
            

            <div style="margin-top: 10px;">
                <h3 style="color:red;">HKD ￥<?php echo $vo['market_price']; ?></h3>
            </div>

            <div class="item_" style="margin-bottom: 50px;">
                <span style="border-radius: 3px 0 0 3px;margin-right: -1px;" onclick="add_cart(<?php echo $vo['cart_id']; ?>,'del')">－</span>
                <input type="number" value="<?php echo $vo['amount']; ?>" id="goods_num<?php echo $vo[cart_id]; ?>"/>
                <span style="border-radius: 0 3px 3px 0;" onclick="add_cart(<?php echo $vo['cart_id']; ?>,'add')">＋</span>
                <img src="/HK/web/public/static/shop//img/delete.png" style="width: 15px;float: right;">
            </div>
        </div>
        <div style="height: 3px;width: 94%;margin-left: 3%;margin-right: 3%;background-color:#E5E5E5; "></div>
    </div>
    
<?php endforeach; endif; else: echo "" ;endif; ?>





    <div style="height: 30px;width: 100%;"></div>

</div>


<div style="margin: 0;padding-left: 10px; width: 100%;margin-bottom: 50px;">
    <span style="color: red;">*注：</span>购物车购买金额，代购费收取15%
</div>


<div class="row back-white fixed-bottom">
    <!-- <div class="col col-20" style="margin-left: 11px;padding-top: 15px;">
        <input type="checkbox" style="margin-right: 10px;"></input>全选
    </div> -->
    <div class="col col-65" style="padding-top: 15px;padding-right: 10px;">
    合计：<span style="color: red;">HKD ￥<b id="total_price">0</b></span>
    </div>
    <div class="col col-25" style="background-color: #4FD2C2;color: #fff;text-align: center;padding-bottom: 15px;padding-top: 15px;">
        <a style="color: #fff;">结算</a>
    </div>
</div>


</body>
</html>


<script type="text/javascript">
function add_cart(cart_id,type){

    $.ajax({
        url: "<?php echo url('ajax_add_cart'); ?>",
        type: 'GET',
        dataType: 'json',
        data: {cart_id:cart_id,type:type},
        success:function(data) {  
            if(data.status==10001){
                $("#goods_num"+cart_id).val(data.amount);
            }
        },  
        error : function() {  
            alert("失败");
        }  
    });
}


//核算价格
function deal_price(){

    var arr=new Array();

    $('input[name="goods_checkbox"]:checked').each(function(i){
        // alert($(this).val())
        arr[i] = $(this).val();
    });
    var vals = arr.join(",");
    // console.log(arr);
    // alert(vals);
    $.ajax({
        url: "<?php echo url('deal_price'); ?>",
        type: 'GET',
        dataType: 'json',
        data: {cart_ids:vals},
        success:function(data) {  
            if(data.status==10001){
                $("#total_price").html(data.total_price);
            }
        },  
        error : function() {  
            alert("失败");
        }  
    });

}


</script>