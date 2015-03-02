<?php
addJavascripts(array("js/libs/ckeditor/ckeditor.js", 
					 "js/libs/ckfinder/ckfinder.js", 
					 "js/bootstrap.file-input.js", 
					 getAsset("mailing")."js/admin-template.js"));

session::getFlashMessage( 'actions_message' ); 
mailingTemplatesController::createAction();
mailingTemplatesController::updateAction();
$plantilla = mailingTemplatesController::getItemAction();	

?>
	<div class="row row-top">	
		<div class="col-md-9 inset">
			<?php
			menu::breadcrumb(array(
				array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
				array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
				array("ItemLabel"=>strTranslate("Massive_Mailing"), "ItemUrl"=>"admin-templates"),
				array("ItemLabel"=>strTranslate("Mailing_templates"), "ItemUrl"=>"admin-templates"),
				array("ItemLabel"=>"Edición de plantillas", "ItemClass"=>"active"),
			));
			?>
			<form id="formData" name="formData" method="post" action="" role="form" enctype="multipart/form-data">
				<input type="hidden" name="id_template" id="id_template" value="<?php echo $plantilla['id_template'];?>" />
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<small><label for="template_name"><?php echo strTranslate("Name");?></label></small>
							<input type="text" name="template_name" id ="template_name" class="form-control form-big" value="<?php echo $plantilla['template_name'];?>" />
							<span id="nombre-alert" class="alert-message alert alert-danger"></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<small><label><?php echo strTranslate("Type");?>:</label></small>
							<select name="template_tipo" id="template_tipo" class="form-control">
							<?php
							$mailing = new mailing();
							$tipo_info = $mailing->getTemplatesTypes("");
							foreach($tipo_info as $tipo):
								echo '<option value="'.$tipo['id_type'].'" '.($tipo['id_type']==$plantilla['id_type'] ? 'selected="selected"' : '').'>'.$tipo['name_type'].'</option>';    
							endforeach;
							?>
							</select>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<small><label><?php echo strTranslate("Campaign");?>:</label></small>
							<select name="template_campana" id="template_campana" class="form-control">
							<?php
							$campaigns = new campaigns();
							$tipo_campana = $campaigns->getCampaigns("");
							foreach($tipo_campana as $campana):
								echo '<option value="'.$campana['id_campaign'].'" '.($campana['id_campaign']==$plantilla['id_campaign'] ? 'selected="selected"' : '').'>'.$campana['name_campaign'].'</option>';    
							endforeach;
							?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<small><label for="nombre-fichero">Imagen miniatura de la plantilla</label></small>
							<br /><input name="nombre-fichero" id="nombre-fichero" type="file" class="btn btn-primary" title="<?php echo strTranslate("Choose_file");?>" />		
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<small><label for="template_body">Contenido de la plantilla:</label></small>
							<p class="text-muted">El contenido de la plantilla puede incluir las etiquetas [USER_LOGO], [USER_EMPRESA], [USER_DIRECCION], [DATE_PROMOCION], [CLAIM_PROMOCION], [DESCUENTO_PROMOCION].</p>
							<textarea cols="40" rows="5" id="template_body" name="template_body"><?php echo $plantilla['template_body'];?></textarea>
							<script type="text/javascript">
								var editor=CKEDITOR.replace('template_body',{customConfig : 'config-page.js'});
								CKFinder.setupCKEditor(editor, 'js/libs/ckfinder/') ;
							</script>
						</div>
						<button class="btn btn-primary" id="SubmitData" name="SubmitData" type="submit"><?php echo strTranslate("Save_data");?></button>
					</div>
				</div>
			</form>	
		</div>
		<?php menu::adminMenu();?>
	</div>