<?php
/**
* Print HTML add comment
*
* @param 	int 	$id_tema 	id_tema new comment
*/
function addForoComment($id_tema){
	$foro = new foro();
	//INSERT COMMENT
	if (isset($_POST['texto-comentario']) and $_POST['texto-comentario']!="" and ($_POST['id_tema']!="" or $_POST['id_tema']!=0)){
		if ($foro->InsertComentario($_POST['id_tema'],
							$_POST['texto-comentario'],
							$_SESSION['user_name'],
							ESTADO_COMENTARIOS_FORO)){
		session::setFlashMessage( 'actions_message', "Comentario insertado correctamente.", "alert alert-success");
		} 
		else{ session::setFlashMessage( 'actions_message', "Se ha producido un error en la inserción del comentario. Por favor, inténtalo más tarde.", "alert alert-danger");}    
		redirectURL($_SERVER['REQUEST_URI']);
	}   
  
	?>
	<form id="coment-form" name="coment-form" action="" method="post" role="form">
		<input type="hidden" name="id_tema" id="id_tema" value="<?php echo $id_tema;?>"/>
		<textarea cols="45" id="texto-comentario" name="texto-comentario" class="jtextareaComentar form-control"></textarea>
		<div class="alert-message alert alert-danger" id="alertas-foro"></div>
		<button class="btn btn-primary btn-block" type="submit" id="coment-submit" name="coment-submit"><?php echo strTranslate("Send");?></button>	
	</form>
	<?php
}
?>