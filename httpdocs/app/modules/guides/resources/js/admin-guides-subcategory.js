jQuery(document).ready(function(){
	$(".numeric").numeric();

	$("#formData").submit(function(evento){
		var resultado_ok = true;

		// if (jQuery.trim($("#titulo").removeClass("input-alert").val()) == ""){
		// 	$('#titulo').addClass("input-alert").attr("placeholder", $('#titulo').data("alert")).focus();
		// 	resultado_ok = false;
		// }
			
		return resultado_ok;
	});

	$("#type_guide").change(function(evento){
		getGuides($(this).val());
	});

	getGuides($("#type_guide").val());
	
	function getGuides(tipo){
		var selected = $("#id_guide_selected").val();
		$("#id_guide").load("app/modules/guides/pages/guidesCmb.php?sel=" + selected +"&tipo=" + tipo, function(){
			getCategories($("#id_guide").val());
		});
	}
	
	$("#id_guide").change(function(evento){
		getCategories($(this).val());
	});
		
	function getCategories(tipo){
		var selected = $("#id_guide_category_selected").val();
		$("#id_guide_category").load("app/modules/guides/pages/guidesCmb.php?sel=" + selected +"&cat=" + tipo, function(){

		});
	}	
});