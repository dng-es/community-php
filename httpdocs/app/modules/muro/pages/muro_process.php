<?php
$base_dir = str_replace('modules/muro/pages', '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");
include_once($base_dir . "modules/muro/classes/class.muro.php");

session::ValidateSessionAjax();
$muro = new muro();
//INSERTAR COMENTARIO
if (isset($_POST['texto-comentario']) and $_POST['texto-comentario'] != ""){
	if ($_SESSION['user_canal'] != 'admin') $canal = $_SESSION['user_canal'];
	else $canal = sanitizeInput($_POST['canal_comentario']);

	$texto_comentario = nl2br(sanitizeInput($_POST['texto-comentario']));
	ErrorMsg($insercion_comentario = $muro->InsertComentario($canal,
														$texto_comentario,
														$_SESSION['user_name'],
														ESTADO_COMENTARIOS_MURO,
														$_POST['tipo_muro']));
}
//RESPONDER COMENTARIO
if (isset($_POST['id_comentario_responder']) and $_POST['id_comentario_responder'] != ""){ 
	if ($_POST['texto-responder'] == '') ErrorMsg("Debe insertar algo de texto");
	else{
		$id = sanitizeInput($_POST['id_comentario_responder']);
		$texto_comentario = nl2br(sanitizeInput($_POST['texto-responder']));
		ErrorMsg($insercion_respuesta = $muro->responderComentarioMuro( $_SESSION['user_name'],
																	ESTADO_COMENTARIOS_MURO,
																	$id,
																	$texto_comentario));
	}
}
?>