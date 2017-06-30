<?php
/**
 * Muestra las batallas de un usuario
 * @param	string		$seleccionado	Elemento seleccionado del combo
 * @param	string		$filter			Filtro en los elementos del combo
 * @return 	string       				HTML combo elements
 */
function ComboTipo($seleccionado = "", $filter = ""){
	$agenda = new agenda();
	$elements = $agenda->getTipos($filter." ORDER BY tipo_name");
	foreach($elements as $element):?>
		<option value="<?php echo $element['id_agenda_tipo'];?>" <?php if ($seleccionado == $element['id_agenda_tipo']) echo ' selected="selected" ';?>><?php echo $element['tipo_name'];?></option>
	<?php endforeach;
}
?>