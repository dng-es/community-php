<?php

/**
* @Manage globaloptions
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.0
*
*/
class globaloptions{

	public function updateUserPartyId($username,$party_id){	 
		$Sql="UPDATE users SET party_id='".$party_id."' WHERE username='".$username."' ";
		return connection::execute_query($Sql);
	}
}
?>