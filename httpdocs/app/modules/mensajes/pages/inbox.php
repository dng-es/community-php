<?php
templateload("addmessage","mensajes");

addJavascripts(array(getAsset("mensajes")."js/inbox.js"));
?>  
<div class="row row-top">
	<div class="app-main">
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
		$elements = mensajesController::getListAction(20);
		$contador_no_leidos=connection::countReg("mensajes"," AND user_destinatario='".$_SESSION['user_name']."' AND estado=0 ");
		?>

		<p><?php echo strTranslate("Mailing_messages");?> <?php echo $elements['total_reg'];?> | <?php echo strTranslate("Mailing_unread");?> <span id="contador-no-leidos"><?php echo $contador_no_leidos;?></span> | 
		<a href="#" id="mensaje-new-trigger"><?php echo strTranslate("New_message");?></a> | <a href="inbox"><?php echo strTranslate("Refresh");?> <?php echo strtolower(strTranslate("Mailing_inbox"));?></a> | <a href="sent-items"><?php echo strTranslate("Mailing_sent");?></a></p>
		<div class="table-responsive container-min">
			<table class="table">
			<?php foreach($elements['items'] as $mensaje):
				if ($mensaje['estado']==0){$estilo_leido="MensajeNoLeido";$estilo_titulo="TituloNoleido ";}
				else {$estilo_leido="";$estilo_titulo="";} ?>
				
				<tr id="MensajeOvejaContent<?php echo $mensaje['id_mensaje'];?>" class="MensajeCuerpo <?php echo $estilo_leido;?>">
					<td nowrap="nowrap" valign="top">
						<span class="fa fa-ban icon-table" onClick="Confirma('¿Seguro que desea eliminar el mensaje?', 'inbox?act=ko&id=<?php echo $mensaje['id_mensaje'];?>')" title="<?php echo strTranslate("Delete");?>"></span>
						<span class="fa fa-reply icon-table message-reply" data-id="<?php echo $mensaje['id_mensaje'];?>" title="<?php echo strTranslate("Reply");?>"></span>			
					</td>
					<td valign="top" nowrap="nowrap"><span id="leidoMensajeNick<?php echo $mensaje['id_mensaje'];?>"><span id="message-nick-<?php echo $mensaje['id_mensaje'];?>"><?php echo $mensaje['nick'];?></span></span></td>
					<td width="100%" valign="top">
						<a id="<?php echo $mensaje['id_mensaje'];?>" href="#" value="1" class="titulo-mensaje <?php echo $estilo_titulo;?>" title="<?php echo $mensaje['asunto_mensaje'];?>"><?php echo $mensaje['asunto_mensaje'];?></a>
						<div class="pull-right"><span id="leidoMensajeTime<?php echo $mensaje['id_mensaje'];?>"><small class="text-muted"><?php echo getDateFormat($mensaje['date_mensaje'], "LONG");?></small></span></div>
					</td>		
				</tr>
				<tr id="MensajeOveja<?php echo $mensaje['id_mensaje'];?>" class="MensajeTextoCuerpo">
					<td colspan="4" id="message-body-<?php echo $mensaje['id_mensaje'];?>" class="text-muted"><?php echo nl2br($mensaje['mensaje_cuerpo']);?></td>
				</tr>			 
			<?php endforeach; ?>
			</table>
			<br />
			<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
		</div>
	</div>
  	<div class="app-sidebar">
		<div class="panel-interior">
			<?php echo SearchForm(0, "inbox", "searchForm", strTranslate("Search"), strTranslate("Search"), "", "");?>
			<h4><?php echo strTranslate("Your_messages");?></h4>
			<p><?php echo strTranslate("Mailing_text");?></p>
		</div>
	</div>
</div>

<?php addMensaje();?>