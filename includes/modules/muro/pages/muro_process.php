<?php
include_once("includes/constants.php");
include_once("includes/core/functions.php");
include_once("includes/core/class.connection.php");
include_once("includes/core/class.session.php");
include_once("includes/users/class.users.php");
include_once("includes/muro/class.muro.php");
session::ValidateSessionAjax();
$muro=new muro();
//INSERTAR COMENTARIO
if (isset($_POST['texto-comentario']) and $_POST['texto-comentario']!=""){
	if ($_SESSION['user_perfil']!='admin' and $_SESSION['user_perfil']!='formador'){$canal=$_SESSION['user_canal'];}
	else { $canal=$_POST['canal_comentario'];}
		ErrorMsg($insercion_comentario = $muro->InsertComentario($canal,
															$_POST['texto-comentario'],
															$_SESSION['user_name'],
															ESTADO_COMENTARIOS_MURO,
															$_POST['tipo_muro']));
}
//RESPONDER COMENTARIO
if (isset($_POST['id_comentario_responder']) and $_POST['id_comentario_responder']!="") { 
	if ($_POST['texto-responder']==''){ErrorMsg("Debe insertar algo de texto");}
	else{
		ErrorMsg($insercion_respuesta = $muro->responderComentarioMuro( $_SESSION['user_name'],
																	ESTADO_COMENTARIOS_MURO,
																	$_POST['id_comentario_responder'],
																	$_POST['texto-responder']));
	}
}
?>