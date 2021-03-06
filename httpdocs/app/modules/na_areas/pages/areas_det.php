<?php
templateload("search","foro");
templateload("list","foro");
templateload("paginator","foro");
templateload("addforo","foro");
templateload("player","videos");

addJavascripts(array("js/libs/jwplayer/jwplayer.js", 
					 "js/bootstrap.file-input.js", 
					 getAsset("na_areas")."js/areas_det.js"));

if (isset($_REQUEST['id']) && $_REQUEST['id'] != ""):
	$na_areas = new na_areas();
	$id_area = intval($_REQUEST['id']);

	$module_config = getModuleConfig("na_areas");
	$acceso = foroController::accesoForoAreaAction($id_area);
	$area = na_areasController::getItemAction($id_area);
	$canales = explode(",", $area[0]['area_canal']);

	if ( $acceso==1 ):?>
	<div class="row row-top">
		<div class="app-main">
			<?php
			menu::breadcrumb(array(
				array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
				array("ItemLabel"=>strTranslate("Na_areas"), "ItemUrl"=>"areas"),
				array("ItemLabel"=> $area[0]['area_nombre'], "ItemClass"=>"active"),
			));

			na_areasController::uploadTareaAction();
			session::getFlashMessage('actions_message');
			?>
			<p><?php echo nl2br($area[0]['area_descripcion']);?></p>
			<div class="clearfix"></div>
			<div class="row">
				
				<?php $contador_tareas = printTareas($id_area);
				$class_foros = ($contador_tareas > 0 ? 'col-md-6' : 'col-md-12')
				?>
				<div class="<?php echo $class_foros;?>">
					<?php if ($module_config['options']['forums'] == true && count($canales) == 1){
						//mostrar foros del area
						$filtro = " AND id_area=".$id_area." AND activo=1 ";						
						$elements = foroController::getListTemasAction($module_config['options']['forums_per_page'], $filtro);

						echo '<h4>'.strTranslate("Forums").' del curso</h4>';
						if ($elements['total_reg'] == 0) echo '<div class="alert alert-warning">'.strTranslate("No_active_forums").'.</div>';
						foreach($elements['items'] as $element):
							ForoList($element);		
						endforeach;  

						Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], "areas_det?id=".$id_area, '', $elements['find_reg']);
					}?>
				</div>
			</div>
		</div>
	<?php else: ?>
	  	<div class="alert alert-warning"><?php e_strTranslate("Access_denied");?></div>
	<?php endif;?>
<?php endif;?>
	<div class="app-sidebar">
		<div class="panel-interior">
			<?php
			if ($module_config['options']['forums'] == true && count($canales) == 1) PanelSubirTemaForo(false, "", 0, $id_area);?>
			<br />
			<p class="text-center"><i class="fa fa-mortar-board fa-big"></i></p>
		</div>
	</div>
</div>

<?php 
function printTareas($id_area){
	$na_areas = new na_areas();
	$contador_tareas = 0;
	$elements = $na_areas->getTareas(" AND id_area=".$id_area." AND activa=1 ");
	global $ini_conf; 



	foreach($elements as $element):
		//VERIFICAR SI ES UNA TAREA PARA UN GRUPO Y SI EL USUARIO PERTENECE O NO AL GRUPO
		$acceso_grupo = 1;
		if ($_SESSION['user_canal'] != 'admin'){
			if ($element['tarea_grupo'] == 1){
				$acceso_grupo = count($na_areas->getUsersTareaGrupos($element['id_tarea'],$_SESSION['user_name']));
			}
		}
		if ($element['tarea_grupo'] == 0 || $acceso_grupo == 1){
			$contador_tareas++;

			if ($contador_tareas == 1) echo '<div class="col-md-6"><h4>Tareas del curso</h4>';

			echo '<div class="panel panel-default">
				  <div class="panel-heading">';
			echo ((isset($element['id_recompensa']) && $element['id_recompensa'] > 0) ? '<img class="pull-right" width="15px" title="'.$element['recompensa_name'].'" src="'.PATH_REWARDS.$element['recompensa_image'].'" />' : '');
			echo ' <h3 class="panel-title">'.$element['tarea_titulo'].'</h3></div>
				  <div class="panel-body">
				  <p>'.$element['tarea_descripcion'].'</p>';
			echo '<a class="trigger-documentacion" href="#"><i class="fa fa-angle-double-right"></i> '.strTranslate("Documentation").'</a>
					<div class="documentacion-tareas">';
			documentosTarea($element['id_tarea']);
			echo '</div>';
			//SOLO SE PODRÁN SUBIR ARCHIVOS SI ES UNA TAREA DE SUBIDA DE FICHEROS
			if ($element['tipo'] == 'fichero'){
				if ($element['activa_links'] == 1){
					$archivos = $na_areas->getTareasUser(" AND user_tarea='".$_SESSION['user_name']."' AND id_tarea=".$element['id_tarea']." AND id_area=".$id_area." ");
					echo '<div><a target="_blank" href="docs/showfile.php?t=1&file='.$element['tarea_archivo'].'"><i class="fa fa-angle-double-right"></i> '.strTranslate("Download_task").'</a></div>	
						<div class="trigger-tarea"><a href="#"><i class="fa fa-angle-double-right"></i> '.strTranslate("Upload_task").' ('.count($archivos).')</a></div>		
							<div class="form-tareas" id="subir-tarea-'.$element['id_tarea'].'">
								<form id="data-'.$element['id_tarea'].'" name="" action="" method="post" enctype="multipart/form-data" role="form">
									<input type="hidden" name="id_tarea" value="'.$element['id_tarea'].'"/>
									<input type="hidden" name="id_area" value="'.$id_area.'"/>
									<input type="file" class="btn btn-default" name="nombre-fichero" id="nombre-fichero-'.$element['id_tarea'].'" title="'.strTranslate("Choose_file").'" /> 
									<span id="fichero-comentario-alert-'.$element['id_tarea'].'" class="alert-message alert alert-danger"></span>
									<button type="button" class="enviarButton btn btn-primary btnfileTarea" id="'.$element['id_tarea'].'" name="'.$element['id_tarea'].'">'.strTranslate("Upload").'</button>						
								</form>
							</div>';
				}
				//PARA CADA TAREA SE OBTIENEN LOS FICHEROS SUBIDOS POR EL USUARIO
				foreach($archivos as $archivo):
					echo '<br /><a class="user-file text-muted" target="_blank" href="docs/showfile.php?t=1&file='.$archivo['file_tarea'].'">
							<span class="fa fa-download"></span> '.strTranslate("Uploaded").' '.getDateFormat($archivo['fecha_tarea'], "SHORT").'</a>';
				endforeach;
			}
			elseif ($element['tipo'] == 'formulario'){
				echo'<p><a href="areas_form?id='.$element['id_tarea'].'"><i class="fa fa-angle-double-right"></i> '.strTranslate("Access_form").'</a></p>';
			}

			echo '</div></div>';
		}
	endforeach;
	
	if ($contador_tareas > 0) echo '</div>';

	return $contador_tareas;
}

function documentosTarea($id_tarea){
	$na_areas = new na_areas();
	$documentos = $na_areas->getTareasDocumentos(" AND id_tarea=".$id_tarea." ");
	if (count($documentos) == 0) echo '<p class="text-muted">'.strTranslate("No_files_for_this_task").'</p>';
	else{
		//echo '<h5>Ficheros</h5>';
		foreach($documentos as $documento):
				echo '<div class="panel-documentos">';
				switch ($documento['documento_tipo']){
					case 'fichero':
						echo '<p class="text-center">
								<a target="_blank" href="docs/showfile.php?t=1&file='.$documento['documento_file'].'">
								<i class="fa fa-file"></i> '.$documento['documento_nombre'].'</a>
							</p>';
						break;
					case 'enlace':
						echo '<p class="text-center">
								<a target="_blank" href="'.$documento['documento_file'].'">
								<i class="fa fa-globe"></i>
								'.$documento['documento_nombre'].'</a>
							</p>';
						break;
					case 'video':
						playVideo("video".$documento['id_documento'], PATH_VIDEOS.$documento['documento_file'], 240, 180, 'bottom', false, 0);
						echo '<p class="text-center">'.$documento['documento_nombre'].'</p>';
						break;
					case 'podcast':
						playVideo("podcast".$documento['id_documento'], "docs/audio/".$documento['documento_file'], 240, 24, 'bottom', false, 0);
						echo '<p class="text-center">'.$documento['documento_nombre'].'</p>';
						break;
				}
				echo '</div>';
		endforeach;
	}
	echo '<div class="clearfix"></div>';
}
?>