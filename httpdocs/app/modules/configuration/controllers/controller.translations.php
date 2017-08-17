<?php
class configurationTranslationsController{
	public static function updateAction(){
		if (isset($_POST['module_trans']) && $_POST['module_trans'] != ""){
			try {			
				if ($_POST['module_trans'] == 'core_ini')
					$language_file = realpath(dirname(__FILE__)).'/../../../languages/'.$_POST['language_trans'].'/language.php';
				else 
					$language_file = realpath(dirname(__FILE__)).'/../../'.$_POST['module_trans'].'/resources/languages/'.$_POST['language_trans'].'/language.php';

				$language_content = "<?php 
";
				foreach ($_POST as $key => $value) {
					if ($key != 'module_trans' && $key != 'language_trans'  && $key != 'form-submit') $language_content .= $key.' = "'.$value.'"
';
				}
				$language_content ."?>";
				if (FileSystem::createFile($language_file, $language_content))
					session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");
				else
					session::setFlashMessage('actions_message', strTranslate("Error_procesing").". Verifique los permisos de escritura del fichero de idiomas.", "alert alert-danger");

			} catch (Exception $e) {
					session::setFlashMessage('actions_message', $e->getMessage(), "alert alert-danger");
			}
		
			redirectURL($_SERVER['REQUEST_URI']);
		}
	}
	
	public static function getLanguageFile($module, $language){
		if ($module == 'core_ini')
			$language_file = realpath(dirname(__FILE__)).'/../../../languages/'.$language.'/language.php';
		else
			$language_file = realpath(dirname(__FILE__)).'/../../'.$module.'/resources/languages/'.$language.'/language.php';

		$language_array = array();
		if (file_exists($language_file)) $language_array = parse_ini_file($language_file);
		return $language_array;
	}
}
?>