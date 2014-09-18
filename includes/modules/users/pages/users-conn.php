<?php
addJavascripts(array(getAsset("users")."js/users-conn.js"));
?>
<div class="row">
	<div class="col-md-12">
		<div class="inset">
			<h2><?php echo strTranslate("Users_connected");?></h2>
	  		<p>Descubre qué usuarios están en este mismo momento en la comunidad.</p>
	  		<div id="mensajes">
			<div class="mensaje"><div id="cargando"><i class="fa fa-spinner fa-spin ajax-load"></i></div></div>
			</div>
		</div>
	</div>
</div>
