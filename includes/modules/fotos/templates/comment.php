<?php
function commentFoto($comentario,$destino="fotos-comentarios"){ ?>
	<div class="media media-comment">
		<?php userFicha($comentario);?>
		<p><b><?php echo $comentario['nick'];?></b> <?php echo strTranslate("says");?>: (<?php echo strftime(DATE_FORMAT_SHORT,strtotime($comentario['date_comentario']));?>)</p>
		<p><?php echo $comentario['comentario'];?></p>

		<div class="comment-info">
			<?php if ($_SESSION['user_perfil'] == 'admin') echo ' <span class="label" title="ID del comentario">id: '.$comentario['id_comentario'].'</span>'; ?>	
		</div>
	</div>
<?php } ?>