<?php
templateload("addmessage","mensajes");

addJavascripts(array("js/jquery.bettertip.pack.js", getAsset("mensajes")."js/inbox.js"));
?>  
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<?php 

		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Mailing_messages"), "ItemUrl"=>"inbox"),
			array("ItemLabel"=>strTranslate("Mailing_inbox"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );  
		mensajesController::createNickAction();
		mensajesController::createAction();
		mensajesController::deleteRecibidoAction();

		$mensajeria = new mensajes();
		$mensajes = $mensajeria->getMensajes(" AND user_destinatario='".$_SESSION['user_name']."' AND estado<>2 ORDER BY date_mensaje DESC");
		$contador_no_leidos=connection::countReg("mensajes"," AND user_destinatario='".$_SESSION['user_name']."' AND estado=0 ");
		?>

		<p><?php echo strTranslate("Mailing_messages");?>: <?php echo count($mensajes);?> (<?php echo strTranslate("Mailing_unread");?>: <span id="contador-no-leidos"><?php echo $contador_no_leidos;?></span>) | 
		<a href="#" id="mensaje-new-trigger"><?php echo strTranslate("New_message");?></a> | <a href="inbox"><?php echo strTranslate("Refresh");?> <?php echo strtolower(strTranslate("Mailing_inbox"));?></a> | <a href="sent-items"><?php echo strTranslate("Mailing_sent");?></a></p>
		<div class="table-responsive container-min">
			<table class="table">
			<?php foreach($mensajes as $mensaje):
				if ($mensaje['estado']==0){$estilo_leido="MensajeNoLeido";$estilo_titulo="TituloNoleido ";}
				else {$estilo_leido="";$estilo_titulo="";} ?>
				
				<tr id="MensajeOvejaContent<?php echo $mensaje['id_mensaje'];?>" class="MensajeCuerpo <?php echo $estilo_leido;?>">
					<td nowrap="nowrap" valign="top">
						<span class="fa fa-ban icon-table" onClick="Confirma('¿Seguro que desea eliminar el mensaje?', 'inbox?act=ko&id=<?php echo $mensaje['id_mensaje'];?>')" title="<?php echo strTranslate("Delete");?>"></span>
						<span class="fa fa-reply icon-table message-reply" data-id="<?php echo $mensaje['id_mensaje'];?>" title="<?php echo strTranslate("Reply");?>"></span>			
					</td>
					<td valign="top" nowrap="nowrap"><span id="leidoMensajeNick<?php echo $mensaje['id_mensaje'];?>"><i class="fa fa-user"></i> <span id="message-nick-<?php echo $mensaje['id_mensaje'];?>"><?php echo $mensaje['nick'];?></span></span></td>
					<td width="100%" valign="top"><a id="<?php echo $mensaje['id_mensaje'];?>" href="#" value="1" class="titulo-mensaje <?php echo $estilo_titulo;?>" title="<?php echo $mensaje['asunto_mensaje'];?>"><?php echo $mensaje['asunto_mensaje'];?></a></td>
					<td width="150px" valign="top" align="right" nowrap="nowrap"><span id="leidoMensajeTime<?php echo $mensaje['id_mensaje'];?>"><small class="text-muted"><?php echo getDateFormat($mensaje['date_mensaje'], "DATE_TIME");?></small></span></td>		
				</tr>
				<tr id="MensajeOveja<?php echo $mensaje['id_mensaje'];?>" class="MensajeTextoCuerpo">
					<td colspan="4" id="message-body-<?php echo $mensaje['id_mensaje'];?>"><small><em class="text-muted"><?php echo nl2br($mensaje['mensaje_cuerpo']);?></em></small></td>
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