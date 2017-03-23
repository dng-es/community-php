<?php
class notificationsController{
	public static function insertNotifications($id_content, $type_notification){
		$module_config = getModuleConfig($type_notification);
		if ($module_config['options']['show_alarms']):
			$notifications = new notifications();
			$elements = $notifications->getNotificationInscription(" AND username_inscription<>'".$_SESSION['user_name']."' AND type_inscription='".$type_notification."' AND id_content=".$id_content." ");
			foreach ($elements as $element):
				$notifications->insertNotification($element['username_inscription'], $type_notification, $id_content);
			endforeach;
		endif;
	}

	public static function deleteNotification($id_content, $type_notification){
		$notifications = new notifications();
		$notifications->deleteNotification($_SESSION['user_name'], $type_notification, $id_content);
	}
	
	public static function notificationInscription($id_content, $type_notification, $destination){
		if (isset($_REQUEST['idn']) && intval($_REQUEST['idn']) >= 0){
			$notifications = new notifications();
			if (intval($_REQUEST['idn']) == 1){
				if ($notifications->insertNotificationInscription($_SESSION['user_name'], $type_notification, $id_content))
					session::setFlashMessage('actions_message', strTranslate("Notifications_inscription_ok"), "alert alert-success");
				else
					session::setFlashMessage('actions_message', strTranslate("Notifications_inscription_ko"), "alert alert-danger");
			}
			elseif (intval($_REQUEST['idn']) == 0){

				if ($notifications->deleteNotificationInscription($_SESSION['user_name'], $type_notification, $id_content))
					session::setFlashMessage('actions_message', strTranslate("Notifications_inscription_ok_delete"), "alert alert-success");
				else
					session::setFlashMessage('actions_message', strTranslate("Notifications_inscription_ko"), "alert alert-danger");
			}

			redirectURL($destination);
		}
	}
}
?>
