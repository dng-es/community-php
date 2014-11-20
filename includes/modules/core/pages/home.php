<?php

addJavascripts(array(getAsset("muro")."js/muro-comentario-ajax.js", 
					 getAsset("core")."js/home.js"));

templateload("reply","muro");
templateload("show","novedades");
templateload("panels","destacados");

//usuarios conectados
$filtroCanal= ($_SESSION['user_canal']!="admin" ? " AND (connection_canal='".$_SESSION['user_canal']."' or connection_canal='admin' or connection_canal='formador') " : "");
$users = new users();
$users_conn = count($users->getUsersConn($filtroCanal));

$last_photo = fotosController::getListAction(1, " ORDER BY id_file DESC ");
$last_video = videosController::getListAction(1, "");
$last_foros = foroController::getLastTemasAction(4, " AND t.id_area=0 AND ocio=0 ");
$last_blog = foroController::getListTemasAction(1, " AND ocio=1 AND activo=1 AND id_tema_parent=0 ORDER BY id_tema DESC ");
?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<div class="row">
		<div class="col-md-12">
		<p class="text-muted">
			<span class="fa-stack fa-lg">
				<i class="fa fa-circle fa-stack-2x"></i>
				<i class="fa fa-plug fa-stack-1x fa-inverse"></i>
			</span>
			<?php echo $_SESSION['name'];?>, <?php echo strTranslate("Wellcome_to");?> <?php echo $ini_conf['SiteName'];?>. <a href="?page=users-conn">[<?php echo strTranslate("Users_connected").": ".$users_conn;?>]</a>
		</p>
		</div>
		</div>
		<div class="row">
			<div class="col-md-5">
				<?php showNovedades();?>
			</div>
			<div class="col-md-7">
				<div class="row">
					<div class="col-md-12 section">
						<section>
							<h3><?php echo strTranslate("Highlights");?></h3>
							<?php PanelLastDestacado();?>
						</section>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-md-12 section full-height">
						<section>
							<h3><?php echo strTranslate("Last_formus");?></h3>
							<p>Descubre los últimos foros en los que los usuarios han participado.</p>
							<ul class="list-funny">
							<?php foreach($last_foros as $last_foro): ?>
								<?php $foro_tema = foroController::getItemTemaAction($last_foro['id_tema']);?>
								<li class="ellipsis"><a href="?page=foro-comentarios&id=<?php echo $foro_tema[0]['id_tema'];?>"><?php echo $foro_tema[0]['nombre'];?></a></li>
							<?php endforeach; ?>
							</ul>
						</section>
					</div>
				</div>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-4 ">
				<div class="col-md-12 section full-height">
					<section>
						<h3><?php echo strTranslate("Last_photos");?></h3>
						<div class="media-preview-container">
							<a href="?page=fotos"><img class="media-preview" src="<?php echo PATH_FOTOS.$last_photo['items'][0]['name_file'];?>" alt="<?php echo $last_photo['items'][0]['titulo'];?>" /></a>
							<div>
								<a href="?page=fotos"><?php echo $last_photo['items'][0]['titulo'];?></a><br />
								<span><?php echo $last_photo['items'][0]['nick'];?> - <?php echo getDateFormat($last_photo['items'][0]['date_foto'], "LONG");?></span><br />
							</div>
						</div>
					</section>
				</div>
			</div>
			<div class="col-md-4">
				<div class="col-md-12 section full-height">
					<section>
						<h3><?php echo strTranslate("Last_videos");?></h3>
						<div class="media-preview-container">
							<a href="?page=video&id=<?php echo $last_video['items'][0]['id_file'];?>">
							<img class="media-preview" src="<?php echo PATH_VIDEOS.$last_video['items'][0]['name_file'].'.jpg';?>" alt="<?php echo $last_video['items'][0]['titulo'];?>" /></a>
							<div>
								<a href="?page=video&id=<?php echo $last_video['items'][0]['id_file'];?>"><?php echo $last_video['items'][0]['titulo'];?></a><br />
								<span><?php echo $last_video['items'][0]['nick'];?> - <?php echo getDateFormat($last_video['items'][0]['date_video'], "LONG");?></span><br />
							</div>
						</div>
					</section>
				</div>
			</div>			
			<div class="col-md-4">
				<div class="col-md-12 section full-height">
					<section>
						<h3><?php echo strTranslate("Last_blog");?></h3>
						<div class="media-preview-container">
							<a href="?page=blog&id=<?php echo $last_blog['items'][0]['id_tema'];?>">
							<img class="media-preview" src="images/foro/<?php echo $last_blog['items'][0]['imagen_tema'];?>" alt="<?php echo $last_blog['items'][0]['nombre'];?>" /></a>
							<div>
								<a href="?page=blog&id=<?php echo $last_blog['items'][0]['id_tema'];?>"><?php echo $last_blog['items'][0]['nombre'];?></a><br />
								<span><?php echo getDateFormat($last_blog['items'][0]['date_tema'], "LONG");?></span>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div id="muro-insert">
			<form id="muro-form" name="coment-form" action="" method="post" role="form">
				<input type="hidden" name="tipo_muro" id ="tipo_muro" value="principal" />   
				<h4>
					<span class="fa-stack fa-sx">
						<i class="fa fa-circle fa-stack-2x"></i>
						<i class="fa fa-comment fa-stack-1x fa-inverse"></i>
					</span>
					<?php echo strTranslate("New_comment_on_wall");?>
				</h4>
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