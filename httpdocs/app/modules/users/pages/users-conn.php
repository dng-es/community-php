<?php
addJavascripts(array(getAsset("users")."js/users-conn.js"));

//usuarios conectados
$filtroCanal= ($_SESSION['user_canal'] != "admin" ? " AND (connection_canal='".$_SESSION['user_canal']."' or connection_canal='admin') " : "");
$users = new users();
$users_conn = count($users->getUsersConn($filtroCanal));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Users_connected"), "ItemClass"=>"active"),
		));
		?>
		<div class="inset">
	  		<h4>Descubre qué usuarios están en este mismo momento en la comunidad.</h4>
	  		<p class="hidden-md hidden-lg">Ahora mismo hay <strong><?php echo $users_conn;?></strong> usuarios conectados.<br /></p>
			<div id="mensajes">
				<div class="mensaje">
					<div id="cargando"><i class="fa fa-spinner fa-spin ajax-load"></i></div>
				</div>
			</div>
		</div>
	</div>
	<div class="app-sidebar hidden-xs hidden-sn">
		<div class="panel-interior">
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-plug fa-stack-1x fa-inverse"></i>
				</span>
				<?php echo strTranslate("Users_connected");?>
			</h4>
			<p>Ahora mismo hay <strong><?php echo $users_conn;?></strong> usuarios conectados.</p>
			<p class="text-muted">Haciendo click sobre el usuario le puedes mandar un mensaje.</p>
		</div>	
	</div>
</div>