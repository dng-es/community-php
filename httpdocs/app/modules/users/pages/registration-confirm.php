<div id="confirm-container" class="row">      
	<div class="col-md-6">
		<img src="images/logo01.png" class="responsive login-img" />
	</div>
	<div class="col-md-6" style="border-left:1px solid #a1569d">
		<h1>Confirmación de usuario</h1>
		<?php
		$users = new users();
		if (connection::countReg("users"," AND sha1(username)='".$_REQUEST['a']."' AND sha1(user_password)='".$_REQUEST['c']."' AND sha1(email)='".$_REQUEST['b']."' ")==1){
			if($users->confirmRegistration($_REQUEST['a'],$_REQUEST['b'],$_REQUEST['c'])){
				echo '<p>Usuario confirmado correctamente. Pincha <a href="?page=login">aquí</a> para acceder.</p>';
			}
			else{echo '<p>No se encuentran sus datos para realizar la activación</p>';}
		}
		else{
			echo '<p>No se encuentran sus datos para realizar la activación</p>';
		}
		?>
	</div>
</div>