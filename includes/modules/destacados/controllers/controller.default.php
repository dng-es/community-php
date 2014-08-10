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

	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */	
	public static function adminMenu(){
		return array( array("LabelHeader" => 'Modules',
							"LabelSection" => strTranslate("Reto_tag"),
							"LabelItem" => 'Nuevo / Modificar',
							"LabelUrl" => 'admin-reto&act=edit',
							"LabelPos" => 1),
					  array("LabelHeader" => 'Modules',
							"LabelSection" => strTranslate("Reto_tag"),
							"LabelItem" => 'Validar contenidos',
							"LabelUrl" => 'admin-validacion-reto',
							"LabelPos" => 2));	
	}	
}
?>