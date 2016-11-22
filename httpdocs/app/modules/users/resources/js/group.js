// JavaScript Document
jQuery(document).ready(function(){	
	$("#groups_user").change(function(e){
		document.location.href="mygroup?id=" + $(this).val();
	});
});