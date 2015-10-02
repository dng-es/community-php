<?php
class blog{
	public function insertAlerts(){	
		$Sql = "INSERT INTO blog_alerts (id_tema,username_alert)
				SELECT id_tema, '".$_SESSION['user_name']."' FROM foro_temas WHERE ocio=1 AND id_tema NOT IN (SELECT id_tema FROM blog_alerts WHERE username_alert = '".$_SESSION['user_name']."')";
		return connection::execute_query($Sql);
	}
}
?>