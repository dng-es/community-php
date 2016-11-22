// JavaScript Document
jQuery(document).ready(function(){
	$(".configuration-trigger").click(function(e){
		e.preventDefault();
		var modulename = $(this).data("module");

		$("#configurationModal .modal-title small").html(modulename);

		$('#configurationModal').modal();
		$.ajax({
			type: "GET",
			url: "app/modules/configuration/pages/admin-modules-ajax.php",
			data: {module: modulename},
			cache: false
			})
			.done(function(data){
				$("#configurationModal .modal-body").html(data);
			});
	});
});