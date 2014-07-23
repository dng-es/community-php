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
	<div id="page-info">Envío de comunicaciones</div>
	<div class="row inset row-top">
		<div class="col-md-9">
		<?php
		session::getFlashMessage( 'actions_message' );
		mailingController::createUserAction();

		$id = isset($_GET['id']) == true ? $_GET['id'] : 0;
		$plantilla = mailingTemplatesController::getItemAction($id);
		?>
			<div class="panel panel-default">
				<div class="panel-heading">Datos del mensaje</div>
				<div class="panel-body">
					<h4><?php echo $plantilla['template_name'];?> - <?php echo $plantilla['tipo'];?> - <?php echo $plantilla['campana'];?></h4>
					<img style="width:100%" src="images/mailing/<?php echo $plantilla['template_mini'];?>" alt="banner" /><br /><br />
					<form role="form" id="formData" name="formData" enctype="multipart/form-data" method="post" action="?page=user-message&amp;id=<?php echo $id;?>&amp;accion2=ok">
<!-- 						<input type="hidden" id="email_message" name="email_message" value="<?php echo $ini_conf['MailingEmail']?>"/>
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

						<div class="form-group">
							<?php if ($plantilla['id_type']==1 or $plantilla['id_type']==3):?>
							<label for="texto_message">Descuento de la oferta:</label><br />
							<input type="text" class="form-control numeric" id="texto_message" name="texto_message" style="width: 60px;display:inline-block" /> %
							<?php else: ?>
							<label for="texto_message">Texto mensaje:</label>
							<textarea class="form-control" id="texto_message" name="texto_message" style="height:120px"></textarea>
							<?php endif; ?>
							<span id="texto-alert" class="alert-message alert alert-danger"></span>
						</div> 	

						<?php if ($plantilla['id_type']==3):?>
						<div class="form-group">
							<label for="texto_message">Texto mensaje:</label>
							<textarea class="form-control" id="texto2_message" name="texto2_message" style="height:120px"></textarea>
							<span id="texto2-alert" class="alert-message alert alert-danger"></span>
						</div> 
						<?php endif; ?>							

						<p>Lista de envío: si lo deseas puedes selecionar una lista ya creada o cargar un fichero Excel con los correos.</p>			
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
						<div class="row inset"><div class="col-md-12" style="background-color:#fff;padding-top:15px">				
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
			<div class="panel panel-default">
				<div class="panel-heading">Envío de comunicaciones</div>
				<div class="panel-body">
					<a href="?page=user-templates" class="comunidad-color">Ir a todas las comunicaciones</a><br />
					<a href="?page=user-messages" class="comunidad-color">Mis comunicaciones enviadas</a>
				</div>
			</div>
		</div>
	</div>
</div>
	<?php
}
?>