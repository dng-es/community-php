<?php
usersController::loginRedirectAction(); 
addJavascripts(array(getAsset("users")."js/login.js"));
session::getFlashMessage('actions_message');
$module_config = getModuleConfig("users");
?>
<div class="row" id="login-container-deg">
	<div class="col-md-5">
		<img src="themes/<?php echo $_SESSION['user_theme'];?>/images/logo01.png" alt="<?php echo $ini_conf['SiteName'];?>" class="responsive login-img" />
	</div>
	<div class="col-md-6 login-container">
		<h1 class="inset"><?php e_strTranslate("Identify_to_access");?></h1>
		<?php session::getFlashMessage('actions_message');?>
		<form method="post" action="" name="form-login" id="form-login" role="form" class="form-horizontal" autocomplete="off">          
			<div class="row">
				<div class="col-md-4"> 
					<div class="form-group has-feedback">
						<label for="form-login-user" class="sr-only col-sm-4 control-label"><?php e_strTranslate("Username");?></label>
						<div class="col-sm-12 form-control-container">
							<input type="text" class="form-control" id="form-login-user" name="form-login-user" placeholder="<?php e_strTranslate("Username");?>">
							<span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
							<div class="input-effect"></div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group has-feedback">
						<label for="form-login-password" class="sr-only col-sm-4 control-label"><?php e_strTranslate("Password");?></label>
						<div class="col-sm-12 form-control-container">
							<input type="password" class="form-control" id="form-login-password" name="form-login-password" placeholder="<?php e_strTranslate("Password");?>">
							<span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span>
							<div class="input-effect"></div>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-md-offset-1">
					<button type="submit" name="loginSubmit" id="loginSubmit" class="btn btn-primary btn-block"><?php e_strTranslate("Enter");?></button>
				</div>
			</div>
		</form>
		<div class="container-separator">
			<a href="remember" class="login-link"><?php e_strTranslate("Forgot_your_password");?> <i class="fa fa-chevron-circle-right"></i></a>
			<?php if ($module_config['options']['allow_registration'] === true)  echo '<br /><a href="registration" class="login-link">'.strTranslate("Register").' <i class="fa fa-chevron-circle-right"></i></a>';?>
			<br /><br />
		</div>
	</div>
</div>