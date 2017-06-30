<?php
$base_dir = str_replace('modules/users/pages', '', realpath(dirname(__FILE__)));
include_once($base_dir . "modules/class.headers.php");

addJavascripts(array(getAsset("users")."js/remember.js"));
$module_config = getModuleConfig("users");
?>
<div class="row" id="login-container-deg">
	<div class="col-md-5">
		<img src="themes/<?php echo $_SESSION['user_theme'];?>/images/logo01.png" alt="<?php echo $ini_conf['SiteName'];?>" class="responsive login-img" />
	</div>
	<div class="col-md-7 login-container">
		<h1 class="inset"><?php e_strTranslate("Recover_password");?></h1>
		<?php
		session::getFlashMessage( 'actions_message' );
		usersController::recoverPasswordAction();?>
		<form method="post" action="" name="formRemember" id="formRemember" role="form" class="form-signin form-horizontal">
			<div class="row">
				<div class="col-md-10">
					<label for="form-lostpw-user"><?php e_strTranslate("Recover_password_info");?></label>
					<input type="text" name="form-lostpw-user" id="form-lostpw-user" class="form-control" placeholder="<?php e_strTranslate("Username");?>" required autofocus />
					<div class="row nopadding">
						<div class="col-md-6 nopadding">
							<br />
							<button type="submit" name="rememberSubmit" id="rememberSubmit" class="btn btn-primary btn-block"><?php e_strTranslate("Recover_password");?></button>
						</div>
						<div class="col-md-6 nopadding">
							<br />
							<a href="login" class="btn btn-default btn-block"><?php e_strTranslate("Identify_to_access");?></a>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div class="container-separator">
			<?php if ($module_config['options']['allow_registration'] === true) :
				e_strTranslate("If_not_registered");?> <a  href="registration"><?php e_strTranslate("Register");?></a>
			<?php endif;?>
		</div>
	</div>
</div>