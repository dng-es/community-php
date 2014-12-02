<?php
class destacadosController{


	public static function updateAction(){
		if (isset($_POST['id_destacado']) and $_POST['id_destacado']!=""){
			$destacados = new destacados();
			if ($destacados->InsertDestacado($_POST['tipo_destacado'],$_POST['id_destacado'],$_POST['texto_destacado'],$_POST['canal_destacado'])) {
				session::setFlashMessage( 'actions_message', "Destacado modificado correctamente.", "alert alert-success");
				redirectURL($_SERVER['REQUEST_URI']);
			}
		}
	}	
}
?>