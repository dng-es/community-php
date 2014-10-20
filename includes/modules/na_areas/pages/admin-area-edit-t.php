<?php
include_once("includes/constants.php");
include_once("includes/core/functions.core.php");
include_once("includes/core/class.connection.php");
include_once("includes/core/class.session.php");
include_once("includes/users/class.users.php");	
include_once("includes/na_areas/class.na_areas.php");

//ACTUALIZAR TAREA
if (isset($_POST['tarea']) and $_POST['tarea']!=""){
	$na_areas = new na_areas();
	if ($na_areas->updateTarea($_POST['tarea'],$_POST['descripcion'])){echo 'ok';}
	else {echo 'ko';}
} 
?>