<?php
/**
 * Print HTML user groups combo
 * @param	Array 		$groups 		Elementos del array de grupos
 * @param	Int 		$id_group 		Usuario del que se muestran las recompensas
 * @return	String						HTML combo
 */
function panelGroup($groups, $id_group){ ?>
	<?php if (count($groups) > 0): ?>
	<div class="col-md-12">
	<label for="groups_user"><?php e_strTranslate("My_groups");?></label>
		<select id="groups_user" name="groups_user" class="form-control">
			<option value="">--<?php e_strTranslate("Choose_group");?>--</option>
			<?php foreach($groups as $group): ?>
				<option value="<?php echo $group['cod_tienda'];?>" <?php echo ($group['cod_tienda'] == $id_group ? ' selected="selected" ' : '');?>><?php echo $group['cod_tienda'];?> - <?php echo $group['nombre_tienda'];?></option>	
			<?php endforeach; ?>
		</select>
	</div>
	<?php endif;?>
<?php } ?>