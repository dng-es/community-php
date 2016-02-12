jQuery(document).ready(function(){
	showGroupMessages();
	//var timer = setInterval( showGroupMessages, 10000);
	
	function showGroupMessages(){
		$("#cargandoGroupMessages").css("display", "inline");
		$("#destinoGroupMessages").load("app/modules/users/pages/groupmessages.php", function(){
			$("#cargandoGroupMessages").css("display", "none");
			//$("#destinoGroupMessages").addClass('GroupMessages-visible');
			$("#destinoGroupMessages").show(700);
		});
	}
})