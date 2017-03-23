<?php
/**
 * Print HTML add video form
 * @param	Int 		$id 			Id del video al que se inserta el comentario
 * @return	String						HTML form
 */
function addVideoComment($id){ ?>
	<form action="" role="form" method="post" name="form-video-comment" id="form-video-comment" class="panel-interior">
		<input type="hidden" name="video-id" id="video-id" value="<?php echo $id;?>" />
		<label for="video-comentario"><?php e_strTranslate("video_comment_new");?></label>
		<textarea name="video-comentario" id="video-comentario" class="form-control" placeholder="<?php e_strTranslate("Your_comment");?>"></textarea>
		<span id="video-comentario-alert" class="alert-message alert alert-danger"><?php e_strTranslate("video_comment_new_label");?></span>
		<button type="submit" class="btn btn-primary"><?php e_strTranslate("video_comment_send");?></button>
	</form>
<?php } ?>