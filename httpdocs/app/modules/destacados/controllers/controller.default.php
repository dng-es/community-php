<?php
class destacadosController{
	public static function updateAction(){
		if (isset($_POST['id_destacado']) && $_POST['id_destacado'] != ""){
			$destacados = new destacados();
			$id_destacado = intval($_REQUEST['id_destacado']);
			$tipo_destacado = sanitizeInput($_POST['tipo_destacado']);
			$texto_destacado = sanitizeInput($_POST['texto_destacado']);
			$canal_destacado = sanitizeInput($_POST['canal_destacado']);
			if ($id_destacado > 0){
				if ($destacados->InsertDestacado($tipo_destacado, $id_destacado, $texto_destacado, $canal_destacado)) 
					session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
				else
					session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			}
			else session::setFlashMessage('actions_message', strTranslate("Required_all_fields"), "alert alert-danger");
			
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}
}
?>