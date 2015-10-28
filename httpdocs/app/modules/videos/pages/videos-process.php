<?php
$base_dir = str_replace('modules/videos/pages', '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");
include_once($base_dir . "modules/videos/classes/class.videos.php");

session::ValidateSessionAjax();
$videos = new videos();
//REGISTRAR REPRODUCCION
if (isset($_POST['v']) and $_POST['v'] != ""){
	echo $videos->insertVideoView($_POST['v'], $_SESSION['user_name']);
}
?>