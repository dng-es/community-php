<?php
$base_dir = str_replace('modules/fotos/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/class.users.php");
include_once($base_dir . "modules/fotos/class.fotos.php");
include_once($base_dir . "modules/users/templates/tipuser.php");
include_once($base_dir . "modules/fotos/templates/comment.php");


session::ValidateSessionAjax();
$fotos=new fotos();
//VOTAR FOTO
if (isset($_POST['idv']) and $_POST['idv']!=""){
	echo $fotos->InsertVotacion($_POST['idv'],$_SESSION['user_name']);
}

//INSERTAR COMENTARIO
if (isset($_POST['respuesta-texto']) and $_POST['respuesta-texto']!=""){
	echo $fotos->InsertComentario($_POST['id_file'],$_POST['respuesta-texto'],$_SESSION['user_name'],1);
}

//MOSTRAR COMENTARIOS
if ($_REQUEST['idf'] and $_REQUEST['idf']!=""){
	$elements = $fotos->getComentariosFoto(" AND id_file=".$_REQUEST['idf']." AND estado=1 ORDER BY id_comentario DESC");
	foreach($elements as $element):
		commentFoto($element,"");
	endforeach;
}
?>