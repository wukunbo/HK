 
function XianShi_NeiRong(URL){ 
  // document.body.scrollTop 
     
	if(document.getElementById("XianShi_NeiRong").style.display=="none"){
	document.getElementById("XianShi_NeiRong").style.display=""; 
	document.getElementById('XianShi_NeiRong').style.left=(document.body.clientWidth-800)/2+"px";  
	document.getElementById("XianShi_NeiRong").style.top=document.documentElement.scrollTop+40+"px";  
	
	//document.getElementById("XianShi_NeiRong").style.height=document.documentElement.clientHeight-50+"px";  
	
	//document.getElementById('XianShi_BJ').style.height=document.body.scrollHeight+"px";  
	document.getElementById('XianShi_BJ').style.height=window.screen.scrollHeight+"px";  
	document.getElementById('XianShi_BJ').style.width=document.body.clientWidth+"px";  
	document.getElementById('XianShi_BJ').style.display=""; 
	}else{
		
	}
    
   $("#XianShi_NeiRong").html('').load(URL); 
 
}
function XianShi_NeiRong_TXT(TXT){ 
  // document.body.scrollTop 
     
	if(document.getElementById("XianShi_NeiRong").style.display=="none"){
	document.getElementById("XianShi_NeiRong").style.display=""; 
	document.getElementById('XianShi_NeiRong').style.left=(document.body.clientWidth-800)/2+"px";  
	document.getElementById("XianShi_NeiRong").style.top=document.documentElement.scrollTop+40+"px";  
	
	//document.getElementById("XianShi_NeiRong").style.height=document.documentElement.clientHeight-50+"px";  
	
	//document.getElementById('XianShi_BJ').style.height=document.body.scrollHeight+"px";  
	document.getElementById('XianShi_BJ').style.height=window.screen.scrollHeight+"px";  
	document.getElementById('XianShi_BJ').style.width=document.body.clientWidth+"px";  
	document.getElementById('XianShi_BJ').style.display=""; 
	}else{
		
	}
    
   $("#XianShi_NeiRong").html(URL); 
 
}
 
function XianShi_GuanBi(){
	$("#XianShi_NeiRong").empty();
	document.getElementById("XianShi_NeiRong").style.display="none";
	document.getElementById("XianShi_BJ").style.display="none";
}
 
function drop_confirm(msg, url){
    if(confirm(msg)){
        window.location = url;
    }
}
 
//功能选择
function function_sel(keywords,context){
	$("#keywords").val(keywords)
	$("#context").val(context)
	XianShi_GuanBi()
}
function reply_ajax(url,item_id){
	  
		 if($("#title_ajax").val()==""){
		 	alert("标题不能为空");
		 	return false;
		 }
		 if($("#image_ajax").val()==""){
		 	alert("图片不能为空");
		 	return false;
		 } 
	$.ajax({
            type: "post",
            url: url,
            data: $("#upload_ajax").serialize(),
            dataType: "json",
            success: function(data) {
                if (data.result == 0) {
                     
					alert(data.info);
                    return false;
                }else if (data.result == 1) {
					 //关闭DIV
					var detail=eval('('+data.data+')');
				 
					 
					$("#item_id_"+item_id).val(detail.id)
					$("#item_cata_"+item_id).val(detail.cata)
					$("#item_title_"+item_id).html(detail.title)
					$("#item_image_"+item_id).html('<img src="../'+detail.image+'" class="image">');
					
						var w = $(".image").width();
						var h = $(".image").height();
						var s_w=80;
						var s_h=h*s_w/w 
						$(".image").attr({width:s_w, height:s_h});
						
					alert(data.info);			
					XianShi_GuanBi();
                }
                
            }
        })
   
 	return false;
}
 
/*
JS设置cookie:
 
假设在A页面中要保存变量username的值("jack")到cookie中,key值为name，则相应的JS代码为：

document.cookie="name="+username; 

JS读取cookie:
 
假设cookie中存储的内容为：name=jack;password=123
 
则在B页面中获取变量username的值的JS代码如下：

var username=document.cookie.split(";")[0].split("=")[1]; 

//JS操作cookies方法!

//写cookies

function setCookie(name,value)
{
    var Days = 30;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days*24*60*60*1000);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}

//读取cookies
function getCookie(name)
{
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
 
    if(arr=document.cookie.match(reg))
 
        return unescape(arr[2]);
    else
        return null;
}

//删除cookies
function delCookie(name)
{
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null)
        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}
//使用示例
setCookie("name","hayden");
alert(getCookie("name"));

//如果需要设定自定义过期时间
//那么把上面的setCookie　函数换成下面两个函数就ok;


//程序代码
function setCookie(name,value,time)
{
    var strsec = getsec(time);
    var exp = new Date();
    exp.setTime(exp.getTime() + strsec*1);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function getsec(str)
{
   alert(str);
   var str1=str.substring(1,str.length)*1;
   var str2=str.substring(0,1);
   if (str2=="s")
   {
        return str1*1000;
   }
   else if (str2=="h")
   {
       return str1*60*60*1000;
   }
   else if (str2=="d")
   {
       return str1*24*60*60*1000;
   }
}
//这是有设定过期时间的使用示例：
//s20是代表20秒
//h是指小时，如12小时则是：h12
//d是天数，30天则：d30

setCookie("name","hayden","s20");
*/
 
	 