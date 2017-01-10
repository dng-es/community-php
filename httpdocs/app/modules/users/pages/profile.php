<?php
addCss(array("css/bootstrap-datetimepicker.min.css"));

addJavascripts(array("js/bootstrap.file-input.js", 
					"js/bootstrap-datepicker.js", 
					"js/bootstrap-datepicker.es.js", 
					getAsset("users")."js/profile.js",
					getAsset("alerts")."js/alerts.js",
					"js/jquery.geturlparam.js",
					getAsset("fotos")."js/fotos.js"));

templateload("panels", "alerts");
templateload("tipuser", "users");
templateload("na_areasuser", "na_areas");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("My_profile"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		usersController::updatePerfilAction();
		$usuario = usersController::getPerfilAction($_SESSION['user_name']);
		?>
		<!-- Nav tabs -->
		<ul class="nav nav-tabs">
			<li <?php echo (!(isset($_GET['t'])) ? ' class="active"' : '');?>><a href="#general" data-toggle="tab"><?php e_strTranslate("Main_data");?></a></li>
			<?php if(getModuleExist("na_areas")):  ?>
			<li <?php echo ((isset($_GET['t']) and $_GET['t'] == 2) ? ' class="active"' : '');?>><a href="#areas" data-toggle="tab"><?php e_strTranslate("Na_areas");?></a></li>
			<?php endif;?>
			<?php if(getModuleExist("fotos")): ?>
			<li <?php echo ((isset($_GET['t']) and $_GET['t'] == 3) ? ' class="active"' : '');?>><a href="#fotos" data-toggle="tab"><?php e_strTranslate("Photos");?></a></li>
			<?php endif; ?>
			<?php if(getModuleExist("videos")): 
			$videos = videosController::getListAction(1000, " AND user_add='".$usuario['username']."' AND estado=1 ");
			?>
			<li <?php echo ((isset($_GET['t']) and $_GET['t'] == 4) ? ' class="active"' : '');?>><a href="#videos" data-toggle="tab"><?php e_strTranslate("Videos");?></a></li>
			<?php endif; ?>
		</ul>

		<div class="tab-content">
			<div class="tab-pane fade in <?php echo (!(isset($_GET['t'])) ? ' active' : '');?>" id="general">
				<div class="row"> 
					<div class="col-md-8">
					<br />
					<span id="password-text-alert" class="alert-message alert alert-danger"></span>
					<form id="confirm-form" name="confirm-form" enctype="multipart/form-data" action="" method="post" role="form" class="form-horizontal">
						<input type="hidden" name="user-username" id="user-username" value="<?php echo $_SESSION['user_name'];?>">
						<div class="row">
						<div class="col-md-12">
						<label class="control-label" for="user-empresa"><small><?php e_strTranslate("Group_user");?></small></label>
						<input type="text" name="user-empresa" id="user-empresa" class="form-control" disabled="disabled" value="<?php echo $usuario['nombre_tienda'];?>" />
						</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="control-label" for="username-text"><small><?php e_strTranslate("Username");?></small></label>
								<input type="text" name="username-text" id="username-text" class="form-control" disabled="disabled" value="<?php echo $_SESSION['user_name'];?>" />
							</div>
							<div class="col-md-6">
								<label class=" control-label" for="user-nick"><small><?php e_strTranslate("Nick");?></small></label>
								<input maxlength="100" name="user-nick" id="user-nick" type="text" class="form-control" value="<?php echo $usuario['nick'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="control-label" for="user-pass"><small><?php e_strTranslate("Password");?></small></label>
								<input maxlength="100" name="user-pass" id="user-pass" type="password" class="form-control" value="<?php echo $usuario['user_password'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
							</div>
							<div class="col-md-6">
								<label class="control-label" for="user-repass"><small><?php e_strTranslate("Password_re");?></small></label>
								<input maxlength="100" name="user-repass" id="user-repass" type="password" class="form-control" value="<?php echo $usuario['user_password'];?>" data-alert="<?php e_strTranslate("Password_not_match");?>" />
							</div>
						</div>

						<hr />

						<div class="row">
							<div class="col-md-6">
								<label class=" control-label" for="user-nombre"><small><?php e_strTranslate("Name");?></small></label>
								<input maxlength="100" name="user-nombre" id="user-nombre" type="text" class="form-control" value="<?php echo $usuario['name'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
							</div>
							<div class="col-md-6">
								<label class="control-label" for="user-apellidos"><small><?php e_strTranslate("Surname");?></small></label>
								<input maxlength="100" name="user-apellidos" id="user-apellidos" type="text" class="form-control" value="<?php echo $usuario['surname'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="control-label" for="user-email"><small>Email</small></label>
								<input maxlength="100" name="user-email" id="user-email" type="text" class="form-control" value="<?php echo $usuario['email'];?>" data-alert="<?php e_strTranslate("Required_email");?>" />
							</div>
							<div class="col-md-3">
								<label class="control-label" for="user-date"><small><?php e_strTranslate("Born_date");?></small></label>
								<div id="datetimepicker1" class="input-group date">
									<input data-format="yyyy/MM/dd" readonly type="text" id="user-date" class="form-control" name="user-date" data-alert="<?php e_strTranslate("Required_date");?>"></input>
									<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>

								<script type="text/javascript">
									jQuery(document).ready(function(){
										$("#datetimepicker1").datetimepicker({
											language: "es-ES",
											startDate: "2014/01/01"
										});
										<?php 
										if ($usuario['user_date'] != null){
											echo "var fecha = '".date('D M d Y H:i:s O',strtotime($usuario['user_date']))."';";
											echo '$("#datetimepicker1").data("datetimepicker").setLocalDate(new Date (fecha));';
										}
										?>
									});
								</script>
							</div>

							<div class="col-md-3">
								<label class="control-label" for="user_lan"><small><?php e_strTranslate("Language");?></small></label>
								<select name="user_lan" id="user_lan" class="form-control">
									<?php ComboLanguages($usuario['user_lan']);?>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<label class="control-label" for="user-comentarios"><small><?php e_strTranslate("what_do_you_think");?></small></label>
								<textarea name="user-comentarios" id="user-comentarios" class="form-control"><?php echo $usuario['user_comentarios'];?></textarea>
							</div>
						</div>

						<hr />

						<div class="row">
							<div class="col-md-6">
								<label class=" control-label" for="direccion_user"><small><?php e_strTranslate("Address");?></small></label>
								<input maxlength="250" name="direccion_user" id="direccion_user" type="text" class="form-control" value="<?php echo $usuario['direccion_user'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
							</div>
							<div class="col-md-6">
								<label class="control-label" for="ciudad_user"><small><?php e_strTranslate("City");?></small></label>
								<input maxlength="100" name="ciudad_user" id="ciudad_user" type="text" class="form-control" value="<?php echo $usuario['ciudad_user'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<label class=" control-label" for="provincia_user"><small><?php e_strTranslate("State");?></small></label>
								<input maxlength="100" name="provincia_user" id="provincia_user" type="text" class="form-control" value="<?php echo $usuario['provincia_user'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
							</div>
							<div class="col-md-6">
								<label class="control-label" for="cpostal_user"><small><?php e_strTranslate("Postal_code");?></small></label>
								<input maxlength="10" name="cpostal_user" id="cpostal_user" type="text" class="form-control" value="<?php echo $usuario['cpostal_user'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<label class="control-label" for="telefono"><small><?php e_strTranslate("Telephone");?></small></label>
								<input maxlength="10" name="telefono" id="telefono" type="text" class="form-control" value="<?php echo $usuario['telefono'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
							</div>
						</div>

						<hr />

						<div class="row">
							<div class="col-md-6 inset">
								<input name="nombre-fichero" id="nombre-fichero" type="file" class="btn btn-primary btn-block" title="<?php e_strTranslate("Change_picture");?>" /> 
							</div>
							<div class="col-md-6 inset">
								<input type="submit" class="btn btn-primary btn-block" id="confirm-submit" name="confirm-submit" value="<?php e_strTranslate("Save_data");?>" />
							</div>
						</div>
					</form>
					</div>
					<div class="col-md-4">
						<br />
						<br />
						<a class="btn btn-default btn-block" href="group?id=<?php echo $_SESSION['user_empresa'];?>"><?php e_strTranslate("My_group");?></a>
						
						<?php if(getModuleExist("shop")):  ?>
						<a class="btn btn-default btn-block" href="shoporders"><?php e_strTranslate("Shop_my_orders");?></a>
						<?php endif; ?>

						<br />
						<table class="table table-striped">
							<tr><td><label><small><?php e_strTranslate("Date_add");?></small></label></td><td><small class="text-muted"><?php echo getDateFormat($usuario['date_add'], "DATE_TIME");?></small></td></tr>
							<tr><td><label><small><?php echo ucfirst(strTranslate("Last_access"));?></small></label></td><td><small class="text-muted"><?php echo getDateFormat($usuario['last_access'], "DATE_TIME");?></small></td></tr>
							<?php if ($_SESSION['show_user_points']):?>
							<tr><td><label><small><?php echo ucfirst(strTranslate("APP_points"));?></small></label></td><td><small class="text-muted"><?php echo $usuario['puntos'];?></small></td></tr>
							<?php endif; ?>
							<?php if(getModuleExist("shop")):  ?>
							<tr><td><label><small><?php echo ucfirst(strTranslate("APP_Credits"));?></small></label></td><td><small class="text-muted"><?php echo $usuario['creditos'];?></small></td></tr>
							<?php endif; ?>
							<tr><td><label><small><?php echo ucfirst(strTranslate("APP_shares"));?></small></label></td><td><small class="text-muted"><?php echo $usuario['participaciones'];?></small></td></tr>
						</table>

						<?php panelAlerts();?>

					</div>
				</div>
			</div>
			<?php if(getModuleExist("na_areas")): ?>
			<div class="tab-pane fade <?php echo ((isset($_GET['t']) and $_GET['t'] == 2) ? ' in active' : '');?>" id="areas">
				<?php userNaAreas($_SESSION['user_name']);?>
			</div>
			<?php endif; ?>
			<?php if(getModuleExist("fotos")): ?>
			<div class="tab-pane fade <?php echo ((isset($_GET['t']) and $_GET['t']==3) ? ' in active' : '');?>" id="fotos">

				<section id="photos">

				</section>
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
							<div class="modal-body">
								...
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
			</div>
			<?php endif; ?>
			<?php if(getModuleExist("videos")): ?>
			<div class="tab-pane fade <?php echo ((isset($_GET['t']) and $_GET['t'] == 4) ? ' in active' : '');?>" id="videos">
					<div class="row">
					<?php
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

					if ($videos['total_reg'] == 0) echo '<br /><div class="alert alert-warning"><b>'.$usuario['nick'].'</b> no ha subido videos</div>';
					?>
					</div>
					<br />
			</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<p>Selecciona una imagen para tu perfil en formato JPG, PNG o GIF. El tamaño de la imagen no podrá exceder de 1MB.</p>
			<img src="<?php echo $usuario['user_foto'];?>" class="user-perfil-img" /> 
			<div class="text-center stars-big"><?php echo userEstrellas($usuario['participaciones'])?></div><br />
			<?php if(getModuleExist("recompensas")): ?>
					<?php templateload("user_recompensa", "recompensas");?>
					<?php userRecompensa($_SESSION['user_name']);?>
			<?php endif; ?>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal modal-wide fade" id="fotosModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"><?php e_strTranslate("Photos");?></h4>
			</div>
			<div class="modal-body">
				...
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->