<?php
templateload("player","videos");

addJavascripts(array("js/libs/jwplayer/jwplayer.js"));

videosController::downloadZipFile();

//VALIDAR CONTENIDOS
if (isset($_REQUEST['act'])) {
	$users = new users();
	$videos = new videos();
	if ($_REQUEST['act']=='video_ok'){
		if (copy(PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4", PATH_VIDEOS.$_REQUEST['f'].".mp4")){
			copy(PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4.jpg", PATH_VIDEOS.$_REQUEST['f'].".mp4.jpg");
			//unlink (PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4");
			unlink (PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4.jpg");
			//unlink (PATH_VIDEOS_TEMP.$_REQUEST['f']);
			$videos->cambiarEstado($_REQUEST['id'],1);
			$videos->cambiarNombre($_REQUEST['id']);
			$users->sumarPuntos($_REQUEST['u'], PUNTOS_VIDEO, PUNTOS_VIDEO_MOTIVO);
		}
		else ErrorMsg("No se ha podido validar el video.");
	}
	elseif ($_REQUEST['act'] == 'video_conv') $videos->convertirVideo($_REQUEST['f'], PATH_VIDEOS_TEMP, PATH_VIDEOS_CONVERT);
	elseif ($_REQUEST['act'] == 'video_ko'){
		unlink (PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4");
		unlink (PATH_VIDEOS_CONVERT.$_REQUEST['f'].".mp4.jpg");
		unlink (PATH_VIDEOS_TEMP.$_REQUEST['f']);
		$videos->cambiarEstado($_REQUEST['id'], 2);
	}

	header("Location: admin-validacion-videos"); 
}

$videos = new videos();
$pendientes = $videos->getVideos(" AND estado=0 AND id_promocion=0 ");?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Videos"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Video_validation"), "ItemClass"=>"active"),
		));
		?>
		<ul class="nav nav-pills navbar-default">
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo count($pendientes);?></b> <?php echo strtolower(strTranslate("Items"));?>. <?php echo ucfirst(strTranslate("APP_points"));?> a otorgar por video: <b><?php echo PUNTOS_VIDEO;?></b></a></li>
		</ul>
		<?php foreach($pendientes as $element):
			$convertido = ((file_exists(PATH_VIDEOS_CONVERT.$element['name_file'].'.mp4')) ? true : false);
			echo '<div class="col-md-4"><br />';
			if ($convertido==true) playVideo("VideoConvertido".$element['id_file'], PATH_VIDEOS_CONVERT.$element['name_file'].'.mp4', 165, 100);
			else playVideo("VideoPendiente".$element['id_file'], PATH_VIDEOS_TEMP.$element['name_file'], 165, 100);
		
			if ($convertido == true){
				echo '	<a class="" href="#" onClick="Confirma(\'¿Seguro que desea validar el vídeo?\',
						\'admin-validacion-videos?act=video_ok&id='.$element['id_file'].'&f='.$element['name_file'].'&u='.$element['user_add'].'\'); return false" 
						title="validar video" /><span><i class="fa fa-check"></i> validar video</span></a> - 
						
						<a class="" href="#" onClick="Confirma(\''.strTranslate("Are_you_sure_to_delete").'?\',
						\'admin-validacion-videos?act=video_ko&id='.$element['id_file'].'&u='.$element['user_add'].'\'); return false;" 
						title="eliminar video" /><i class="fa fa-can"></i> eliminar</a>';
			}
			else{
				echo '<a class="" href="#" 
						onClick="Confirma(\'¿Seguro que desea convertir el vídeo?, el proceso puede durar varios minutos.\', 
						\'admin-validacion-videos?act=video_conv&id='.$element['id_file'].'&f='.$element['name_file'].'&u='.$element['user_add'].'\'); return false;" 
						title="convertir video" /><i class="fa fa-video-camera"></i> convertir</a>';
			}
			echo ' - <a class="" href="admin-validacion-videos?exp='.$element['name_file'].'" title="descargar vídeo"><i class="fa fa-download"></i> descargar</a>';
			echo '<div class="video-content">';
			echo '	</div>
					<div class="video-info">
						<small>'.$element['titulo'].'<br />
						'.$element['user_add'].' - '.$element['canal_file'].' - 
						<span class="text-muted">'.getDateFormat($element['date_video'], "SHORT").'</span>
						</small>
					</div>';
			echo '</div>';
		endforeach;?>
	</div>
	<?php menu::adminMenu();?>
</div>