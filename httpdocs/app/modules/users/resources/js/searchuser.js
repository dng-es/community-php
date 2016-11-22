// JavaScript Document
jQuery(document).ready(function(){
	var modal_window = $('<div class="modal modal-wide fade" id="searchUserModal" tabindex="-1" role="dialog" aria-labelledby="searchUserModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title" id="searchUserModalLabel">Resultados de la búsqueda</h4></div><div class="modal-body" id="searchUserResult"></div></div></div></div>');
	$("body").append(modal_window);
	$("#searchUserForm").submit(function(e){

		$("#searchUserModal").modal();

		$.ajax({
			type: 'POST',
			cache: false,
			url: 'app/modules/users/pages/searchuser_process.php',
			data: $("#searchUserForm").serialize(),
			success: function(data){
				$("#searchUserResult").html(data);
			}
		});

		return false;

	});
});