<?php
class promocionesController{
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
							"LabelSection" => 'Destacado',
							"LabelItem" => 'Establecer destacado',
							"LabelUrl" => 'admin-destacados',
							"LabelPos" => 1));	
	}	
}
?>