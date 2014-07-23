<?php
function PanelSubirFoto($id_promocion=0){
    echo '	<script language="JavaScript" src="'.getAsset("fotos").'js/fotos.js"></script> 
			<div id="banner-fotos-form">
			<h4>'.strTranslate("Upload_photo").'</h4>
  			<p>'.strTranslate("Upload_photo_formats_allowed").' <b>GIF</b>, <b>PNG,</b> o <b>JPG</b>. '.strTranslate("Upload_photo_max_size_allowed").' <b>'.MAX_SIZE_FOTOS_KB.' Kb</b></p>
			<form id="foto-form" name="coment-form" action="" method="post" enctype="multipart/form-data" role="form">
               <input type="hidden" name="id_promocion" id="id_promocion" value="'.$id_promocion.'"/>
			   <input type="hidden" name="tipo_envio" id="tipo_envio" value="foto"/>
			   <input maxlength="250" name="titulo-foto" id="titulo-foto" type="text" class="form-control" value="" placeholder="'.strTranslate("Photo_title").'" /><br />';

   if ($_SESSION['user_perfil']=='admin' or $_SESSION['user_perfil']=='formador'){
		echo '<select name="canal-foto" id="canal-foto" class="form-control">
				<option value="comercial">Canal comerciales</option>
				<option value="gerente">Canal gerentes</option>
			  </select><br />';
   }
   echo '	<input type="file" class="btn btn-default btn-block" name="nombre-foto" id="nombre-foto" title="'.strTranslate("Choose_file").'" /><br />
			<div class="alert alert-danger" id="alertas-participa" style="display: none"></div>
			<button type="button" class="btn btn-primary btn-block" id="foto-submit" name="foto-submit">'.strTranslate("Send_photo").'</button>
			</form>
			</div>';	
}
?>