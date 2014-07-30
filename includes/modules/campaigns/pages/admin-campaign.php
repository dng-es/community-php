<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_admin=1;
function ini_page_header ($ini_conf) {?>
	<script language="JavaScript" src="js/bootstrap.file-input.js"></script>
	<script type="text/javascript" src="<?php echo getAsset("campaigns");?>js/admin-campaign.js"></script>
<?php
}
function ini_page_body ($ini_conf){
	//CONTROL NIVEL DE ACCESO
	$perfiles_autorizados = array("admin");
	session::AccessLevel($perfiles_autorizados);

	session::getFlashMessage( 'actions_message' ); 
	campaignsController::createAction();
	campaignsController::updateAction();
	$plantilla = campaignsController::getItemAction();	

?>
	<div class="row row-top">	
		<div class="col-md-9">
			<h1>Edición de campañas</h1>
			<form id="formData" name="formData" method="post" action="" role="form" enctype="multipart/form-data">
				<input type="hidden" name="id_campaign" id="id_campaign" value="<?php echo $plantilla['id_campaign'];?>" />
				
				<div class="checkbox">
					<label>
						<input type="checkbox" name="novedad" id="novedad"<?php echo $plantilla['novedad']==1 ? ' checked="checked"' : "";?>> Novedad
					</label>
				</div>

				<div class="form-group">
					<label for="name_campaign">Nombre de la campaña</label>
					<input type="text" name="name_campaign" id ="name_campaign" class="form-control" value="<?php echo $plantilla['name_campaign'];?>" />
					<span id="nombre-alert" class="alert-message alert alert-danger"></span>
				</div>

				<div class="form-group">
					<label for="desc_campaign">Descripción:</label>
					<textarea class="form-control" rows="8" id="desc_campaign" name="desc_campaign"><?php echo $plantilla['desc_campaign'];?></textarea>
					<span id="descripcion-alert" class="alert-message alert alert-danger"></span>
				</div>

				<div class="form-group">
					<label>Tipo de campaña:</label>
					<select name="id_type" id="id_type" class="form-control">
					<?php
					$campaigns = new campaigns();
					$tipo_campana = $campaigns->getCampaignsTypes("");
					foreach($tipo_campana as $campana):
						echo '<option value="'.$campana['id_campaign_type'].'" '.($campana['id_campaign_type']==$plantilla['id_campaign_type'] ? 'selected="selected"' : '').'>'.$campana['campaign_type_name'].'</option>';    
					endforeach;
					?>
					</select>
				</div>

				<div class="form-group">				
					<div class="row">
						<div class="col-md-3">
							<label for="nombre-fichero">Imagen miniatura de la campaña</label>
							<input name="nombre-fichero" id="nombre-fichero" type="file" class="btn btn-primary btn-block" title="Seleccionar imágen" />
							<?php 
							if (isset($plantilla['imagen_mini']) and $plantilla['imagen_mini']!=""){
								echo '<br /><img src="images/banners/'.$plantilla['imagen_mini'].'" style="width:100%" />';
							}
							?>
						</div>	
						<div class="col-md-3">
							<label for="nombre-fichero">Imagen Slide de la campaña</label>
							<input name="nombre-fichero-big" id="nombre-fichero-big" type="file" class="btn btn-primary btn-block" title="Seleccionar imágen" />
							<?php 
							if (isset($plantilla['imagen_big']) and $plantilla['imagen_big']!=""){
								echo '<br /><img src="images/banners/'.$plantilla['imagen_big'].'" style="width:100%" />';
							}
							?>
						</div>	
					</div>			
				</div>

				<button class="btn btn-primary" id="SubmitData" name="SubmitData" type="submit">Guardar campaña</button>
			</form>	
		</div>
		<?php menu::adminMenu();?>
	</div>
<?php 
}
?>