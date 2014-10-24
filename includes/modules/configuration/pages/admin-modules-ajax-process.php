<?php
$base_dir = str_replace('modules/configuration/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/configuration/class.configuration.php");


session::ValidateSessionAjax();
//modificar configuracion del modulo
if (isset($_POST['modulename']) and $_POST['modulename']!=""){

	$options = "";
	foreach(array_keys($_POST) as $element):
		if ($element != 'modulename' and substr($element, (strlen($element)-7), strlen($element))=="_typeof"){	
			$form_field = substr($element, 0, strlen($element)-7);
			switch ($_POST[$element]) {
				case 'boolean':
					$value = ((isset($_POST[$form_field]) and $_POST[$form_field]=='on') ? true : false);
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
	endforeach;


/*	$array[] = 'Sequence item';
	$array['The Key'] = 'Mapped value';
	$array[] = array('A sequence','of a sequence');
	$array[] = array('first' => 'A sequence','second' => 'of mapped values');
	$array['Mapped'] = array('A sequence','which is mapped');
	$array['A Note'] = 'What if your text is too long?';
	$array['Another Note'] = 'If that is the case, the dumper will probably fold your text by using a block.  Kinda like this.';
	$array['The trick?'] = 'The trick is that we overrode the default indent, 2, to 4 and the default wordwrap, 40, to 60.';
	$array['Old Dog'] = "And if you want\n to preserve line breaks, \ngo ahead!";
	$array['key:withcolon'] = "Should support this to";*/

	$file = $base_dir . "modules/".$_POST['modulename']."/config.yaml";
	if (writeYml($array, $file)){
		echo 'Datos guardados correctamente';
	}
	else{
		echo 'Error al guardar datos';
	}
}
?>