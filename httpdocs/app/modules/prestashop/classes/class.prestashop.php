<?php

class prestashop{

	public function updateUser($username, $id_externo){
		$Sql = "UPDATE users SET 
				id_externo = ".$id_externo." WHERE username='".$username."' ";
		return connection::execute_query($Sql);
	}
}
?>