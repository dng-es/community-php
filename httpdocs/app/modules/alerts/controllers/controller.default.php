<?php
class alertsController{
	public static function createAction(){
		if (isset($_POST['text_alert']) and trim($_POST['text_alert'])){
			$alerts = new alerts();

			if ($alerts->insertAlerts(sanitizeInput($_POST['text_alert']), sanitizeInput($_POST['type_alert']), sanitizeInput($_POST['destination_alert']), $_SESSION['user_name'], sanitizeInput($_POST['priority']), sanitizeInput($_POST['date_ini']." 00:00:00"), sanitizeInput($_POST['date_fin']." 23:59:59")))
				session::setFlashMessage( 'actions_message', strTranslate("Insert_procesing"), 'alert alert-success');
			else
				session::setFlashMessage( 'actions_message', strTranslate("Error_procesing"), 'alert alert-danger');

			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function updateAction(){
	
	}
}
?>