<?php

addJavascripts(array(getAsset("muro")."js/muro-comentario-ajax.js", 
					 getAsset("core")."js/home.js",
					 getAsset("users")."js/groupmessages.js"));

templateload("reply", "muro");
templateload("show", "novedades");
templateload("panels", "destacados");
templateload("cmbCanales", "users");

//usuarios conectados
$filtroCanal = ($_SESSION['user_canal'] != "admin" ? " AND (connection_canal='".$_SESSION['user_canal']."' or connection_canal='admin') " : "");
$users = new users();
$users_conn = count($users->getUsersConn($filtroCanal));

$last_photo = fotosController::getListAction(1, " AND estado=1 ORDER BY id_file DESC ");
$last_video = videosController::getListAction(1, " AND estado=1 ");
$last_foros = foroController::getLastTemasAction(4, " AND t.id_area=0 AND ocio=0 ");

$filtro_blog = ($_SESSION['user_canal'] == 'admin' ? "" : " AND (canal='".$_SESSION['user_canal']."' OR canal='todos') ");
$last_blog = foroController::getListTemasAction(1, $filtro_blog." AND ocio=1 AND activo=1 AND id_tema_parent=0 ORDER BY id_tema DESC ");
?>
<div class="row row-top">
	<div class="app-main">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default panel-ranking">
					<div class="panel-body nopadding">
						<div class="row">
							<div class="col-md-8 inset">
								<h4>
									<?php echo $_SESSION['user_nick'];?>
								</h4>
								<?php e_strTranslate("Wellcome_to");?> <?php echo $ini_conf['SiteName'];?>.
							</div>
							<div class="col-md-4 label-success inset panel-color">
								<p class="text-center"><big><?php echo $_SESSION['user_puntos'];?></big><br />
									<?php echo ucfirst(strTranslate("APP_points"));?>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default panel-ranking">
					<div class="panel-body nopadding">
						<div class="row">
							<div class="col-md-8 inset">
								<h4>
									<?php e_strTranslate("Users_connected");?>
								</h4>
								<?php e_strTranslate("Go_to");?> <a href="users-conn"><?php e_strTranslate("Users_connected");?></a>
							</div>
							<div class="col-md-4 label-info inset panel-color">
								<p class="text-center"><big><?php echo $users_conn;?></big><br />
									<?php e_strTranslate(($users_conn > 1 ? "Users" : "User"));?>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<?php showNovedades();?>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12 section panel panel-default">
						<h3><?php e_strTranslate("Last_blog");?></h3>
						<?php if (isset($last_blog['items'][0])): ?>
						<div class="media-preview-container">
							<a href="blog"><?php echo $last_blog['items'][0]['nombre'];?></a><br />
							<span class="text-muted"><small><?php echo ucfirst(getDateFormat($last_blog['items'][0]['date_tema'], "LONG"));?></small></span>
							<p><?php echo blogController::get_resume($last_blog['items'][0]['descripcion']);?></p>
						</div>
						<?php else: ?>
							<div class="text-muted">Todavía no se han creado entradas</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 section full-height panel panel-default">
						<h3><?php e_strTranslate("Last_formus");?></h3>
						<p><?php e_strTranslate("Discover_last_formus");?>.</p>
						<ul class="list-funny">
						<?php foreach($last_foros as $last_foro): ?>
							<?php $foro_tema = foroController::getItemTemaAction($last_foro['id_tema']);?>
							<li class="ellipsis"><a href="foro-comentarios?id=<?php echo $foro_tema[0]['id_tema'];?>"><?php echo $foro_tema[0]['nombre'];?></a></li>
						<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="row">
						<div class="col-md-4 section full-height">
							<h3><?php e_strTranslate("Last_photos");?></h3>
							<?php if (isset($last_photo['items'][0])): ?>
							<div class="media-preview-container">
								<a href="fotos"><img class="media-preview" src="<?php echo PATH_FOTOS.$last_photo['items'][0]['name_file'];?>" alt="<?php echo prepareString($last_photo['items'][0]['titulo']);?>" /></a>
								<div>
									<a href="fotos"><?php echo $last_photo['items'][0]['titulo'];?></a><br />
									<?php echo $last_photo['items'][0]['nick'];?><br />
									<span><small><?php echo ucfirst(getDateFormat($last_photo['items'][0]['date_foto'], "LONG"));?></small></span><br />
								</div>
							</div>
							<?php else: ?>
								<div class="text-muted">Todavía no se han subido fotos</div>
							<?php endif; ?>
						</div>
						<div class="col-md-4 section full-height">
							<h3><?php e_strTranslate("Last_videos");?></h3>
							<?php if (isset($last_video['items'][0])): ?>
							<div class="media-preview-container">
								<a href="videos">
								<img class="media-preview" src="<?php echo PATH_VIDEOS.$last_video['items'][0]['name_file'].'.jpg';?>" alt="<?php echo prepareString($last_video['items'][0]['titulo']);?>" /></a>
								<div>
									<a href="videos"><?php echo $last_video['items'][0]['titulo'];?></a><br />
									<?php echo $last_video['items'][0]['nick'];?><br />
									<small><span><?php echo ucfirst(getDateFormat($last_video['items'][0]['date_video'], "LONG"));?></small></span><br />
								</div>
							</div>
							<?php else: ?>
								<div class="text-muted"><?php e_strTranslate("No_video_uploads");?></div>
							<?php endif; ?>
						</div>
						<div class="col-md-4 section full-height">
							<h3><?php e_strTranslate("Highlights");?></h3>
							<?php PanelLastDestacado();?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="app-sidebar">
		<div id="destinoGroupMessages">
			<div id="cargandoGroupMessages" style="display:none"><i class="fa fa-spinner fa-spin"></i></div>
		</div>
		<div id="muro-insert">
			<form id="muro-form" name="coment-form" action="" method="post" role="form">
				<input type="hidden" name="tipo_muro" id ="tipo_muro" value="principal" />   
				<h4>
					<span class="fa-stack fa-sx">
						<i class="fa fa-circle fa-stack-2x"></i>
						<i class="fa fa-comment fa-stack-1x fa-inverse"></i>
					</span>
					<?php e_strTranslate("New_comment_on_wall");?>
				</h4>
				<textarea maxlength="160" class="form-control" id="texto-comentario" name="texto-comentario"></textarea>
				<?php if ($_SESSION['user_canal'] == 'admin'):?>
				<select name="canal_comentario" id="canal_comentario" class="form-control">
				<?php ComboCanales();?>
				</select>
				<?php endif;?>
				<button class="btn btn-primary btn-block" type="button" id="muro-submit" name="coment-submit"><?php e_strTranslate("Send");?></button>
			</form>
		</div>
		<div id="result-muro"></div>
		<div id="destino" class="panel-muro">
				<div id="cargando" style="display:none"><i class="fa fa-spinner fa-spin ajax-load"></i></div>
		</div>
		<?php replyMuro();?>
	</div>
</div>