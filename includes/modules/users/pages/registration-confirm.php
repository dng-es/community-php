<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_admin=0;
function ini_page_header ($ini_conf) { ?>

<?php
}
function ini_page_body ($ini_conf){ 
  echo '<div id="confirm-container" class="row">      
          <div class="col-md-6">
            <img src="images/logo01.png" class="responsive login-img" />
          </div>
          <div class="col-md-6" style="border-left:1px solid #a1569d"><h2>Confirmación de usuario</h2>';
  ShowForm();
  echo '</div>
  </div>';
}

///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////

function ShowForm()
{
  $users = new users();
  if ($users->countReg("users"," AND sha1(username)='".$_REQUEST['a']."' AND sha1(user_password)='".$_REQUEST['c']."' AND sha1(email)='".$_REQUEST['b']."' ")==1){
  	if($users->confirmRegistration($_REQUEST['a'],$_REQUEST['b'],$_REQUEST['c'])){
  		echo '<p>Usuario confirmado correctamente. Pincha <a href="?page=login">aquí</a> para acceder.</p>';
  	}
  	else{echo '<p>No se encuentran sus datos para realizar la activación</p>';}
  }
  else{
  	echo '<p>No se encuentran sus datos para realizar la activación</p>';
  }
}
?>