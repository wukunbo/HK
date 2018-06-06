 
	$("#url_sel_ajax").click( 
	
	
		function(){
			if(document.getElementById("url_ajax").disabled == false){
				 
				document.getElementById("url_ajax").disabled = true
				$("#url_ajax").val("")	 
			}else{	 
				document.getElementById("url_ajax").disabled = false
				 
			}
		}
	);	
	
 CKEDITOR.replace( 'context_ajax',{
  toolbar :
  [  
	  ['RemoveFormat','Bold','Italic','Underline'],
	  ['NumberedList','BulletedList'],
	  ['JustifyLeft','JustifyCenter','JustifyRight'],
	  ['Link','Unlink'],
	  ['Image','Flash','Smiley'],
	  
	  ['TextColor','BGColor','Maximize'] ,
	  
	  ['Font','FontSize'] 
  ] 
  });
	function fuasdnfsdaf(){
		var htmlData=CKEDITOR.instances.myEditor.getData();
		var appEndData="追加的内容";
		var theData=appEndData;
		CKEDITOR.instances.myEditor.setData(theData);
	}	 

 