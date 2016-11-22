<?php
$base_dir = str_replace( ((strrpos( __DIR__ , "\\" ) === false) ? 'modules/shop/pages' : 'modules\\shop\\pages')  , '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/shop/classes/shop.php");

session::ValidateSessionAjax();

if (isset($_POST['opt']) and $_POST['opt'] == 'categorias'){
	$shop = new shop();
	$elements = $shop->getProductsCategories();
	$json_elements = "[";
	foreach ($elements as $element):
		$json_elements .= '"'.$element['category'].'",';
	endforeach;
	$json_elements = substr($json_elements, 0, -1);
	$json_elements .= "]";
	echo $json_elements;
}

if (isset($_POST['opt']) and $_POST['opt'] == 'subcategorias'){
	$shop = new shop();
	$elements = $shop->getProductsSubcategories();
$json_elements = "[";
	foreach ($elements as $element):
		$json_elements .= '"'.$element['subcategory'].'",';
	endforeach;
	$json_elements = substr($json_elements, 0, -1);
	$json_elements .= "]";
	echo $json_elements;
}

?>