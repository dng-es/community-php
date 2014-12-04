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
		<textarea cols="45" id="texto-comentario" name="texto-comentario" class="jtextareaComentar form-control" title="<?php echo strTranslate("Required_field");?>"></textarea>
		<br />
		<button class="btn btn-primary col-md-3 col-sm-4 col-xs-12" type="submit" id="coment-submit" name="coment-submit"><?php echo strTranslate("Send");?></button>	
	</form>
	<?php
}
?>