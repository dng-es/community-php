<?php
usersController::loginRedirectAction(); 
addJavascripts(array(getAsset("users")."js/login.js"));
session::getFlashMessage('actions_message');
$module_config = getModuleConfig("users");
?>
<div class="row" id="login-container-deg">
	<div class="col-md-5">
		<img src="images/logo01.png" alt="<?php echo $ini_conf['SiteName'];?>" class="responsive login-img" />
	</div>
	<div class="col-md-7 login-container">
		<h1 class="inset"><?php echo strTranslate("Identify_to_access");?></h1>
		<?php session::getFlashMessage('actions_message');?>
		<form method="post" action="" name="form-login" id="form-login" role="form" class="form-horizontal">          
			<div class="row">
				<div class="col-md-5"> 
					<div class="form-group has-feedback">
						<label for="form-login-user" class="col-sm-4 control-label"><?php echo strTranslate("Username");?></label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="form-login-user" name="form-login-user" placeholder="<?php echo strTranslate("Username");?>">
							<span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="form-group has-feedback">
						<label for="form-login-password" class="col-sm-4 control-label"><?php echo strTranslate("Password");?></label>
						<div class="col-sm-8">
							<input type="password" class="form-control" id="form-login-password" name="form-login-password" placeholder="<?php echo strTranslate("Password");?>">
							<span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span>
						</div>
					</div>
				</div>
				<div class="col-md-2">
				<button type="submit" name="loginSubmit" id="loginSubmit" class="btn btn-primary btn-block"><?php echo strTranslate("Enter");?></button>
				</div>
			</div>
		</form>
		<div class="container-separator">
			<a href="remember" class="login-link"><?php echo strTranslate("Forgot_your_password");?> <i class="fa fa-chevron-circle-right"></i></a>
			<?php if ($module_config['options']['allow_registration'] === true)  echo '<a href="registration" class="login-link">'.strTranslate("Register").' <i class="fa fa-chevron-circle-right"></i></a>';?>
			<br /><br />
		</div>
	</div>
</div>