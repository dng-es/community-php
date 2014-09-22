<?php
templateload("addmessage","mensajes");

addJavascripts(array("js/jquery.bettertip.pack.js", getAsset("mensajes")."js/mensajes.js"));
?>  
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">

		<?php 
		session::getFlashMessage( 'actions_message' );  
		mensajesController::createAction();
		mensajesController::deleteRecibidoAction();

		$mensajeria = new mensajes();
		$mensajes = $mensajeria->getMensajes(" AND user_destinatario='".$_SESSION['user_name']."' AND estado<>2 ORDER BY date_mensaje DESC");
		$contador_no_leidos=mensajes::countReg("mensajes"," AND user_destinatario='".$_SESSION['user_name']."' AND estado=0 ");
		?>

		<h2>bandeja de entrada</h2>
		<p><?php echo strTranslate("Mailing_messages");?>: <?php echo count($mensajes);?> (<?php echo strTranslate("Mailing_unread");?>: <span id="contador-no-leidos"><?php echo $contador_no_leidos;?></span>) | 
		<a href="#" id="mensaje-new-trigger"><?php echo strTranslate("New_message");?></a> | <a href="?page=mensajes">refrescar bandeja de entrada</a> | <a href="?page=mensajes_e">elementos enviados</a></p>
		<div class="table-responsive">
		<table class="table">
		<?php foreach($mensajes as $mensaje):
			if ($mensaje['estado']==0){$estilo_leido="MensajeNoLeido";$estilo_titulo="TituloNoleido ";}
			else {$estilo_leido="";$estilo_titulo="";}
			
			echo '<tr id="MensajeOvejaContent'.$mensaje['id_mensaje'].'" class="MensajeCuerpo '.$estilo_leido.'">';
			echo '<td nowrap="nowrap" valign="top">
					<span class="fa fa-ban icon-table" onClick="Confirma(\'¿Seguro que desea eliminar el mensaje?\',
						\'?page=mensajes&act=ko&id='.$mensaje['id_mensaje'].'\')" title="'.strTranslate("Delete").'" />
					</span>
					<span class="fa fa-reply icon-table message-reply" data-id="'.$mensaje['id_mensaje'].'" title="'.strTranslate("Reply").'" />
					</span>			
				 </td>';
			echo '<td valign="top" nowrap="nowrap"><span id="leidoMensajeNick'.$mensaje['id_mensaje'].'"><i class="fa fa-user"></i> <span id="message-nick-'.$mensaje['id_mensaje'].'">'.$mensaje['nick'].'</span></span></td>';
			echo '<td width="100%" valign="top"><a id="'.$mensaje['id_mensaje'].'" href="#" value="1" class="titulo-mensaje '.$estilo_titulo.'" title="'.$mensaje['asunto_mensaje'].'">
			'.$mensaje['asunto_mensaje'].'</a></td>';			
			echo '<td width="150px" valign="top" align="right" nowrap="nowrap"><span id="leidoMensajeTime'.$mensaje['id_mensaje'].'"><small class="text-muted">'.strftime(DATE_TIME_FORMAT,strtotime($mensaje['date_mensaje'])).'</small></span></td>';			
			echo '</tr>';
			echo '<tr id="MensajeOveja'.$mensaje['id_mensaje'].'" class="MensajeTextoCuerpo">
					  <td colspan="4" id="message-body-'.$mensaje['id_mensaje'].'">'.nl2br($mensaje['mensaje_cuerpo']).'
					  </td>
				</tr>';?>			 
		<?php endforeach; ?>
		</table>
		</div>
	</div>
  	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<h4>Tus mensajes</h4>
			<p>Contacta con uno de tus compañeros de la comunidad, es tan sencillo como poner su Alias, escribir el mensaje y enviárselo.</p>
		</div>
	</div>
</div>

<?php addMensaje();?>