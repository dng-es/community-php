jQuery(document).ready(function(){
	$(".numeric").numeric();

	$("#formData").submit(function(evento){
		var resultado_ok = true;

		if (jQuery.trim($("#name_guide_category").removeClass("input-alert").val()) == ""){
			$('#name_guide_category').addClass("input-alert").attr("placeholder", $('#name_guide_category').data("alert")).focus();
			resultado_ok = false;
		}
			
		return resultado_ok;
	});

	$("#type_guide").change(function(evento){
		getGuides($(this).val());
	});

	getGuides($("#type_guide").val());
	
	function getGuides(tipo){
		var selected = $("#id_guide_selected").val();
		$("#id_guide").load("app/modules/guides/pages/guidesCmb.php?sel=" + selected +"&tipo=" + tipo, function(){

		});
	}
});