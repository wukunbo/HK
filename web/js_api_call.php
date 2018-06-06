<?php

    header("Content-type: text/html; charset=utf-8");
    session_start();
    error_reporting(E_ALL ^ E_NOTICE);
    define('ROOT_PATH', dirname(__FILE__) . '/'); 

    require 'config.php';
    
    $log_id=$_REQUEST[log_id];
    
    // $_SESSION[wx][1]["openid"]="oUqHR07oH-W1Ptb3XQcUwpauwg-Q";
    
    // var_dump($_SESSION);exit;
    
    if (!$con){
        die('Could not connect: ' . mysql_error());
    }
    mysql_query("SET NAMES 'utf8'");
    //$trade_out_on=$_REQUEST['trade_out_on'];
    //$action=$_REQUEST['action'];

    //获取订单详情
    $type=$_REQUEST['type'];
    $log_id=$_REQUEST['log_id'];
    //$trade_out_on=$_REQUEST['trade_out_on'];
     
    $type=1;//不分单
    if($type==1){
        //获取订单信息
         
        $sql = "SELECT order_id FROM tl_order_log where order_log_id ='".$log_id."'";
        $result = mysql_query($sql,$con);
        $row = mysql_fetch_array($result);
        // echo $sql;
        $order_id=$row['order_id'];
        //var_dump($row);
         
        //$trade_out_on=$_REQUEST['trade_out_on'];
         
        $sql = "SELECT * from tl_order WHERE pay_status = 0 and order_id='".$order_id."'";
        // echo $sql;exit;
        
        $result = mysql_query($sql,$con);
        $order_detail = mysql_fetch_assoc($result);
         
        $trade_out_on=$order_detail[order_sn]."-".$log_id;
    }
    
    
    // var_dump($order_detail);exit;
     
    //获取微信配置
    $order_detail[wx_id]=1;
    
    require_once ("WxPay.Config.php"); //微信接口信息
     
    //var_dump($_SESSION);
    include_once("wxpay/WxPayPubHelper/WxPayPubHelper.php");
    
    //使用jsapi接口
    $jsApi = new JsApi_pub();

    //=========步骤1：网页授权获取用户openid============
    //通过code获得openid
    //$wx_config[id]=6;
     //var_dump($_SESSION[wx][$wx_config[id]]["openid"]);
     //exit;
     
    if($_SESSION[wx][$wx_config[id]]["openid"]=="" && $_REQUEST["return"]!="weixin"){
        $url=DOMAIN."js_api_call.php?log_id=".$log_id."&token={$_REQUEST[token]}";
        header("location:weixin.php?c=Index&a=get_openid&url=".$url."");
        exit;
    }
    if (!$_SESSION[wx][$wx_config[id]]['code'] && !$_SESSION[wx][$wx_config[id]]["openid"])
    {
        //echo 1;
        //exit;
        //  echo 123123;
        //触发微信返回code码
        $url_self='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
    //  $url = $jsApi->createOauthUrlForCode(WxPayConf_pub::JS_API_CALL_URL);
        $url = $jsApi->createOauthUrlForCode($url_self);
        //header("Location: $url"); 
    }else
    {
        //echo 2;
        //exit;
        //获取code码，以获取openid
        $_GET['code']= $_GET[wx][$wx_config[id]]['code'];
         
        $jsApi->setCode($code);
        if($_SESSION[wx][$wx_config[id]]["openid"]){
            $openid = $jsApi->getOpenId($_SESSION[wx][$wx_config[id]]["openid"]);
        }else{
            
            $openid = $jsApi->getOpenId();
        }   
    }
    
    if(!$_SESSION[wx][$wx_config[id]]["openid"]){
        echo '<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">';
         echo '<div style=" text-align:center; font-size:25px;">误操作,无OPENID</div>';
         exit;
    }
    //判断是否有效的支付订单
    if($order_detail[total_fee]<=0 || $trade_out_on==""){
        if($_REQUEST[ajax]){
            echo 10000;
            exit;
        }
        echo "<script>alert('无效请求".$order_detail[total_fee].$trade_out_on."')</script>";
        echo "<script>location.href='user.php'</script>";
        exit;
    }
    if(!$order_detail[real_fee]){
     
        echo "<script>location.href='user.php'</script>";
        exit;
        
        $order_detail[total_fee]=100;
        $order_detail[real_fee]=100;
    }
 
    //=========步骤2：使用统一支付接口，获取prepay_id============
    //使用统一支付接口
    $unifiedOrder = new UnifiedOrder_pub();
    
    
    //var_dump($order_detail[total_fee]);
     //var_dump($order_detail);
    $body= $order_id;
    $out_trade_no=$trade_out_on;
    $total_fee_org=$order_detail[real_fee];
    $total_fee=$total_fee_org*100;
    //$total_fee=$total_fee_org*100;
    //$total_fee=$total_fee_org*100;
    //$log_id=$_REQUEST["log_id"]=1;    
    $md5=md5(substr($out_trade_no,0,5));
    //var_dump($md5);
    //var_dump($out_trade_no);
    //var_dump($out_trade_no);
    //设置统一支付接口参数
    //设置必填参数
    //appid已填,商户无需重复填写
    //mch_id已填,商户无需重复填写
    //noncestr已填,商户无需重复填写
    //spbill_create_ip已填,商户无需重复填写
    //sign已填,商户无需重复填写
    $unifiedOrder->setParameter("openid","$openid");//商品描述
    $unifiedOrder->setParameter("body",$out_trade_no);//商品描述
    //自定义订单号，此处仅作举例
    $timeStamp = time();
    //$out_trade_no = WxPayConf_pub::APPID."$timeStamp";
    //var_dump(WxPayConf_pub::NOTIFY_URL);
    $unifiedOrder->setParameter("out_trade_no",$out_trade_no);//商户订单号 
    $unifiedOrder->setParameter("total_fee",$total_fee);//总金额
    $unifiedOrder->setParameter("notify_url",WxPayConf_pub::NOTIFY_URL);//通知地址 
    $unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
    $unifiedOrder->setParameter("attach",$md5);//附加数据 
    //非必填参数，商户可根据实际情况选填
    //$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号  
    //$unifiedOrder->setParameter("device_info","XXXX");//设备号 
    //$unifiedOrder->setParameter("attach",);//附加数据 
    //$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
    //$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间 
    //$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记 
    //$unifiedOrder->setParameter("openid","XXXX");//用户标识
    //$unifiedOrder->setParameter("product_id",$log_id);//商品ID

    $prepay_id = $unifiedOrder->getPrepayId();
//echo WxPayConf_pub::NOTIFY_URL;
    
    //=========步骤3：使用jsapi调起支付============
    $jsApi->setPrepayId($prepay_id);

    $jsApiParameters = $jsApi->getParameters();
    if($_REQUEST[ajax]){
        echo $jsApiParameters; 
        exit;
    }
    //var_dump($jsApiParameters);
    //echo $jsApiParameters;
    $tips = '<a href=user.php?act=order_info&id='.$order_id.' class=red><br><br>订单已经生成！<br><br>订单号：'.$_REQUEST["out_trade_no"].'<br><br>查看 订单详情！</a>';
    $to_url="user.php?c=Order&a=order_lists&order_id=".$order_id;
    //var_dump($to_url);
    if($order_detail[pintuan_id]!=""){//拼团
        $sql = "SELECT * from tl_order_goods WHERE   order_id='".$order_id."'";
        $result = mysql_query($sql,$con);
        $row = mysql_fetch_assoc($result);
        if($row[goods_id]){//拼团成功
        //  var_dump($to_url);
            $to_url="shop.php?m=Shop&c=Goods&a=goods_detail&goods_id=".$row[goods_id]."&pintuan_id=".$order_detail[pintuan_id];
        }else{
            $to_url="user.php?c=Pintuan&a=lists";
        }
        //var_dump($to_url);
    }
     
    $sql = "SELECT * from tl_order WHERE pay_status = 0 and order_id='".$order_id."'";
            //echo $sql;
    $result = mysql_query($sql,$con);
    $order_detail = mysql_fetch_assoc($result);
    if($order_detail[pintuan_status]==1 && ($order_detail[is_pintuan]==1 || $order_detail[app]=='pintuan') ){//拼团成功
        $to_url="user.php?c=Order&a=order_lists&order_id=".$order_id;
    }

?>

<!-- 提交订单返回页面 -->
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon.png"/>
    <title>提交订单</title>
 
    <script src="js/jquery-1.6.2.min.js" type="text/javascript"></script>
 
    <script type="text/javascript">
        type="<?php echo $type;?>";
        order_id="<?php echo $order_id;?>";
        from_type="<?php echo $_REQUEST[from];?>";
        //调用微信JS api 支付
        function jsApiCall()
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                <?php echo $jsApiParameters;?>,
                function(res){
                    //WeixinJSBridge.log(res.err_msg);
                    if(res.err_msg.indexOf('ok')>0){
                        alert("已成功支付");
                        if(from_type!=="pc"){
                            location.href="http://www.taiwaskii.com/app/zhubaoshangcheng/#/my_order";   
                        }
                        
                        
                    }else{
                        // alert(res.err_code+res.err_desc+res.err_msg);
                        alert("取消支付");
                    }
                     
                    
                }
            );
        }
        
        function callpay()
        {
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            }else{
                jsApiCall();
            }
        }
        callpay()
    </script>
 
</head>

<div class="mid" style="max-width:600px; margin:auto;">
 
    <div class="fxjh_one">
         
        <div class="fxjh_two">
            <div class="fxjh_twotop">
                <h4 style="font-size: 24px;margin-bottom: 15px;">¥<span><?php echo $total_fee_org;?></span> </h4>
                <p>订单编号：<?php echo $order_detail[order_sn];?></p>
            </div>
           
            <div class="fxjh_twobtm">
                 <a href="javascript:callpay()" title="微信支付" class="no1">确定</a>
                  
             
            </div>
        </div>
    </div>
    
 
</div>
<style>
body{ font-family: "微软雅黑";background: #f3f5f7;}
.fxjh_one li {
    float: left;
}
.fxjh_one li a {
    border-bottom: 2px solid #ccc;
    border-right: 1px solid #ccc;
    color: #868585;
    display: block;
    font-size: 26px;
    height: 60px;
    line-height: 60px;
    text-align: center;
    width: 299px;
}
.fxjh_one li.no a {
    border-right: 0 none;
}
.fxjh_one li.current a, .fxjh_one li a:hover {
    border-bottom: 2px solid #d60000;
    color: #d60000;
    text-decoration: none;
}
.fxjh_one table {
    overflow: hidden;
    text-align: center;
    width: 100%;
}
.fxjh_one table th {
    background: none repeat scroll 0 0 #f9f9f9;
    border-bottom: 1px solid #eeeeee;
    color: #525252;
    font-size: 22px;
    font-weight: normal;
    height: 60px;
}
.fxjh_one table td {
    border-bottom: 1px solid #eeeeee;
    color: #818181;
    font-size: 20px;
    height: 70px;
}
.fxjh_one table td span {
    color: #ca0000;
}
.fxjh_one h1 {
    color: #303030;
    font-size: 26px;
    font-weight: normal;
    margin-right: 30px;
    margin-top: 10px;
    padding-right: 30px;
    text-align: right;
 
}
.fxjh_one h1 span {
    color: #ca0000;
}
.fxjh_two {
    margin: 0 auto;
    overflow: hidden;
   
}
.fxjh_two .fxjh_twotop {
     background: #fff;
    overflow: hidden;
    padding: 30px 0 30px;
    width: 100%;
    font-family: "微软雅黑";
    text-align: center;
}
.fxjh_two p {
    color: #303030;
    font-size: 16px;
    height: 30px;
    text-align: center;
    width: 100%;
   
}
.fxjh_two p span {
    color: #ca0000;
}
.fxjh_two input {
    background: none repeat scroll 0 0 #f9f9f9;
    border: 1px solid #ccc;
    color: #9f9f9f;
    display: block;
    font-family: "微软雅黑";
    font-size: 22px;
    height: 60px;
    line-height: 60px;
    margin: 0 auto 25px;
    text-indent: 10px;
   
}
.fxjh_two input:hover {
    border: 1px solid #f00;
}
.fxjh_twobtm {
    overflow: hidden;
    padding-top: 40px;
    width: 100%;
}
.fxjh_two a.no1, .fxjh_two a.no2 {
    color: #fff;
    display: block;
    font-size: 28px;
    height: 65px;
    line-height: 65px;
    margin: 0 auto 20px;
    text-align: center;
   
}

.fxjh_twobtm {
    overflow: hidden;
    padding-top: 40px;
    width: 100%;
}
.fxjh_two a.no1 {
    background: #1dbf09; border-radius:5px;
}
.fxjh_two a.no1, .fxjh_two a.no2 {
    color: #fff;
    display: block;
    font-size: 28px;
    height: 65px;
    line-height: 65px;
    margin: 0 auto 20px;
    text-align: center;
     
}
a {
    color: #5c5c5c;
    font-family: "微软雅黑";
    text-decoration: none;
}
</style>
 
</body>
</html>
 
 <?php
 //判断是否来自手机
 function is_mobile_request()  
{  
 $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';  
 $mobile_browser = '0';  
 if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))  
  $mobile_browser++;  
 if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))  
  $mobile_browser++;  
 if(isset($_SERVER['HTTP_X_WAP_PROFILE']))  
  $mobile_browser++;  
 if(isset($_SERVER['HTTP_PROFILE']))  
  $mobile_browser++;  
 $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));  
 $mobile_agents = array(  
    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',  
    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',  
    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',  
    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',  
    'newt','noki','oper','palm','pana','pant','phil','play','port','prox',  
    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',  
    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',  
    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',  
    'wapr','webc','winw','winw','xda','xda-'
    );  
 if(in_array($mobile_ua, $mobile_agents))  
  $mobile_browser++;  
 if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)  
  $mobile_browser++;  
 // Pre-final check to reset everything if the user is on Windows  
 if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)  
  $mobile_browser=0;  
 // But WP7 is also Windows, with a slightly different characteristic  
 if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)  
  $mobile_browser++;  
 if($mobile_browser>0)  
  return true;  
 else
  return false;
 }
 ?>