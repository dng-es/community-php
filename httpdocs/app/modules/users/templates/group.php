<?php

function panelGroup($groups, $id_group){ ?>

	<h4>
		<span class="fa-stack fa-sx">
			<i class="fa fa-circle fa-stack-2x"></i>
			<i class="fa fa-share-alt fa-stack-1x fa-inverse"></i>
		</span>
		<?php e_strTranslate("My_groups");?>
	</h4>
	<?php if (count($groups) > 0):?>
	<select id="groups_user" name="groups_user" class="form-control">
		<option value="">--<?php echo strTranslate("Choose_group");?>--</option>
	  	<?php foreach($groups as $group): ?>
	  			<option value="<?php echo $group['cod_tienda'];?>" <?php echo ($group['cod_tienda'] == $id_group ? ' selected="selected" ' : '');?>><?php echo $group['cod_tienda'];?> - <?php echo $group['nombre_tienda'];?></option>	
	  	<?php endforeach; ?>
	</select>
	<?php endif;?>
<?php }
?>