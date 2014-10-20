<?php
templateload("addmessage","mensajes");

addJavascripts(array("js/jquery.bettertip.pack.js", getAsset("mensajes")."js/mensajes.js"));
?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<?php
		session::getFlashMessage( 'actions_message' ); 
		mensajesController::createAction();
		mensajesController::deleteEnviadoAction();

		$mensajeria = new mensajes();
		$mensajes = $mensajeria->getMensajesEnviados(" AND user_remitente='".$_SESSION['user_name']."' AND estado_remitente=0 ORDER BY date_mensaje DESC");
		?>

		<h2><?php echo strTranslate("Mailing_sent");?></h2>
		<p><?php echo strTranslate("Mailing_messages");?>: <span id="contador-leidos"><?php echo count($mensajes);?></span> | 
		<a href="#" id="mensaje-new-trigger"><?php echo strTranslate("New_message");?></a> | <a href="?page=mensajes"><?php echo strTranslate("Mailing_inbox");?></a></p>
		<div class="table-responsive container-min">
			<table class="table">
			<?php foreach($mensajes as $mensaje): ?>			
				<tr id="MensajeOvejaContent<?php echo $mensaje['id_mensaje'];?>" class="MensajeCuerpo MensajeLeido">
					<td nowrap="nowrap" valign="top">
						<span class="fa fa-ban icon-table" onClick="Confirma('¿Seguro que desea eliminar el mensaje?', '?page=mensajes_e&act=ko&id=<?php echo $mensaje['id_mensaje'];?>')" title="<?php echo  strTranslate("Delete");?>"></span>
						<span class="fa fa-reply icon-table message-forward" data-id="<?php echo $mensaje['id_mensaje'];?>" title="<?php echo strTranslate("Forward");?>"></span>			
					</td>
					<td valign="top" nowrap="nowrap"><span id="leidoMensajeNick<?php echo $mensaje['id_mensaje'];?>"><i class="fa fa-user"></i> <span id="message-nick-<?php echo $mensaje['id_mensaje'];?>"><?php echo $mensaje['nick'];?></span></span></td>
					<td width="100%" valign="top"><a id="<?php echo $mensaje['id_mensaje'];?>" href="#" value="1" class="titulo-mensaje MensajeLeido" title="<?php echo $mensaje['asunto_mensaje'];?>"><?php echo $mensaje['asunto_mensaje'];?></a></td>
					<td width="150px" valign="top" align="right" nowrap="nowrap"><span id="leidoMensajeTime<?php echo $mensaje['id_mensaje'];?>"><small class="text-muted"><?php echo getDateFormat($mensaje['date_mensaje'], "DATE_TIME");?></small></span></td>		
				</tr>
				<tr id="MensajeOveja<?php echo $mensaje['id_mensaje'];?>" class="MensajeTextoCuerpo">
					<td colspan="4" id="message-body-<?php echo $mensaje['id_mensaje'];?>">
					<?php echo nl2br($mensaje['mensaje_cuerpo']);?>
					</td>
				</tr>		 
			<?php endforeach; ?>
			</table>
		</div>
	</div>
  	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<h4><?php echo strTranslate("Your_messages");?></h4>
			<p><?php echo strTranslate("Mailing_text");?></p>
		</div>
	</div>
</div>

<?php addMensaje();?>