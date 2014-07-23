<?php
function PanelSubirVideo($id_promocion = 0){
    echo '	<script language="JavaScript" src="'.getAsset("videos").'js/videos.js"></script>
			<div id="banner-videos-form">
			<h4>'.strTranslate("Upload_video").'</h4>
			<p>'.strTranslate("Upload_video_formats_allowed").' <b>MP4, MOV, AVI, 3GP, WMV</b>. '.strTranslate("Upload_video_max_size_allowed").' <b>'.MAX_SIZE_VIDEOS_KB.' Kb</b>.</p>
			<form id="video-form" name="video-form" action="" method="post" enctype="multipart/form-data" role="form" >
              <input type="hidden" name="id_promocion" id="id_promocion" value="'.$id_promocion.'"/>
			  <input type="hidden" name="tipo_envio" id="tipo_envio" value="video"/>
			  <label for="titulo-video" class="sr-only">Título:</label>
			  <input maxlength="250" name="titulo-video" id="titulo-video" type="text" class="form-control" value="" placeholder="'.strTranslate("Video_title").'" /><br />';

	if ($_SESSION['user_perfil']=='admin' or $_SESSION['user_perfil']=='formador'){ 
		echo '<label for="canal-video" class="sr-only">Canal:</label>
			  <select name="canal-video" id="canal-video" class="form-control">
				<option value="comercial">Canal comerciales</option>
				<option value="gerente">Canal gerentes</option>
			  </select><br />';
	}
	echo '	  <label for="nombre-foto" class="sr-only">Video:</label>
			  <input type="file" class="btn btn-default btn-block" name="nombre-video" id="nombre-video" title="'.strTranslate("Choose_file").'" /><br />
			  <div class="alert alert-danger" id="alertas-participa" style="display: none"></div>
			  <button type="submit" class="btn btn-primary btn-block" id="video-submit" name="video-submit">'.strTranslate("Send_video").'</button>
			</form>
			</div>';			
}
?>