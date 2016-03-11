<?php

addJavascripts(array(getAsset("muro")."js/muro-comentario-ajax.js", 
					 getAsset("core")."js/home.js",
					 getAsset("alerts")."js/alerts.js"));

templateload("reply", "muro");
templateload("show", "novedades");
templateload("panels", "destacados");
templateload("panels", "na_areas");
templateload("panels", "blog");
templateload("panels", "fotos");
templateload("panels", "foro");
templateload("panels", "videos");

//usuarios conectados
$filtroCanal = ($_SESSION['user_canal'] != "admin" ? " AND (connection_canal='".$_SESSION['user_canal']."' or connection_canal='admin') " : "");
$users = new users();
$users_conn = count($users->getUsersConn($filtroCanal));


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
									<?php e_strTranslate("Hello");?> <?php echo $_SESSION['user_nick'];?>
								</h4>
								<small><?php e_strTranslate("Wellcome_to");?> <?php echo $ini_conf['SiteName'];?>.</small>
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
								<small><?php e_strTranslate("Go_to");?> <a href="users-conn"><?php e_strTranslate("Users_connected");?></a></small>
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