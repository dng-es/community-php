<?php
addJavascripts(array(getAsset("muro")."js/muro-comentario-ajax.js", 
					 getAsset("core")."js/home.js",
					 getAsset("novedades")."js/show.js"));

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
templateload("panels", "agenda");
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
				<div class="col-md-6 nopadding">
					<?php panelAreas();?>
				</div>
				
				<div class="col-md-6">
					<?php panelForos();?>
				</div>

				<div class="col-md-12 nopadding">
					<?php panelRankings();?>
				</div>
			</div>
			<div class="col-md-4">
				<?php panelDestacado();?>
				<?php panelBlog();?>
				<?php panelFotos();?>
				<?php panelVideos();?>
				<?php panelNovedadesBanner();?>
			</div>
		</div>
	</div>
	<div class="app-sidebar">
		<br />
		<?php get_hooks('sidebar');?>
		<?php panelMuro();?>
		<?php panelAgenda();?>
	</div>
</div>
<?php popupNovedades();?>