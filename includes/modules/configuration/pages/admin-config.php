<?php
//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);

addJavascripts(array(getAsset("configuration")."js/admin-config.js"));

session::getFlashMessage( 'actions_message' ); 
configurationController::updateAction();
$elements = configurationController::getItemAction();
$modules = configurationController::getListModulesAction();
?>
<div class="row  row-top">
	<div class="col-md-9">
		<h1>Configuración de la comunidad</h1>
		<!-- Nav tabs -->
		<ul class="nav nav-tabs">
		  <li class="active"><a href="#general" data-toggle="tab">Datos generales</a></li>
		  <li><a href="#modulos" data-toggle="tab">Módulos activos</a></li>
		</ul>		
		
		<div class="tab-content">
				<div class="tab-pane fade in active" id="general">
					<br />
				<P>Datos generales de la Web.</P>
				<form enctype="multipart/form-data" id="formData" name="formData" method="post" action="">
					<table class="table">
						<tr><th>Variable</th><th>Valor</th></tr>
						<tr>
							<td width="30%" valign="top"><label for="site-name">Nombre del sitio:</label></td>
							<td width="70%">
								<input type="text" class="form-control" maxlength="250" Size="40" id="site-name" name="site-name" value="<?php echo $elements[0]['SiteName'];?>"/> 
								<span id="site-name-alert" class="alert-message alert alert-danger"><?php echo strTranslate("Required_field");?></span>	     
						</td>
						</tr> 
						<tr>
							<td width="30%" valign="top"><label for="site-name">URL del sitio (con http://):</label></td>
							<td width="70%">
								<input type="text" class="form-control" maxlength="250" Size="40" id="site-url" name="site-url" value="<?php echo $elements[0]['SiteUrl'];?>"/> 
								<span id="site-url-alert" class="alert-message alert alert-danger"><?php echo strTranslate("Required_field");?></span>	     
						</td>
						</tr> 				 
						<tr>
							<td width="30%" valign="top"><label for="email-contact">Email de contacto:</label></td>
							<td width="70%">
								<input type="text" class="form-control" maxlength="250" Size="40" id="email-contact" name="email-contact" value="<?php echo $elements[0]['ContactEmail'];?>"/> 
								<span id="email-contact-alert" class="alert-message alert alert-danger"><?php echo strTranslate("Required_email");?></span>	     
						</td>
						</tr>
						<tr>
							<td width="30%" valign="top"><label for="email-contact">Email comunicaciones:</label></td>
							<td width="70%">
								<input type="text" class="form-control" maxlength="250" Size="40" id="email-mailing" name="email-mailing" value="<?php echo $elements[0]['MailingEmail'];?>"/> 
								<span id="email-mailing-alert" class="alert-message alert alert-danger"><?php echo strTranslate("Required_email");?></span>	     
						</td>
						</tr>					
						<tr>
							<td width="30%" valign="top"><label for="site-title">Título de la web:</label></td>
							<td width="70%">
								<input type="text" class="form-control" maxlength="250" Size="40" id="site-title" name="site-title" value="<?php echo $elements[0]['SiteTitle'];?>"/> 
								<span id="site-title-alert" class="alert-message alert alert-danger"></span>	     
						</td>
						</tr> 
						<tr>
							<td width="30%" valign="top"><label for="site-desc">Descripción de la web:</label></td>
							<td width="70%">
								<input type="text" class="form-control" maxlength="250" Size="40" id="site-desc" name="site-desc" value="<?php echo $elements[0]['SiteDesc'];?>"/> 
								<span id="site-desc-alert" class="alert-message alert alert-danger"></span>	     
						</td>
						</tr>  
						<tr>
							<td width="30%" valign="top"><label for="site-subject">Asunto de la web:</label></td>
							<td width="70%">
								<input type="text" class="form-control" maxlength="250" Size="40" id="site-subject" name="site-subject" value="<?php echo $elements[0]['SiteSubject'];?>"/> 
								<span id="site-subject-alert" class="alert-message alert alert-danger"></span>	     
						</td>
						</tr> 
						<tr>
							<td width="30%" valign="top"><label for="site-keywords">Palabras clave</label><br />Keywords separadas por coma.</td>
							<td width="70%">
								<textarea class="form-control" id="site-keywords" name="site-keywords"><?php echo $elements[0]['SiteKeywords'];?></textarea>
								<span id="site-keywords-alert" class="alert-message alert alert-danger"></span>	     
						</td>
						</tr>
						<tr>
							<td width="30%" valign="top"><label for="direccion">Dirección:</label></td>
							<td width="70%">
								<input type="text" class="form-control" maxlength="250" Size="40" id="direccion" name="direccion" value="<?php echo $elements[0]['direccion'];?>"/> 
								<span id="direccion-alert" class="alert-message alert alert-danger"></span>	     
						</td>
						</tr> 
						<tr>
							<td width="30%" valign="top"><label for="telefono">Teléfono:</label></td>
							<td width="70%">
								<input type="text" class="form-control" maxlength="250" Size="40" id="telefono" name="telefono" value="<?php echo $elements[0]['telefono'];?>"/> 
								<span id="telefono-alert" class="alert-message alert alert-danger"></span>	     
						</td>
						</tr> 
						<tr>
							<td width="30%" valign="top"><label for="telefono2">Teléfono 2:</label></td>
							<td width="70%">
								<input type="text" class="form-control" maxlength="250" Size="40" id="telefono2" name="telefono2" value="<?php echo $elements[0]['telefono2'];?>"/> 
								<span id="telefono2-alert" class="alert-message alert alert-danger"></span>	     
						</td>
						</tr>   
						<tr>
							<td width="30%" valign="top"><label for="fax">Fax:</label></td>
							<td width="70%">
								<input type="text" class="form-control" maxlength="250" Size="40" id="fax" name="fax" value="<?php echo $elements[0]['fax'];?>"/> 
								<span id="fax-alert" class="alert-message alert alert-danger"></span>	     
						</td>
						</tr>        
						<tr>
							<td colspan="2"><button type="submit" class="btn btn-primary" id="form-submit" name="form-submit">Guardar configuración</button></td>
						</tr>
					</table>
				</form>
			</div>

			<div class="tab-pane fade" id="modulos">
				<br />
				<P>A continuación se muestran todos los módulos instalados</P>
				<table class="table">
					<tr><th>Módulo</th><th>Descripción</th></tr>
				<?php foreach($modules as $module):				
						echo '<tr>
						<td>'.$module['folder'].'</td>
						<td class="legend">'.$module['ann'].'</td>
						</tr>';
					endforeach;
				?>
				</table>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>