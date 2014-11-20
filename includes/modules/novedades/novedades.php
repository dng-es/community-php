<?php
class novedadesCore{
	public static function updateAction(){
		if (isset($_POST['texto'])){
			$novedades = new novedades();		
			$cuerpo = stripslashes($_POST['texto']);
			$activo = ($_POST['activo']=="on" ? 1 : 0);
			$canal = $_POST['canal'];

			if ($novedades->updateNovedades($cuerpo,$activo, $canal)) {
				session::setFlashMessage( 'actions_message', "Modificación realizada correctamente.", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al modificar registro.", "alert alert-danger");
			}
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function adminMenu(){
		return array(
			menu::addAdminMenu(array(
				"PageName" => "admin-novedades",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("News"),
				"LabelItem" => strTranslate("News_update"),
				"LabelUrl" => "admin-novedades",
				"LabelPos" => 1,
			))
		);
	}	
}
?>