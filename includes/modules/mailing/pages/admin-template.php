<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_admin=1;
function ini_page_header ($ini_conf) {?>
	<script language="JavaScript" src="js/bootstrap.file-input.js"></script>
	<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="js/ckfinder/ckfinder.js"></script>
	<script type="text/javascript" src="<?php echo getAsset("mailing");?>js/admin-template.js"></script>
<?php
}
function ini_page_body ($ini_conf){
	//CONTROL NIVEL DE ACCESO
	$perfiles_autorizados = array("admin");
	session::AccessLevel($perfiles_autorizados);

	session::getFlashMessage( 'actions_message' ); 
	mailingTemplatesController::createAction();
	mailingTemplatesController::updateAction();
	$plantilla = mailingTemplatesController::getItemAction();	

?>
	<div id="page-info">Edición de plantillas</div>
	<div class="row inset row-top">	
		<div class="col-md-9">
			<form id="formData" name="formData" method="post" action="" role="form" enctype="multipart/form-data">
				<input type="hidden" name="id_template" id="id_template" value="<?php echo $plantilla['id_template'];?>" />
				<div class="form-group">
					<label for="template_name">Nombre de la plantilla</label>
					<input type="text" name="template_name" id ="template_name" class="form-control" value="<?php echo $plantilla['template_name'];?>" />
					<span id="nombre-alert" class="alert-message alert alert-danger"></span>
				</div>

				<div class="form-group">
					<label for="nombre-fichero">Imagen miniatura de la plantilla</label>
					<div class="row">
						<div class="col-md-3">
							<input name="nombre-fichero" id="nombre-fichero" type="file" class="btn btn-primary btn-block" title="Seleccionar imágen" />
						</div>	
					</div>			
				</div>


				<label>Tipo de plantilla:</label>
				<select name="template_tipo" id="template_tipo" class="form-control">
				<?php
				$mailing = new mailing();
				$tipo_info = $mailing->getTemplatesTypes("");
				foreach($tipo_info as $tipo):
					echo '<option value="'.$tipo['id_type'].'" '.($tipo['id_type']==$plantilla['id_type'] ? 'selected="selected"' : '').'>'.$tipo['name_type'].'</option>';    
				endforeach;
				?>
				</select>
				<label>Campaña:</label>
				<select name="template_campana" id="template_campana" class="form-control">
				<?php
				$campaigns = new campaigns();
				$tipo_campana = $campaigns->getCampaigns("");
				foreach($tipo_campana as $campana):
					echo '<option value="'.$campana['id_campaign'].'" '.($campana['id_campaign']==$plantilla['id_campaign'] ? 'selected="selected"' : '').'>'.$campana['name_campaign'].'</option>';    
				endforeach;
				?>
				</select>

				<div class="form-group">
					<label for="template_body">Contenido de la plantilla:</label>
					<textarea cols="40" rows="5" id="template_body" name="template_body"><?php echo $plantilla['template_body'];?></textarea>
					<script type="text/javascript">
						var editor=CKEDITOR.replace('template_body',{customConfig : 'config-page.js'});
						CKFinder.setupCKEditor(editor, 'js/ckfinder/') ;
					</script>
				</div>
				<button class="btn btn-primary" id="SubmitData" name="SubmitData" type="submit">Guardar plantilla</button>
			</form>	
		</div>
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading">Gestion de plantillas</div>
				<div class="panel-body">
					<a href="?page=admin-templates" class="comunidad-color">Ir a todas las plantillas</a><br />
					<a href="?page=admin-template&act=new" class="comunidad-color">Nueva plantilla</a>
				</div>
			</div>
		</div>
	</div>
<?php 
}
?>