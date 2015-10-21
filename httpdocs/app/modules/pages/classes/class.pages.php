<?php
class pages{
	public function getPages($filter = ""){
		$Sql = "SELECT * FROM pages WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertPage($id, $page_content){
		$Sql = "INSERT INTO pages (page_name,page_content) 
			VALUES('".$id."','".$page_content."')";
		return connection::execute_query($Sql);
	}

	public function updatePage($id, $page_content){
		$Sql = "UPDATE pages SET 
				page_content='".$page_content."' 
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