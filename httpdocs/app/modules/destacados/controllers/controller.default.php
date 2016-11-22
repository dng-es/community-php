<?php
class destacadosController{
	public static function updateAction(){
		if (isset($_POST['id_destacado']) and $_POST['id_destacado'] != ""){
			$destacados = new destacados();
			if ($destacados->InsertDestacado($_POST['tipo_destacado'], $_POST['id_destacado'], $_POST['texto_destacado'], $_POST['canal_destacado'])) 
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}
}
?>