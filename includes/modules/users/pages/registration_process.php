<?php
$base_dir = str_replace('modules/users/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/class.users.php");
//session::ValidateSessionAjax();

//VERIFICAR CÓDIGO DE TIENDA
if (isset($_POST['cod_tienda']) and $_POST['cod_tienda']!=""){
	$users = new users();
	$tienda = $users->getTiendas(" AND cod_tienda='".$_POST['cod_tienda']."' ");
	if (count($tienda)==1){
		echo $tienda[0]['nombre_tienda'];
	}
	else{
		echo 'ko';
	}
}
?>