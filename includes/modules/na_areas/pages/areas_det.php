<?php

templateload("search","foro");
templateload("list","foro");
templateload("paginator","foro");
templateload("addforo","foro");
templateload("player","videos");

addJavascripts(array("js/libs/jwplayer/jwplayer.js", 
					 "js/bootstrap.file-input.js", 
					 getAsset("na_areas")."js/areas_det.js"));


if (isset($_REQUEST['id']) and $_REQUEST['id']!=""){
	$na_areas = new na_areas();
	$id_area = $_REQUEST['id'];

	$module_config = getModuleConfig("na_areas");
	$acceso = foroController::accesoForoAreaAction($id_area);
	$area = na_areasController::getItemAction($id_area);
  	
  	if ( $acceso==1 ): ?>
	<div class="row row-top">
		<div class="col-md-8 col-lg-9 inset">
			<?php
			session::getFlashMessage( 'actions_message' );	
			na_areasController::uploadTareaAction();
			?>

			<h1><?php echo strTranslate("Na_areas");?> <small><?php echo $area[0]['area_nombre'];?></small></h1>
			<p><?php echo $area[0]['area_descripcion'];?></p>
			<div class="clearfix"></div>

			<?php printTareas($id_area);

			if ($module_config['options']['forums']==true){
				//mostrar foros del area
				$id_tema_parent = connection::SelectMaxReg("id_tema","foro_temas"," AND id_tema_parent=0 AND id_area=".$id_area." ");
				$filtro=" AND id_area=".$id_area." AND id_tema_parent=".$id_tema_parent." AND activo=1 ";
				if ($_SESSION['user_canal']!='admin' and $_SESSION['user_canal']!='formador' and $_SESSION['user_canal']!='foros'){$filtro.=" AND canal='".$_SESSION['user_canal']."' ";}
				
				$elements = foroController::getListTemasAction($module_config['options']['forums_per_page'], $filtro);

				echo '<h2>'.strTranslate("Forums").'</h2>';
				if ($elements['total_reg']==0) echo '<div class="alert alert-warning">No hay foros creados.</div>';
				foreach($elements['items'] as $element):
					ForoList($element);		
				endforeach;  
				
				Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],"areas_det&id=".$id_area,'',$elements['find_reg']);
			} ?>
		</div>
	<?php else: ?>
	  	<div class="alert alert-warning">No tienes acceso a la seecion</div>
	<?php endif;
} ?>


	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<?php
			if ($module_config['options']['forums']==true){
				//BANNER CREAR TEMA
				PanelSubirTemaForo($id_tema_parent,$area[0]['area_canal'], false, "", 0, $id_area);
			}
			?>
			<br /><p>Pincha <a href="?page=areas">aquí</a> para volver a todos los cursos</p>
		</div>
	</div>
</div>


<?php 
function printTareas($id_area){
  $na_areas = new na_areas();
  $contador_tareas=0;
  $elements = $na_areas->getTareas(" AND id_area=".$id_area." and activa=1 "); 
  foreach($elements as $element):
	//VERIFICAR SI ES UNA TAREA PARA UN GRUPO Y SI EL USUARIO PERTENECE O NO AL GRUPO
	$acceso_grupo=1;
	if ($_SESSION['user_perfil']!='admin' and $_SESSION['user_perfil']!='formador'){
		if ($element['tarea_grupo']==1){
			$acceso_grupo=count($na_areas->getUsersTareaGrupos($element['id_tarea'],$_SESSION['user_name']));
		}
	}
  	if ($element['tarea_grupo']==0 or $acceso_grupo==1){
  		$contador_tareas++;
		echo '<div class="panel panel-default">
			  <div class="panel-heading"><h4>'.$element['tarea_titulo'].'</h4></div>
			  <div class="panel-body">
			  <p>'.$element['tarea_descripcion'].'</p>';

		echo '<a class="trigger-documentacion" href="#"><i class="fa fa-angle-double-right"></i> Documentación</a>
				<div class="documentacion-tareas">';
				documentosTarea($element['id_tarea']);
		echo '</div>';
		//SOLO SE PODRÁN SUBIR ARCHIVOS SI ES UNA TAREA DE SUBIDA DE FICHEROS
		if ($element['tipo']=='fichero'){ 
			if ($element['activa_links']==1){
				$archivos = $na_areas->getTareasUser(" AND user_tarea='".$_SESSION['user_name']."' AND id_tarea=".$element['id_tarea']." AND id_area=".$id_area." ");
				echo'<div><a target="_blank" href="docs/showfile.php?t=1&file='.$element['tarea_archivo'].'"><i class="fa fa-angle-double-right"></i> Descargar tarea</a></div>	
					<div class="trigger-tarea"><a href="#"><i class="fa fa-angle-double-right"></i> Realizar tarea ('.count($archivos).')</a></div>		
						<div class="form-tareas" id="subir-tarea-'.$element['id_tarea'].'">
						    <form id="data-'.$element['id_tarea'].'" name="" action="" method="post" enctype="multipart/form-data" role="form">
								<input type="hidden" name="id_tarea" value="'.$element['id_tarea'].'"/>
								<input type="hidden" name="id_area" value="'.$id_area.'"/>
								<input type="file" class="btn btn-default" name="nombre-fichero" id="nombre-fichero-'.$element['id_tarea'].'" title="Seleccionar archivo" /> 
								<span id="fichero-comentario-alert-'.$element['id_tarea'].'" class="alert-message alert alert-danger"></span>
								<button type="button" class="enviarButton btn btn-default btnfileTarea" id="'.$element['id_tarea'].'" name="'.$element['id_tarea'].'">Subir archivo</button>						
							</form>
						</div>';
			}
			//PARA CADA TAREA SE OBTIENEN LOS FICHEROS SUBIDOS POR EL USUARIO
			foreach($archivos as $archivo):
				echo '<br /><a class="user-file text-muted" target="_blank" href="docs/showfile.php?t=1&file='.$archivo['file_tarea'].'">
						<span class="fa fa-download"></span> subido el '.getDateFormat($archivo['fecha_tarea'], "SHORT").'</a>';
			endforeach;
		}
		elseif ($element['tipo']=='formulario'){ 
			echo'<p><a href="?page=areas_form&id='.$element['id_tarea'].'"><i class="fa fa-angle-double-right"></i> Acceder al formulario</a></p>';
		}


		echo '</div></div>';
	}
  endforeach; 	
  if ($contador_tareas==0){ 
  	echo '<div class="alert alert-info"><i class="fa fa-info-circle"></i> No hay tareas activas.</div>';
  }
}

function documentosTarea($id_tarea){
	$na_areas = new na_areas();

	$documentos = $na_areas->getTareasDocumentos(" AND id_tarea=".$id_tarea." ");
	if (count($documentos)==0){
		echo '<p class="text-muted">No existen documentos para la tarea</p>';
	}
	else {
		//echo '<h5>Ficheros</h5>';
		foreach($documentos as $documento):
				echo '<div class="panel-documentos">';
				switch ($documento['documento_tipo']) {
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
						playVideo("video".$documento['id_documento'],PATH_VIDEOS.$documento['documento_file'],240,180,'bottom',false,0); 
						echo '<p class="text-center">'.$documento['documento_nombre'].'</p>';
						break;					
					case 'podcast':
						playVideo("podcast".$documento['id_documento'],"docs/audio/".$documento['documento_file'],240,24,'bottom',false,0); 
						echo '<p class="text-center">'.$documento['documento_nombre'].'</p>';
						break;
				}
				echo '</div>';
		endforeach;
	}
	echo '<div class="clearfix"></div>';
}
?>