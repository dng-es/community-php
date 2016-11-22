<?php
templateload("player","videos");

addJavascripts(array("js/libs/jwplayer/jwplayer.js", getAsset("videos")."js/admin-validacion-videos.js"));

videosController::downloadZipFile();

$videos = new videos();
//$pendientes = $videos->getVideos(" AND estado=0 AND id_promocion=0 ");
$pendientes = $videos->getVideos(" AND estado=0 ");?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Videos"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Video_validation"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		videosController::adminActions();
		?>
		<ul class="nav nav-pills navbar-default">
			<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo count($pendientes);?></b> <?php echo strtolower(strTranslate("Items"));?>. <?php echo ucfirst(strTranslate("APP_points"));?> a otorgar por video: <b><?php echo PUNTOS_VIDEO;?></b></a></li>
		</ul>
		<?php foreach($pendientes as $element):
			$convertido = ((file_exists(PATH_VIDEOS_CONVERT.$element['name_file'].'.mp4')) ? true : false);
			echo '<div class="col-md-4"><br />';
			if ($convertido==true) playVideo("VideoConvertido".$element['id_file'], PATH_VIDEOS_CONVERT.$element['name_file'].'.mp4', 165, 100);
			else playVideo("VideoPendiente".$element['id_file'], PATH_VIDEOS_TEMP.$element['name_file'], 165, 100);
		
			if ($convertido == true){
				echo '	<a class="trigger-validar" href="#" data-id="'.$element['id_file'].'" data-f="'.$element['name_file'].'" data-u="'.$element['user_add'].'" title="validar video" /><span><i class="fa fa-check"></i> validar video</span></a> - 
						
						<a class="" href="#" onClick="Confirma(\''.strTranslate("Are_you_sure_to_delete").'?\',
						\'admin-validacion-videos?act=video_ko&id='.$element['id_file'].'&u='.$element['user_add'].'\'); return false;" 
						title="eliminar video" /><i class="fa fa-can"></i> eliminar</a>';
				echo '<input type="text" name="tipo_video" id="tipo_video_'.$element['id_file'].'" class="form-control" value="'.$element['tipo_video'].'" />';
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