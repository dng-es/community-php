<?php
$base_dir = str_replace('modules/cuestionarios/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/cuestionarios/classes/class.cuestionarios.php");

//session::ValidateSessionAjax();


//OBTENER RESPUESTAS
if (isset($_POST['cuestionario']) and $_POST['cuestionario'] != ""){
	$cuestionarios = new cuestionarios();
	$datos = "<ul>";
	$respuestas=$cuestionarios->getRespuestasUserAdmin(" AND p.id_cuestionario=".$_POST['cuestionario']." and r.respuesta_user='".$_POST['user']."' ");
	foreach($respuestas as $respuesta):
		$datos.="<li>".$respuesta['Pregunta'].": <strong>".$respuesta['Respuesta']."</strong></li>";
	endforeach;
	$datos.="</ul>";
	echo $datos;
}
?>