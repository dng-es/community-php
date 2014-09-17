<?php
addCss(array("css/bootstrap-datetimepicker.min.css"));

addJavascripts(array("js/bootstrap.file-input.js", 
					"js/bootstrap-datepicker.js", 
					"js/bootstrap-datepicker.es.js", 
					getAsset("users")."js/user-perfil.js"));

session::getFlashMessage( 'actions_message' ); 
usersController::updatePerfilAction();
$usuario = usersController::getPerfilAction();

?>
<div class="row inset row-top">
	<h1><?php echo strTranslate("My_profile");?></h1>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs">
		<li <?php echo (!(isset($_GET['t'])) ? ' class="active"' : '');?>><a href="#general" data-toggle="tab">Datos generales</a></li>
		<li <?php echo ((isset($_GET['t']) and $_GET['t']==2) ? ' class="active"' : '');?>><a href="#statistics" data-toggle="tab"><?php echo strTranslate("Statistics");?></a></li>
	</ul>	
	
	<div class="tab-content">
		<div class="tab-pane fade in <?php echo (!(isset($_GET['t'])) ? ' active' : '');?>" id="general">
			<div class="row inset"> 
				<form id="confirm-form" name="confirm-form" enctype="multipart/form-data" action="" method="post" role="form" class="form-horizontal">
			  		<div class="col-md-9">
						<input type="hidden" name="user-username" id="user-username" value="<?php echo $_SESSION['user_name'];?>">
						
							<div class="form-group">
								<label class="col-sm-2 control-label" for="user-empresa"><?php echo strTranslate("Group_user");?>:</label>
								<div class="col-sm-10">
								  <input type="text" name="user-empresa" id="user-empresa" class="form-control" disabled="disabled" value="<?php echo $usuario['nombre_tienda'];?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="username-text"><?php echo strTranslate("Username");?>:</label>
								<div class="col-sm-10">
								  <input type="text" name="username-text" id="username-text" class="form-control" disabled="disabled" value="<?php echo $_SESSION['user_name'];?>" />
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
								<label class="col-sm-2 control-label" for="user-nombre"><?php echo strTranslate("Name");?>:</label>
								<div class="col-sm-10">
								  <input maxlength="100" name="user-nombre" id="user-nombre" type="text" class="form-control" value="<?php echo $usuario['name'];?>" />
								  <span id="user-nombre-alert" class="alert-message alert alert-danger"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="user-apellidos"><?php echo strTranslate("Surname");?>:</label>
								<div class="col-sm-10">
								  <input maxlength="100" name="user-apellidos" id="user-apellidos" type="text" class="form-control" value="<?php echo $usuario['surname'];?>" />
								  <span id="user-apellidos-alert" class="alert-message alert alert-danger"></span>
								</div>
							</div>					
							<div class="form-group">
								<label class="col-sm-2 control-label" for="user-date"><?php echo strTranslate("Born_date");?>:</label>
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
								<label class="col-sm-2 control-label" for="user-email">Email:</label>
								<div class="col-sm-10">
								  <input maxlength="100" name="user-email" id="user-email" type="text" class="form-control" value="<?php echo $usuario['email'];?>" />
								  <span id="user-email-alert" class="alert-message alert alert-danger"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="user-pass"><?php echo strTranslate("Password");?>:</label>
								<div class="col-sm-10">
								  <input maxlength="100" name="user-pass" id="user-pass" type="password" class="form-control" value="<?php echo $usuario['user_password'];?>" />
								  <span id="user-pass-alert" class="alert-message alert alert-danger"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="user-repass"><?php echo strTranslate("Password_re");?>:</label>
								<div class="col-sm-10">
								  <input maxlength="100" name="user-repass" id="user-repass" type="password" class="form-control" value="<?php echo $usuario['user_password'];?>" />
								  <span id="user-repass-alert" class="alert-message alert alert-danger"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="user-comentarios"><?php echo strTranslate("Address");?>:</label>
								<div class="col-sm-10">
								  <textarea name="user-comentarios" id="user-comentarios" class="form-control"><?php echo $usuario['user_comentarios'];?></textarea>
								  <span id="user-comentarios-alert" class="alert-message alert alert-danger"></span>
								</div>
							</div>					

					</div>
			  		<div class="col-md-3">
						<img src="<?php echo $usuario['user_foto'];?>" class="user-perfil-img" /><br />
						<p>Selecciona una imagen para tu perfil en formato JPG, PNG o GIF. El tamaño de la imagen no podrá exceder de 1MG.</p>
						<input name="nombre-fichero" id="nombre-fichero" type="file" class="btn btn-primary btn-block" title="<?php echo strTranslate("Change_picture");?>" /><br />
						<input type="submit" class="btn btn-primary btn-block" id="confirm-submit" name="confirm-submit" value="<?php echo strTranslate("Save_data");?>" />
					</div>
				</form>
			</div>
		</div>
		<div class="tab-pane fade <?php echo ((isset($_GET['t']) and $_GET['t']==2) ? ' in active' : '');?>" id="statistics">
			<br />
			<p>No hay estadistivas activas</p>
			<br /><br /><br /><br />
		</div>
	</div>
</div>