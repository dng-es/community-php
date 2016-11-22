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
			array("ItemLabel"=>strTranslate("Mailing_sent"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		mensajesController::createAction();
		mensajesController::deleteEnviadoAction();

		$mensajeria = new mensajes();
		$elements = mensajesController::getListSentAction(20);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<p><?php e_strTranslate("Mailing_messages");?> <span id="contador-leidos"><?php echo $elements['total_reg'];?></span> | 
				<a href="#" id="mensaje-new-trigger"><?php e_strTranslate("New_message_app");?></a> | <a href="inbox"><?php e_strTranslate("Mailing_inbox");?></a></p>
				<div class="table-responsive container-min">
					<table class="table">
					<?php foreach($elements['items'] as $mensaje): ?>
						<tr id="MensajeOvejaContent<?php echo $mensaje['id_mensaje'];?>" class="MensajeCuerpo MensajeLeido">
							<td nowrap="nowrap" valign="top">
								<button type="button" class="btn btn-default btn-xs" onClick="Confirma('¿Seguro que desea eliminar el mensaje?', 'sent-items?act=ko&id=<?php echo $mensaje['id_mensaje'];?>'); return false;" title="<?php echo  strTranslate("Delete");?>"><i class="fa fa-trash icon-table"></i></button>

								<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Forward");?>"><i class="fa fa-reply icon-table message-forward" data-id="<?php echo $mensaje['id_mensaje'];?>"></i></button>		
							</td>
							<td valign="top" nowrap="nowrap"><span id="leidoMensajeNick<?php echo $mensaje['id_mensaje'];?>"><span id="message-nick-<?php echo $mensaje['id_mensaje'];?>"><?php echo $mensaje['nick'];?></span></span></td>
							<td width="100%" valign="top">
								<a id="<?php echo $mensaje['id_mensaje'];?>" href="#" value="1" class="titulo-mensaje MensajeLeido" title="<?php echo $mensaje['asunto_mensaje'];?>"><?php echo $mensaje['asunto_mensaje'];?></a>
								<div class="pull-right"><span id="leidoMensajeTime<?php echo $mensaje['id_mensaje'];?>"><small class="text-muted"><?php echo getDateFormat($mensaje['date_mensaje'], "LONG");?></small></span></div>
							</td>
						</tr>
						<tr id="MensajeOveja<?php echo $mensaje['id_mensaje'];?>" class="MensajeTextoCuerpo">
							<td colspan="4" id="message-body-<?php echo $mensaje['id_mensaje'];?>" class="text-muted">
								<?php echo showHtmlLinks(nl2br($mensaje['mensaje_cuerpo']));?>
							</td>
						</tr>
					<?php endforeach; ?>
					</table>
				</div>
			</div>
			<br />
			<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
		</div>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<?php echo SearchForm(0, "sent-items", "searchForm", strTranslate("Search"), strTranslate("Search"), "", "");?>
			<h4><?php e_strTranslate("Your_messages");?></h4>
			<p><?php e_strTranslate("Mailing_text");?></p>
		</div>
	</div>
</div>

<?php addMensaje();?>