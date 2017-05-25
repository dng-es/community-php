<?php
addJavascripts(array(getAsset("muro")."js/muro-comentario-ajax.js", 
					 getAsset("core")."js/home.js",
					 getAsset("users")."js/searchuser.js",
					 getAsset("novedades")."js/show.js"));

templateload("panels", "blog");
templateload("panels", "fotos");
templateload("panels", "muro");
templateload("panels", "novedades");
templateload("panels", "videos");
templateload("searchuser", "users");
?>
<div class="row row-top">
	<div class="app-sidebar">
		<br />
		<div class="col-md-12">
			<?php panelSearchUser(false);?>
		</div>
		<br />
		<br />
		<?php panelMuro();?>
	</div>
	<div class="app-main">
		<div class="row">
			<div class="col-md-12">
				<?php panelNovedades();?>
				
				<div class="col-md-4 nopadding">
					<?php panelBlog();?>
				</div>

				<div class="col-md-4 ">
					<?php panelFotos();?>
				</div>

				<div class="col-md-4 nopadding">
					<?php panelVideos();?>
				</div>
			</div>
		</div>
	</div>	
</div>
<?php popupNovedades();?>