<?php
templateload("addmessage","mensajes");

addJavascripts(array("js/jquery.bettertip.pack.js", getAsset("mensajes")."js/mensajes.js"));
?>  
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<?php
		
		$mensajes = new mensajes();

		//VARIABLES DE INICIO DEL MENSAJE
		if ($_REQUEST['act']=='resp'){
			//DATOS DEL MENSAJE ORIGINAL
			$mensaje = $mensajes->getMensajes(" AND id_mensaje=".$_REQUEST['id']." ");
			if ($mensaje[0]['user_destinatario']==$_SESSION['user_name']){
				$asunto_resp="RE: ".$mensaje[0]['asunto_mensaje'];
				$nick_resp=$mensaje[0]['nick'];
				$cuerpo_resp='


-------------------------------------
'.
$nick_resp.' escribió:

'.$mensaje[0]['mensaje_cuerpo'];
  }
	echo '<script>
			$(document).ready(function(){
				$("#mensaje-new").slideDown();	
			});
		  </script>';
  }
			else {
			  $asunto_resp=$_POST['asunto-comentario'];
			  $nick_resp=$_POST['nick-comentario'];	  
			  $cuerpo_resp=$_POST['texto-comentario'];
			} 
			
			if (isset($_REQUEST['n']) and $_REQUEST['n']!=""){
				$nick_resp=$_REQUEST['n'];
			echo '<script>
				$(document).ready(function(){
					$("#mensaje-new").slideDown();	
				});
			  </script>';
			} 
  
	//INSERTAR COMENTARIO-MENSAJE
	if (isset($_POST['texto-comentario']) and $_POST['texto-comentario']!=""){
	$insercion_comentario = $mensajes->InsertMensaje($_SESSION['user_nick'],
														 $_SESSION['user_name'],
														 $_SESSION['user_mail'],
														 $_POST['nick-comentario'],
														 $_POST['asunto-comentario'],
														 $_POST['texto-comentario']);
														 
	if ($insercion_comentario==0){ErrorMsg("Mensaje enviado correctamente.");
	echo '<script>
				$(document).ready(function(){
					$("#mensaje-new").css({"display":"none"});	
				});
			  </script>';
	}
	else{
		if ($insercion_comentario==2){ErrorMsg("No se encuentra el destinatario <b>".$_POST['nick-comentario']."</b>.");}
		elseif ($insercion_comentario==3){ErrorMsg("No se puede enviar un mensaje a si mismo.");}	
		else { ErrorMsg("Se ha producido un error durante el env&iacute;o del mensaje. Int&eacute;ntelo m&aacute;s tarde.");}
		echo '<script>
				$(document).ready(function(){
					$("#mensaje-new").slideDown();	
				});
			  </script>';
	}
  }
  //ELIMINAR MENSAJE
  if ($_REQUEST['act']=='ko'){
	  $mensajes->deleteMensaje($_REQUEST['id']);
  }

session::getFlashMessage( 'actions_message' );  

?>

		<?php getBandejaEntrada(); ?>
	</div>
  	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<h4>Tus mensajes</h4>
			<p>Contacta con uno de tus compañeros de la comunidad, es tan sencillo como poner su Alias, escribir el mensaje y enviárselo.</p>
		</div>
	</div>
</div>

<?php addMensaje();?>

<?php
///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////


function getBandejaEntrada()
{
	echo '<h2>bandeja de entrada</h2>';
	$mensajeria = new mensajes();
	$mensajes = $mensajeria->getMensajes(" AND user_destinatario='".$_SESSION['user_name']."' AND estado<>2 ORDER BY date_mensaje DESC");
	$refrescar_link=' | <a href="?page=mensajes">refrescar bandeja de entrada</a>';
	$enviados_link=' | <a href="?page=mensajes_e">elementos enviados</a>';
	$mensaje_new_link='<a href="#" id="mensaje-new-trigger">nuevo mensaje</a>';
	if (count($mensajes)==0){
		echo '<p style="margin-bottom: 250px">no tienes mensajes | '.$mensaje_new_link.$refrescar_link.$enviados_link.'</p>';
	}
	else{
	  $contador_leidos=mensajes::countReg("mensajes"," AND user_destinatario='".$_SESSION['user_name']."' AND estado=1 ");
	  $contador_no_leidos=mensajes::countReg("mensajes"," AND user_destinatario='".$_SESSION['user_name']."' AND estado=0 ");
	  echo '<p>mensajes: 
	  		<span><b>total: '.($contador_leidos+$contador_no_leidos).'</b></span> - 
			<span><b>leidos: <span id="contador-leidos">'.$contador_leidos.'</span></b></span> - 
			<span><b>no leidos: <span id="contador-no-leidos">'.$contador_no_leidos.'</span></b></span> | 
			'.$mensaje_new_link.$refrescar_link.$enviados_link.'</p>';
	  echo '<table class="table">';
	  foreach($mensajes as $mensaje):
			if ($mensaje['estado']==0){$estilo_leido="MensajeNoLeido";$estilo_titulo="TituloNoleido ";}
			else {$estilo_leido="";$estilo_titulo="";}
			
			echo '<tr id="MensajeOvejaContent'.$mensaje['id_mensaje'].'" class="MensajeCuerpo '.$estilo_leido.'">';
			echo '<td nowrap="nowrap" valign="top">
					<span class="fa fa-ban icon-table" onClick="Confirma(\'¿Seguro que desea eliminar el mensaje?\',
						\'?page=mensajes&act=ko&id='.$mensaje['id_mensaje'].'\')" title="eliminar" />
					</span>
					<span class="fa fa-reply icon-table" 
						onClick=\'location.href="?page=mensajes&act=resp&id='.$mensaje['id_mensaje'].'"\' title="responder" />
					</span>			
				 </td>';
			echo '<td valign="top" nowrap="nowrap"><span id="leidoMensajeNick'.$mensaje['id_mensaje'].'"><i class="fa fa-user"></i> '.$mensaje['nick'].'</span></td>';
			echo '<td width="100%" valign="top"><a id="'.$mensaje['id_mensaje'].'" href="#" value="1" class="titulo-mensaje '.$estilo_titulo.'" title="'.$mensaje['asunto_mensaje'].'">
			'.$mensaje['asunto_mensaje'].'</a>
				<div id="MensajeOveja'.$mensaje['id_mensaje'].'" class="MensajeTextoCuerpo">
					  <p><b>'.$mensaje['nick'].'</b> escribi&oacute;:</p>
					  <p>'.nl2br($mensaje['mensaje_cuerpo']).'</p>
				</div>
			</td>';			
			echo '<td width="150px" valign="top" align="right" nowrap="nowrap"><span id="leidoMensajeTime'.$mensaje['id_mensaje'].'"><b>'.strftime(DATE_TIME_FORMAT,strtotime($mensaje['date_mensaje'])).'</b></span></td>';			
			echo '</tr>';
			 
	  endforeach;
	  echo '</table><br />';
	  echo '<div id="leer-oveja"></div>';	
	}
}
?>
