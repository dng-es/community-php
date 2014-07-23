<?php
function addVideoComment($id){
	?>
	<form action="" role="form" method="post" name="form-video-comment" id="form-video-comment">
		<input type="hidden" name="video-id" id="video-id" value="<?php echo $id;?>" />
		<label for="video-comentario"><?php echo strTranslate("video_comment_new");?></label>
		<textarea name="video-comentario" id="video-comentario" class="form-control" placeholder="Nuevo comentario"></textarea>
		<span id="video-comentario-alert" class="alert-message alert alert-danger"><?php echo strTranslate("video_comment_new_label");?></span>
		<br />
		<button type="submit" class="btn btn-primary"><?php echo strTranslate("video_comment_send");?></button>
	</form>
	<?php 
}
?>