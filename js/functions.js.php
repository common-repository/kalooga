<?php
/*
Kalooga plugin
*/
require_once('../classes.php');
?>
<!-- 
var uniqueID;
var kaloogaAPIKey;
var publisherID;
var customConfiguration = false;

function init(){
    //generate uniqe id / overloadId
	var d = new Date();
	uniqueID = d.getTime() + "";
	uniqueID = uniqueID.substring(5);

	kaloogaAPIKey = "<?php echo get_option("kalooga_api_key");?>";
	publisherID = "<?php echo get_option("kalooga_publisher_id");?>";

	if(kaloogaAPIKey != ''){
		$("#simple-mode").hide();	
		$("#advanced-mode").show();
		$("#advanced-mode-extra").hide();
		$("#simple-mode-extra").hide();
		getJSONData(kaloogaAPIKey);
	}else{
		$("#simple-mode").show();	
		$("#advanced-mode").hide();
		$("#advanced-mode-form").hide();
				
		document.getElementById('show-example').disabled=false;
		document.getElementById('continue').disabled=false;
		setSelectedItem();
	}
}//init
function refreshCustomWidget(){
	if(customConfiguration == true){
		
		var query = document.getElementById('kalooga-query').value;
		query = query.replace(/"/g, '&quot;');
		var widget;
		
		var widgetID = document.getElementById('kalooga-widget-id').value;	
		widget="<?php echo $publishing_url;?>/preview?publisherId="+publisherID+"&overloadId="+uniqueID;
	 
		document.getElementById('kalooga-example').src=widget;
		document.getElementById('kalooga-example').parentNode.style.display="inline";
		$("#kalooga-example").show();
	
	}else{
		kaloogaShowExample();
	}
}
function setSelectedItem(){	    
	//get selected content
	var selectedContent = parent.tinyMCE.activeEditor.selection.getContent();
	if(selectedContent != ''){
		//Check if it is an advanced widget
		if(selectedContent.search('kalooga wid=') != -1){
			//arr_content = selectedContent.split('[kalooga pid=');
			arr_content = selectedContent.split('[kalooga ');
			//arr_content = arr_content[1].split(' oid=');
			arr_content = arr_content[1].split('wid=');
			//uniqueID = arr_content[0];
			arr_content = arr_content[1].split(' /]');
			widgetID = arr_content[0];
			selectOption("kalooga-widget-id",widgetID);
			mode='advanced';
			kaloogaShowExample();
		//Check if it is an simple query widget
		}else if(selectedContent.search('kalooga q=') != -1){
			arr_content = selectedContent.split('[kalooga q=');
			arr_content = arr_content[1].split(' t=');
			var q = arr_content[0];
			arr_content = arr_content[1].split(' /]');
			var widgetType = arr_content[0];
			document.getElementById('kalooga-query').value = q;
			document.getElementById(widgetType).selected = true;
			$("#simple-mode").show();
			$("#advanced-mode").hide();
			mode='simple';
			kaloogaShowExample();
		}
	}
}

//Select option in selectbox
function selectOption(selectBoxID,value){
	var list = document.getElementById(selectBoxID);
	if(list&&list.options.length){
		for(var i=0; i<list.options.length; i++){
			if(list.options[i].value == value){
				list.selectedIndex = i;
				//list.disabled = true;
				return;
			}
		}
	}
}
  
  //set mode, advanced||simple
  var mode='<?php if(get_option('kalooga_api_key'))echo'advanced';else echo'simple';?>';
  
  function isInt (i) {
	return (i % 1) == 0;
  }
	      
  function kaloogaShowExample() {
	  var query = document.getElementById('kalooga-query').value;
	  query = query.replace(/"/g, '&quot;');
	  var widget;
	  
	  if ( mode == 'advanced') {
	  	  var widgetID = document.getElementById('kalooga-widget-id').value;
	  	  $("#customWidgetButtons").show();	
		  widget="<?php echo $publishing_url."/preview?code=";?>" + widgetID;
	  } else {
		  if(query == '') return;
		  
	  	  var widgetType = document.getElementById('kalooga-widget-type').value;
	  	  widget="<?php echo $publishing_url;?>/preview?code=" + widgetType + "&query=" + query;
	  }
	  document.getElementById('kalooga-example').src=widget;
	  document.getElementById('kalooga-example').parentNode.style.display="inline";
	  $("#kalooga-example").show();
  }

  function kaloogaSendCode(advanced){
	  var query = document.getElementById('kalooga-query').value;
	  query = query.replace(/"/g, '&quot;');
	  var widgetType = document.getElementById('kalooga-widget-type').value;
	  var returnTag;

	  if( mode == 'advanced' ){
		  var widgetID = document.getElementById('kalooga-widget-id').value;
		  if(customConfiguration == true){
		  	returnTag = "[kalooga pid=" + publisherID + " oid=" + uniqueID + " wid=" + widgetID + " /]";
		  }else{
		  	returnTag = "[kalooga wid=" + widgetID + " /]";
		  }
	  }else{
		  returnTag = "[kalooga q=" + query + " t=" + widgetType + " /]";
	  }		  
	  window.tinyMCE.execCommand("mceInsertContent", false, returnTag);
	  tinyMCEPopup.close();
  }
  function kaloogaConfigureCustom(){
	  var widgetID = document.getElementById('kalooga-widget-id').value;
	  customConfiguration = true;
	  if(isInt(widgetID)){
	  	window.open("<?php echo $publisher_url;?>/publisher/widgets/" + publisherID + "/" + widgetID + "/" + uniqueID + "/<?php form_option('kalooga_api_key');?>/integration/","KaloogaConfigureCustom");
		//document.getElementById("kalooga-widget-id").disabled = true;
		//document.getElementById('show-example').disabled=false;
		//document.getElementById('continue').disabled=false;
	  }
  }
  function switchDivs(){		  
	  if(mode=='advanced'){
		  mode='simple';	
		  $("#preview-send-buttons").show();	  
		  $("#customWidgetButtons").hide();
		  //document.getElementById('show-example').disabled=false;
		  //document.getElementById('continue').disabled=false;
	  }else{
		  mode='advanced';
		    
		  $("#customWidgetButtons").show();
		  if(document.getElementById("kalooga-widget-id").disabled == false){
			  //document.getElementById('show-example').disabled=true;
			  //document.getElementById('continue').disabled=true;
		  }
		  if(kaloogaAPIKey == ''){
		  	$("#preview-send-buttons").hide();
		  }
	  }	  
	  $("#simple-mode").slideToggle("slow");
	  $("#advanced-mode").slideToggle("slow");
	  $("#kalooga-example").fadeOut("slow");		  
  }  
  function in_array(stringToSearch, arrayToSearch) {
            for (s = 0; s < arrayToSearch.length; s++) {
                        thisEntry = arrayToSearch[s].toString();
                        if (thisEntry == stringToSearch) {
                                   return true;
                        }
            }
            return false;
}
  function getJSONData(APIKey){
    $.getJSON("<?php echo $publishing_url;?>/info?format=JSON&callback=?&api_key=" + APIKey + "&pub_id=" + publisherID,
            function(data){
            if(data.status == "succes"){
	        	publisherID = data.publisherId;
	              $.each(data.channels, function(i,channel){ 
	                      
	                  var types = [];
	                  for(var i in channel.widgets){
	                  	if(in_array(channel.widgets[i].type,types) == false){
	                  		types[types.length] = channel.widgets[i].type;
	                  	}
	                  }
	                  for(var i in types){                  
	                  $("#kalooga-widget-id").append("<optgroup label=\"" + channel.title + "-" + types[i] + "\">"); 
	                  	for(var j in channel.widgets){
	                  		if(types[i] == channel.widgets[j].type){
	    	              		$("#kalooga-widget-id").append("<option value=\"" + channel.widgets[j].widgetID + "\">" + channel.widgets[j].title + "</option>");
	                  		}
	                  	}
	                  }	
	                  
	    	          $("#kalooga-widget-id").append("</optgroup>");
	              });
	              setSelectedItem();
	           }else{
	           		alert(data.description);
	           }
            });
      }
-->