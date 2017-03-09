<?php
addCss(array("css/bootstrap-datetimepicker.min.css"));
addJavascripts(array("js/bootstrap.file-input.js", 
					 "js/bootstrap-datepicker.js",
					 getAsset("users")."js/registration.js"));
$module_config = getModuleConfig("users");
if ($module_config['options']['allow_registration'] === true):
?>
<div id="confirm-container" class="row">			
	<div class="col-md-5">
		<img src="themes/<?php echo $_SESSION['user_theme'];?>/images/logo01.png" alt="<?php echo $ini_conf['SiteName'];?>" class="responsive login-img" />
	</div>
	<div class="col-md-6 login-container">
		<div class="col-md-12">
		<?php
		session::getFlashMessage( 'actions_message' );

		//REGISTRO USUARIO
		if (isset($_POST['username-text']) && $_POST['username-text'] != ""){
			$users = new users();
			$confirmar=$users->registerUser(sanitizeInput($_POST['username-text']),
											sanitizeInput($_POST['user-nick']),
											sanitizeInput($_POST['user-nombre']),
											sanitizeInput($_POST['user-apellidos']),
											sanitizeInput($_POST['user-pass']),
											sanitizeInput($_POST['user-email']),
											$_FILES['nombre-fichero'],
											'',
											sanitizeInput($_POST['user-date']),
											sanitizeInput($_POST['user-empresa']));


			if ($confirmar == 1){
				$subject_mail = "Alta de usuario en ".$ini_conf['SiteName'];;
				$template = new tpl("registration", "users");
				$template->setVars(array(
					"title_email" => strTranslate("Registration"),
					"registration_link" => 'registration-confirm?a='.sha1($_POST['username-text']).'&b='.sha1($_POST['user-email']).'&c='.sha1($_POST['user-pass'])
				));

				$body_mail = $template->getTpl();

				//SendEmail($ini_conf['ContactEmail'],$_POST['user-email'],$subject_mail,$body_mail,0,$ini_conf['SiteName']);
				messageProcess($subject_mail, array($ini_conf['MailingEmail'] => $ini_conf['SiteName']), array($_POST['user-email']), $body_mail, null);
				redirectURL("registration?m=1");
			}
			elseif ($confirmar == 2) ErrorMsg("<p>Se ha producido algun error al confirmar sus datos.</p>");
			elseif ($confirmar == 3) ErrorMsg("<p>El nick <b>".$_POST['user-nick']."</b> ya existe.</p>");
			elseif ($confirmar == 4) ErrorMsg("<p>El código de tienda introducido no es válido.</p>");
			elseif ($confirmar == 5) ErrorMsg("<p>El DNI/usuario ya existe.</p>");
		}

		if (isset($_REQUEST['m']) && $_REQUEST['m'] == 1){ ?>
				<h1><?php e_strTranslate("Registration");?></h1>
				<p>
					Tus datos se han registrado correctamente.<br />
					Recibirás en tu cuenta de correo un email para confirmar tu registro, sigue las instrucciones del mensaje para acceder.
				</p>
				<br />
				<a href="login" class="btn btn-default btn-lg"><?php e_strTranslate("Identify_to_access");?></a>	
			</div>
		<?php }
		else{
		$pages = new pages();
		$politica = $pages->getPages(" AND page_name='policy' ");
		$declaracion = $pages->getPages(" AND page_name='declaracion' ");

		$user_name = "";
		$user_nombre = "";
		$user_apellidos = "";
		$user_email = "";
		$user_nick = "";
		$user_pass = "";
		$user_repass = "";
		$user_empresa = "";
		$user_date = "";

		if (isset($_POST['username-text'])) {
			$user_name = $_POST['username-text'];
			$user_nombre = $_POST['user-nombre'];
			$user_apellidos = $_POST['user-apellidos'];
			$user_email = $_POST['user-email'];
			$user_nick = $_POST['user-nick'];
			$user_pass = $_POST['user-pass'];
			$user_repass = $_POST['user-repass'];
			$user_empresa = $_POST['user-empresa'];
			$user_date = $_POST['user-date'];
		}
		?>
		<h1><?php e_strTranslate("Registration");?></h1>
		<form id="confirm-form" name="confirm-form" enctype="multipart/form-data" action="" method="post" role="form" class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-4 control-label" for="username-text"><?php e_strTranslate("Username");?>:</label>
				<div class="col-sm-8">	
					<input name="username-text" id="username-text" type="text" class="form-control" value="<?php echo $user_name;?>" placeholder="" />
					<span id="username-text-alert" class="alert-message alert alert-danger"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="user-empresa"><?php e_strTranslate("Group_user");?>:</label>
				<div class="row">
					<div class="col-xs-5">
						<input name="user-empresa" id="user-empresa" date-c="0" type="text" class="form-control" value="<?php echo $user_empresa;?>" placeholder="" />
					</div>
					<div class="col-xs-7">
						<input name="user-empresa-nombre" id="user-empresa-nombre" type="text" class="form-control" disabled="disabled" value="" />
				<span id="user-empresa-alert" class="alert-message alert alert-danger"></span>
				<span id="tienda-alert" class="alert-message alert alert-danger"></span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="user-nick"><?php e_strTranslate("Nick");?>:</label>
				<div class="col-sm-8">
					<input maxlength="100" name="user-nick" id="user-nick" type="text" class="form-control" value="<?php echo $user_nick;?>" placeholder="" />
					<span id="user-nick-alert" class="alert-message alert alert-danger"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="user-nombre"><?php e_strTranslate("Name");?>:</label>
				<div class="col-sm-8">
					<input maxlength="100" name="user-nombre" id="user-nombre" type="text" class="form-control" value="<?php echo $user_nombre;?>" placeholder="" />
					<span id="user-nombre-alert" class="alert-message alert alert-danger"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="user-apellidos"><?php e_strTranslate("Surname");?>:</label>
				<div class="col-sm-8">
					<input maxlength="100" name="user-apellidos" id="user-apellidos" type="text" class="form-control" value="<?php echo $user_apellidos;?>" placeholder="" />
					<span id="user-apellidos-alert" class="alert-message alert alert-danger"></span>
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
				<script>
					jQuery(document).ready(function(){
						$("#datetimepicker1").datetimepicker({
						  language: "es-ES",
						  startDate: "2014/01/01"
						});
						<?php if (isset($user_date) && $user_date != ""){
							echo "var fecha = '".date('D M d Y H:i:s O',strtotime($user_date))."';";
							echo '$("#datetimepicker1").data("datetimepicker").setLocalDate(new Date (fecha));';
						}?>
					});
				</script>

				<span id="user-date-alert" class="alert-message alert alert-danger"></span>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="user-email">Email:</label>
				<div class="col-sm-8">
					<input maxlength="100" name="user-email" id="user-email" type="text" class="form-control" value="<?php echo $user_email;?>" placeholder="Intruduce tu email" />
					<span id="user-email-alert" class="alert-message alert alert-danger"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="user-pass"><?php e_strTranslate("Password");?>:</label>
				<div class="col-sm-8">
					<input maxlength="100" name="user-pass" id="user-pass" type="password" class="form-control" value="<?php echo $user_pass;?>" />
					<span id="user-pass-alert" class="alert-message alert alert-danger"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" for="user-repass"><?php e_strTranslate("Password_re");?>:</label>
				<div class="col-sm-8">
					<input maxlength="100" name="user-repass" id="user-repass" type="password" class="form-control" value="<?php echo $user_repass;?>" />
					<span id="user-repass-alert" class="alert-message alert alert-danger"></span>
				</div>
			</div>
			<div class="form-group" style="display:none">
				<label class="col-sm-4 control-label" for="nombre-fichero">Foto:</label>
				<div class="col-sm-8">
					<input name="nombre-fichero" id="nombre-fichero" type="file"  class="btn btn-default" title="<?php e_strTranslate("Choose_file");?>" />
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-8">
					<div class="checkbox checkbox-primary">
						<input type="checkbox" class="styled" id="user-declaracion"  name="user-declaracion">
						<label for="confirmed_user"> <?php e_strTranslate("Acept");?> 
							<a href="#" id="declaracion-trigger"><?php e_strTranslate("Terms_and_conditions");?></a></label>
					</div>
					<span id="user-declaracion-alert" class="alert-message alert alert-danger"></span>
				</div>
			</div>


			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-8">
					<div class="row">
						<div class="col-md-5">
							<br />
							<button type="submit" name="confirm-submit" id="confirm-submit" class="btn btn-primary btn-block"><?php e_strTranslate("Register");?></button>
						</div>
						<div class="col-md-7">
							<br />
							<a href="login" class="btn btn-default btn-block"><?php e_strTranslate("Identify_to_access");?></a>
						</div>
					</div>
				</div>
			</div>
		</form>
		<br />
	</div>
	</div>
</div>


<?php }?>
<?php else: ?>
	<h1><?php e_strTranslate("Access_denied");?></h1>
<?php endif; ?>


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