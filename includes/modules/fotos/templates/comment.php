<?php
function commentFoto($comentario,$destino="fotos-comentarios"){ ?>
	<div class="media media-comment">
		<?php userFicha($comentario);?>
		<p>
			<span class="text-primary"><small><?php echo $comentario['nick']; ?></small></span><br />
			<span class="text-muted"><small><?php echo getDateFormat($comentario['date_comentario'], "LONG")." ".getDateFormat($comentario['date_comentario'], "TIME"); ?></small></span>
		</p>
		<p><?php echo $comentario['comentario'];?></p>

		<div class="comment-info">
			<?php if ($_SESSION['user_perfil'] == 'admin') echo ' <span class="label" title="ID del comentario">id: '.$comentario['id_comentario'].'</span>'; ?>	
		</div>
	</div>
<?php } ?>