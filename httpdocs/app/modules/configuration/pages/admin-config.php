<?php
addJavascripts(array(getAsset("configuration")."js/admin-config.js"));
?>
<div class="row  row-top">
	<div class="app-main">
		<?php 

		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Configuration"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Main_data"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' ); 
		configurationController::updateAction();
		$elements = configurationController::getItemAction();
		?>
		<form enctype="multipart/form-data" id="formData" name="formData" method="post" action="" role="form" class="form-horizontal">
			<div class="row">
				<div class="col-md-6">
					<label class="control-label" for="site-name"><small>Nombre del sitio:</small></label>
					<input type="text" class="form-control" maxlength="250" Size="40" id="site-name" name="site-name" value="<?php echo $elements[0]['SiteName'];?>" data-alert="<?php echo strTranslate("Required_field");?>" /> 
				</div>
				<div class="col-md-6">
					<label class="control-label" for="site-name"><small>URL del sitio: <span class="text-muted">con http://</span></small></label>
					<input type="text" class="form-control" maxlength="250" id="site-url" name="site-url" value="<?php echo $elements[0]['SiteUrl'];?>" data-alert="<?php echo strTranslate("Required_field");?>" /> 
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<label class="control-label" for="email-contact"><small>Email de contacto:</small></label>
					<input type="text" class="form-control" maxlength="250" id="email-contact" name="email-contact" value="<?php echo $elements[0]['ContactEmail'];?>" data-alert="<?php echo strTranslate("Required_email");?>" /> 
				</div>
				<div class="col-md-6">
					<label class="control-label" for="email-contact"><small>Email comunicaciones:</small></label>
					<input type="text" class="form-control" maxlength="250" id="email-mailing" name="email-mailing" value="<?php echo $elements[0]['MailingEmail'];?>" data-alert="<?php echo strTranslate("Required_email");?>" /> 
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<label class="control-label" for="site-title"><small>Título de la web:</small></label>
					<input type="text" class="form-control" maxlength="250" id="site-title" name="site-title" value="<?php echo $elements[0]['SiteTitle'];?>" data-alert="<?php echo strTranslate("Required_field");?>" /> 
				</div>
				<div class="col-md-6">
					<label class="control-label" for="site-subject"><small>Asunto de la web:</small></label>
					<input type="text" class="form-control" maxlength="250" id="site-subject" name="site-subject" value="<?php echo $elements[0]['SiteSubject'];?>" data-alert="<?php echo strTranslate("Required_field");?>" /> 
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<label class="control-label" for="site-desc"><small>Descripción de la web:</small></label>
					<textarea class="form-control" maxlength="250" id="site-desc" name="site-desc" data-alert="<?php echo strTranslate("Required_field");?>"><?php echo $elements[0]['SiteDesc'];?></textarea>
				</div>
				<div class="col-md-6">
					<label class="control-label" for="site-keywords"><small>Palabras clave: <span class="text-muted">Keywords separadas por coma</span></small></label>
					<textarea class="form-control" id="site-keywords" name="site-keywords" data-alert="<?php echo strTranslate("Required_field");?>"><?php echo $elements[0]['SiteKeywords'];?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<label class="control-label" for="direccion"><small><?php echo strTranslate("Address");?>:</small></label>
					<input type="text" class="form-control" maxlength="250" id="direccion" name="direccion" value="<?php echo $elements[0]['direccion'];?>" data-alert="<?php echo strTranslate("Required_field");?>" /> 
				</div>
				<div class="col-md-6">
					<label class="control-label" for="telefono"><small><?php echo strTranslate("Telephone");?>:</small></label>
					<input type="text" class="form-control" maxlength="250" id="telefono" name="telefono" value="<?php echo $elements[0]['telefono'];?>" data-alert="<?php echo strTranslate("Required_field");?>" /> 
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<label class="control-label" for="telefono2"><small><?php echo strTranslate("Telephone");?> 2:</small></label>
					<input type="text" class="form-control" maxlength="250" id="telefono2" name="telefono2" value="<?php echo $elements[0]['telefono2'];?>" data-alert="<?php echo strTranslate("Required_field");?>" /> 
				</div>
				<div class="col-md-6">
					<label class="control-label" for="fax"><small>Fax:</small></label>
					<input type="text" class="form-control" maxlength="250" id="fax" name="fax" value="<?php echo $elements[0]['fax'];?>" data-alert="<?php echo strTranslate("Required_field");?>"/> 
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<br />
					<button type="submit" class="btn btn-primary btn-block" id="form-submit" name="form-submit"><?php echo strTranslate("Save_data");?></button>
				</div>
			</div>
		</form>
	</div>

	<?php menu::adminMenu();?>
</div>