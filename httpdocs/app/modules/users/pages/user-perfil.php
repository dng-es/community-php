<?php
addCss(array("css/bootstrap-datetimepicker.min.css"));

addJavascripts(array("js/bootstrap.file-input.js", 
					"js/bootstrap-datepicker.js", 
					"js/bootstrap-datepicker.es.js", 
					getAsset("users")."js/user-perfil.js"));

templateload("tipuser","users");
templateload("na_areasuser","na_areas");

?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<ol class="breadcrumb">
			<li><a href="?page=home"><?php echo strTranslate("Home");?></a></li>
			<li class="active"><?php echo strTranslate("My_profile");?></li>
		</ol>

		<?php
		session::getFlashMessage( 'actions_message' ); 
		usersController::updatePerfilAction();
		$usuario = usersController::getPerfilAction($_SESSION['user_name']);
		?>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs">
		<li <?php echo (!(isset($_GET['t'])) ? ' class="active"' : '');?>><a href="#general" data-toggle="tab"><?php echo strTranslate("Main_data");?></a></li>
		<?php if (1==1): ?>
		<li <?php echo ((isset($_GET['t']) and $_GET['t']==2) ? ' class="active"' : '');?>><a href="#<?php echo strTranslate("Na_areas");?>" data-toggle="tab"><?php echo strTranslate("Na_areas");?></a></li>
		<?php endif;?>
	</ul>	
	
	<div class="tab-content">
		<div class="tab-pane fade in <?php echo (!(isset($_GET['t'])) ? ' active' : '');?>" id="general">
			<div class="row"> 
				<div class="col-md-8">
				<br />
				<form id="confirm-form" name="confirm-form" enctype="multipart/form-data" action="" method="post" role="form" class="form-horizontal">
					<input type="hidden" name="user-username" id="user-username" value="<?php echo $_SESSION['user_name'];?>">
			  		<div class="row">
			  		<div class="col-md-12">
					<label class="control-label" for="user-empresa"><small><?php echo strTranslate("Group_user");?></small></label>
					<input type="text" name="user-empresa" id="user-empresa" class="form-control" disabled="disabled" value="<?php echo $usuario['nombre_tienda'];?>" />
					</div>
					</div>
			  		<div class="row">
				  		<div class="col-md-6">
							<label class="control-label" for="username-text"><small><?php echo strTranslate("Username");?></small></label>
							<input type="text" name="username-text" id="username-text" class="form-control" disabled="disabled" value="<?php echo $_SESSION['user_name'];?>" />
						</div>
						<div class="col-md-6">
							<label class=" control-label" for="user-nick"><small><?php echo strTranslate("Nick");?></small></label>
							<input maxlength="100" name="user-nick" id="user-nick" type="text" class="form-control" value="<?php echo $usuario['nick'];?>" data-alert="<?php echo strTranslate("Required_field");?>" />
						</div>
					</div>
			  		<div class="row">
						<div class="col-md-6">
							<label class="control-label" for="user-pass"><small><?php echo strTranslate("Password");?></small></label>
							<input maxlength="100" name="user-pass" id="user-pass" type="password" class="form-control" value="<?php echo $usuario['user_password'];?>" data-alert="<?php echo strTranslate("Required_field");?>" />
						</div>
						<div class="col-md-6">
							<label class="control-label" for="user-repass"><small><?php echo strTranslate("Password_re");?></small></label>
							<input maxlength="100" name="user-repass" id="user-repass" type="password" class="form-control" value="<?php echo $usuario['user_password'];?>" data-alert="<?php echo strTranslate("Password_not_match");?>" />
						</div>
					</div>
			  		<div class="row">
						<div class="col-md-6">
							<label class=" control-label" for="user-nombre"><small><?php echo strTranslate("Name");?></small></label>
							<input maxlength="100" name="user-nombre" id="user-nombre" type="text" class="form-control" value="<?php echo $usuario['name'];?>" data-alert="<?php echo strTranslate("Required_field");?>" />
						</div>
						<div class="col-md-6">							
							<label class="control-label" for="user-apellidos"><small><?php echo strTranslate("Surname");?></small></label>
							<input maxlength="100" name="user-apellidos" id="user-apellidos" type="text" class="form-control" value="<?php echo $usuario['surname'];?>" data-alert="<?php echo strTranslate("Required_field");?>" />
						</div>
					</div>
			  		<div class="row">
						<div class="col-md-6">
							<label class="control-label" for="user-email"><small>Email</small></label>
							<input maxlength="100" name="user-email" id="user-email" type="text" class="form-control" value="<?php echo $usuario['email'];?>" data-alert="<?php echo strTranslate("Required_email");?>" />
						</div>
						<div class="col-md-6">
							<label class=" control-label" for="user-date"><small><?php echo strTranslate("Born_date");?></small></label>
							<div id="datetimepicker1" class="input-group date">
								<input data-format="yyyy/MM/dd" readonly type="text" id="user-date" class="form-control" name="user-date" data-alert="<?php echo strTranslate("Required_date");?>"></input>
								<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>

							<script type="text/javascript">
								jQuery(document).ready(function(){
									$("#datetimepicker1").datetimepicker({
										language: "es-ES",
										startDate: "2014/01/01"
									});
									<?php 
									if ($usuario['user_date']!=null){
										echo "var fecha = '".date('D M d Y H:i:s O',strtotime($usuario['user_date']))."';";
										echo '$("#datetimepicker1").data("datetimepicker").setLocalDate(new Date (fecha));';
									}
									?>
								});
							</script>
						</div>
					</div>		
					<div class="row">
						<div class="col-md-12">
							<label class="control-label" for="user-comentarios"><small><?php echo strTranslate("what_do_you_think");?></small></label>
							<textarea name="user-comentarios" id="user-comentarios" class="form-control"><?php echo $usuario['user_comentarios'];?></textarea>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 inset">
							<input name="nombre-fichero" id="nombre-fichero" type="file" class="btn btn-primary btn-block" title="<?php echo strTranslate("Change_picture");?>" /> 
						</div>
						<div class="col-md-6 inset">
							<input type="submit" class="btn btn-primary btn-block" id="confirm-submit" name="confirm-submit" value="<?php echo strTranslate("Save_data");?>" />
						</div>
					</div>
				</form>
				</div>
				<div class="col-md-4">
					<br />
					<br />
					<table class="table table-striped">
						<tr><td><label><small><?php echo strTranslate("Date_add");?></small></label></td><td><small class="text-muted"><?php echo getDateFormat($usuario['date_add'], "DATE_TIME");?></small></td></tr>
						<tr><td><label><small><?php echo ucfirst(strTranslate("Last_access"));?></small></label></td><td><small class="text-muted"><?php echo getDateFormat($usuario['last_access'], "DATE_TIME");?></small></td></tr>
						<tr><td><label><small><?php echo ucfirst(strTranslate("APP_points"));?></small></label></td><td><small class="text-muted"><?php echo $usuario['puntos'];?></small></td></tr>
						<tr><td><label><small><?php echo ucfirst(strTranslate("APP_shares"));?></small></label></td><td><small class="text-muted"><?php echo $usuario['participaciones'];?></small></td></tr>
					</table>		
				</div>
			</div>
		</div>
		<?php if (1==1): ?>
		<div class="tab-pane fade <?php echo ((isset($_GET['t']) and $_GET['t']==2) ? ' in active' : '');?>" id="<?php echo strTranslate("Na_areas");?>">
			<?php userNaAreas($_SESSION['user_name']);?>
		</div>
		<?php endif; ?>
	</div>
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<img src="<?php echo $usuario['user_foto'];?>" class="user-perfil-img" /> 
			<div class="text-center stars-big"><?php echo userEstrellas($usuario['participaciones'])?></div><br />
			<p>Selecciona una imagen para tu perfil en formato JPG, PNG o GIF. El tamaño de la imagen no podrá exceder de 1MG.</p>
		</div>
	</div>
</div>