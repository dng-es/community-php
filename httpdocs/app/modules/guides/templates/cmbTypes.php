<?php
function ComboTypes($seleccionado = "", $filter = " AND disabled=0 "){
	$users = new users();
	$elements = $users->getPerfiles($filter." ORDER BY perfil");
	foreach($elements as $element): ?>
		<option value="<?php echo $element['perfil'];?>" <?php if ($seleccionado == $element['perfil']){ echo ' selected="selected" ';}?>><?php echo $element['perfil'];?></option>
	<?php endforeach;
}

function ComboGuides($seleccionado = "", $filter = " AND active_guide=1 "){
	$guides = new guides();
	$elements = $guides->getGuides($filter);
	foreach($elements as $element): ?>
		<option value="<?php echo $element['id_guide'];?>" <?php if ($seleccionado == $element['id_guide']){ echo ' selected="selected" ';}?>><?php echo $element['name_guide'];?></option>
	<?php endforeach;
}

function ComboCategories($seleccionado = "", $filter = " AND active_guide_category=1 "){
	$guides = new guides();
	$elements = $guides->getGuidesCategories($filter);
	foreach($elements as $element): ?>
		<option value="<?php echo $element['id_guide_category'];?>" <?php if ($seleccionado == $element['id_guide_category']){ echo ' selected="selected" ';}?>><?php echo $element['name_guide_category'];?></option>
	<?php endforeach;
}

function ComboCategoriesTypes($seleccionado = "", $filter = " AND active_guide_subcategory_type=1 "){
	$guides = new guides();
	$elements = $guides->getGuidesSubCategoriesTypes($filter);
	foreach($elements as $element): ?>
		<option value="<?php echo $element['id_guide_subcategory_type'];?>" <?php if ($seleccionado == $element['id_guide_subcategory_type']){ echo ' selected="selected" ';}?>><?php echo $element['name_guide_subcategory_type'];?></option>
	<?php endforeach;
}
?>