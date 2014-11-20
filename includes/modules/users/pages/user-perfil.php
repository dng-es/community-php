<?php
addCss(array("css/bootstrap-datetimepicker.min.css"));

addJavascripts(array("js/bootstrap.file-input.js", 
					"js/bootstrap-datepicker.js", 
					"js/bootstrap-datepicker.es.js", 
					getAsset("users")."js/user-perfil.js"));

templateload("tipuser","users");

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
		<li <?php echo ((isset($_GET['t']) and $_GET['t']==2) ? ' class="active"' : '');?>><a href="#statistics" data-toggle="tab"><?php echo strTranslate("Statistics");?></a></li>
	</ul>	
	
	<div class="tab-content">
		<div class="tab-pane fade in <?php echo (!(isset($_GET['t'])) ? ' active' : '');?>" id="general">
			<div class="row inset"> 
				<form id="confirm-form" name="confirm-form" enctype="multipart/form-data" action="" method="post" role="form" class="form-horizontal">
			  		<div class="col-md-12">
						<input type="hidden" name="user-username" id="user-username" value="<?php echo $_SESSION['user_name'];?>">
						
							<div class="form-group">
								<label class="col-sm-2 control-label" for="username-text"><?php echo strTranslate("Username");?></label>
								<div class="col-sm-10">
								  <input type="text" name="username-text" id="username-text" class="form-control" disabled="disabled" value="<?php echo $_SESSION['user_name'];?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="user-empresa"><?php echo strTranslate("Group_user");?></label>
								<div class="col-sm-10">
								  <input type="text" name="user-empresa" id="user-empresa" class="form-control" disabled="disabled" value="<?php echo $usuario['nombre_tienda'];?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="user-nick"><?php echo strTranslate("Nick");?>:</label>
								<div class="col-sm-10">
								  <input maxlength="100" name="user-nick" id="user-nick" type="text" class="form-control" value="<?php echo $usuario['nick'];?>" />
								  <span id="user-nick-alert" class="alert-message alert alert-danger"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="user-nombre"><?php echo strTranslate("Name");?></label>
								<div class="col-sm-10">
								  <input maxlength="100" name="user-nombre" id="user-nombre" type="text" class="form-control" value="<?php echo $usuario['name'];?>" />
								  <span id="user-nombre-alert" class="alert-message alert alert-danger"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="user-apellidos"><?php echo strTranslate("Surname");?></label>
								<div class="col-sm-10">
								  <input maxlength="100" name="user-apellidos" id="user-apellidos" type="text" class="form-control" value="<?php echo $usuario['surname'];?>" />
								  <span id="user-apellidos-alert" class="alert-message alert alert-danger"></span>
								</div>
							</div>					
							<div class="form-group">
								<label class="col-sm-2 control-label" for="user-date"><?php echo strTranslate("Born_date");?></label>
								<div class="col-sm-10">

									  <div id="datetimepicker1" class="input-group date">
									    <input data-format="yyyy/MM/dd" readonly type="text" id="user-date" class="form-control" name="user-date"></input>
									      <span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
									  </div>

									  <script>
										jQuery(document).ready(function(){
											$("#datetimepicker1").datetimepicker({
										      language: "es-ES",
										      startDate: "2014/01/01"
										    });
		<?php 								    
		if ($usuario['user_date']!=null){
			echo "							var fecha = '".date('D M d Y H:i:s O',strtotime($usuario['user_date']))."';";
			echo '							$("#datetimepicker1").data("datetimepicker").setLocalDate(new Date (fecha));';
		}
		?>								});
									  </script>

									<span id="user-date-alert" class="alert-message alert alert-danger"></span>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="user-email">Email</label>
								<div class="col-sm-10">
								  <input maxlength="100" name="user-email" id="user-email" type="text" class="form-control" value="<?php echo $usuario['email'];?>" />
								  <span id="user-email-alert" class="alert-message alert alert-danger"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="user-pass"><?php echo strTranslate("Password");?></label>
								<div class="col-sm-10">
								  <input maxlength="100" name="user-pass" id="user-pass" type="password" class="form-control" value="<?php echo $usuario['user_password'];?>" />
								  <span id="user-pass-alert" class="alert-message alert alert-danger"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="user-repass"><?php echo strTranslate("Password_re");?></label>
								<div class="col-sm-10">
								  <input maxlength="100" name="user-repass" id="user-repass" type="password" class="form-control" value="<?php echo $usuario['user_password'];?>" />
								  <span id="user-repass-alert" class="alert-message alert alert-danger"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="user-comentarios"><?php echo strTranslate("what_do_you_think");?></label>
								<div class="col-sm-10">
								  <textarea name="user-comentarios" id="user-comentarios" class="form-control"><?php echo $usuario['user_comentarios'];?></textarea>
								  <span id="user-comentarios-alert" class="alert-message alert alert-danger"></span>
								</div>
							</div>					
							<div class="col-md-6 col-md-offset-3">
								<div class="col-md-6 inset">
									<input name="nombre-fichero" id="nombre-fichero" type="file" class="btn btn-primary btn-block" title="<?php echo strTranslate("Change_picture");?>" /> 
								</div>
								<div class="col-md-6 inset">
									<input type="submit" class="btn btn-primary btn-block" id="confirm-submit" name="confirm-submit" value="<?php echo strTranslate("Save_data");?>" />
								</div>
							</div>
					</div>
				</form>
			</div>
		</div>
		<div class="tab-pane fade <?php echo ((isset($_GET['t']) and $_GET['t']==2) ? ' in active' : '');?>" id="statistics">
			<br />
			<p>Estadísticas de uso de la comunidad por el usuario <b><?php echo $usuario['username'];?></b></p>
			<table class="table table-striped">
				<tr><td><label><?php echo strTranslate("Date_add");?></label></td><td><?php echo $usuario['date_add'];?></td></tr>
				<tr><td><label><?php echo ucfirst(strTranslate("Last_access"));?></label></td><td><?php echo getDateFormat($usuario['last_access'], "DATE_TIME");?></td></tr>
				<tr><td><label><?php echo ucfirst(strTranslate("APP_points"));?></label></td><td><?php echo $usuario['puntos'];?></td></tr>
			</table>
		</div>
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