<?php
$base_dir = str_replace( ((strrpos( __DIR__ , "\\" ) === false) ? 'modules/configuration/pages' : 'modules\\configuration\\pages')  , '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
session::ValidateSessionAjax();

if (isset($_POST['action']) and $_POST['action'] == "init"):
	$configuration = new configuration();
	$configuration->deletePanel(" AND page_name='home' ");
endif;

if (isset($_POST['panel_name']) and $_POST['panel_name'] != ""):
	$configuration = new configuration();
	$configuration->updatePanel('home', $_POST['panel_name'], $_POST['panel_cols'], $_POST['panel_pos'], $_POST['panel_row']);
endif;

if (isset($_POST['action']) and $_POST['action'] == "panels"):
	$configuration = new configuration();
	$elements = $configuration->getPanels(" AND panel_visible=0 ");

	foreach($elements as $element):
		echo '<option value="'.$element['panel_name'].'">'.$element['panel_name'].'</option>';
	endforeach;
endif;

?>