<?php
templateload("player","videos");

addJavascripts(array("js/libs/jwplayer/jwplayer.js"));

videosController::downloadZipFile();

//VALIDAR CONTENIDOS
if (isset($_REQUEST['act'])) { 	
	$users = new users();
	$videos = new videos();    
	if ($_REQUEST['act']=='video_ok'){
	  if (copy(PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4",PATH_VIDEOS.$_REQUEST['f'].".mp4")) {
		  copy(PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4.jpg",PATH_VIDEOS.$_REQUEST['f'].".mp4.jpg");
		  //unlink (PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4");
		  unlink (PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4.jpg");
		  //unlink (PATH_VIDEOS_TEMP.$_REQUEST['f']);
		  $videos->cambiarEstado($_REQUEST['id'],1);
		  $videos->cambiarNombre($_REQUEST['id']);
		  $users->sumarPuntos($_REQUEST['u'],PUNTOS_VIDEO,PUNTOS_VIDEO_MOTIVO);
		  }
	  else {ErrorMsg("No se ha podido validar el video.");}  
	}
	elseif ($_REQUEST['act']=='video_conv'){
	  $videos->convertirVideo($_REQUEST['f'],PATH_VIDEOS_TEMP,PATH_VIDEOS_CONVERT);    
	}
	elseif ($_REQUEST['act']=='video_ko'){
		unlink (PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4");
		unlink (PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4.jpg");
		unlink (PATH_VIDEOS_TEMP.$_REQUEST['f']);
		$videos->cambiarEstado($_REQUEST['id'],2);}

	header("Location: ?page=admin-validacion-videos"); 
}

//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);

$videos = new videos();
$pendientes = $videos->getVideos(" AND estado=0 AND id_promocion=0 ");?>
<div class="row inset row-top">
	<div class="col-md-9">
		<h1><?php echo strTranslate("Video_validation");?></h1>
		<ul class="nav nav-pills navbar-default"> 
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo count($pendientes);?></b> <?php echo strtolower(strTranslate("Items"));?>. <?php echo ucfirst(strTranslate("APP_points"));?> a otorgar por video: <b><?php echo PUNTOS_VIDEO;?></b></a></li>      
		</ul>
		<?php foreach($pendientes as $element):	  		
			$convertido = ((file_exists(PATH_VIDEOS_CONVERT.$element['name_file'].'.mp4')) ? true : false);			
			echo '<div class="col-md-3">';
	 		echo '<div class="btn-group">';			
			if ($convertido==true){  			
				echo '	<a class="btn btn-default" href="#" onClick="Confirma(\'¿Seguro que desea validar el vídeo?\',
						\'?page=admin-validacion-videos&act=video_ok&id='.$element['id_file'].'&f='.$element['name_file'].'&u='.$element['user_add'].'\')" 
						title="validar video" /><span>validar video</span></a>
						
						<a class="btn btn-default" href="#" onClick="Confirma(\''.strTranslate("Are_you_sure_to_delete").'?\',
						\'?page=admin-validacion-videos&act=video_ko&id='.$element['id_file'].'&u='.$element['user_add'].'\')" 
						title="eliminar video" />eliminar video</a>';
			}
			else{
				echo '<a class="btn btn-default" href="#" 
					  onClick="Confirma(\'¿Seguro que desea convertir el vídeo?, el proceso puede durar varios minutos.\',
					  \'?page=admin-validacion-videos&act=video_conv&id='.$element['id_file'].'&f='.$element['name_file'].'&u='.$element['user_add'].'\')" 
					  title="convertir video" />convertir video</a>';
			}								
			echo '<a class="btn btn-default" href="?page=admin-validacion-videos&exp='.$element['name_file'].'" title="descargar vídeo">descargar vídeo</a>';			
			echo '</div>
				  <div class="video-content">';
			if ($convertido==true){ playVideo("VideoConvertido".$element['id_file'],PATH_VIDEOS_CONVERT.$element['name_file'].'.mp4',165,100);}
			else { playVideo("VideoPendiente".$element['id_file'],PATH_VIDEOS_TEMP.$element['name_file'],165,100);}
			echo '	</div>
				  	<div class="video-info">
						<b>'.strTranslate("Date").':</b> '.getDateFormat($element['date_video'], "SHORT").'
						<b>'.strTranslate("User").':</b> '.$element['user_add'].' 
						<b>Canal:</b> '.$element['canal'].' 
						<b>'.strTranslate("Title").':</b> '.$element['titulo'].'
				  	</div>'; 
			echo '</div>';				  
		endforeach;?>
	</div>
	<?php menu::adminMenu();?>
</div>