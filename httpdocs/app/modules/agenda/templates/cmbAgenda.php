<?php
function ComboTipo($seleccionado = "", $filter = "" ){
		//echo "casa";
	$agenda = new agenda();
	$elements = $agenda->getTipos($filter." ORDER BY tipo_name");

	foreach($elements as $element):
		//echo "<script>alert('".$element['tipo']."');</script>";
		?>
			<option value="<?php echo $element['id_agenda_tipo'];?>" <?php if ($seleccionado == $element['id_agenda_tipo']){echo ' selected="selected" ';
				}?>><?php echo $element['tipo_name'];?></option>
	<?php endforeach;
}
?>