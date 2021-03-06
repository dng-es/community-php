<?php
addCss(array("css/bootstrap-datetimepicker.min.css"));
addJavascripts(array("js/bootstrap-datepicker.js",
					 "js/bootstrap.file-input.js",
					 getAsset("users")."js/user-confirm.js"));

$confirmar = usersController::confirmUserAction();
$pages = new pages();
$declaracion = $pages->getPages(" AND page_name='declaracion' ");
?>
<div id="confirm-container" class="row">
	<div class="col-md-5">
		<img src="themes/<?php echo $_SESSION['user_theme'];?>/images/logo01.png" alt="<?php echo $ini_conf['SiteName'];?>" class="responsive login-img" />
	</div>
	<div class="col-md-6 login-container">
		<div class="col-md-12 noppading">
			<h1><?php e_strTranslate("Confirm_data");?></h1>
			<?php
			if ($confirmar == 1 ){ ?>
				<p><?php e_strTranslate("Confirmation_message");?> .</p>
				<br />
				<a href="login" class="btn btn-primary"><?php e_strTranslate("Identify_to_access");?></a>
			<?php }
			elseif ($confirmar == 2){
				ErrorMsg('<p>'.strTranslate("Error_procesing").'.</p>');
				ShowForm();
			}
			elseif ($confirmar == 3){
				ErrorMsg('<p>'.strTranslate("Nick").' <b>'.$_POST['user-nick'].'</b> '.strTranslate("Already_exist").'.</p>');
				ShowForm();
			}
			else ShowForm(); ?>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal modal-wide fade" id="declaracionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"><?php e_strTranslate("Terms_and_conditions");?></h4>
			</div>
			<div class="modal-body">
			<?php echo $declaracion[0]['page_content'];?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php 
///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////

function ShowForm(){
	//VERIFICAR QUE EL USUARIO NO ESTE YA CONFIRMADO
	$users = new users();
	$usuario = $users->getUsers(" AND username='".$_SESSION['user_name']."' ");

	if ($usuario[0]['confirmed'] == 1){
		echo '<div class="alert alert-warning">El usuario ya esta confirmado.
			Para acceder a la comunidad pincha <a href="login" class="text-primary">aquí</a>.</div>';
	}
	else{
		if (isset($_POST['user-nombre'])){
			$user_nombre = $_POST['user-nombre'];
			$user_apellidos = $_POST['user-apellidos'];
			$user_email = $_POST['user-email'];
		}
		else {
			$user_nombre = $usuario[0]['name'];
			$user_apellidos = $usuario[0]['surname'];
			$user_email = $usuario[0]['email'];
		}
		$user_nick = "";
		$user_pass = "";
		$user_repass = "";

		if (isset($_POST['user-nick'])) $user_nick = $_POST['user-nick'];
		if (isset($_POST['user-pass'])) $user_pass = $_POST['user-pass'];
		if (isset($_POST['user-repass'])) $user_repass = $_POST['user-repass'];
		?>
		<form id="confirm-form" name="confirm-form" enctype="multipart/form-data" action="" method="post" role="form" class="form-horizontal">
			<input type="hidden" name="user-username" id="user-username" value="<?php echo $_SESSION['user_name'];?>">
			<div class="form-group hidden">
				<label class="col-sm-4 control-label" for="username-text"><?php e_strTranslate("Username");?>:</label>
				<div class="col-sm-8">
					<input name="username-text" id="username-text" type="text" class="form-control" disabled="disabled" value="<?php echo $_SESSION['user_name'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="user-nick"><i class="fa fa-info-circle pointer tip text-primary" title="<?php e_strTranslate("Nick_info");?>"></i> <?php e_strTranslate("Nick");?>:</label>
				<div class="col-sm-8">
					<input maxlength="100" name="user-nick" id="user-nick" type="text" class="form-control" value="<?php echo $user_nick;?>" data-alert="<?php e_strTranslate("Required_field");?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="user-nombre"><?php e_strTranslate("Name");?>:</label>
				<div class="col-sm-8">
					<input maxlength="100" name="user-nombre" id="user-nombre" type="text" class="form-control" value="<?php echo $user_nombre;?>" data-alert="<?php e_strTranslate("Required_field");?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="user-apellidos"><?php e_strTranslate("Surname");?>:</label>
				<div class="col-sm-8">
					<input maxlength="100" name="user-apellidos" id="user-apellidos" type="text" class="form-control" value="<?php echo $user_apellidos;?>" data-alert="<?php e_strTranslate("Required_field");?>" />
				</div>
			</div>
			<div class="form-group" style="display:none">
				<label class="col-sm-4 control-label" for="user-date"><?php e_strTranslate("Born_date");?>:</label>
				<div class="col-sm-8">
					<div id="datetimepicker1" class="input-group date">
						<input data-format="yyyy/MM/dd" readonly type="text" id="user-date" class="form-control" name="user-date"></input>
						<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="user-email"><?php e_strTranslate("Email");?>:</label>
				<div class="col-sm-8">
					<input maxlength="100" name="user-email" id="user-email" type="text" class="form-control" value="<?php echo $user_email;?>" data-alert="<?php e_strTranslate("Required_email");?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="user-pass"><?php e_strTranslate("Password");?>:</label>
				<div class="col-sm-8">
					<input maxlength="100" name="user-pass" id="user-pass" type="password" class="form-control" value="<?php echo $user_pass;?>" data-alert="<?php e_strTranslate("Required_field");?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="user-repass"><?php e_strTranslate("Password_re");?>:</label>
				<div class="col-sm-8">
					<input maxlength="100" name="user-repass" id="user-repass" type="password" class="form-control" value="<?php echo $user_repass;?>" data-alert="<?php e_strTranslate("Password_not_match");?>" />
				</div>
			</div>
			<div class="form-group" style="display:none">
				<label class="col-sm-4 control-label" for="nombre-fichero"><?php e_strTranslate("Picture");?>:</label>
				<div class="col-sm-8">
					<input name="nombre-fichero" id="nombre-fichero" type="file"  class="btn btn-default" title="<?php e_strTranslate("Choose_file");?>" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-4 text-right"><span id="user-declaracion-alert"></span></div>
				<div class="col-sm-8">
					<div class="checkbox checkbox-primary">
						<input type="checkbox" class="styled" id="user-declaracion"  name="user-declaracion">
						<label for="confirmed_user"> <?php e_strTranslate("Acept");?> 
							<a href="#" id="declaracion-trigger"><?php e_strTranslate("Terms_and_conditions");?></a></label>
					</div>
					<br />
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-4 text-right"><span id="recomendacion-result"></span></div>
				<div class="col-sm-8">
					<p><?php echo strTranslate("Confirm_recommend", PUNTOS_CONFIRM);?>:</p>
					<input maxlength="100" name="user_recommend" id="user_recommend" type="text" class="form-control" value="" data-alert="" />
				</div>
			</div>
						
			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-8 col-md-4">
					<button type="submit" name="confirm-submit" id="confirm-submit" class="btn btn-primary btn-block"><?php e_strTranslate("Send_data");?></button>
				</div>
			</div>
		</form>
		<br />
	<?php
	}
}
?>