<?php
class pages{
	public function getPages($filter = ""){
		$Sql = "SELECT * FROM pages WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertPage($id, $page_content, $page_menu, $page_title, $page_order = 0){
		$Sql = "INSERT INTO pages (page_name,page_content,page_menu, page_title, page_order) 
			VALUES('".$id."','".$page_content."',".$page_menu.", '".$page_title."', ".$page_order.")";
		return connection::execute_query($Sql);
	}

	public function updatePage($id, $page_content, $page_menu, $page_title, $page_order){
		$Sql = "UPDATE pages SET 
				page_title='".$page_title."', 
				page_content='".$page_content."', 
				page_menu=".$page_menu.", 
				page_order=".$page_order." 
				WHERE page_name='".$id."'";
		return connection::execute_query($Sql);
	}

	public function deletePage($id){
		$Sql = "DELETE FROM pages 
			 WHERE page_name='".$id."'";
		return connection::execute_query($Sql);
	}
}
?>