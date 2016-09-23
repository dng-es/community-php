// JavaScript Document
jQuery(document).ready(function(){	
	$("#groups_user_container").css("display" , ($("#tipo_ranking").val() == '' ? "block" : "none"));

	$("#groups_user").change(function(e){
		var id_ranking = $(this).data("idg");
		document.location.href="incentives-rankings?id=" + id_ranking +"&idg=" + $(this).val();
	});

	$("#tipo_ranking").change(function(e){
		var id_ranking = $(this).data("idg"),
			tipo = $(this).val();

		document.location.href="incentives-rankings?id=" + id_ranking +"&t=" + tipo;
	});
});