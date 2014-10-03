<?php
templateload("player","videos");

addCss(array("css/modal.css"));
addJavascripts(array("js/libs/jwplayer/jwplayer.js", "js/modal.js"));


//DESCARGAR ARCHIVO
if (isset($_REQUEST['exp']) and $_REQUEST['exp']!="") {	
	require ("includes/core/class.zipfile.php");
	$zipfile = new zipfile();
	$origen=PATH_VIDEOS_TEMP;
	if (isset($_REQUEST['s']) and $_REQUEST['s']==1){$origen=PATH_VIDEOS;}

	$zipfile->add_file(implode("",file($origen.$_REQUEST['exp'])), $_REQUEST['exp']);

	header("Content-type: application/octet-stream");
	header("Content-disposition: attachment; filename=videos.zip");
	echo $zipfile->file();
}

//VALIDAR CONTENIDOS
if (isset($_REQUEST['act'])) { 	
	$users = new users();
	$videos = new videos();
	$fotos = new fotos();
	$foro = new foro();
	$muro = new muro();
	$promociones = new promociones();
	
	//SELECCIÓN DEL RETO ACTIVO
	$promociones = new promociones();
	$promocion = $promociones->getPromociones(" AND active=1 ");
	$id_promocion = $promocion[0]['id_promocion'];
	$nombre_muro = $promocion[0]['nombre_promocion'];
	
	if ($_REQUEST['act']=='video_conv'){
	  $videos->convertirVideo($_REQUEST['f'],PATH_VIDEOS_TEMP,PATH_VIDEOS_CONVERT);    
	}
	elseif ($_REQUEST['act']=='videoreto_ok'){
	  if (copy(PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4",PATH_VIDEOS.$_REQUEST['f'].".mp4")) {
		  copy(PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4.jpg",PATH_VIDEOS.$_REQUEST['f'].".mp4.jpg");
		  unlink (PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4");
		  unlink (PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4.jpg");
		  //unlink (PATH_VIDEOS_TEMP.$_REQUEST['f']);
		  $videos->cambiarEstado($_REQUEST['id'],1);
		  $promociones->emailValidacionSimple($_REQUEST['u'],$id_promocion,$nombre_muro);
		  $videos->cambiarNombre($_REQUEST['id']);
		  $puntuaciones = connection::countReg("galeria_videos"," AND id_promocion=".$_REQUEST['p']." AND user_add='".$_REQUEST['u']."' AND estado=1 ");
		  if ($puntuaciones==1){ $users->sumarPuntos($_REQUEST['u'],PUNTOS_RETO_FILE,PUNTOS_RETO_MOTIVO);}
		  elseif ($puntuaciones==2){ $users->sumarPuntos($_REQUEST['u'],PUNTOS_RETO2_FILE,PUNTOS_RETO_MOTIVO);}
		  elseif ($puntuaciones==3){ $users->sumarPuntos($_REQUEST['u'],PUNTOS_RETO2_FILE,PUNTOS_RETO_MOTIVO);}
	  }
	  else {ErrorMsg("No se ha podido validar el video.");} 
		  
	}
	elseif ($_REQUEST['act']=='videoreto_sel'){
	  if ($videos->cambiarEstado($_REQUEST['id'],1,1)){
		  $users->sumarPuntos($_REQUEST['u'],PUNTOS_RETO_SELECCION_FILE,PUNTOS_RETO_SELECCION_MOTIVO);
		  }
	  else {ErrorMsg("No se ha podido validar el video.");}  
	}
	elseif ($_REQUEST['act']=='fotoreto_ok'){
	  $fotos->cambiarEstado($_REQUEST['id'],1,0);
	  $promociones->emailValidacionSimple($_REQUEST['u'],$id_promocion,$nombre_muro);
	  $puntuaciones = connection::countReg("galeria_fotos"," AND id_promocion=".$_REQUEST['p']." AND user_add='".$_REQUEST['u']."' AND estado=1 ");
	  if ($puntuaciones==1){ $users->sumarPuntos($_REQUEST['u'],PUNTOS_RETO_FILE,PUNTOS_RETO_MOTIVO);}
	  //elseif ($puntuaciones==2){ $users->sumarPuntos($_REQUEST['u'],PUNTOS_RETO2_FILE,PUNTOS_RETO_MOTIVO);}
	  //elseif ($puntuaciones==3){ $users->sumarPuntos($_REQUEST['u'],PUNTOS_RETO2_FILE,PUNTOS_RETO_MOTIVO);}
	}
	elseif ($_REQUEST['act']=='fotoreto_sel'){
	  $fotos->cambiarEstado($_REQUEST['id'],1,1);
	  $users->sumarPuntos($_REQUEST['u'],PUNTOS_RETO_SELECCION_FILE,PUNTOS_RETO_SELECCION_MOTIVO);
	}	
	elseif ($_REQUEST['act']=='reto_ok'){
	  $muro->cambiarEstado($_REQUEST['id'],1);
	  $promociones->emailValidacionSimple($_REQUEST['u'],$id_promocion,$nombre_muro);
	  
	  $puntuaciones = connection::countReg("muro_comentarios"," AND tipo_muro='".$_REQUEST['p']."' AND user_comentario='".$_REQUEST['u']."' AND estado=1 ");

	  if ($puntuaciones==1){ $users->sumarPuntos($_REQUEST['u'],PUNTOS_RETO,PUNTOS_RETO_MOTIVO);}
	  elseif ($puntuaciones==2){ $users->sumarPuntos($_REQUEST['u'],PUNTOS_RETO2,PUNTOS_RETO_MOTIVO);}
	  elseif ($puntuaciones==3){ $users->sumarPuntos($_REQUEST['u'],PUNTOS_RETO2,PUNTOS_RETO_MOTIVO);}	  
	}
	elseif ($_REQUEST['act']=='reto_sel'){
	  $muro->cambiarEstado($_REQUEST['id'],1,1);
	  $users->sumarPuntos($_REQUEST['u'],PUNTOS_RETO_SELECCION,PUNTOS_RETO_SELECCION_MOTIVO);
	}	
	elseif ($_REQUEST['act']=='video_ko'){
		unlink (PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4");
		unlink (PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4.jpg");
		unlink (PATH_VIDEOS_TEMP.$_REQUEST['f']);
		$videos->cambiarEstado($_REQUEST['id'],2);
		$promociones->emailCancelacionSimple($_REQUEST['u'],$id_promocion,$nombre_muro);}
	elseif ($_REQUEST['act']=='foto_ko'){
		$fotos->cambiarEstado($_REQUEST['id'],2,0);
		$promociones->emailCancelacionSimple($_REQUEST['u'],$id_promocion,$nombre_muro);}
	elseif ($_REQUEST['act']=='muro_ko'){
		$muro->cambiarEstado($_REQUEST['id'],2);
		$users->restarPuntos($_REQUEST['u'],PUNTOS_MURO,PUNTOS_MURO_MOTIVO);
		$promociones->emailCancelacionSimple($_REQUEST['u'],$id_promocion,$nombre_muro);
	}
	header("Location: ?page=admin-validacion-reto"); 
}

//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);

//SELECCIÓN DEL RETO ACTIVO
$promociones = new promociones();
$promocion = $promociones->getPromociones(" AND active=1 ");
$id_promocion = $promocion[0]['id_promocion'];
$nombre_muro = $promocion[0]['nombre_promocion'];?>

<div class="row row-top">
	<div class="col-md-9">
		<h1>validaciones reto actual</h1>
		<?php
		//COMENTARIOS RETO PENDIENTES DE VALIDAR
		getRetoPendientes($nombre_muro);
		//COMENTARIOS RETO VALIDADOS
		getRetoValidados($nombre_muro);  
		//VIDEOS PENDIENTES DE VALIDAR
		getVideosRetoPendientes($id_promocion);
		//VIDEOS VALIDADOS
		getVideosRetoValidados($id_promocion);  
		//FOTOS PENDIENTES DE VALIDAR
		getFotosRetoPendientes($id_promocion);   
		//FOTOS PENDIENTES DE VALIDAR
		getFotosRetoValidados($id_promocion);?>
	</div>
	<?php menu::adminMenu();?>
</div>

<?php

///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////
function getVideosRetoPendientes($id_promocion)
{
	$videos = new videos();
	$pendientes = $videos->getVideos(" AND estado=0 AND id_promocion=".$id_promocion." ");
	if (count($pendientes)==0){
		echo '<p>No hay <span class="comunidad-color">VIDEOS</span> en el reto pendientes de validar.<br />
			'.ucfirst(strTranslate("APP_points")).' a otorgar por video validado: <span class="comunidad-color">'.PUNTOS_RETO.'.</span></p><br />';
	}
	else{
	  echo '<p>Tiene los siguientes <span class="comunidad-color">VIDEOS</span> en el reto pendientes de validar.<br />
			'.ucfirst(strTranslate("APP_points"));.' a otorgar por video validado: <span class="comunidad-color">'.PUNTOS_RETO.'.</span></p><br />';
	  foreach($pendientes as $element):
			if (file_exists(PATH_VIDEOS_CONVERT.$element['name_file'].'.mp4')){ $convertido=true;}
			else {$convertido=false;}
			
			echo '<div class="video-container">';
			echo '<div class="video-tool">';	
			if ($convertido==true){ 
			echo'	<a class="video-tool-validate" href="#" onClick="Confirma(\'¿Seguro que desea validar el video '.str_replace('"','',$element['titulo']).'?\',
					\'?page=admin-validacion-reto&act=videoreto_ok&id='.$element['id_file'].'&p='.$element['id_promocion'].'&f='.$element['name_file'].'&u='.$element['user_add'].'\')" title="validar video" /><span>validar video</span></a>

					<a class="video-tool-delete" href="#" onClick="Confirma(\'¿Seguro que desea eliminar el video '.str_replace('"','',$element['titulo']).'?\',\'?page=admin-validacion-reto&act=video_ko&id='.$element['id_file'].'&u='.$element['user_add'].'\')" title="eliminar video" /><span>Eliminar</span></a>';
			}
			else{
			echo '	<a class="video-tool-convert" href="#" onClick="Confirma(\'¿Seguro que desea convertir el video '.str_replace('"','',$element['titulo']).'?, el proceso puede durar varios minutos.\', \'?page=admin-validacion-reto&act=video_conv&id='.$element['id_file'].'&f='.$element['name_file'].'&u='.$element['user_add'].'\')" title="convertir video" /><span>convertir video</span></a>';
			}
			
			echo '  <a class="video-tool-downloads" href="?page=admin-validacion-reto&exp='.$element['name_file'].'" title="descargar video"><span>descargar video</span></a>';
			echo '</div>
				  <div class="video-content">';			
			
			if ($convertido==true){ playVideo("VideoRetoConvertido".$element['id_file'],PATH_VIDEOS_CONVERT.$element['name_file'].'.mp4',165,100);}
			else { playVideo("VideoRetoPendiente".$element['id_file'],PATH_VIDEOS_TEMP.$element['name_file'],165,100);}
			echo '	</div>
					<div class="video-info">
						<b>fecha:</b> '.strftime(DATE_FORMAT_SHORT,strtotime($element['date_video'])).'
						<b>usuario:</b> '.$element['user_add'].' 
						<b>canal:</b> '.$element['canal'].' 
						<b>titulo:</b> '.$element['titulo'].'
					</div>'; 
			echo '</div>'; 
	  endforeach;	
	}
}

function getVideosRetoValidados($id_promocion)
{
	$videos = new videos();
	$pendientes = $videos->getVideos(" AND estado=1 AND seleccion_reto=0 AND id_promocion=".$id_promocion." ");
	if (count($pendientes)==0){
		echo '<p>No hay <span class="comunidad-color">VIDEOS</span> en el reto para seleccionar.<br />
			'.ucfirst(strTranslate("APP_points")).' a otorgar por video seleccionado: <span class="comunidad-color">'.PUNTOS_RETO_SELECCION.'.</span><br />';
	}
	else{
	  echo '<p>Tiene los siguientes <span class="comunidad-color">VIDEOS</span> en el reto para seleccionar como los mejores.<br />
			'.ucfirst(strTranslate("APP_points")).' a otorgar por video seleccionado: <span class="comunidad-color">'.PUNTOS_RETO_SELECCION.'.</span></p><br />';

	  foreach($pendientes as $element):
			echo '<div class="video-container">';
			echo ' <div class="video-tool">';
			echo '   <a class="video-tool-validate" href="#" 
					onClick="Confirma(\'¿Seguro que desea seleccionar el video '.str_replace('"','',$element['titulo']).'?\',
					 \'?page=admin-validacion-reto&act=videoreto_sel&id='.$element['id_file'].'&f='.$element['name_file'].'&u='.$element['user_add'].'\')" 
					 title="seleccionar video" /><span>seleccionar video</span></a>';
			echo '   <a class="video-tool-downloads" href="?page=admin-validacion-reto&s=1&exp='.$element['name_file'].'"><span>descargar video</span></a>'; 	
			echo ' </div>
				   <div class="video-content">';
			playVideo("VideoRetoPendiente".$element['id_file'],PATH_VIDEOS.$element['name_file'],165,100);				   		  
			echo ' </div>
				   <div class="video-info">
						<b>fecha:</b> '.strftime(DATE_FORMAT_SHORT,strtotime($element['date_video'])).'
						<b>usuario:</b> '.$element['user_add'].' 
						<b>canal:</b> '.$element['canal'].' 
						<b>titulo:</b> '.$element['titulo'].'
				   </div>'; 
			echo '</div>';		
	  endforeach;
	  echo '</table><br />';	
	}
}




function getFotosRetoPendientes($id_promocion)
{
	$fotos = new fotos();
	$pendientes = $fotos->getFotos(" AND estado=0 AND seleccion_reto=0 and id_promocion=".$id_promocion." ");
	if (count($pendientes)==0){
		echo '<p>No hay <span class="comunidad-color">FOTOS</span> en el reto pendientes de validar.<br /> 
			Puntos a otorgar por seleccionar foto: <span class="comunidad-color">'.PUNTOS_RETO_SELECCION.'</span>.<br />
			Puntos a otorgar por validar foto: <span class="comunidad-color">'.PUNTOS_RETO.'</span></p><br />';
	}
	else{
	  echo '<p>Tiene las siguientes <span class="comunidad-color">FOTOS</span> en el reto pendientes de validar.<br /> 
			Puntos a otorgar por seleccionar foto: <span class="comunidad-color">'.PUNTOS_RETO_SELECCION.'</span>.<br />
			Puntos a otorgar por validar foto: <span class="comunidad-color">'.PUNTOS_RETO.'</span></p><br />';
	  echo '<div class="table-responsive">';
	  echo '<table class="table">';
	  echo '<tr>';
	  echo '<th width="50px">&nbsp;</th>';
	  echo '<th>&nbsp;usuario</th>';
	  echo '<th>&nbsp;canal</th>';
	  echo '<th>t&iacute;tulo foto</th>';
	  echo '<th>fecha</th>';
	  echo '</tr>';
  
	  foreach($pendientes as $element):
			echo '<tr>';
			echo '<td nowrap="nowrap">
					<span class="sprites mini-add">
						<a href="#" onClick="Confirma(\'¿Seguro que desea validar la foto '.str_replace('"','',$element['titulo']).'?\',
						\'?page=admin-validacion-reto&act=fotoreto_ok&id='.$element['id_file'].'&p='.$element['id_promocion'].'&u='.$element['user_add'].'\')" 
						title="Validar" /><span>Validar</span></a>
					</span>
					<span class="sprites mini-del">
						<a href="#" onClick="Confirma(\'¿Seguro que desea eliminar la foto '.str_replace('"','',$element['titulo']).'?\',
						\'?page=admin-validacion-reto&act=foto_ko&id='.$element['id_file'].'&u='.$element['user_add'].'\')" 
						title="Eliminar" /><span>Eliminar</span></a>
					</span>
					
					<div id="MensajeFoto'.$element['id_file'].'" class="modal-content">
						  <p><b>'.$element['user_add'].'</b> mand&oacute; la foto:</p><hr />
						  <p><em>'.$element['titulo'].'</em></p><br />
						  <center>
							<img src="'.PATH_FOTOS.$element['name_file'].'" class="galeria-fotos" style=" width:280px !important" />
						  </center>
					</div>
				 </td>';					
			echo '<td>'.$element['user_add'].'</td>';
			echo '<td>'.$element['canal'].'</td>';
			echo '<td><a href="#" class="abrir-modal" title="MensajeFoto'.$element['id_file'].'">'.$element['titulo'].'</a></td>';
			echo '<td>'.strftime(DATE_FORMAT_SHORT,strtotime($element['f.date_foto'])).'</td>';			
			echo '</tr>';   
	  endforeach;
	  echo '</table>
		</div>
	  <br />';	
	}
}

function getFotosRetoValidados($id_promocion)
{
	$fotos = new fotos();
	$pendientes = $fotos->getFotos(" AND estado=1 AND seleccion_reto=0 and id_promocion=".$id_promocion." ");
	if (count($pendientes)==0){
		echo '<p>No hay <span class="comunidad-color">FOTOS</span> en el reto pendientes de seleccionar.<br /> 
			Puntos a otorgar por seleccionar foto: <span class="comunidad-color">'.PUNTOS_RETO_SELECCION.'</span>.</p><br />';
	}
	else{
	  echo '<p>Tiene las siguientes <span class="comunidad-color">FOTOS</span> en el reto pendientes de seleccionar.<br /> 
			Puntos a otorgar por seleccionar foto: <span class="comunidad-color">'.PUNTOS_RETO_SELECCION.'</span>.</p><br />';
	  echo '<div class="table-responsive">';
	  echo '<table class="table">';
	  echo '<tr>';
	  echo '<th width="50px">&nbsp;</th>';
	  echo '<th>&nbsp;usuario</th>';
	  echo '<th>&nbsp;canal</th>';
	  echo '<th>t&iacute;tulo foto</th>';
	  echo '<th>fecha</th>';
	  echo '</tr>';
  
	  foreach($pendientes as $element):
			echo '<tr>';
			echo '<td nowrap="nowrap">
					<span class="sprites mini-sel">
						<a href="#" onClick="Confirma(\'¿Seguro que desea selecionar la foto '.str_replace('"','',$element['titulo']).'?\',
						\'?page=admin-validacion-reto&act=fotoreto_sel&id='.$element['id_file'].'&u='.$element['user_add'].'\')" 
						title="Seleccionar" /><span>Seleccionar</span></a>
					</span>					
					<div id="MensajeFoto'.$element['id_file'].'" class="modal-content">
						  <p><b>'.$element['user_add'].'</b> mand&oacute; la foto:</p><hr />
						  <p><em>'.$element['titulo'].'</em></p><br />
						  <center>
							<img src="'.PATH_FOTOS.$element['name_file'].'" class="galeria-fotos" style=" width:280px !important" />
						  </center>
					</div>
				 </td>';					
			echo '<td>'.$element['user_add'].'</td>';
			echo '<td>'.$element['canal'].'</td>';
			echo '<td><a href="#" class="abrir-modal" title="MensajeFoto'.$element['id_file'].'">'.$element['titulo'].'</a></td>';
			echo '<td>'.strftime(DATE_FORMAT_SHORT,strtotime($element['f.date_foto'])).'</td>';			
			echo '</tr>';   
	  endforeach;
	  echo '</table>
		</div>
	  <br />';	
	}
}
function getRetoPendientes($nombre_muro)
{
	$muro = new muro();
	$pendientes = $muro->getComentarios(" AND estado=0 AND seleccion_reto=0 AND tipo_muro='".$nombre_muro."' ");

	if (count($pendientes)==0){
		echo '<p>No hay mensajes en el <span class="comunidad-color">RETO</span> pendientes de validar.<br />
			Puntos a otorgar por mensaje validado: <span class="comunidad-color">'.PUNTOS_RETO.'.</span></p><br />';
	}
	else{
	  echo '<p>Hay los siguientes mensajes en el <span class="comunidad-color">RETO</span> pendientes de validar.<br />
			Puntos a otorgar por mensaje validado: <span class="comunidad-color">'.PUNTOS_RETO.'.</span></p><br />';
	  echo '<div class="table-responsive">';
	  echo '<table class="table">';
	  echo '<tr>';
	  echo '<th width="30px">&nbsp;</th>';
	  echo '<th>&nbsp;ID</th>';
	  echo '<th>&nbsp;reto</th>';
	  echo '<th>&nbsp;usuario</th>';
	  echo '<th>&nbsp;canal</th>';
	  echo '<th>fecha</th>';
	  echo '</tr>';
  
	  foreach($pendientes as $element):
			echo '<tr>';
			echo '<td nowrap="nowrap">	
					<span class="fa fa-check-circle icon-table" title="Validar"
						onClick="Confirma(\'¿Seguro que desea validar el comentario '.$element['id_comentario'].'?\',
						\'?page=admin-validacion-reto&act=reto_ok&id='.$element['id_comentario'].'&p='.$element['tipo_muro'].'&u='.$element['user_comentario'].'\')">
						<span>Cerrar</span>
					</span>
					
					<span class="fa fa-ban icon-table" title="Eliminar"
						onClick="Confirma(\'¿Seguro que desea eliminar el comentario '.$element['id_comentario'].'?\',
						\'?page=admin-validacion-reto&act=muro_ko&id='.$element['id_comentario'].'&u='.$element['user_comentario'].'\')">
						<span>Cerrar</span>
					</span>																				
					
					<div id="MensajeMuro'.$element['id_comentario'].'" class="modal-content">
						  <p><b>'.$element['user_comentario'].'</b> escribi&oacute;:</p><hr />
						  <p><em>'.$element['comentario'].'</em></p>
					</div>			
				 </td>';					
			echo '<td><a href="#" class="abrir-modal" title="MensajeMuro'.$element['id_comentario'].'">'.$element['id_comentario'].'</a></td>';
			echo '<td>'.$element['tipo_muro'].'</td>';
			echo '<td>'.$element['user_comentario'].'</td>';
			echo '<td>'.$element['canal'].'</td>';
			echo '<td>'.strftime(DATE_FORMAT_SHORT,strtotime($element['date_comentario'])).'</td>';			
			echo '</tr>';   
	  endforeach;
	  echo '</table>
		</div>
	  <br />';	
	}
}

function getRetoValidados($nombre_muro)
{
	$muro = new muro();
	$pendientes = $muro->getComentarios(" AND estado=1 AND seleccion_reto=0 AND tipo_muro='".$nombre_muro."' ");

	if (count($pendientes)==0){
		echo '<p>No hay mensajes en el <span class="comunidad-color">RETO</span> para ser seleccionados.<br />
			Puntos a otorgar por mensaje seleccionado: <span class="comunidad-color">'.PUNTOS_RETO_SELECCION.'.</span></p><br />';
	}
	else{
	  echo '<p>Hay los siguientes mensajes en el <span class="comunidad-color">RETO</span> para ser seleccionados.<br />
			Puntos a otorgar por mensaje seleccionado: <span class="comunidad-color">'.PUNTOS_RETO_SELECCION.'.</span></p><br />';
	  echo '<div class="table-responsive">';
	  echo '<table class="table">';
	  echo '<tr>';
	  echo '<th width="30px">&nbsp;</th>';
	  echo '<th>&nbsp;ID</th>';
	  echo '<th>&nbsp;reto</th>';
	  echo '<th>&nbsp;usuario</th>';
	  echo '<th>&nbsp;canal</th>';
	  echo '<th>fecha</th>';
	  echo '</tr>';
  
	  foreach($pendientes as $element):
			echo '<tr>';
			echo '<td nowrap="nowrap">
					<span class="fa fa-check-circle icon-table" title="Seleccionar"
						onClick="Confirma(\'¿Seguro que desea seleccionar el comentario '.$element['id_comentario'].'?\',
						\'?page=admin-validacion-reto&act=reto_sel&id='.$element['id_comentario'].'&u='.$element['user_comentario'].'\')">
						<span>Cerrar</span>
					</span>					
					<div id="MensajeMuro'.$element['id_comentario'].'" class="modal-content">
						  <p><b>'.$element['user_comentario'].'</b> escribi&oacute;:</p><hr />
						  <p><em>'.$element['comentario'].'</em></p>
					</div>			
				 </td>';					
			echo '<td><a href="#" class="abrir-modal" title="MensajeMuro'.$element['id_comentario'].'">'.$element['id_comentario'].'</a></td>';
			echo '<td>'.$element['tipo_muro'].'</td>';
			echo '<td>'.$element['user_comentario'].'</td>';
			echo '<td>'.$element['canal'].'</td>';
			echo '<td>'.strftime(DATE_FORMAT_SHORT,strtotime($element['date_comentario'])).'</td>';			
			echo '</tr>';   
	  endforeach;
	  echo '</table>
	  </div>
	  <br />';	
	}
}
?>
