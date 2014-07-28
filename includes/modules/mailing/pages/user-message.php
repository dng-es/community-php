<?php

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

templateload("cmbListas","mailing");

function ini_page_header ($ini_conf) {

?>
<script language="JavaScript" src="js/jquery.numeric.js"></script>
<script language="JavaScript" src="js/bootstrap.file-input.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.es.js"></script>
<script language="JavaScript" src="<?php echo getAsset("mailing");?>js/user-message.js"></script>
<script language="JavaScript" src="<?php echo getAsset("mailing");?>js/user-message-test.js"></script>
<?php }
function ini_page_body ($ini_conf){
	?>
	<div class="row less-width row-top">
		<div class="col-md-9">
		<div class="textuppercase blue more-marginbottom"><h1 class="font-title">Envío de comunicaciones</h1></div>
		<?php
		session::getFlashMessage( 'actions_message' );
		mailingController::createUserAction();

		$id = isset($_GET['id']) == true ? $_GET['id'] : 0;
		$plantilla = mailingTemplatesController::getItemAction($id);
		
		if ($_SESSION['cod_tienda']==''){
			$nombre = '';
			$direccion='';
			$cod_postal='';
			$poblacion='';
			$provincia='';
			$telefono='';
			$web='';
		} else {
			$optica = usersTiendasController::getListActionTienda(1,$_SESSION['cod_tienda']);
			$nombre = $optica['items'][0]['nombre_tienda'];
			$direccion = $optica['items'][0]['direccion'];
			$cod_postal= $optica['items'][0]['codigo_postal'];
			$poblacion= $optica['items'][0]['ciudad'];
			$provincia= $optica['items'][0]['provincia'];
			$telefono= $optica['items'][0]['telefono'];
			$web= $optica['items'][0]['web'];
			
			$redes = usersRedesController::getListAction(10, $optica['items'][0]['cod_tienda']);
			$list_tiendas = usersTiendasController::getListActionUsuario(1,$_SESSION['user_name']);
		}

		?>
			<div class="panel panel-default">
				<div class="panel-heading">Datos del mensaje</div>
				<div class="panel-body">
					<div class="row">
						<h4 class="blue2 text-center more-marginbottom less-width"><?php echo $plantilla['template_name'];?> - <?php echo $plantilla['tipo'];?> - <?php echo $plantilla['campana'];?></h4>
					</div>
						<label>Comunicaci&oacute;n:</label> <?php echo $plantilla['template_name'];?><br />
						<label>Campa&ntilde;a:</label> <?php echo $plantilla['campana']; ?><br />
						<label>Tipo de campa&ntilde;a:</label> <?php echo  $plantilla['tipo']; ?><br /><br />					
						<form role="form" id="formData" name="formData" enctype="multipart/form-data" method="post" action="?page=user-message&amp;id=<?php echo $id;?>&amp;accion2=ok">
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

						<label for="nombre_optica">&Oacute;ptica:</label>
						<input type="text" class="form-control" id="nombre_optica" name="nombre_optica" value="<?php echo $nombre;?>" />

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

						<label for="web">Web &Oacute;ptica:</label>
						<input type="text" class="form-control" id="web_direccion" name="web_direccion" value="<?php echo $web;?>" />
						<?php endif; ?>

						<?php if (strpos($plantilla['template_body'], '[USER_REDES]') !== FALSE): ?>
							<label for="red">Redes Sociales:</label>
							<?php if (isset($redes) && count($redes['items'])>0):?>
								<?php foreach($redes['items'] as $red): ?>
									<div class="margTitle marginLeft">
									<input type="checkbox" name="red<?php echo $red['id_red'];?>" value="<?php echo $red['id_red'];?>" checked disabled /><label for="red_<?php echo $red['nombre'];?>"><?php echo $red['nombre'];?></label>
									</div>
								<?php endforeach;?>							
							<?php else: ?>
								<div class="margTitle marginLeft">
									<label for="red">No hay redes sociales asignadas a esta &oacute;ptica</label>
								</div>
							<?php endif; ?>							
						<?php endif; ?>

						<?php if (strpos($plantilla['template_body'], '[USER_OPTICAS]') !== FALSE): ?>
							<?php if (isset($list_tiendas) && count($list_tiendas['items'])>1):?>
								<label for="red">&Oacute;pticas:</label>
								<?php foreach($list_tiendas['items'] as $tienda): ?>
									<?php if ($optica['items'][0]['cod_tienda']<>$tienda['cod_tienda']) {?>
										<div class="margTitle marginLeft">
											<input type="checkbox" id="optica_<?php echo $tienda['cod_tienda'];?>" name="optica_<?php echo $tienda['cod_tienda'];?>" value="<?php echo $tienda['cod_tienda'];?>" /><label for="red_<?php echo $tienda['cod_tienda'];?>"><?php echo $tienda['nombre_tienda']." (".$tienda['direccion'].")";?></label>
										</div>
									<?php } ?>
								<?php endforeach;?>							
							<?php endif; ?>							
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

						<br /><p>Lista de envío: si lo deseas puedes selecionar una lista ya creada o cargar un fichero Excel con los correos.</p>			
						<div class="row inset">
							<div class="col-md-4">
								<div class="radio">
									<label>
										<input type="radio" name="tipo-lista" id="tipo-lista-lista" checked="checked" value="lista" />Selecciona una de tus listas:
									</label>
									<br /><br />
									<?php ComboListas(0);?>	
									<span id="lista-alert" class="alert-message alert alert-danger"></span>			
								</div>					
							</div>
							<div class="col-md-8">
								<div class="radio">
									<label>
									<input type="radio" name="tipo-lista" id="tipo-lista-fichero" value="fichero" />Selecciona un fichero Excel (XLS) que contenga en la primera columna los emails:<br /><br />
									</label>
									<input name="nombre-fichero" id="nombre-fichero" type="file" class="btn btn-primary" title="Seleccionar fichero" />
									<span id="fichero-alert" class="alert-message alert alert-danger"></span>
								</div>						
							</div>		
						</div>		
						<div class="row inset"><div class="col-md-12" style="background-color:#fff;padding-top:15px;padding-bottom:15px">				
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
										<p>Para finalizar, pulsa en el botón "crear mensaje".</p>
										<button type="submit" id="SubmitData" name="SubmitData" class="btn btn-primary">Crear mensaje</button>						
									</div>
								</div>

								<div class="tab-pane fade" id="prueba">
									<div class="col-md-6">
										<br />
										<p>Envio de prueba: introduce los usuarios separados por coma:</p>
										<input type="text" name="email_test" id="email_test" value="" class="form-control" />
									</div>
									<div class="col-md-6">				
										<button type="button" id="SubmitTest" name="SubmitTest" class="btn btn-primary" style="margin-top:48px"><i class="glyphicon glyphicon-envelope"></i> Enviar prueba</button>	
									</div>									
								</div>

								<div class="tab-pane fade" id="agenda">
									<div class="col-md-8">
										<br />
										<p>Si lo deseas puedes programar el envío y se realizará automáticamente</p>
										<div id="datetimepicker1" class="input-group date">
										    <input data-format="yyyy/MM/dd" readonly type="text" id="user-date" class="form-control" name="user-date"></input>
										    <span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
										    &nbsp;<button type="button" id="SubmitAgenda" name="SubmitAgenda" class="btn btn-primary">Programar mensaje</button>
										</div>									
										<span id="user-date-alert" class="alert-message alert alert-danger"></span>			
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
			<div id="right-panel" class="panel panel-default">
				<div class="panel-heading">Envío de comunicaciones</div>
				<div class="panel-body">
					<a href="?page=user-templates" class="comunidad-color">Ir a todas las comunicaciones</a><br />
					<a href="?page=user-messages" class="comunidad-color">Mis comunicaciones enviadas</a>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Preview Comunicaci&oacute;n</div>
				<div class="panel-body">
				<img style="width:100%" src="images/mailing/<?php echo $plantilla['template_mini'];?>" alt="banner" />
			</div>
		</div>

		</div>
	</div>
</div>
	<?php
}
?>