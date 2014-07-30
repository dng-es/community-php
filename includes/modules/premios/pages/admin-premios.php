<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_select=5;
function ini_page_header ($ini_conf) {?>
	<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
	<!-- Bootstrap input file -->
	<script type="text/javascript" src="js/bootstrap.file-input.js"></script>
		<script type="text/javascript">
		 jQuery(document).ready(function(){
			 $('input[type=file]').bootstrapFileInput();
		});
	</script>
<?php }
function ini_page_body ($ini_conf){
	//CONTROL NIVEL DE ACCESO
	$session = new session();
	$perfiles_autorizados = array("admin");
	$session->AccessLevel($perfiles_autorizados);
	
	$accion=$_GET['act'];
	if ($accion=='edit' and $_GET['accion2']=='ok'){ UpdateData();}
	
	$premios = new premios();
	$elements=$premios->getPremios(); 	
?>
<div class="row row-top">
	<div class="col-md-9">
		<h1>Premios del día</h1>

		<p>Introduce el premio día, podrá ser un texto o una imagen. El premio anterior será modificado por el nuevo que introduzcas.</p>
		<form id="formData" name="formData" method="post" enctype="multipart/form-data" action="?page=admin-premios&act=edit&amp;accion2=ok" role="form">
		<table cellspacing="0" cellpadding="2px">
			<tr><td>
			<label>selecciona el tipo de banner:</label>
				<div class="radio">
					<label><input name="tipo_premio" type="radio" value="imagen" checked  /> imagen (283px X 135px max.)</label>
				</div>

				<div class="radio">
					<label><input name="tipo_premio" type="radio" value="video" /> video</label>
				</div>

				<div class="radio">
					<label><input name="tipo_premio" type="radio" value="texto" /> texto</label>
				</div>

			</td></tr>
			<tr><td>
				<label>selecciona la im&aacute;gen del banner:</label>
				<div class="radio">
					<label><input name="imagen_premio" type="radio" value="1" checked /> Im&aacute;gen 1 fija</label>
				</div>

				<div class="radio">
					<label><input name="imagen_premio" type="radio" value="2" /> Im&aacute;gen 2 con movimiento</label>
				</div>
			</td></tr>  
			<tr><td>
			<label>selecciona el archivo si en el primer punto has marcado tipo=imagen o tipo=video</label>
			<p><input type="file" id="imagen_premio" name="imagen_premio" class="btn btn-primary" title="Seleccionar archivo" /></p>
			<label>introduce el texto si has marcado tipo=texto</label>
			<p><textarea cols="40" rows="5" name="texto_premio"></textarea></p>
			<script type="text/javascript">CKEDITOR.replace('texto_premio',{customConfig : 'config-admin.js'});</script>
			</td></tr>
			<tr><td><input type="submit" name="SubmitData" class="btn btn-primary" value="Guardar datos" /></td></tr>
		</table>
		</form>	
	</div>
	<?php menu::adminMenu();?>
</div>
<?php 
}

function UpdateData() {
	$premios = new premios();
	
	if ($_POST['tipo_premio']=='imagen'){ $cuerpo=$_FILES['imagen_premio'];}
	elseif ($_POST['tipo_premio']=='video'){ $cuerpo=$_FILES['imagen_premio'];}
	
	else {$cuerpo=$_POST['texto_premio'];}
	if ($premios->updatePremios($_POST['tipo_premio'],$cuerpo,$_POST['imagen_premio'])) {
			OkMsg("Premio modificado correctamente.");}
}
?>