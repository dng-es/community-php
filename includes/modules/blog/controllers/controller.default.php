<?php
class blogController{
	public static function createAction(){
		
	}

	public static function updateAction(){
	
	}

/**
	 * Para mostrar estadisticas de uso del modulo por parte de un usuario
	 * @param  	string 		$username 		Id usuario a mostrar información
	 * @return 	array           			Array con resultados
	 */
	public function userModuleStatistis($username){
		$num = connection::countReg("foro_comentarios c LEFT JOIN foro_temas t ON c.id_tema=t.id_tema "," AND t.ocio=1 AND c.user_comentario='".$username."' ");


		return array('Comentarios en los blogs' => $num);	
	}	

	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */	
	public static function adminMenu(){
		return array( array("LabelHeader" => 'Modules',
							"LabelSection" => strTranslate('Blog'),
							"LabelItem" => strTranslate("New_post"),
							"LabelUrl" => 'admin-blog-new&act=new',
							"LabelPos" => 1),
					  array("LabelHeader"=>'Modules',
							"LabelSection"=>strTranslate('Blog'),
							"LabelItem"=>strTranslate("Posts_list"),
							"LabelUrl"=>'admin-blog',
							"LabelPos" => 2));	
	}			
}
?>