<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/configuration/pages' : 'modules\\configuration\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
session::ValidateSessionAjax();

if (isset($_POST['action']) && $_POST['action'] == "init"):
	$theme = trim(sanitizeInput($_POST['theme']));
	if ($theme != ''){
		$configuration = new configuration();
		$configuration->deletePanel(" AND page_name='home' AND page_theme='".$theme."' ");
	}
endif;

if (isset($_POST['panel_name']) && $_POST['panel_name'] != ""):
	$theme = $_POST['theme'];
	$configuration = new configuration();
	$configuration->updatePanel('home', $_POST['panel_name'], $_POST['panel_cols'], $_POST['panel_pos'], $_POST['panel_row'], $theme);
endif;

if (isset($_POST['action']) && $_POST['action'] == "panels"):
	$theme = $_POST['theme'];
	$configuration = new configuration();
	$elements = $configuration->getPanels(" AND page_name='home' AND page_theme='' AND panel_name NOT IN (SELECT panel_name FROM config_panels WHERE page_name='home' AND page_theme='".$theme."') ORDER BY panel_name");

	foreach($elements as $element):
		echo '<option value="'.$element['panel_name'].'">'.$element['panel_name'].'</option>';
	endforeach;
endif;
?>