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

		

		<h2>Mensajes enviados</h2>
		<p>Mensajes enviados: <span id="contador-leidos"><?php echo count($mensajes);?></span> | 
		<a href="#" id="mensaje-new-trigger">nuevo mensaje</a> | <a href="?page=mensajes">bandeja de entrada</a></p>
		<table class="table">
		<?php foreach($mensajes as $mensaje):				
			echo '<tr id="MensajeOvejaContent'.$mensaje['id_mensaje'].'" class="MensajeCuerpo MensajeLeido">';
			echo '<td nowrap="nowrap" valign="top">
					<span class="fa fa-ban icon-table" onClick="Confirma(\'¿Seguro que desea eliminar el mensaje?\',
						\'?page=mensajes_e&act=ko&id='.$mensaje['id_mensaje'].'\')" title="eliminar" />
					</span>
					<span class="fa fa-reply icon-table" 
						onClick=\'location.href="?page=mensajes_e&act=resp&id='.$mensaje['id_mensaje'].'"\' title="reenviar" />
					</span>			
				 </td>';
			echo '<td valign="top" nowrap="nowrap"><span id="leidoMensajeNick'.$mensaje['id_mensaje'].'" class="'.$estilo_leido.'"><i class="fa fa-user"></i> '.$mensaje['nick'].'</span></td>';
			echo '<td width="100%" valign="top"><a id="'.$mensaje['id_mensaje'].'" href="#" value="1" class="titulo-mensaje MensajeLeido" title="'.$mensaje['asunto_mensaje'].'">'.$mensaje['asunto_mensaje'].'</a></td>';			
			echo '<td width="150px" valign="top" align="right" nowrap="nowrap"><span id="leidoMensajeTime'.$mensaje['id_mensaje'].'" class="'.$estilo_leido.'"><b>'.strftime(DATE_TIME_FORMAT,strtotime($mensaje['date_mensaje'])).'</b></span></td>';			
			echo '</tr>';
			echo '<div id="MensajeOveja'.$mensaje['id_mensaje'].'" class="MensajeTextoCuerpo">
					  <p><b>'.$mensaje['nick'].'</b> escribió:</p>
					  <p>'.nl2br($mensaje['mensaje_cuerpo']).'</p>
				  </div>';			 
		endforeach;?>
		</table><br />
		<div id="leer-oveja"></div>
	</div>
  	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<h4>Tus mensajes</h4>
			<p>Contacta con uno de tus compañeros de la comunidad, es tan sencillo como poner su Alias, escribir el mensaje y enviárselo.</p>
		</div>
	</div>
</div>

<?php addMensaje();?>