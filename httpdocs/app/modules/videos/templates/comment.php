<?php
templateload("tipuser", "users");

function videoCommentGallery($comentarios, $destino = "videos-comentarios"){
	if (count($comentarios) > 0){
		foreach($comentarios as $comentario):
			videoComment($comentario, $destino);
		endforeach;
	}
	else echo '<br /><div class="alert alert-warning"><i class=" fa fa-info-circle"></i> '.strTranslate("No_video_comments").'</div>';
}

function videoComment($comentario, $destino = "videos-comentarios"){?>
	<div class="media media-comment">
		<?php userFicha($comentario);?>
		<p>
			<a href="profile&n=<?php echo $comentario['nick']; ?>"><small><?php echo $comentario['nick'];?></small></a><br />
			<span class="text-muted"><small><?php echo getDateFormat($comentario['date_comentario'], "LONG")." ".getDateFormat($comentario['date_comentario'], "TIME"); ?></small></span>
		</p>
		<p><a name="comentario-id-'.$comentario['id_comentario'].'" id="comentario-id-'.$comentario['id_comentario'].'"></a></p>
		<p><?php echo showHtmlLinks($comentario['comentario']);?></p>
		<div class="comment-info">
			<span class="label tooltip-bottom" title="<?php e_strTranslate("Vote_comment");?>"><a class="trigger-video" href="<?php echo $destino.'&idvc='.$comentario['id_comentario'];?>" data-id="'.$comentario['id_comentario'].'">
			<i class="fa fa-heart"></i> <?php echo $comentario['votaciones'];?></a></span>
			<?php if ($_SESSION['user_perfil'] == 'admin') echo ' <span class="label tooltip-bottom" title="ID del comentario">id: '.$comentario['id_comentario'].'</span>'; ?>
		</div>
	</div>
<?php }?>