<?php

templateload("cmbListas","mailing");

addJavascripts(array("js/jquery.numeric.js", 
					 "js/bootstrap.file-input.js", 
					 "js/bootstrap-datepicker.js", 
					 "js/bootstrap-datepicker.es.js", 
					 getAsset("mailing")."js/user-message.js", 
					 getAsset("mailing")."js/user-message-test.js"));

?>
<div class="row inset row-top">
	<div class="col-md-9">
		<?php

		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
			array("ItemLabel"=>strTranslate("Mailing_templates"), "ItemUrl"=>"?page=user-templates"),
			array("ItemLabel"=>"Envío de comunicaciones", "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		mailingController::createUserAction();

		$id = isset($_GET['id']) == true ? $_GET['id'] : 0;
		$plantilla = mailingTemplatesController::getItemAction($id);
		$direccion='';
		$cod_postal='';
		$poblacion='';
		$provincia='';
		$telefono='';
		$web='';
		?>
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title"><big>PASO 1</big> - Datos del mensaje</h3></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-6">

						<form role="form" id="formData" name="formData" enctype="multipart/form-data" method="post" action="?page=user-message&amp;id=<?php echo $id;?>&amp;accion2=ok">
		<!-- 				<input type="hidden" id="email_message" name="email_message" value="<?php echo $ini_conf['MailingEmail']?>"/>
						<input type="hidden" id="nombre_message" name="nombre_message" value="<?php echo $_SESSION['name'].''.$_SESSION['surname'];?>"/> -->
						<input type="hidden" id="template_message" name="template_message" value="<?php echo $id;?>" />


						<div class="form-group">
							<label for="nombre_message">Tu nombre:</label>
							<input class="form-control" type="text" id="nombre_message" name="nombre_message" value="<?php echo $_SESSION['name'].''.$_SESSION['surname'];?>"/>
							<span id="nombre-alert" class="alert-message alert alert-danger"></span>
						</div> 	

						<div class="form-group">
							<label for="email_message">Tu email:</label>
							<input class="form-control" type="text" id="email_message" name="email_message" value="<?php echo $_SESSION['user_email'];?>"/>
							<span id="email-alert" class="alert-message alert alert-danger"></span>
						</div> 	


						<div class="form-group">
							<label for="asunto_message">Asunto del mensaje:</label>
							<input class="form-control" type="text" id="asunto_message" name="asunto_message" value=""/>
							<span id="asunto-alert" class="alert-message alert alert-danger"></span>
						</div> 		

						<?php if (strpos($plantilla['template_body'], '[USER_DIRECCION]') !== FALSE): ?>
						<label for="calle_direccion">Calle:</label>
						<input type="text" class="form-control" id="calle_direccion" name="calle_direccion" value="<?php echo $direccion;?>" />

						<label for="postal_direccion">C. Postal:</label>
						<input type="text" class="form-control" id="postal_direccion" name="postal_direccion" value="<?php echo $cod_postal;?>" />

						<label for="poblacion_direccion">Población:</label>
						<input type="text" class="form-control" id="poblacion_direccion" name="poblacion_direccion" value="<?php echo $poblacion;?>" />

						<label for="provincia_direccion">Provincia:</label>
						<input type="text" class="form-control" id="provincia_direccion" name="provincia_direccion" value="<?php echo $provincia;?>" />

						<label for="telefono_direccion">Teléfono:</label>
						<input type="text" class="form-control" id="telefono_direccion" name="telefono_direccion" value="<?php echo $telefono;?>" />

						<label for="web">Web:</label>
						<input type="text" class="form-control" id="web_direccion" name="web_direccion" value="<?php echo $web;?>" />
						<?php endif; ?>

						<?php if (strpos($plantilla['template_body'], '[CLAIM_PROMOCION]') !== FALSE): ?>
						<label for="claim_promocion">Mensaje:</label>
						<textarea class="form-control" id="claim_promocion" name="claim_promocion"></textarea>
						<?php endif; ?>

						<?php if (strpos($plantilla['template_body'], '[DESCUENTO_PROMOCION]') !== FALSE): ?>
						<label for="descuento_promocion">Descuento %:</label>
						<input type="text" class="form-control numeric" id="descuento_promocion" name="descuento_promocion" />
						<?php endif; ?>

						<?php if (strpos($plantilla['template_body'], '[DATE_PROMOCION]') !== FALSE): ?>
						<label for="date_promocion">Fecha fin promoción:</label>
						<div id="datetimepicker2" class="input-group date">
						    <input data-format="dd/MM/yyyy" readonly type="text" id="date_promocion" class="form-control" name="date_promocion"></input>
						    <span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
						<?php endif; ?>							

					</div>
					<div class="col-md-6">
						<h4><?php echo $plantilla['template_name'];?> - <?php echo $plantilla['tipo'];?> - <?php echo $plantilla['campana'];?></h4>
						<img style="width:100%" src="images/mailing/<?php echo $plantilla['template_mini'];?>" alt="banner" /><br /><br />
					</div>
				</div>
			</div>
		</div>

			<div class="panel panel-default">
				<div class="panel-heading"><h3 class="panel-title"><big>PASO 2</big> - Lista de envío</h3></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-4">
							<div class="radio">
								<label>
									<input type="radio" name="tipo-lista" id="tipo-lista-lista" checked="checked" value="lista" />Selecciona una de tus listas
									<br /><span class="text-muted"><small>Realiza el envío a una de tus listas personalizadas</small></span>
								</label>
								<br /><br />
								<?php ComboListas(0);?>	
								<span id="lista-alert" class="alert-message alert alert-danger"></span>			
							</div>					
						</div>
						<div class="col-md-4">
							<div class="radio">
								<label>
									<input type="radio" name="tipo-lista" id="tipo-lista-fichero" value="fichero" />Cargar un fichero
									<br /><span class="text-muted"><small>Excel XLS que contenga en la primera columna los emails</small></span>
								</label>
								<br /><br />
								<input name="nombre-fichero" id="nombre-fichero" type="file" class="btn btn-primary pull-right" title="Seleccionar fichero" />
								<span id="fichero-alert" class="alert-message alert alert-danger"></span>
							</div>						
						</div>
						<div class="col-md-4">
							<div class="radio">
								<label>
									<input type="radio" name="tipo-lista" id="tipo-lista-todos" value="todos" />Todos los usuarios activos
									<br /><span class="text-muted"><small>Envío a todos los usuarios activos y confirmados</small></span>
								</label>	
							</div>					
						</div>	
					</div>	
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading"><h3 class="panel-title"><big>PASO 3</big> - Generar envio</h3></div>
				<div class="panel-body">					
					<div class="row"><div class="col-md-12" style="background-color:#fff;padding-top:15px">				
						<!-- Nav tabs -->
						<ul class="nav nav-tabs">
						  <li class="active"><a href="#envio" data-toggle="tab">Realizar el envío</a></li>
						  <li><a href="#prueba" data-toggle="tab">Probar el envío</a></li>
						  <li><a href="#agenda" data-toggle="tab">Programar el envío</a></li>
						</ul>		
							
						<div class="tab-content">
			  				<div class="tab-pane fade in active" id="envio">
								<div class="col-md-6">
									<br />
									<p class="text-muted">Para finalizar, pulsa en el botón "crear mensaje".</p>
									<button type="submit" id="SubmitData" name="SubmitData" class="btn btn-primary">Crear mensaje</button>
									<a href="#" target="_blank" id="PreviewData" name="PreviewData" class="btn btn-primary">Previsualizar mensaje</a>
								</div>
							</div>

							<div class="tab-pane fade" id="prueba">
								<div class="col-md-6">
									<br />
									<p class="text-muted">Envio de prueba: introduce los usuarios separados por coma:</p>
									<input type="text" name="email_test" id="email_test" value="" class="form-control" />
								</div>
								<div class="col-md-6">				
									<button type="button" id="SubmitTest" name="SubmitTest" class="btn btn-primary" style="margin-top:48px"><i class="glyphicon glyphicon-envelope"></i> Enviar prueba</button>	
								</div>									
							</div>

							<div class="tab-pane fade" id="agenda">
								<br />
								<p class="text-muted">Si lo deseas puedes programar el envío y se realizará automáticamente</p>
								<div class="col-md-8">
									<br />
									<div id="datetimepicker1" class="input-group date">
									    <input data-format="yyyy/MM/dd" readonly type="text" id="user-date" class="form-control" name="user-date"></input>
									    <span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
									</div>									
									<span id="user-date-alert" class="alert-message alert alert-danger"></span>			
								</div>
								<div class="col-md-4">
									<br />
									<button type="button" id="SubmitAgenda" name="SubmitAgenda" class="btn btn-primary">Programar mensaje</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">Envío de comunicaciones</div>
			<div class="panel-body">
				<a href="?page=user-templates" class="comunidad-color">Ir a todas las comunicaciones</a><br />
				<a href="?page=user-messages" class="comunidad-color">Mis comunicaciones enviadas</a>
			</div>
		</div>
	</div>
</div>