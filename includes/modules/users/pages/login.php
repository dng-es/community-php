<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
function ini_page_header ($ini_conf) { 
	if (isset($_SESSION['user_logged']) and $_SESSION['user_logged']) {header("Location: ?page=home");}
?>
	<script src="<?php echo getAsset("users");?>js/login.js"></script>
<?php
}
function ini_page_body ($ini_conf){
	if (isset($_POST['form-lostpw-user'])){
		  $users = new users();
		  $user = $users->getUsers(" AND username='".$_POST['form-lostpw-user']."'");
		  
		  if ($user[0]['user_password'] <> ''){
				$asunto = strtoupper($ini_conf['SiteName']).': '.strTranslate("Recover_credentials");
			  	$cuerpo_mensaje = strTranslate("Your_details_access").' '.$ini_conf['SiteName'].':
  '.strTranslate("Username").': '.$_POST['form-lostpw-user'].'
  '.strTranslate("Password").': '.$user[0]['user_password'];	

			  	if (SendEmail($ini_conf['ContactEmail'],$user[0]['email'],$asunto,$cuerpo_mensaje,0)) {
					$mensaje='<div class="alert alert-success">'.strTranslate("Recover_password_alert").'</div>';
				}
				else { $mensaje='<div class="alert alert-danger">'.strTranslate("Error_procesing").'</div>';}
		  } else {
			  $mensaje = '<div class="alert alert-danger">'.strTranslate("User_not_valid").'</div>';
		  }

		?>
		<div id="login-container">
			<img src="images/logo01.png" class="responsive login-img" />
            <p><?php echo $mensaje;?></p>
            <p><a class="btn btn-primary btn-block" href="?page=login"><?php echo strTranslate("Go_back");?></a></p>
        </div>
		<?php 
	} else if (!isset($_GET['do']) or $_GET['do'] <> "lostpw"){
		?>
		<div class="row" id="login-container-deg">
			<div class="col-md-6">
				<img src="images/logo01.png" class="responsive login-img" />
			</div>
			<div class="col-md-6 login-right">
				<div class="col-md-12 noppading">
		            <h2><?php echo strTranslate("Identify_to_access");?></h2>
		            <form method="post" action="" name="form-login" id="form-login" role="form" class="form-horizontal">          
		                <div class="row">
			                <div class="col-md-6"> 
				                <div class="form-group">
								    <label for="form-login-user" class="col-sm-4 control-label"><?php echo strTranslate("Username");?></label>
								    <div class="col-sm-8">
								      <input type="text" class="form-control" id="form-login-user" name="form-login-user" placeholder="<?php echo strTranslate("Username");?>">
								    </div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
								    <label for="form-login-password" class="col-sm-4 control-label"><?php echo strTranslate("Password");?></label>
								    <div class="col-sm-8">
								      <input type="password" class="form-control" id="form-login-password" name="form-login-password" placeholder="<?php echo strTranslate("Password");?>">
								    </div>
								</div>
							</div>
						</div>
		                <button type="submit" name="loginSubmit" id="loginSubmit" class="btn btn-primary pull-right"><?php echo strTranslate("Enter");?></button>
		                <p><?php echo strTranslate("Forgot_your_password");?> <a href="?page=login&do=lostpw" ><?php echo strTranslate("Click_here");?></a></p>
		            </form>
		        </div>
		        <div class="col-md-12" style="border-top:1px solid #1d7493;padding-top:20px;margin-top:20px">
					<p><?php echo strTranslate("If_not_registered");?> <a class="btn btn-primary" href="?page=registration"><?php echo strTranslate("Register");?></a></p>
		        </div>
        	</div>
        </div>
		<?php 
	} else {
		?>
		<div id="login-container" class="container">
            <form method="post" action="" name="form-lostpw" id="form-lostpw" role="form" class="form-signin">
            	<img src="images/logo01.png" class="responsive login-img" />
            	<p><?php echo strTranslate("Recover_password_info");?></p>
                <label for="form-lostpw-user" class="sr-only"><?php echo strTranslate("Username");?>:</label>
                <input type="text" name="form-lostpw-user" id="form-lostpw-user" class="form-control" placeholder="<?php echo strTranslate("Username");?>" required autofocus />
                <button type="button" name="PassSubmit" id="PassSubmit" class="btn btn-primary btn-block"><?php echo strTranslate("Recover_password");?></button>
                <a class="btn btn-primary btn-block" id="back-link" href="?page=login"><?php echo strTranslate("Go_back");?></a>
            </form>		
		</div>
		<?php 
	}
}
?>