<?php
function ComboCanales($seleccionado = "", $filter = " AND visible=1 "){
	$users = new users();
	$elements = $users->getCanales($filter." ORDER BY canal");
	foreach($elements as $element): ?>
			<option value="<?php echo $element['canal'];?>" <?php if ($seleccionado == $element['canal']){ echo ' selected="selected" ';}?>><?php echo $element['canal_name'];?></option>
	<?php endforeach;
}
?>