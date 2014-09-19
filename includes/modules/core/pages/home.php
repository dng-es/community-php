<?php

addJavascripts(array(getAsset("muro")."js/muro-comentario-ajax.js", 
					 getAsset("users")."js/users-conn-ajax.js", 
					 getAsset("core")."js/home.js"));

templateload("reply","muro");
templateload("show","novedades");

//usuarios conectados
$filtroCanal= ($_SESSION['user_canal']!="admin" ? " AND (connection_canal='".$_SESSION['user_canal']."' or connection_canal='admin' or connection_canal='formador') " : "");
$users_conn = count(users::getUsersConn($filtroCanal));

?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<p class="text-muted"><?php echo $_SESSION['name'];?>, bienvenid@ a la comunidad. <a href="?page=users-conn">[<?php echo strTranslate("Users_connected").": ".$users_conn;?>]</a></p>
		<hr />
		<div class="row">
			<div class="col-md-12">
				<?php showNovedades();?>
			</div>
		</div>
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div id="muro-insert">
			<form id="muro-form" name="coment-form" action="" method="post" role="form">
				<input type="hidden" name="tipo_muro" id ="tipo_muro" value="principal" />   
				<h4><?php echo strTranslate("New_comment_on_wall");?></h4>
				<textarea maxlength="160" class="form-control" id="texto-comentario" name="texto-comentario"></textarea>
				<?php if ($_SESSION['user_perfil']=='admin' or $_SESSION['user_perfil']=='formador'):?>
				<select name="canal_comentario" id="canal_comentario" class="form-control">
				<?php ComboCanales();?>
				</select>
				<?php endif;?>
				<button class="btn btn-primary btn-block" type="button" id="muro-submit" name="coment-submit"><?php echo strTranslate("Send");?></button>
			</form>
		</div>
		<div id="result-muro"></div>
		<div id="destino" class="panel-muro">
				<div id="cargando" style="display:none"><i class="fa fa-spinner fa-spin ajax-load"></i></div>
		</div>
		<?php replyMuro();?>
	</div>
</div>
