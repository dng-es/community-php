<?php
function commentFoto($comment,$destino="fotos-comentarios"){ ?>
	<div class="media media-comment">
		<?php userFicha($comment);?>
		<p>
			<a href="user-profile?n=<?php echo $comment['nick']; ?>"><small><?php echo $comment['nick']; ?></small></a><br />
			<span class="text-muted"><small><?php echo getDateFormat($comment['date_comentario'], "LONG")." ".getDateFormat($comment['date_comentario'], "TIME"); ?></small></span>
		</p>
		<p><?php echo $comment['comentario'];?></p>

		<div class="comment-info">
			<?php if ($_SESSION['user_perfil'] == 'admin') echo ' <span class="label" title="ID del comentario">id: '.$comment['id_comentario'].'</span>'; ?>	
		</div>
	</div>
<?php } ?>