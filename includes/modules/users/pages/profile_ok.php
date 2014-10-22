<?php
addCss(array("css/bootstrap-datetimepicker.min.css"));
templateload("addmessage","mensajes");
templateload("tipuser","users");

addJavascripts(array(getAsset("mensajes")."js/mensajes.js", 
					 getAsset("users")."js/profile.js",
					 "js/bootstrap.file-input.js", 
					 "js/jquery.bettertip.pack.js",
					 "js/jquery.bettertip.pack.js", 
					 "js/jquery.geturlparam.js", 
					 getAsset("fotos")."js/fotos.js"));


?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<h1><?php echo strTranslate("User_profile");?></h1>
		<?php
		session::getFlashMessage( 'actions_message' );
		mensajesController::createAction();
		$filter = ($_SESSION['user_perfil']!="admin" ? " AND (canal='".$_SESSION['user_canal']."' OR canal='admin') " : "");
		$nick = (isset($_REQUEST['n']) ? $_REQUEST['n'] : "");
		$usuario = usersController::getPublicPerfilAction($nick, $filter);
		?>
	<!-- Nav tabs -->
		<ul class="nav nav-tabs">
			<li <?php echo (!(isset($_GET['t'])) ? ' class="active"' : '');?>><a href="#general" data-toggle="tab"><?php echo strTranslate("Main_data");?></a></li>
			<?php if(getModuleExist("fotos")): ?>
			<li <?php echo ((isset($_GET['t']) and $_GET['t']==2) ? ' class="active"' : '');?>><a href="#fotos" data-toggle="tab"><?php echo strTranslate("Photos");?></a></li>
			<?php endif; ?>
			<?php if(getModuleExist("videos")): 
			$videos = videosController::getListAction(1000, " AND user_add='".$usuario['username']."' AND estado=1 ");
			?>
			<li <?php echo ((isset($_GET['t']) and $_GET['t']==3) ? ' class="active"' : '');?>><a href="#videos" data-toggle="tab"><?php echo strTranslate("Videos");?></a></li>
			<?php endif; ?>
		</ul>	
		
		<div class="tab-content">
			<div class="tab-pane fade in <?php echo (!(isset($_GET['t'])) ? ' active' : '');?>" id="general">
				<div class="row inset"> 
			  		<div class="col-md-12">
						<?php if (count($usuario)>0): ?>
						<form id="confirm-form" name="confirm-form" enctype="multipart/form-data" action="" method="post" role="form" class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="user-nick"><?php echo strTranslate("Nick");?>:</label>
								<div class="col-sm-4">
								  <input maxlength="100" name="user-nick" id="user-nick" type="text" class="form-control" disabled="disabled" value="<?php echo $usuario['nick'];?>" />
								</div>
								<label class="col-sm-1 control-label" for="user-nick"><?php echo ucfirst(strTranslate("APP_points"));?>:</label>
								<div class="col-sm-5">
								  <input maxlength="100" name="user-nick" id="user-nick" type="text" class="form-control" disabled="disabled" value="<?php echo $usuario['puntos'];?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="user-nombre"><?php echo strTranslate("Name");?>:</label>
								<div class="col-sm-10">
								  <input maxlength="100" name="user-nombre" id="user-nombre" type="text" class="form-control" disabled="disabled" value="<?php echo $usuario['name'];?> <?php echo $usuario['surname'];?>" />
								</div>
							</div>					
							<div class="form-group">
								<label class="col-sm-2 control-label" for="user-date"><?php echo strTranslate("Born_date");?>:</label>
								<div class="col-sm-4">
									  <div id="datetimepicker1" class="input-group date">
									    <input data-format="yyyy/MM/dd" readonly type="text" id="user-date" class="form-control" disabled="disabled" name="user-date"value="<?php echo ($usuario['user_date']!=null ? getDateFormat($usuario['user_date'], 'SHORT') : '');?>"></input>
									      <span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
									  </div>
								</div>

								<label class="col-sm-1 control-label" for="user-empresa"><?php echo strTranslate("Group_user");?>:</label>
								<div class="col-sm-5">
								  <input type="text" name="user-empresa" id="user-empresa" class="form-control" disabled="disabled" value="<?php echo $usuario['nombre_tienda'];?>" />
								</div>
							</div>					
							<div class="form-group">
								<label class="col-sm-2 control-label" for="user-comentarios"><?php echo strTranslate("Address");?>:</label>
								<div class="col-sm-10">
								  <textarea name="user-comentarios" id="user-comentarios" class="form-control" disabled="disabled"><?php echo $usuario['user_comentarios'];?></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 col-md-offset-2">
									<a class="btn btn-primary new-message" data-n="<?php echo $usuario['nick'];?>" href="#"><?php echo strTranslate("Send_message_to_user");?></a>	
								</div>
							</div>
						</form>	
							
						<?php else: ?>
						<div class="alert alert-warning"><?php echo strTranslate("User_not_found");?></div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php if(getModuleExist("fotos")): ?>
			<div class="tab-pane fade <?php echo ((isset($_GET['t']) and $_GET['t']==2) ? ' in active' : '');?>" id="fotos">

				<section id="photos">

				</section>
				<div id="cargando-infinnite"><span class="btn btn-default">seguir cargando imagenes <i class="fa fa-arrow-circle-down"></i></span></div>
				<div id="cargando-infinnite-end"><span class="btn btn-default alert-info">No hay más imágenes <i class="fa fa-info-circle"></i></span></div>
				<div class="clearfix"></div>
				<!-- Modal -->
				<div class="modal modal-wide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel"><?php echo strTranslate("Photos");?></h4>
							</div>
							<div class="modal-body">
								...
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
			</div>
			<?php endif; ?>
			<?php if(getModuleExist("videos")): ?>
			<div class="tab-pane fade <?php echo ((isset($_GET['t']) and $_GET['t']==3) ? ' in active' : '');?>" id="videos">

					<?php
					foreach($videos['items'] as $element):
					echo '<div class="video-preview-container col-md-4 inset"><a href="?page=video&id='.$element['id_file'].'&pag='.$pagina_sig.'"><img src="'.PATH_VIDEOS.$element['name_file'].'.jpg" class="video-preview" /></a>
								<div><a href="?page=video&id='.$element['id_file'].'">'.$element['titulo'].'</a><br />
									 <span>'.getDateFormat($element['date_video'], "LONG").'</span><br />
									 '.$element['nick'].'
								</div>
							</div>';
					endforeach;

					if ($videos['total_reg']==0) echo '<br /><div class="alert alert-warning"><b>'.$usuario['nick'].'</b> no ha subido videos</div>';
					?>
					<br />
			</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<?php if (count($usuario)>0): ?>
			<img src="<?php echo $usuario['user_foto'];?>" class="user-perfil-img" />  
			<div class="text-center stars-big"><?php echo userEstrellas($usuario['participaciones'])?></div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php addMensaje();?>