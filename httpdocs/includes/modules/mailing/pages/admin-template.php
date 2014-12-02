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
				array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
				array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"?page=admin"),
				array("ItemLabel"=>strTranslate("Massive_Mailing"), "ItemUrl"=>"#"),
				array("ItemLabel"=>"Plantillas de comunicaciones", "ItemUrl"=>"?page=admin-templates"),
				array("ItemLabel"=>"Edición de plantillas", "ItemClass"=>"active"),
			));
			?>
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
					<p>El contenido de la plantilla puede incluir las etiquetas [USER_LOGO], [USER_EMPRESA], [USER_DIRECCION], [DATE_PROMOCION], [CLAIM_PROMOCION], [DESCUENTO_PROMOCION].</p>
					<textarea cols="40" rows="5" id="template_body" name="template_body"><?php echo $plantilla['template_body'];?></textarea>
					<script type="text/javascript">
						var editor=CKEDITOR.replace('template_body',{customConfig : 'config-page.js'});
						CKFinder.setupCKEditor(editor, 'js/libs/ckfinder/') ;
					</script>
				</div>
				<button class="btn btn-primary" id="SubmitData" name="SubmitData" type="submit">Guardar plantilla</button>
			</form>	
		</div>
		<?php menu::adminMenu();?>
	</div>