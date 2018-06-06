function reply_add_ajax_NeiRong(URL,id){ 
  // document.body.scrollTop 
    id=0;
	t=(document.getElementById("editor_div_"+id).style.top);
	l=(document.getElementById("editor_div_"+id).style.left);
	l=l.replace("px",""); 
	l=l-442-40;
	l=l+"px";
 
	if(document.getElementById("reply_add_ajax_NeiRong").style.display=="none"){
		document.getElementById("reply_add_ajax_NeiRong").style.display=""; 
		document.getElementById('reply_add_ajax_NeiRong').style.left=l;  
		document.getElementById("reply_add_ajax_NeiRong").style.top=t;  
		
		//document.getElementById("reply_add_ajax_NeiRong").style.height=document.documentElement.clientHeight-50+"px";  
		
		//document.getElementById('reply_add_ajax_BJ').style.height=document.body.scrollHeight+"px";  
		 
	}else{
		
	}
    
   $("#reply_add_ajax_NeiRong").html('').load(URL); 
 
}
 
function reply_add_ajax_GuanBi(){
	$("#reply_add_ajax_NeiRong").empty();
	document.getElementById("reply_add_ajax_NeiRong").style.display="none";
	document.getElementById("reply_add_ajax_BJ").style.display="none";
}

//类型切换
$(function(){
 	$("#cata").on("click", "a", function(e) {
			 					 
		var id = $(e.target).attr("data-id");	
		var url = $(e.target).attr("data-url");	
		cata="cata_"+id;
		 
		if(url){
			XianShi_NeiRong(url);
		}
		cata_change(id,cata); 

	});
});	
function cata_change(id,cata){
	 
		$("#msg_cata").val(id);
		document.getElementById("context").style.display=""; 
		if(id=="txt"){
			document.getElementById("context").style.display=""; 
			document.getElementById("textCounterTxt").style.display=""; 
			document.getElementById("context_reply").style.display="none"; 	
		}else{
			document.getElementById("context").style.display="none"; 
			document.getElementById("textCounterTxt").style.display="none"; 
			document.getElementById("context_reply").style.display=""; 	
		}
 		 
		$("#cata > a").removeClass();		
		$("#"+cata).addClass("cur");	
}
//素材
function tag_meterial_dis(obj,div){
	$("#tag > a").removeClass();
 
	document.getElementById(div+"_tag").className="on";
 
	if(div=="lists_img"){
	 	document.getElementById("lists_img").style.display="block";	
	 	document.getElementById("ajax_upload").style.display="none";			
	}else{
	 	document.getElementById("lists_img").style.display="none";	
	 	document.getElementById("ajax_upload").style.display="block";			
	}
	
		      
}
//回复图片
function photo_sel_to_reply(image_data){
	 
	$("#image_data").val(image_data);
	$("#image_thumb").html('<img src="../'+image_data+'" class="image">');
	$("#image_cover").html('<img src="../'+image_data+'" class="image">');
	 
	Xianshi_GuanBi();
 
}
//回复图片
function photo_sel_to_reply(image_data){
	 
 
		$("#image_data").val(image_data);
		$("#image_thumb").html('<img src="../'+image_data+'" class="image">');
		$("#image_cover").html('<img src="../'+image_data+'" class="image">');			
	 
	 XianShi_GuanBi();
 
}
//回复图片
function photo_sel_to_reply_ajax(image_data){
	 
	 XianShi_GuanBi();
	 document.getElementById("image_data_ajax").value=image_data;
	 document.getElementById("image_thumb_ajax").innerHTML='<img src="../'+image_data+'" class="image">';
  
}
function insert_material_ajax(image){
	 
    var ajax_image = $("#ajax_image").val();
    if (ajax_image == "" ) {
        alert("标题不能为空");
		return false;
    }
        $.ajaxFileUpload({
           
            url: "tlwx.php?m=Material&a=insert_update",
          //  data: $("#ajax_save_form").serialize(),
			fileElementId:image,
			secureuri:false,
            dataType: "json",
            success: function(data,status) {
                if (data.status == 0) {
                    alert("上传失败");
                }else if (data.status == 2) {
                    alert("上传失败2");
                }else if(data.status == 1) {
					 
					photo_sel_to_reply_ajax(data.url);
					alert("成功");
                }
            },error: function (data, status, e)//服务器响应失败处理函数
                {
					alert(e);
                }
        })
		 
  
	return false;
} 
 
function insert_material(image,to_obj){	 
    var ajax_image = $("#ajax_image").val();
    if (ajax_image == "" ) {
        alert("标题不能为空");
		return false;
    }
        $.ajaxFileUpload({          
            url: "tlwx.php?m=Material&a=insert_update",
           // data: $("#ajax_save_form").serialize(),
			fileElementId:image,
			secureuri:false,
            dataType: "json",
            success: function(data,status) {
                if (data.status == 0) {
                    alert("上传失败");
                }else if (data.status == 2) {
                    alert("上传失败2");
                }else if(data.status == 1) {
					if(to_obj=="to_reply"){
						photo_sel_to_reply(data.url);
					}else{
						location.href="tlwx.php?m=Material&a=lists";
						//photo_sel(data.id,data.url);
					}
					  
					 alert("成功");
                }
            },error: function (data, status, e)//服务器响应失败处理函数
                {
					alert(e);
                }
        });
		 
  
	//return false;
}
//多图文中的图文素材
function reply_insert_ajax(item_id){
	 
    var ajax_image = $("#ajax_image").val();
 	 var oEditor = FCKeditorAPI.GetInstance("data[context_ajax]") ; 
  	 $("#context_ajax").val(oEditor.GetXHTML(true));
    if (ajax_image == "" ) {
        alert("标题不能为空");
		return false;
    }
  	 $.ajax({
            type: "post",
            url: "tlwx.php?m=Reply&a=reply_insert_ajax",
            data: $("#upload_ajax").serialize(),
            dataType: "json",
            success: function(data,status) {
                if (data.status == 0) {
                    alert(data.info);
                }else if (data.status == 2) {
                    alert("上传失败2");
                }else if(data.status == 1) {
					 
					document.getElementById("item_title_"+item_id).innerHTML=data.title;
					document.getElementById("item_image_"+item_id).innerHTML='<img src="../'+data.image+'" class="image">';
					document.getElementById("item_id_"+item_id).value=data.id;
					document.getElementById("item_cata_"+item_id).value=1;
					document.getElementById("editor_div_"+item_id).innerHTML="<a href=\"javascript:reply_add_ajax_NeiRong('tlwx.php?m=Reply&a=content_add&ajax=1&item_id="+item_id+"&id="+data.id+"',1)\">图文信息</a> <a href=\"javascript:reply_add_ajax_NeiRong('tlwx.php?action=good_lists_ajax&item_id=1&id="+data.id+"',1)\">商品信息</a> <a href=\"javascript:imagelists_del(1,"+data.id+")\">删除</a>";
					alert("成功");
					reply_add_ajax_GuanBi();
                }
            },error: function (data, status, e)//服务器响应失败处理函数
                {
					alert(e);
                }
        })
		 
  
	return false;
}

//删除图$("p").remove(); 
$(function(){
 	$("#lists_img").on("click", ".del_action", function(e) {
															   
		 if (confirm("删除后，不可恢复！")==true){
			var id = $(e.target).attr("data-id");													 
			 
			$.ajax({
				type: "get",
				url: del_url+"&id="+id,
				dataType: "json",
				success: function(data,textStatus) {
					if (data.status == 0) {
						//失败
						alert("删除失败");
					}else if(data.status == 1) {
						//进行url跳转 参与成功
						 
						$("#item_"+id).remove(); 
						alert("删除成功");
					}else {
						show_loading_close();
						show_tips("网络出错，请重新加载！");
					}
				}
			})
		 }else{
			   return false;
		}																   
		 
	});
});

function textCounter(obj, countfield, maxlimit) { 
   // 函数，3个参数，表单名字，表单域元素名，限制字符； 
   obj=document.getElementById(obj);
   if (obj.value.length > maxlimit) {
   //如果元素区字符数大于最大字符数，按照最大字符数截断； 
   		obj.value = obj.value.substring(0, maxlimit); 
   }else {
   //在记数区文本框内显示剩余的字符数； 
   		document.getElementById(countfield).innerHTML = maxlimit - obj.value.length; 
   }
}  