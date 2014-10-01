<?php

addJavascripts(array(getAsset("muro")."js/muro-comentario-ajax.js", 
					 getAsset("users")."js/users-conn-ajax.js", 
					 getAsset("core")."js/home.js"));

templateload("reply","muro");
templateload("show","novedades");

//usuarios conectados
$filtroCanal= ($_SESSION['user_canal']!="admin" ? " AND (connection_canal='".$_SESSION['user_canal']."' or connection_canal='admin' or connection_canal='formador') " : "");
$users = new users();
$users_conn = count($users->getUsersConn($filtroCanal));

$last_photo = fotosController::getListAction(1, " ORDER BY id_file DESC ");
$last_video = videosController::getListAction(1, "");
$last_foros = foroController::getLastTemasAction(5);
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
		<div class="row">
			<div class="col-md-4">
				<section>
					<h3><?php echo strTranslate("Last_photos");?></h3>
					<div class="video-preview-container">
						<a href="?page=fotos"><img class="video-preview" src="<?php echo PATH_FOTOS.$last_photo['items'][0]['name_file'];?>" /></a>
						<div>
							<a href="?page=fotos"><?php echo $last_photo['items'][0]['titulo'];?></a><br />
							<span><?php echo dateLong($last_photo['items'][0]['date_foto']);?></span><br />
							<?php echo $last_photo['items'][0]['nick'];?>
						</div>
					</div>
				</section>
			</div>
			<div class="col-md-4">
				<section>
					<h3><?php echo strTranslate("Last_videos");?></h3>
					<div class="video-preview-container">
						<a href="?page=video&id=<?php echo $last_video['items'][0]['id_file'];?>"><img class="video-preview" src="<?php echo PATH_VIDEOS.$last_video['items'][0]['name_file'].'.jpg';?>" /></a>
						<div>
							<a href="?page=video&id=<?php echo $last_video['items'][0]['id_file'];?>"><?php echo $last_video['items'][0]['titulo'];?></a><br />
							<span><?php echo dateLong($last_video['items'][0]['date_video']);?></span><br />
							<?php echo $last_video['items'][0]['nick'];?>
						</div>
					</div>
				</section>
			</div>
			<div class="col-md-4">
				<section>
					<h3><?php echo strTranslate("Last_formus");?></h3>
					<ul>
					<?php foreach($last_foros as $last_foro): ?>
						<?php $foro_tema = foroController::getItemTemaAction($last_foro['id_tema']);?>
						<li><a href="?page=foro-comentarios&id=<?php echo $foro_tema[0]['id_tema'];?>"><?php echo $foro_tema[0]['nombre'];?></a></li>
					<?php endforeach; ?>
					</ul>
				</section>
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