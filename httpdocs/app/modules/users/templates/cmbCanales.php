<?php
/**
 * Print HTML channels combo
 * @param	String 		$seleccionado	Canal seccionado en el combo
 * @param	String 		$filter 		Filtro a aplicafr en los canales
 * @return	String						HTML combo
 */
function ComboCanales($seleccionado = "", $filter = " AND visible=1 "){
	$users = new users();
	$elements = $users->getCanales($filter." ORDER BY canal");
	$array_canales = explode(",", $seleccionado);
	foreach($elements as $element): ?>
		<option value="<?php echo $element['canal'];?>" <?php if (in_array($element['canal'], $array_canales)) echo ' selected="selected" ';?>><?php echo $element['canal_name'];?></option>
	<?php endforeach;
} ?>