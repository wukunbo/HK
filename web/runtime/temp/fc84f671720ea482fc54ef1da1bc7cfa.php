<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:66:"D:\xampp\htdocs\HK\web/application/shop\view\index\cate_lists.html";i:1526455561;s:63:"D:\xampp\htdocs\HK\web\application\shop\view\Public\header.html";i:1526377370;s:60:"D:\xampp\htdocs\HK\web\application\shop\view\Public\nav.html";i:1526547439;}*/ ?>
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
    .shangpin-bg{
        margin: 0;
        border-bottom: 1px solid #E6E6E6;
        background-color: #ffffff;
        width: 100%;
        padding: 10px!important;
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
    .col-25{
        height: 100%;
        float: left;
    }
    .col-75{
        height: 100%;
        padding: 20px;
    }
    .col-75 img{
        width: 90px;
        height: 90px;
        border-radius: 50%;
    }
    .col_con{
        width: 50%;
        height: 120px;
        margin-bottom: 20px;
        text-align: center;
        float: left;
    }

    .active{
        background-color:#fafafa;
        color: red;
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

<div class="col col-25 clear_p">

<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <span class="col text-center shangpin-bg cate_span" onclick="ajax_cate(<?php echo $vo['cate_id']; ?>,this)"><?php echo $vo['cat_name']; ?></span>
<?php endforeach; endif; else: echo "" ;endif; ?>

   
</div>


<div class="col col-75 col-offset-25" id="cate_div">
    
    <?php if(is_array($data[cate_lists]) || $data[cate_lists] instanceof \think\Collection || $data[cate_lists] instanceof \think\Paginator): $i = 0; $__LIST__ = $data[cate_lists];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <div class="col_con" onclick="to_href('<?php echo url('goods_lists'); ?>?cate_id=<?php echo $vo['cate_id']; ?>')">
        <img src="<?php echo $vo['img_thumb']; ?>">
        <p><?php echo $vo['cat_name']; ?></p>
    </div>
    <?php endforeach; endif; else: echo "" ;endif; ?>

    <div class="clear"></div>
    
</div>



</body>

</html>

<script type="text/javascript">



function ajax_cate(parent_id,t){
    $(".cate_span").removeClass("active");
    $(t).addClass("active");

    $.ajax({
        url: "<?php echo url('ajax_cate'); ?>",
        type: 'GET',
        dataType: 'json',
        data: {parent_id: parent_id},
        success:function(data) {  
            if(data.status==10001){
                $("#cate_div").html(data.html);
            }
        },  
        error : function() {  
            alert("失败");
        }  
    });
    
}


function to_href(url){
    window.location.href=url;
}

</script>