<?php
class notifications{
	public function insertNotification($username_notification, $type_notification, $id_content){
		$Sql = "INSERT INTO notifications (username_notification, type_notification, id_content) 
				VALUES ('".$username_notification."','".$type_notification."', ".$id_content.")"; //echo $Sql;
		return connection::execute_query($Sql);
	}

	public function deleteNotification($username_notification, $type_notification, $id_content){
		$Sql = "DELETE FROM notifications 
				WHERE username_notification='".$username_notification."' 
				AND type_notification='".$type_notification."'
				AND id_content='".$id_content."' ";
		return connection::execute_query($Sql);
	}

	public function getNotificationInscription($filter = ""){
		$Sql = "SELECT * FROM notifications_inscriptions 
				WHERE 1=1 ".$filter; //echo $Sql;
		return connection::getSQL($Sql);
	}

	public function insertNotificationInscription($username_inscription, $type_inscription, $id_content){
		$Sql = "INSERT INTO notifications_inscriptions (username_inscription, type_inscription, id_content) 
				VALUES ('".$username_inscription."','".$type_inscription."', ".$id_content.")";
		return connection::execute_query($Sql);
	}

	public function deleteNotificationInscription($username_inscription, $type_inscription, $id_content){
		$Sql = "DELETE FROM notifications_inscriptions 
				WHERE username_inscription='".$username_inscription."' 
				AND type_inscription='".$type_inscription."'
				AND id_content='".$id_content."' ";
		return connection::execute_query($Sql);
	}
}
?>