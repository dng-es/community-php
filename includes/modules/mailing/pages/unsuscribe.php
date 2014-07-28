<?php

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

function ini_page_header ($ini_conf) { ?>

<?php
}
function ini_page_body ($ini_conf){  
	?>
  	<div id="confirm-container" class="row">			
		<div class="col-md-6">
			<img src="images/logo01.png" class="responsive login-img" />
		</div>
		<div class="col-md-6" style="border-left:1px solid #1d7493">
			<h2>Confirmación de baja</h2>
			<?php 
			session::getFlashMessage( 'actions_message' );  
			mailingController::createBlackAction();	  
			if (sha1($_GET['u'])==$_GET['ua']):?>
				<p>Desea darse de baja de nuestro servicio con el email: <b><?php echo $_GET['u'];?></b></p>
				<form id="confirm-form" name="confirm-form" enctype="multipart/form-data" action="" method="post" role="form" class="form-signin">
					<input type="hidden" name="email_black" id="email_black" value="<?php echo $_GET['u'];?>">
					<input type="submit" class="btn btn-primary" value="Confirmar baja" />
				</form>
			<?php endif; ?>
		</div>
	</div>
<?php
}
?>