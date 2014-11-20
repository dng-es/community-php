<?php
addJavascripts(array(getAsset("users")."js/users-conn.js"));

//usuarios conectados
$filtroCanal= ($_SESSION['user_canal']!="admin" ? " AND (connection_canal='".$_SESSION['user_canal']."' or connection_canal='admin' or connection_canal='formador') " : "");
$users = new users();
$users_conn = count($users->getUsersConn($filtroCanal));

?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<ol class="breadcrumb">
			<li><a href="?page=home"><?php echo strTranslate("Home");?></a></li>
			<li class="active"><?php echo strTranslate("Users_connected");?></li>
		</ol>
		<div class="inset">
	  		<p>Descubre qué usuarios están en este mismo momento en la comunidad.</p>
	  		<div id="mensajes">
			<div class="mensaje"><div id="cargando"><i class="fa fa-spinner fa-spin ajax-load"></i></div></div>
			</div>
		</div>
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
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
