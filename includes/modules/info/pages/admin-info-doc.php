<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

function ini_page_header ($ini_conf) {?>
<script language="JavaScript" src="js/bootstrap.file-input.js"></script>
<script type="text/javascript" src="<?php echo getAsset("info");?>js/admin-info-doc.js"></script>
<?php }
function ini_page_body ($ini_conf){
	//CONTROL NIVEL DE ACCESO
	$perfiles_autorizados = array("admin");
	session::AccessLevel($perfiles_autorizados);

	$accion = (isset($_GET['act']) ? $_GET['act'] : "new");
	$id = (isset($_GET['id']) ? $_GET['id'] : 0);

	session::getFlashMessage( 'actions_message' ); 
	infoController::createAction();
	infoController::updateAction($id);

	$info = new info();
	$campaigns = new campaigns();
	$elements = infoController::getItemAction($id); 
?>
<div class="row row-top">
	<div class="col-md-9">
  		<h1>Gestión de documentos</h1>
		<div class="panel panel-default">
			<div class="panel-heading">Datos del documento</div>
			<div class="panel-body">
				<form id="formData" role="form" name="formData" method="post" enctype="multipart/form-data" action="">
					<input type="hidden" name="id" value="<?php echo $id;?>" />
					<label>Titulo del documento:</label>
					<input class="form-control" type="text" id="info_title" name="info_title" value="<?php echo $elements[0]['titulo_info'];?>" />
					<span id="title-alert" class="alert-message"></span>
					<label>Canal del documento:</label>
					<select name="info_canal" id="info_canal" class="form-control">
					<option tp="1" value="todos" <?php if ($elements[0]['canal_info']=='todos'){ echo ' selected="selected" ';}?>>todos los canales</option>
					<?php ComboCanales($elements[0]['canal_info']); ?>
					</select>
					<label>Tipo de documento:</label>
					<select name="info_tipo" id="info_tipo" class="form-control">
					<?php
					$tipo_info = $info->getInfoTipos("");
					foreach($tipo_info as $tipo):
						echo '<option value="'.$tipo['id_tipo'].'" '.($tipo['id_tipo']==$elements[0]['tipo_info'] ? 'selected="selected"' : '').'>'.$tipo['nombre_info'].'</option>';    
					endforeach;
					?>
					</select>
					<label>Campaña de documento:</label>
					<select name="info_campana" id="info_campana" class="form-control">
					<?php
					$tipo_campana = $campaigns->getCampaigns("");
					foreach($tipo_campana as $campana):
						echo '<option value="'.$campana['id_campaign'].'" '.($campana['id_campaign']==$elements[0]['id_campaign'] ? 'selected="selected"' : '').'>'.$campana['name_campaign'].'</option>';    
					endforeach;
					?>
					</select>		
					<br />
					<div class="row">
						<div class="col-md-6">
							<label>Selecciona el documento:</label><br />
							<input name="info_file" id="info_file" type="file" class="btn btn-default" title="Seleccionar archivo" />
						</div>
						<div class="col-md-6">
						<?php
						if ($elements[0]['file_info']!=""){ 
						  	echo '<a target="_blank" href="docs/showfile.php?file='.$elements[0]['file_info'].'">Ver documento actual</a>';
						}

						?>
						</div>
					</div>
					 
					<span id="file-alert" class="alert-message"></span>
					<br /><br />
					<input type="button" name="SubmitData" id="SubmitData" class="btn btn-primary pull-right" value="Guardar documentación" />
				</form>	
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
<?php 
}
?>