<?php
class destacadosController{
	public static function createAction(){
		
	}

	public static function updateAction(){

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