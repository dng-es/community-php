<?php
addCss(array("css/bootstrap-datetimepicker.min.css"));
addJavascripts(array("js/bootstrap-datepicker.js",
					 "js/bootstrap.file-input.js",
					 getAsset("users")."js/user-confirm.js"));
?>
<div id="confirm-container" class="row">			
	<div class="col-md-5">
		<img src="images/logo01.png" alt="<?php echo $ini_conf['SiteName'];?>" class="responsive login-img" />
	</div>
	<div class="col-md-6 login-container">
		<div class="col-md-12 noppading">
		<h1><?php echo strTranslate("Confirm_data");?></h1>
		<?php
		//CONFIRMAR USUARIO
		if (isset($_POST['user-username']) and $_POST['user-username'] != ""){
			$users = new users();


			$comentarios = sanitizeInput($_POST['user-piensas']);

			$confirmar=$users->confirmUser($_POST['user-username'],
										   $_POST['user-nick'],
										   $_POST['user-nombre'],
										   $_POST['user-apellidos'],
										   $_POST['user-pass'],
										   $_POST['user-email'],
										   $_FILES['nombre-fichero'],
										   $comentarios,
										   $_POST['user-date']);
			if ($confirmar ==1 ){ ?>
				<p><?php echo strTranslate("Confirmation_message");?> .</p>
				<br />
				<a href="login" class="btn btn-primary"><?php echo strTranslate("Identify_to_access");?></a>
				</div>
			<?php }
			elseif ($confirmar == 2) {
				ErrorMsg('<p>'.strTranslate("Error_procesing").'.</p>');
				ShowForm();
			}
			elseif ($confirmar == 3) {
				ErrorMsg('<p>'.strTranslate("Nick").' <b>'.$_POST['user-nick'].'</b> '.strTranslate("Already_exist").'.</p>');
				ShowForm();
			}	
		}
		else {ShowForm();}
  

///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////

function ShowForm()
{
  	//VERIFICAR QUE EL USUARIO NO ESTE YA CONFIRMADO
  	$users = new users();
	$pages = new pages();

	$declaracion = $pages->getPages(" AND page_name='declaracion' ");

	$usuario = $users->getUsers(" AND username='".$_SESSION['user_name']."' ");

	if ($usuario[0]['confirmed'] == 1) {
		echo '<div class="alert alert-warning">El usuario ya esta confirmado.
			Para acceder a la comunidad pincha <a href="login" class="comunidad-color">aquí</a>.</div>';
	}
	else {
		if (isset($_POST['user-nombre'])) {
			$user_nombre=$_POST['user-nombre'];
			$user_apellidos=$_POST['user-apellidos'];
			$user_email=$_POST['user-email'];
		}
		else {
			$user_nombre=$usuario[0]['name'];
			$user_apellidos=$usuario[0]['surname'];
			$user_email=$usuario[0]['email'];
		}
		$user_nick = "";
		$user_pass = "";
		$user_repass = "";

		if (isset($_POST['user-nick'])){$user_nick = $_POST['user-nick'];}
		if (isset($_POST['user-pass'])){$user_pass = $_POST['user-pass'];}
		if (isset($_POST['user-repass'])){$user_repass = $_POST['user-repass'];}
		?>

  		<form id="confirm-form" name="confirm-form" enctype="multipart/form-data" action="" method="post" role="form" class="form-horizontal">
			<input type="hidden" name="user-username" id="user-username" value="<?php echo $_SESSION['user_name'];?>">
			<div class="form-group">
				<label class="col-sm-4 control-label" for="username-text"><?php echo strTranslate("Username");?>:</label>
				<div class="col-sm-8">
					<input name="username-text" id="username-text" type="text" class="form-control" disabled="disabled" value="<?php echo $_SESSION['user_name'];?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label" for="user-nick"><?php echo strTranslate("Nick");?>:</label>
				<div class="col-sm-8">
					<input maxlength="100" name="user-nick" id="user-nick" type="text" class="form-control" value="<?php echo $user_nick;?>" data-alert="<?php echo strTranslate("Required_field");?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label" for="user-nombre"><?php echo strTranslate("Name");?>:</label></td>
				<div class="col-sm-8">
					<input maxlength="100" name="user-nombre" id="user-nombre" type="text" class="form-control" value="<?php echo $user_nombre;?>" data-alert="<?php echo strTranslate("Required_field");?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label" for="user-apellidos"><?php echo strTranslate("Surname");?>:</label></td>
				<div class="col-sm-8">
					<input maxlength="100" name="user-apellidos" id="user-apellidos" type="text" class="form-control" value="<?php echo $user_apellidos;?>" data-alert="<?php echo strTranslate("Required_field");?>" />
				</div>
			</div>

			<div class="form-group" style="display:none">
				<label class="col-sm-4 control-label" for="user-date"><?php echo strTranslate("Born_date");?>:</label></td>
				<div class="col-sm-8">
					<div id="datetimepicker1" class="input-group date">
						<input data-format="yyyy/MM/dd" readonly type="text" id="user-date" class="form-control" name="user-date"></input>
						<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label" for="user-email"><?php echo strTranslate("Email");?>:</label></td>
				<div class="col-sm-8">
					<input maxlength="100" name="user-email" id="user-email" type="text" class="form-control" value="<?php echo $user_email;?>" data-alert="<?php echo strTranslate("Required_email");?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label" for="user-pass"><?php echo strTranslate("Password");?>:</label></td>
				<div class="col-sm-8">
					<input maxlength="100" name="user-pass" id="user-pass" type="password" class="form-control" value="<?php echo $user_pass;?>" data-alert="<?php echo strTranslate("Required_field");?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label" for="user-repass"><?php echo strTranslate("Password_re");?>:</label></td>
				<div class="col-sm-8">
					<input maxlength="100" name="user-repass" id="user-repass" type="password" class="form-control" value="<?php echo $user_repass;?>" data-alert="<?php echo strTranslate("Password_not_match");?>" />
				</div>
			</div>

			<div class="form-group" style="display:none">
				<label class="col-sm-4 control-label" for="nombre-fichero"><?php echo strTranslate("Picture");?>:</label></td>
				<div class="col-sm-8">
					<input name="nombre-fichero" id="nombre-fichero" type="file"  class="btn btn-default" title="<?php echo strTranslate("Choose_file");?>" />
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-8">
					<div class="checkbox">
						<label>
							<input id="user-declaracion" name="user-declaracion" type="checkbox" value="1" /> <?php echo strTranslate("Acept");?> 
							<a href="#" id="declaracion-trigger"><?php echo strTranslate("Terms_and_conditions");?></a>
						</label>
						<span id="user-declaracion-alert" class="alert-message alert alert-danger"></span>
					</div>
				</div>
			</div>					 					 
			
			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-8 col-md-4">
					<button type="submit" name="confirm-submit" id="confirm-submit" class="btn btn-primary btn-block"><?php echo strTranslate("Send_data");?></button>
				</div>
			</div>
		</form>
		<br />
		</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal modal-wide fade" id="declaracionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel"><?php echo strTranslate("Terms_and_conditions");?></h4>
				</div>
				<div class="modal-body">
				<?php echo $declaracion[0]['page_content'];?>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<?php
  	}
}
?>