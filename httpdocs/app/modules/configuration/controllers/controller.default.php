<?php
class configurationController{
	public static function updateAction(){
		if (isset($_POST['site-name']) and $_POST['site-name'] != ''){
			$configuration = new configuration();
			if ($configuration->UpdateConfiguracion($_POST['telefono'],
										 $_POST['telefono2'],
										 $_POST['fax'],
										 $_POST['direccion'],
										 $_POST['email-contact'],
										 $_POST['site-name'],
										 $_POST['site-title'],
										 $_POST['site-desc'],
										 $_POST['site-subject'],
										 $_POST['site-keywords'],
										 $_POST['site-url'],
										 $_POST['email-mailing'])) 
				
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
			else
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function getItemAction(){
		$configuration = new configuration();
		return $configuration->getConfiguracion("");
	}

	public static function getListModulesAction(){
		global $modules;
		$listModules = array();
		foreach($modules as $module):
			$annotations = FileSystem::getClassAnnotations($module['folder']."Core");
			$ano = $annotations[1];
			$ann = "";
			
			$icon = "user";
			foreach($ano as $annotation):
				$thisann = isset($annotation) ? ucfirst($annotation) : "";
				if (strpos($thisann, "Version 0.7") !== false)
					$thisann = '<span class="label label-warning">'.$thisann.'</span>';
				elseif (strpos($thisann, "Version 0.8") !== false) 
					$thisann = '<span class="label label-warning">'.$thisann.'</span>';
				elseif (strpos($thisann, "Version 0.9") !== false) 
					$thisann = '<span class="label label-warning">'.$thisann.'</span>';
				elseif (strpos($thisann, "Version 0") !== false) 
					$thisann = '<span class="label label-danger">'.$thisann.'</span>';
				elseif (strpos($thisann, "Version") !== false) 
					$thisann = '<span class="label label-success">'.$thisann.'</span>';

				$ann .= $thisann."<br />";
			endforeach;
			array_push($listModules, array("folder" => $module['folder'], "ann" => $ann, "icon" => $icon));		
		endforeach;	
		return $listModules;
	}	
}
?>