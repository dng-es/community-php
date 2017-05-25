<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/guides/pages' : 'modules\\guides\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/guides/classes/class.guides.php");

session::ValidateSessionAjax();
$guides = new guides(); 
if (isset($_REQUEST['tipo']) && $_REQUEST['tipo'] != ''){
	$tipo = sanitizeInput($_REQUEST['tipo']);
	$selected = sanitizeInput($_REQUEST['sel']);
	$filter = " AND type_guide='".$tipo."' AND active_guide=1 ORDER BY name_guide ";
	$tipos = $guides->getGuides($filter);

	foreach($tipos as $tipo):?>
		<option value="<?php echo $tipo['id_guide'];?>" <?php if ($selected == $tipo['id_guide']){ echo ' selected="selected" ';}?>>
			<?php echo $tipo['name_guide'];?>
		</option>
	<?php endforeach;
}

if (isset($_REQUEST['cat']) && $_REQUEST['cat'] != ''){
	$tipo = sanitizeInput($_REQUEST['cat']);
	$selected = sanitizeInput($_REQUEST['sel']);
	$filter = " AND c.id_guide='".$tipo."' AND active_guide_category=1 ORDER BY name_guide_category ";
	$tipos = $guides->getGuidesCategories($filter);

	foreach($tipos as $tipo):?>
		<option value="<?php echo $tipo['id_guide_category'];?>" <?php if ($selected == $tipo['id_guide_category']){ echo ' selected="selected" ';}?>>
			<?php echo $tipo['name_guide_category'];?>
		</option>
	<?php endforeach;
}
?>

