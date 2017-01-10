<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/configuration/pages' : 'modules\\configuration\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");

session::ValidateSessionAjax();
//modificar configuracion del modulo
if (isset($_POST['modulename']) and $_POST['modulename'] != ""){
	$module_config = getModuleConfig($_POST['modulename']);
	$array['options'] = null;
	$array['channels'] = null;
	$k = 1;
	foreach(array_keys($_POST) as $element):
		if ($element != 'modulename' and substr($element, (strlen($element)-7), strlen($element)) == "_typeof"){
			$form_field = substr($element, 0, strlen($element)-7);
			switch ($_POST[$element]) {
				case 'boolean':
					$value = ((isset($_POST[$form_field]) and $_POST[$form_field] == 'on') ? true : false);
					break;
				case 'double':
					$value = str_replace(",", ".", $_POST[$form_field]);
					break;
				default:
					$value = $_POST[$form_field];
					break;
			}
			$array['options'][$form_field] = $value;
		}

		if ($element != 'modulename' and substr($element, (strlen($element)-8), strlen($element)) == "_channel"){
			$form_field = substr($element, 0, strlen($element)-8);
			$value = $_POST[$form_field."_channel"];
			if (trim($value) != '') {
				$array['channels']["group".$k] = $value;
				$k++;
			}
		}
	endforeach;

	$module_config['options'] = $array['options'];
	$module_config['channels'] = $array['channels'];

	$file = $base_dir . "modules/".$_POST['modulename']."/config.yaml";
	if (writeYml($module_config, $file)) 
		echo '<span class="text-success"><i class="fa fa-info-circle"></i> Datos guardados correctamente</span>';
	else
		echo '<span class="text-danger"><i class="fa fa-warning"></i> Error al guardar datos</span>';
}
?>