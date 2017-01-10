<?php
/**
* Print HTML add comment
*
* @param 	int 	$id_tema 	id_tema new comment
*/
function addForoComment($id_tema){
	foroController::insertCommentAction();
	?>
	<form id="coment-form" name="coment-form" action="" method="post" role="form">
		<input type="hidden" name="id_tema" id="id_tema" value="<?php echo $id_tema;?>"/>
		<textarea rows="4" id="texto-comentario" name="texto-comentario" title="<?php e_strTranslate("Required_field");?>" class="has-warning jtextareaComentar form-control"></textarea>
		<button class="btn btn-primary btn-block" type="submit" id="coment-submit" name="coment-submit"><?php e_strTranslate("Send");?></button>
	</form>
	<?php
}
?>