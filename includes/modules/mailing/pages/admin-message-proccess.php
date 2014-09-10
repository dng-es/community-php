<?php
//CONTROL NIVEL DE ACCESO
// $perfiles_autorizados = array("admin");
// session::AccessLevel($perfiles_autorizados);

//EXPORT CSV
mailingController::exportMessageAction(" AND id_message IN (SELECT id_message FROM mailing_messages WHERE username_add='".$_SESSION['user_name']."') ");

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);   

addJavascripts(array(getAsset("mailing")."js/admin-message-proccess.js"));

?>
<div id="page-info">Envío de comunicaciones</div>
<div class="row inset row-top">
	<div class="col-md-8">
		<?php
		$mailing = new mailing();
		session::getFlashMessage( 'actions_message' );
			
		//datos del mensaje
		$id=$_REQUEST['id'];
		$elements=$mailing->getMessages(" AND id_message=".$id." "); 	
		?>
		<div class="panel panel-default">
			<div class="panel-heading">Procesar envío del mensaje</div>
			<div class="panel-body">
				<div><b>Asunto:</b> <?php echo $elements[0]['message_subject'];?></div>
				<div><b>Remitente:</b> <?php echo $elements[0]['message_from_email'];?> <?php echo $elements[0]['message_from_name'];?></div>
				<div><b>Lista:</b> <?php echo $elements[0]['message_lista'];?></div>
				<div><b>Total mensajes:</b> <?php echo $elements[0]['total_messages'];?></div>
				<br />
				<div><b>Estado:</b> <span class="label <?php echo $elements[0]['message_status']=='pending' ? 'label-warning' : 'label-success';?>"><?php echo $elements[0]['message_status'];?></span></div>
				<hr />
				<?php if ($elements[0]['message_status']=='pending'):?>
				<a href="#" class="btn btn-primary" id="proccess-message" data-id="<?php echo $elements[0]['id_message'];?>" data-estado="enabled" data-action="pending">Procesar envío del mensaje</a>
				<div id="mailing-process-info">
					Por favor, no cierres esta ventana durante el proceso de envío.
					<br />Proceso en espera...
				</div>
				<?php else: ?>
					<?php if ($elements[0]['total_failed'] > 0 ):?>
						<p class="alert alert-warning">Hay algunos envios que han dado error. Puedes volver a procesarlos pinchando en el boton volver a procesar</p>
						<a href="#" class="btn btn-primary" id="reproccess-message" data-id="<?php echo $elements[0]['id_message'];?>" data-estado="enabled" data-action="failed">Volver a procesar</a>
						<div id="mailing-process-info">
							Por favor, no cierres esta ventana durante el proceso de envío.
							<br />Proceso en espera...
						</div>
					<?php else: ?>
						<p class="alert alert-success">El mensaje ha sido enviado por completo</p>
					<?php endif;?>
					<p>Pincha <a href="?page=admin-message-proccess&exportm=true&id=<?php echo $id;?>">aquí</a> para descarga el informe del envío.</p>
				<?php endif;?>
			</div>
		</div>

		</div>
		<div class="col-md-4">
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