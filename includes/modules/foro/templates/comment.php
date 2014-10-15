<?php
/**
* Print HTML tema comment. Used in foros, blog, áreas de trabajo
*
* @param 	array 		$comentario_foro	comentario data
* @param 	string		$destino 			Links destination (foros, blog, áreas de trabajo) used for "likes"
*/
templateload("tipuser","users");

function commentForo($comentario_foro,$destino="foro-comentarios"){
	
	$foro = new foro ();
	$page_num = isset($_GET['pag']) ? $_GET['pag'] : "";

	?>
	<div class="media media-comment">
		<?php userFicha($comentario_foro); ?>
		<div class="media-body">
			<p><b><?php echo $comentario_foro['nick']; ?></b> <?php echo strTranslate("says");?>: (<?php echo strftime(DATE_FORMAT_SHORT,strtotime($comentario_foro['date_comentario'])); ?>)</p>
			<p><?php echo $comentario_foro['comentario'];?></p>
			
			<div class="comment-reply">
				<form role="form" method="post" action="" class="comment-reply-form">
					<input type="hidden" name="comment-reply-id" value="<?php echo $comentario_foro['id_comentario'];?>" />
					<input type="hidden" name="id_tema" value="<?php echo $comentario_foro['id_tema'];?>" />
					<textarea class="form-control" name="comment-reply-txt"  class="comment-reply-txt"></textarea>
					<div class="alert-message alert alert-danger">Introduce tu respuesta</div>
					<button type="submit" class="btn btn-primary"><?php echo strTranslate("Reply");?></button>
				</form>
			</div>
			<?php 
				$respuestas = $foro->getComentarios(" AND estado=1 AND id_comentario_id=".$comentario_foro['id_comentario']." ORDER BY id_comentario DESC"); 
				foreach($respuestas as $respuesta):
					commentForo($respuesta, $destino);
				endforeach;
			?>
		</div>
		<div class="comment-info">
			<span class="comment-reply-trigger label" title="<?php echo strTranslate("Reply_comment");?> "><i class="fa fa-mail-reply"></i> <?php echo strTranslate("Reply");?></span> 
			<span class="label" title="<?php echo strTranslate("Vote_comment");?>"><a href="?page=<?php echo $destino.'&id='.$comentario_foro['id_tema'].'&idvf='.$comentario_foro['id_comentario'].'&pag='.$page_num;?>">
			<i class="fa fa-heart"></i> <?php echo $comentario_foro['votaciones'];?></a></span>
			<?php if ($_SESSION['user_perfil'] == 'admin') echo ' <span class="label" title="ID del comentario">id: '.$comentario_foro['id_comentario'].'</span>'; ?>	
		</div>
	</div>
	<?php
}

function commentForoRespuestas($id_comentario){

}
?>