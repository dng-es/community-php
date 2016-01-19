<?php
templateload("gallery","videos");
templateload("addfile","videos");
//templateload("addcomment","videos");
//templateload("comment","videos");

templateload("gallery","fotos");
templateload("addfile","fotos");

templateload("comment","muro");
templateload("addcomment","muro");

addJavascripts(array("js/jquery.jtextarea.js", 
					"js/bootstrap.file-input.js", 
					"js/libs/jwplayer/jwplayer.js", 
					"js/jquery.geturlparam.js",
					getAsset("videos")."js/videos.js",
					getAsset("fotos")."js/fotos.js",
					getAsset("promociones")."js/reto.js"));

$filtro_promocion = " AND active=1 ";
?>

<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Blog"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		videosController::voteAction();
		videosController::createAction();
		muroController::createAction();
		fotosController::voteAction();
		fotosController::createAction();

		$promocion = promocionesController::getLastPromocionAction($filtro_promocion);
		$id_promocion = $promocion['id_promocion'];



		if (isset($id_promocion) and $id_promocion != ""){ ?>
			<div class="panel panel-default panel-blog">
				<div class="panel-body">
					<div class="panel-blog-header">
						<h2><?php echo $promocion['nombre_promocion'];?></h2>
					</div>
					<p><?php echo $promocion['texto_promocion'];?></p>
				</div>
			</div>
			<?php

			//mostrar videos subidos por los administradores
			$videos_admin = videosController::getListAction(100, " AND estado=1 AND u.perfil='admin' AND id_promocion=".$id_promocion." ");
			if (count($videos_admin['items']) > 0): ?>
				<div class="panel panel-default">
					<div class="panel-body">
						<h3>Videos de apoyo</h3>
						<?php foreach($videos_admin['items'] as $video):
							echo '<div class="col-md-3"><div class="media-preview-container">
								<a href="videos?id='.$video['id_file'].'&pag='.$pagina_sig.'">
								<img src="'.PATH_VIDEOS.$video['name_file'].'.jpg" class="media-preview" alt="'.prepareString($video['titulo']).'" /></a>
								<div><a href="videos?id='.$video['id_file'].'&pag='.$pagina_sig.'">'.$video['titulo'].'</a><br />
									 '.$video['nick'].'<br />
									 <span><small>'.getDateFormat($video['date_video'], "LONG").'</small></span>
								</div>
							</div></div>';
						endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php 
			//mostrar vídeos subidos por los usuarios
			if ($promocion['galeria_videos'] ==1): 
				$videos = videosController::getListAction(100, " AND estado=1 AND u.perfil<>'admin' AND id_promocion=".$id_promocion." ");
				?>
				<div class="panel panel-default">
					<div class="panel-body">
						<h3>Vídeos subidos por los usuarios</h3>
						<?php if (count($videos['items']) > 0): ?>
						<?php foreach($videos['items'] as $video):
							echo '<div class="col-md-3"><div class="media-preview-container">
								<a href="videos?id='.$video['id_file'].'&pag='.$pagina_sig.'">
								<img src="'.PATH_VIDEOS.$video['name_file'].'.jpg" class="media-preview" alt="'.prepareString($video['titulo']).'" /></a>
								<div><a href="videos?id='.$video['id_file'].'&pag='.$pagina_sig.'">'.$video['titulo'].'</a><br />
									 '.$video['nick'].'<br />
									 <span><small>'.getDateFormat($video['date_video'], "LONG").'</small></span>
								</div>
							</div></div>';
						endforeach; ?>
						<?php else: ?>
							<div class="alert alert-info">Los usuarios todavia no han subido contenidos</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php 
			//mostrar fotos subidos por los usuarios
			if ($promocion['galeria_fotos'] ==1): 
				$videos = videosController::getListAction(10, " AND estado=1 AND u.perfil<>'admin' AND id_promocion=".$id_promocion." ");
				?>
				<div class="panel panel-default">
					<div class="panel-body">
						<h3>Fotos subidas por los usuarios</h3>
						
						<section id="photos">

						</section>
						<div id="cargando-infinnite"><span class="btn btn-default"><?php e_strTranslate("More_photos");?> <i class="fa fa-arrow-circle-down"></i></span></div>
						<div id="cargando-infinnite-end"><span class="btn btn-default alert-info"><?php e_strTranslate("No_more_photos");?> <i class="fa fa-info-circle"></i></span></div>
						<div class="clearfix"></div>
					</div>
				</div>	
			<?php endif; ?>

			<?php 
			//mostrar comentarios subidos por los usuarios
			if ($promocion['galeria_comentarios'] ==1): 
				$muro = new muro();
				$comentarios = $muro->getComentarios(" AND tipo_muro='".$id_promocion."' AND estado=1 ORDER BY date_comentario DESC ");
				if (count($comentarios) > 0): ?>
				<div class="panel panel-default">
					<div class="panel-body">
						<h3>Respuestas subidas por los usuarios</h3>
						<div id="responder-form" style="height: 40px; display:none"></div>
						<?php 
						foreach($comentarios as $comentario):
							commentMuro2($comentario);
						endforeach; ?>
					</div>
				</div>
				<?php else: ?>
					<div class="alert alert-info">Los usuarios todavia no han subido contenidos</div>
				<?php endif; ?>
			<?php endif; ?>

		<?php } ?>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior full-height">
			<?php if ($promocion['galeria_videos'] ==1 or $_SESSION['user_perfil'] == 'admin') PanelSubirVideo($promocion['id_promocion']);?>
			<?php if ($promocion['galeria_fotos'] ==1) PanelSubirFoto($promocion['id_promocion']);?>
			<?php if ($promocion['galeria_comentarios'] ==1) addComment($promocion['id_promocion'], false, "Enviar respuesta");?>
			<br />
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal modal-wide fade" id="fotosModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"><?php e_strTranslate("Photos");?></h4>
			</div>
			<div class="modal-body"></div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->