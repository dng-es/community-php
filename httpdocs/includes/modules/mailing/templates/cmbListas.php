<?php
function ComboListas($seleccionado, $id_combo = "id_list"){
?>
	<select class="form-control" name="id_list" id="<?php echo $id_combo;?>">
			<option value="0" <?php if ($seleccionado==0){ echo ' selected="selected" ';}?>>---Seleccionar lista---</option>
<?php
	$mailing = new mailing();
	$elements = $mailing->getLists(" AND activo=1 AND user_list='".$_SESSION['user_name']."' ");
	foreach($elements as $element):
		?>
		    <option value="<?php echo $element['id_list'];?>" <?php if ($seleccionado==$element['id_list']){ echo ' selected="selected" ';}?>><?php echo $element['name_list'];?></option>
		<?php
	endforeach;
	echo '</select>';	
}
?>