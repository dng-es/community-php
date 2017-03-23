<?php
/**
 * Show Albums combo
 * @param  	Int 		$seleccionado 	Elemento seleccionado
 * @param  	Array 		$elements 		Elementos del combo
 * @param  	String 		$id_combo 		ID para el combo HTML
 * @return 	String       				HTML combo
 */
function comboAlbumes($seleccionado, $elements, $id_combo = "nombre_album"){?>
	<select class="form-control" name="nombre_album" id="<?php echo $id_combo;?>">
		<option value="0" <?php if ($seleccionado == 0){ echo ' selected="selected" ';}?>>---Selecciona el album---</option>
		<?php foreach($elements as $element):?>
			<option value="<?php echo $element['id_album'];?>" <?php if ($seleccionado == $element['id_album']) echo ' selected="selected" ';?>><?php echo $element['nombre_album'];?></option>
		<?php endforeach;?>
	</select>
<?php } ?>