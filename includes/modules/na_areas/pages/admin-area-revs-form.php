<?php
$base_dir = str_replace('modules/na_areas/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/na_areas/classes/class.na_areas.php");

//session::ValidateSessionAjax();


//OBTENER RESPUESTAS
if (isset($_POST['tarea']) and $_POST['tarea']!=""){
	$na_areas = new na_areas();
	$datos="<ul>";
	$respuestas=$na_areas->getRespuestasUserAdmin(" AND p.id_tarea=".$_POST['tarea']." and r.respuesta_user='".$_POST['user']."' ");
	foreach($respuestas as $respuesta):
		$datos.="<li>".$respuesta['Pregunta'].": <strong>".$respuesta['Respuesta']."</strong></li>";
	endforeach;
	$datos.="</ul>";
	echo $datos;
} 
?>