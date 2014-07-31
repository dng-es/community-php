<?php
class configurationController{
	public static function updateAction(){
		if (isset($_POST['site-name']) and $_POST['site-name']!=''){
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
										 $_POST['email-mailing'])) {
				session::setFlashMessage( 'actions_message', "Registro modificado correctamente", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Error al modificar el registro.", "alert alert-danger");
			}
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public function getItemAction(){
		$configuration = new configuration();
		return $configuration->getConfiguracion("");
	}

	public function getListModulesAction(){
		$listModules = array();
		$folders = getListModules();
		foreach($folders as $folder):
			$annotations = FileSystem::getClassAnnotations($folder['folder']);
			$ano = $annotations[1];
			$ann ="";
			foreach($ano as $annotation):
				$thisann = isset($annotation) ? ucfirst($annotation) : "";
				if (strpos($thisann, "Version 0.7")!==false){
					$thisann = '<span class="label label-warning">'.$thisann.'</span>';
				}
				elseif (strpos($thisann, "Version 0.8")!==false){
					$thisann = '<span class="label label-warning">'.$thisann.'</span>';
				}
				elseif (strpos($thisann, "Version 0.9")!==false){
					$thisann = '<span class="label label-warning">'.$thisann.'</span>';
				}
				elseif (strpos($thisann, "Version 0")!==false){
					$thisann = '<span class="label label-danger">'.$thisann.'</span>';
				}
				elseif (strpos($thisann, "Version")!==false){
					$thisann = '<span class="label label-success">'.$thisann.'</span>';
				}
				$ann .= $thisann."<br />";
			endforeach;	
			array_push($listModules, array("folder" => $folder['folder'], "ann" => $ann));		
		endforeach;	
		return $listModules;	
	}

	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */	
	public static function adminMenu(){
		return array( array("LabelHeader" => 'Tools',
							"LabelSection" => 'Configuración',
							"LabelItem" => 'Datos generales',
							"LabelUrl" => 'admin-config',
							"LabelPos" => 1));	
	}	
}
?>