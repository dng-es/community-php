<?php

class guides{

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getGuides($filter = ""){
		$Sql="SELECT * FROM guides WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getGuidesCategories($filter = ""){
		$Sql="SELECT g.name_guide,g.type_guide,c.* FROM guides_categories c 
			LEFT JOIN guides g ON g.id_guide=c.id_guide 
			WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}  

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getGuidesSubCategories($filter = ""){
		$Sql="SELECT g.id_guide,g.name_guide, g.type_guide,c.name_guide_category,t.name_guide_subcategory_type,t.icon_guide_subcategory_type,s.* FROM guides_subcategories s
			LEFT JOIN guides_categories c ON s.id_guide_category=c.id_guide_category
			LEFT JOIN guides_subcategories_types t ON s.id_guide_subcategory_type=t.id_guide_subcategory_type
			LEFT JOIN guides g ON g.id_guide=c.id_guide 
			WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}  

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getGuidesSubCategoriesTypes($filter = ""){
		$Sql="SELECT * FROM guides_subcategories_types WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	} 

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getGuidesSubCategoriesUsers($filter = ""){
		$Sql="SELECT g.name_guide,c.name_guide_category,t.name_guide_subcategory_type,ug.*,u.* FROM guides_subcategories_users ug
			LEFT JOIN guides_subcategories s ON s.id_guide_subcategory=ug.id_guide_subcategory
			LEFT JOIN guides_subcategories_types t ON s.id_guide_subcategory_type=t.id_guide_subcategory_type
			LEFT JOIN guides_categories c ON s.id_guide_category=c.id_guide_category
			LEFT JOIN guides g ON g.id_guide=c.id_guide 
			LEFT JOIN users u ON u.username=ug.user_guide
			WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	} 

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getGuidesSubCategoriesUsersExport($filter = ""){
		$Sql="SELECT g.name_guide AS Guía,c.name_guide_category AS Categoría,t.name_guide_subcategory_type AS Tipo,ug.user_guide AS Usuario,CONCAT(u.name,' ',u.surname) AS Nombre,ug.user_guide_like AS 'Me gusta',ug.user_guide_comment AS Comentarios,ug.date_user_guide AS Fecha 
			FROM guides_subcategories_users ug
			LEFT JOIN guides_subcategories s ON s.id_guide_subcategory=ug.id_guide_subcategory
			LEFT JOIN guides_subcategories_types t ON s.id_guide_subcategory_type=t.id_guide_subcategory_type
			LEFT JOIN guides_categories c ON s.id_guide_category=c.id_guide_category
			LEFT JOIN guides g ON g.id_guide=c.id_guide 
			LEFT JOIN users u ON u.username=ug.user_guide
			WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}  				 

	/**
	 * Elimina registro en guides
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  int 		$activo 	Estado del registro
	 * @return boolean 				Resultado de la SQL
	 */
	public function deleteGuide($id, $activo){
		$Sql = "UPDATE guides SET active_guide=".$activo." WHERE id_guide=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Elimina registro en guides
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  int 		$activo 	Estado del registro
	 * @return boolean 				Resultado de la SQL
	 */
	public function deleteGuideCategory($id, $activo){
		$Sql = "UPDATE guides_categories SET active_guide_category=".$activo." WHERE id_guide_category=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Elimina registro en guides
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  int 		$activo 	Estado del registro
	 * @return boolean 				Resultado de la SQL
	 */
	public function deleteGuideSubCategory($id, $activo){
		$Sql = "UPDATE guides_subcategories SET active_guide_subcategory=".$activo." WHERE id_guide_subcategory=".$id;
		return connection::execute_query($Sql);
	}	

	/**
	 * Elimina registro en guides
	 * @param  int 		$id 		Id registro a eliminar
	 * @param  int 		$activo 	Estado del registro
	 * @return boolean 				Resultado de la SQL
	 */
	public function deleteGuideSubCategoryType($id, $activo){
		$Sql = "UPDATE guides_subcategories_types SET active_guide_subcategory_type=".$activo." WHERE id_guide_subcategory_type=".$id;
		return connection::execute_query($Sql);
	}

	public function insertGuide($name_guide, $type_guide, $order_guide, $active_guide){
		$Sql = "INSERT INTO guides(name_guide, type_guide, order_guide, active_guide) 
				VALUES ('".$name_guide."','".$type_guide."', ".$order_guide.", ".$active_guide.")";
		return connection::execute_query($Sql);
	}

	public function updateGuide($id, $name_guide, $type_guide, $order_guide, $active_guide){
		$Sql = "UPDATE guides SET
				name_guide='".$name_guide."',
				type_guide='".$type_guide."' ,
				order_guide=".$order_guide." ,
				active_guide=".$active_guide." 
				WHERE id_guide=".$id." ";
		return connection::execute_query($Sql);
	}

	public function insertCategory($id_guide, $name_guide_category, $active_guide_category, $order_guide_category){
		$Sql = "INSERT INTO guides_categories(id_guide, name_guide_category, active_guide_category, order_guide_category) 
				VALUES (".$id_guide.",'".$name_guide_category."', ".$active_guide_category.", ".$order_guide_category.")";
		return connection::execute_query($Sql);
	}

	public function updateCategory($id, $id_guide, $name_guide_category, $active_guide_category, $order_guide_category){
		$Sql = "UPDATE guides_categories SET
				id_guide=".$id_guide.",
				name_guide_category='".$name_guide_category."' ,
				active_guide_category=".$active_guide_category." ,
				order_guide_category=".$order_guide_category." 
				WHERE id_guide_category=".$id." ";
		return connection::execute_query($Sql);
	}	

	public function insertSubCategory($id_guide_category, $id_guide_subcategory_type, $desc_guide_subcategory, $active_guide_subcategory, $order_guide_subcategory){
		$Sql = "INSERT INTO guides_subcategories(id_guide_category, id_guide_subcategory_type, desc_guide_subcategory, active_guide_subcategory, order_guide_subcategory) 
				VALUES (".$id_guide_category.",".$id_guide_subcategory_type.", '".$desc_guide_subcategory."', ".$active_guide_subcategory.", ".$order_guide_subcategory.")";
		return connection::execute_query($Sql);
	}

	public function updateSubCategory($id, $id_guide_category, $id_guide_subcategory_type, $desc_guide_subcategory, $active_guide_subcategory, $order_guide_subcategory){
		$Sql = "UPDATE guides_subcategories SET
				id_guide_category='".$id_guide_category."' ,
				id_guide_subcategory_type=".$id_guide_subcategory_type." ,
				desc_guide_subcategory='".$desc_guide_subcategory."' ,
				active_guide_subcategory=".$active_guide_subcategory." ,
				order_guide_subcategory=".$order_guide_subcategory." 
				WHERE id_guide_subcategory=".$id." ";
		return connection::execute_query($Sql);
	}	

	public function insertSubCategoryType($name_guide_subcategory_type, $icon_guide_subcategory_type, $active_guide_subcategory_type, $order_guide_subcategory_type){
		$Sql = "INSERT INTO guides_subcategories_types(name_guide_subcategory_type, icon_guide_subcategory_type, active_guide_subcategory_type, order_guide_subcategory_type) 
				VALUES ('".$name_guide_subcategory_type."','".$icon_guide_subcategory_type."', ".$active_guide_subcategory_type.", ".$order_guide_subcategory_type.")";
		return connection::execute_query($Sql);
	}

	public function updateSubCategoryType($id, $name_guide_subcategory_type, $icon_guide_subcategory_type, $active_guide_subcategory_type, $order_guide_subcategory_type){
		$Sql = "UPDATE guides_subcategories_types SET
				name_guide_subcategory_type='".$name_guide_subcategory_type."' ,
				icon_guide_subcategory_type='".$icon_guide_subcategory_type."' ,
				active_guide_subcategory_type=".$active_guide_subcategory_type." ,
				order_guide_subcategory_type=".$order_guide_subcategory_type." 
				WHERE id_guide_subcategory_type=".$id." ";
		return connection::execute_query($Sql);
	}

	public function insertSubCategoryUser($id_guide_subcategory, $user_guide, $user_guide_like, $user_guide_comment){
		$Sql = "INSERT INTO guides_subcategories_users(id_guide_subcategory, user_guide, user_guide_like, user_guide_comment) 
				VALUES (".$id_guide_subcategory.",'".$user_guide."', ".$user_guide_like.", '".$user_guide_comment."')";
		return connection::execute_query($Sql);
	}

	public function updateSubCategoryUser($id, $id_guide_subcategory, $user_guide, $user_guide_like, $user_guide_comment){
		$Sql = "UPDATE guides_subcategories_users SET
				id_guide_subcategory=".$id_guide_subcategory." ,
				user_guide='".$user_guide."' ,
				user_guide_like=".$user_guide_like." ,
				user_guide_comment='".$user_guide_comment."' 
				WHERE id_guide_users=".$id." ";
		return connection::execute_query($Sql);
	}		
}
?>