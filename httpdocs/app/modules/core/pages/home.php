<?php

addJavascripts(array(getAsset("muro")."js/muro-comentario-ajax.js", 
					 getAsset("core")."js/home.js",
					 getAsset("alerts")."js/alerts.js",
					 getAsset("novedades")."js/show.js"));


templateload("panels", "alerts");
templateload("panels", "blog");
templateload("panels", "destacados");
templateload("panels", "foro");
templateload("panels", "fotos");
templateload("panels", "muro");
templateload("panels", "na_areas");
templateload("panels", "novedades");
templateload("panels", "users");
templateload("panels", "videos");
templateload("panels", "incentivos");

$filtro_perfil = incentivosObjetivosController::getFiltroPerfil($_SESSION['user_perfil']);
$filtro_canal = (($_SESSION['user_canal'] == 'admin' or $_SESSION['user_canal'] == '') ? "" : " AND (canal_objetivo='' OR canal_objetivo='".$_SESSION['user_canal']."') ");


$rankings = incentivosObjetivosController::getListAction(99, $filtro_perfil.$filtro_canal." AND activo_objetivo=1 AND ranking_objetivo=1 ");

?>
<div class="row row-top">
	<div class="app-main">
		<div class="row">
			<div class="col-md-6">
				<?php panelUser();?>
			</div>
			<div class="col-md-6">
				<?php panelConnected();?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<?php panelNovedades();?>

				<?php foreach($rankings['items'] as $ranking):?>
					<?php panelRanking($ranking['id_objetivo']);?>
				<?php endforeach;?>

			</div>
			<div class="col-md-4">
				<?php panelDestacado();?>
				<?php panelBlog();?>
				<?php panelFotos();?>
				<?php panelVideos();?>
				<?php panelAreas();?>	
				<?php panelForos();?>
			</div>
		</div>
	</div>
	<div class="app-sidebar">
		<?php panelAlerts();?>
		<?php panelMuro();?>
	</div>
</div>

<?php popupNovedades();?>