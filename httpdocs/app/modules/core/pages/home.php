<?php

addJavascripts(array(getAsset("muro")."js/muro-comentario-ajax.js", 
					 getAsset("core")."js/home.js",
					 getAsset("alerts")."js/alerts.js"));


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
			<div class="col-md-6">
				<div class="col-md-12 section panel panel-default">
					<?php panelNovedades();?>
				</div>
				<div class="col-md-12 section panel panel-default">
					<?php panelAreas();?>
				</div>

				<div class="col-md-12 section panel panel-default">
					<?php panelDestacado();?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12 section panel panel-default">
						<?php panelBlog();?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 section panel panel-default">
						<?php panelForos();?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12 section panel pane-default">
						<?php panelFotos();?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12 section panel panel-default">
						<?php panelVideos();?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="app-sidebar">
		<?php panelAlerts();?>
		<?php panelMuro();?>
	</div>
</div>