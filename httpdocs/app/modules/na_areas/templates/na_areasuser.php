<?php
function userNaAreas($username){
	$module_config = getModuleConfig("na_areas");
	$points_to_success = $module_config['options']['points_to_success'];
	$elements = na_areas::getTareasFinalizadasUser($username);
	$na_areas = new na_areas();
	?>
	<table class="table table-striped">
		<?php foreach($elements as $element): ?>
			<tr>
				<td>
					<label><small><?php echo $element['area_nombre'];?></small></label><br />
					<small class="text-muted"><?php echo getDateFormat($element['fecha_tarea'], "DATE_FORMAT_SHORT");?></small> 
				</td>
				<td>
					<small><?php echo $element['tarea_titulo'];?></small>
					<?php if ($element['tipo'] == 'formulario'): ?>
					<br /><small><a href="areas_form?id=<?php echo $element['id_tarea'];?>" target="_blank"><?php e_strTranslate("My_answers");?></a></small>
					<?php else: 
					$archivos = $na_areas->getTareasUser(" AND user_tarea='".$username."' AND id_tarea=".$element['id_tarea']." ");
					foreach($archivos as $archivo): ?>
						<br /><small><a href="docs/showfile.php?t=1&file=<?php echo $archivo['file_tarea'];?>" target="_blank"><?php echo $archivo['file_tarea'];?></a></small>
					<?php endforeach;?>
					<?php endif; ?>
				</td>
				<td>
					<?php if ($element['tipo'] == 'formulario'):?>
						<?php if ($element['revision'] == 1): ?>
							<?php if ($element['puntos'] >= $points_to_success): ?>
							<i class="fa fa-trophy fa-medium"><small><?php echo $element['puntos'];?></small></i>
							<?php else:?>
							<small class="text-muted"><?php echo $element['puntos'];?></small>
							<?php endif;?>
						<?php else: ?>
							<small class="text-muted">pendiente revision</small>
						<?php endif;?>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach;?>
	</table>
	<?php 
	if (count($elements) == 0) echo '<div class="row"><div class="col-md-12"><div class="alert alert-warning">'.strTranslate("No_courses_finished")."</div></div></div>";
}
?>