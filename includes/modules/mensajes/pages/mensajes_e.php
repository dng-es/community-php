<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_select=6;
function ini_page_header ($ini_conf) {?>
        <script language="JavaScript" src="js/mensajes.js"></script>
        <!-- tooltip -->
        <link rel="stylesheet" type="text/css" href="css/jquery.bettertip.css" />     
        <script type="text/javascript" src="js/jquery.bettertip.pack.js"></script> 
        <script type="text/javascript">
            $(function(){
                BT_setOptions({openWait:250, closeWait:0, cacheEnabled:true});
            })
        </script>
        <!-- fin tooltip -->       
<?php }
function ini_page_body ($ini_conf){ 

	echo '<div id="page-info">Tus mensajes</div>';
	echo '<div class="row inset row-top">';
	echo '  <div class="col-md-11">';  
	echo '	<p>Contacta con uno de tus compañeros de la comunidad, es tan sencillo como poner su Alias, escribir el mensaje y enviárselo.</p>';

	session::getFlashMessage( 'actions_message' );
	    
  $mensajes = new mensajes();
  //VARIABLES DE INICIO DEL MENSAJE
  if ($_REQUEST['act']=='resp'){
	  //DATOS DEL MENSAJE ORIGINAL
	  $mensaje = $mensajes->getMensajes(" AND id_mensaje=".$_REQUEST['id']." ");
	  if ($mensaje[0]['user_remitente']==$_SESSION['user_name']){
	  $asunto_resp="RV: ".$mensaje[0]['asunto_mensaje'];
	  $nick_remitente=$mensaje[0]['nick'];
	  $nick_resp="";
	  $cuerpo_resp='


-------------------------------------
'.
$nick_remitente.' escribió:

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
		if ($insercion_comentario==2){ErrorMsg("No se encuentra el destinatario <b>".$_POST['nick-comentario']."</b>.");$cuerpo_resp=$_POST['texto-comentario'];}
		elseif ($insercion_comentario==3){ErrorMsg("No se puede enviar un mensaje a si mismo.");$cuerpo_resp=$_POST['texto-comentario'];}	
		else { ErrorMsg("Se ha producido un error durante el env&iacute;o del mensaje. Int&eacute;ntelo m&aacute;s tarde.");$cuerpo_resp=$_POST['texto-comentario'];}
		echo '<script>
				$(document).ready(function(){
					$("#mensaje-new").slideDown();	
				});
			  </script>';
	}
  }
  //ELIMINAR MENSAJE
  if ($_REQUEST['act']=='ko'){
	  $mensajes->deleteMensajeEnviado($_REQUEST['id']);
  }
  

	  echo '	<div class="comunidad-mensaje">			
				<div id="mensaje-new">
				<form id="coment-form" name="coment-form" action="" method="post">
				  	<input type="hidden" name="remitente-comentario" id="remitente-comentario" value="'.$_SESSION['user_name'].'" />
				  	<label for="nick-comentario">Destinatario / Alias:</label>
					<input maxlength="100" name="nick-comentario" id="nick-comentario" type="text" class="form-control" value="'.$nick_resp.'" />
					<span id="nick-comentario-alert" class="alert-message"></span></td>
					<label>Asunto:</label>
					<input maxlength="250" name="asunto-comentario" id="asunto-comentario" type="text" class="form-control" value="'.$asunto_resp.'" />
					<span id="asunto-comentario-alert" class="alert-message"></span></td>
					<label>Mensaje:</label>
					<textarea class="form-control" id="texto-comentario" name="texto-comentario">'.$cuerpo_resp.'</textarea>
					<div id="texto-comentario-alert" class="alert-message"></div>
				  	<br /><button class="btn btn-primary" id="coment-submit" name="coment-submit">Enviar mensaje</button>';
			echo '</form>
				  	<span class=" class="fa fa-times id="mensaje-cerrar" title="cerrar"></span>
				  </div>'; 
			getBandejaSalida();	
			echo '</div>';
			echo '</div>';
	echo '</div>';
	echo '</div>';
}

///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////

function getBandejaSalida()
{
	echo '<h2>elementos enviados</h2>';
	$mensajeria = new mensajes();
	$mensajes = $mensajeria->getMensajesEnviados(" AND user_remitente='".$_SESSION['user_name']."' AND estado_remitente=0 ORDER BY date_mensaje DESC");
	$refrescar_link=' | <a href="?page=mensajes">bandeja de entrada</a>';
	$mensaje_new_link='<a href="#" id="mensaje-new-trigger">nuevo mensaje</a>';
	if (count($mensajes)==0){
		echo '<p style="margin-bottom: 250px">no tienes mensajes | '.$mensaje_new_link.$refrescar_link.'</p>';
	}
	else{
	  $contador_leidos=mensajes::countReg("mensajes"," AND user_remitente='".$_SESSION['user_name']."' AND estado_remitente=0 ");
	  echo '<p>tienes los siguientes mensajes: 
			<span><b>enviados: <span id="contador-leidos">'.$contador_leidos.'</span></b></span> | 
			'.$mensaje_new_link.$refrescar_link.'</p>';
	  echo '<table class="table">';
	  foreach($mensajes as $mensaje):
			
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
			 
	  endforeach;
	  echo '</table>';
	  echo '</table><br />';
	  echo '<div id="leer-oveja"></div>';	
	}
}
?>
