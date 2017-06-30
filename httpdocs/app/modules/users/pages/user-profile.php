<?php
addCss(array("css/bootstrap-datetimepicker.min.css"));
templateload("addmessage", "mensajes");
templateload("tipuser", "users");

addJavascripts(array(getAsset("mensajes")."js/inbox.js", 
					 getAsset("users")."js/user-profile.js",
					 "js/bootstrap.file-input.js", 
					 "js/jquery.geturlparam.js", 
					 getAsset("fotos")."js/fotos.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("User_profile"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		mensajesController::createAction();
		//$filter = ($_SESSION['user_canal'] != "admin" ? " AND (canal='".$_SESSION['user_canal']."' OR canal='admin') " : "");
		$filter = '';
		$nick = (isset($_REQUEST['n']) ? $_REQUEST['n'] : "");
		$usuario = usersController::getPublicPerfilAction($nick, $filter);

		?>
		<!-- Nav tabs -->
		<ul class="nav nav-tabs">
			<li <?php echo (!(isset($_GET['t'])) ? ' class="active"' : '');?>><a href="#general" data-toggle="tab"><?php e_strTranslate("Main_data");?></a></li>
			<?php if(getModuleExist("fotos")): ?>
			<li <?php echo ((isset($_GET['t']) && $_GET['t'] == 2) ? ' class="active"' : '');?>><a href="#fotos" data-toggle="tab"><?php e_strTranslate("Photos");?></a></li>
			<?php endif; ?>
			<?php if(getModuleExist("videos")): ?>
			
			<li <?php echo ((isset($_GET['t']) && $_GET['t'] == 3) ? ' class="active"' : '');?>><a href="#videos" data-toggle="tab"><?php e_strTranslate("Videos");?></a></li>
			<?php endif; ?>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade in <?php echo (!(isset($_GET['t'])) ? ' active' : '');?>" id="general">
				<div class="row inset"> 
					<div class="col-md-12">
						<?php if (isset($usuario->username)): ?>
						<div class="row">
							<div class="form-group col-md-12">
								<label class="control-label" for="user-empresa"><small><?php e_strTranslate("Group_user");?></small></label>
								<input type="text" name="user-empresa" id="user-empresa" class="form-control" disabled="disabled" value="<?php echo $usuario->nombre_tienda;?>" />
							</div>
						</div>	
						<div class="row">
							<div class="form-group col-md-4">
								<label class="control-label" for="user-nick"><small><?php e_strTranslate("Nick");?></small></label>
								<input maxlength="100" name="user-nick" id="user-nick" type="text" class="form-control" disabled="disabled" value="<?php echo $usuario->nick;?>" />
							</div>
							<div class="form-group col-md-4">
								<label class="control-label" for="user-nombre"><small><?php e_strTranslate("Name");?></small></label>
								<input maxlength="100" name="user-nombre" id="user-nombre" type="text" class="form-control" disabled="disabled" value="<?php echo $usuario->name;?>" />
							</div>
							<div class="form-group col-md-4">
								<label class="control-label" for="user-surname"><small><?php e_strTranslate("Surname");?></small></label>
								<input maxlength="100" name="user-surname" id="user-surname" type="text" class="form-control" disabled="disabled" value="<?php echo $usuario->surname;?>" />
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-12">
								<label class="control-label" for="user-comentarios"><small><?php e_strTranslate("what_do_you_think");?></small></label>
								<textarea name="user-comentarios" id="user-comentarios" class="form-control" disabled="disabled"><?php echo $usuario->user_comentarios;?></textarea>
							</div>
						</div>
						<br />
						<div class="row">
							<div class="form-group col-md-12">
								<a class="btn btn-primary new-message" data-n="<?php echo $usuario->nick;?>" href="#"><?php e_strTranslate("Send_message_to_user");?></a>	
							</div>
						</div>
						<?php else: ?>
						<div class="alert alert-warning"><?php e_strTranslate("User_not_found");?></div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php if(getModuleExist("fotos")): ?>
			<div class="tab-pane fade <?php echo ((isset($_GET['t']) && $_GET['t'] == 2) ? ' in active' : '');?>" id="fotos">
				<section id="photos"></section>
				<div id="cargando-infinnite"><span class="btn btn-default"><?php e_strTranslate("More_photos");?> <i class="fa fa-arrow-circle-down"></i></span></div>
				<div id="cargando-infinnite-end"><span class="btn btn-default alert-info"><?php e_strTranslate("No_more_photos");?> <i class="fa fa-info-circle"></i></span></div>
				<div class="clearfix"></div>
				<!-- Modal -->
				<div class="modal modal-wide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel"><?php e_strTranslate("Photos");?></h4>
							</div>
							<div class="modal-body"></div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
			</div>
			<?php endif; ?>
			<?php if(getModuleExist("videos") && isset($usuario->username)):?>
			<div class="tab-pane fade <?php echo ((isset($_GET['t']) && $_GET['t'] == 3) ? ' in active' : '');?>" id="videos">
				<div class="row inset">
				<?php
				$videos = videosController::getListAction(1000, " AND user_add='".$usuario->username."' AND estado=1 ");
				foreach($videos['items'] as $element):
				echo '<div class="media-preview-container col-md-4 inset" style="clear: none">
							<a href="videos?id='.$element['id_file'].'">
							<img src="'.PATH_VIDEOS.$element['name_file'].'.jpg" class="media-preview" alt="'.$element['titulo'].'" /></a>
							<div><a href="videos?id='.$element['id_file'].'">'.$element['titulo'].'</a><br />
								<span>'.getDateFormat($element['date_video'], "LONG").'</span><br />
								 '.$element['nick'].'
							</div>
						</div>';
				endforeach;
				if ($videos['total_reg'] == 0) echo '<br /><div class="alert alert-warning"><b>'.$usuario->nick.'</b> no ha subido videos</div>';
				?>
				</div>
				<br />
			</div>
			<?php endif;?>
		</div>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<?php if (isset($usuario->username)): ?>
			<img src="<?php echo $usuario->user_foto;?>" class="user-perfil-img" />
			<div class="text-center stars-big"><?php echo userEstrellas($usuario->participaciones)?></div>
			<?php if(getModuleExist("recompensas")): ?>
				<?php templateload("user_recompensa", "recompensas");?>
				<?php userRecompensa($usuario->username);?>
				<?php if ($_SESSION['show_user_points']):?>
					<h3 class="text-center text-muted"><?php echo $usuario->puntos;?> <?php echo ucfirst(strTranslate("APP_points"));?></h3>
				<?php endif;?>
			<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php addMensaje();?>
<!-- Modal -->
<div class="modal modal-wide fade" id="fotosModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"><?php e_strTranslate("Photos");?></h4>
			</div>
			<div class="modal-body"></div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->