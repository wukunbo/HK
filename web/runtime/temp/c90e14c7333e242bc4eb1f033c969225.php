<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:66:"D:\xampp\htdocs\HK\web/application/shop\view\User\add_address.html";i:1526619247;s:63:"D:\xampp\htdocs\HK\web\application\shop\view\Public\header.html";i:1526612616;s:60:"D:\xampp\htdocs\HK\web\application\shop\view\Public\nav.html";i:1526547439;s:63:"D:\xampp\htdocs\HK\web\application\shop\view\Public\region.html";i:1526614305;}*/ ?>
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
        position: relative;
        background-image: none!important;
    }
    .title{
        color: black!important;
        font-weight: bold!important;
    }
    select{
        width: 100%;
    }
    p{
        margin: 0;
    }
    .item-input-inset{
        border-bottom: 1px solid #E0E0E0;
        height: 20px;
    }
    .item-input-wrapper{
        background-color: #fff;
    }


    select {
        /*Chrome和Firefox里面的边框是不一样的，所以复写了一下*/
        border: solid 1px #000;

        /*很关键：将默认的select选择框样式清除*/
        appearance:none;
        -moz-appearance:none;
        -webkit-appearance:none;

        /*在选择框的最右侧中间显示小箭头图片*/
        background: url("http://ourjs.github.io/static/2015/arrow.png") no-repeat scroll right center transparent;


        /*为下拉小箭头留出一点位置，避免被文字覆盖*/
        padding-right: 14px;

        outline: none;
        width: 100%;
        height: 40px;
        line-height: 20px;
        padding-left: 60px;
    }


    /*清除ie的默认选择框样式清除，隐藏下拉箭头*/
    select::-ms-expand { display: none; }

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

<form name="form1" method="post" action="<?php echo url('User/address_action'); ?>?cart_ids=<?php echo $_REQUEST[cart_ids]; ?>" onsubmit="return submit_check()">

<input type="text" name="post[id]" value="<?php echo $data['id']; ?>" style="display: none;">


<script>
    select_province="<?php echo $data['province']; ?>";
    select_city="<?php echo $data['city']; ?>";
    select_area="<?php echo $data['area']; ?>";

</script>
<label class="item item-input item-select ">
<div class="input-label"> 省 </div>
<select name="post[province]" id="province" class="form-control"  onChange="javascript:get_city()">
    <option value="" >请选择</option>
</select>
</label>
<label class="item item-input item-select ">
<div class="input-label"> 市 </div>
</select>
<select name="post[city]" id="city"  class="form-control"  onchange ="javascript:get_area()">
    <option value="" >请选择</option>
</select>
</label>
<label class="item item-input item-select ">
<div class="input-label"> 区 </div>
</select>
<select name="post[area]" id="area"  class="form-control"  >
    <option value="" >请选择</option>
</select>
</label>


<script>

var url="http://192.168.1.215/HK/web/plus.php/Region/set_city?";

function get_province(){
    
    
    // alert(url);
    //url="Plus.php?c=Region&a=set_city&parent_id=1&select="+select_province,
    $("#province").html('<option value="">加载中</option>'); 
    $.ajax({
        type: "post",
        url:url+"&parent_id=1&select="+select_province,
        dataType: "json",       
        success: function(data) {
            //alert(data) ;
            if(data.status == '10001'){
                $("#province").html(data.data);

                if(select_city!==''){
                    get_city()
                }
            }else if(data.status == '10002'){
                 
            }               
        },
        complete:function(data){
            
        }
    })
}
function get_city(){
    var p=$("#province").val()
    $("#city").html('<option value="">加载中</option>'); 
    $.ajax({
        type: "post",
        url:url+"&parent_id="+p+"&select="+select_city,
        dataType: "json",       
        success: function(data) {
            if(data.status == '10001'){
                $("#city").html(data.data);
                if(select_area!==''){
                    get_area()
                }
            }else if(data.status == '10002'){
                 
            }               
        },
        complete:function(data){
            
        }
    })
}

function get_area(){
    var p=$("#city").val()
    $("#area").html('<option value="">加载中</option>'); 
    $.ajax({
        type: "post",
        url:url+"&parent_id="+p+"&select="+select_area,
        dataType: "json",       
        success: function(data) {
            if(data.status == '10001'){
                $("#area").html(data.data);
            }else if(data.status == '10002'){
                 
            }               
        },
        complete:function(data){
            
        }
    })
}
get_province();
 
</script>




<label class="item item-input ">
    <input type="text" placeholder="详细地址" id="details_site" name="post[details_site]" value="<?php echo $data[details_site]; ?>" />
</label>


<label class="item item-input ">
    <input type="text" placeholder="姓名" id="name" name="post[name]" value="<?php echo $data[name]; ?>" />
</label>


<label class="item item-input ">
    <input type="text" placeholder="电话" id="phone" name="post[phone]" value="<?php echo $data[phone]; ?>" />
</label>




<div class="item item-checkbox text-left item-borderless" style="padding-left: 40px;padding-right: 0;margin:1px; " >
    <label class="checkbox checkbox-orange" style="left:0px;right:0;">
        <input type="checkbox" name="post[type]" value="1" style="position: relative;top: 2px;margin-right: 5px;"></input>
    </label>
    <span style="font-size:13px;color:#666">设为默认地址</span>
</div>


<div class="bg-transparent padding-h-10" style="margin-top:20px;">
    <input type="submit" class="button button-block button-red" value="提交"  />
</div>



</form>

</body>
</html>


<script type="text/javascript">

function submit_check(){
    var province=$("#province").val();
    if(!province){
        alert("请选择省份");
        return false;
    }

    var city=$("#city").val();
    if(!city){
        alert("请选择市");
        return false;
    }

    var area=$("#area").val();
    if(!area){
        alert("请选择区");
        return false;
    }

    var details_site=$("#details_site").val();
    if(!details_site){
        alert("请填写详细地址");
        return false;
    }

    var name=$("#name").val();
    if(!name){
        alert("请填写姓名");
        return false;
    }


    var phone=$("#phone").val();
    if(!phone){
        alert("请填写电话");
        return false;
    }
}

</script>