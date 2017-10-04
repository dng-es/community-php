<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/users/pages' : 'modules\\users\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");

if(isset($_POST['user_recommend']) && $_POST['user_recommend'] != ''){
	$user_recommend = trim(sanitizeInput($_POST['user_recommend']));
	if (connection::countReg("users", " AND username='".$user_recommend."' AND disabled=0 AND confirmed=1 AND username<>'".$_SESSION['user_name']."' ") > 0) echo '<i class="text-success fa fa-check-circle fa-3x" title="'.strTranslate("Found").'"></i>';
	else echo '<i class="text-danger fa fa-times-circle fa-3x" title="'.strTranslate("Not_found").'"></i>';
}
?>