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

	session::getFlashMessage( 'actions_message' );	
	na_areasController::uploadTareaAction();
	$module_config = getModuleConfig("na_areas");
	$acceso = foroController::accesoForoAreaAction($id_area);
	$area = na_areasController::getItemAction($id_area)
  	
  	if($acceso==1){

		echo '<div class="row row-top">
				<div class="col-md-8 col-lg-9 inset">';
		echo '		<h1>Cursos de formación</h1>';

		//Obtener datos de la primera tarea e formulario
		$elements = $na_areas->getTareas(" AND id_area=".$id_area." AND activa=1 AND tipo='formulario' LIMIT 1 "); 
		$finalizados = connection::countReg("na_tareas_formularios_finalizados"," AND id_tarea=".$elements[0]['id_tarea']." AND user_tarea='".$_SESSION['user_name']."' ");
		$txtBtn = ($finalizados>0) ? "Curso finalizado" : "Realizar tarea del curso";

		if ($finalizados>0){
			//obtener resultado de la valoracion
			$valoracion = $na_areas->getFormulariosFinalizados(" AND user_tarea='".$_SESSION['user_name']."' AND id_tarea=".$elements[0]['id_tarea']);
			if (count($valoracion)>0){
				if ($valoracion[0]['revision']==1 and $valoracion[0]['puntos']>=7){ $msg = "Enhorabuena, has conseguido un <b>".$valoracion[0]['puntos']."</b> en este curso y acumulado <b>".$area[0]['puntos']."</b> horas de vuelo.";}
				if ($valoracion[0]['revision']==1 and $valoracion[0]['puntos']<7){ $msg = "Tu nota es de <b>".$valoracion[0]['puntos']."</b>,  no has conseguido superar el mínimo en este curso para conseguir horas de vuelo.";}
				if ($valoracion[0]['revision']==0){ $msg = "Tus respuestas serán revisadas por un tutor. Muy pronto podrás consultar la puntuación obtenida accediendo al curso.";}
			}
			echo '<div class="alert alert-info"><span class="fa fa-info-circle"></span> '.$msg.'</div>';
		}

		//DATOS DE AREA DE TRABAJO
		echo '		<section>';
		echo '  			<h4>'.$area[0]['area_nombre'].'</h4>
		    				<p>'.$area[0]['area_descripcion'].'</p>
		    				<a href="?page=areas_form&id='.$elements[0]['id_tarea'].'" class="btn btn-primary pull-right">'.$txtBtn.'</a>
		    				<div class="clearfix"></div>';
		echo '		</section>';

		//printTareas($id_area);
		documentosTarea($elements[0]['id_tarea']);

		if ($module_config['forums']==true){
			//mostrar foros del area
			$filtro=" AND id_area=".$id_area." AND id_tema_parent=0 AND activo=1 ";
			if ($_SESSION['user_canal']!='admin' and $_SESSION['user_canal']!='formador' and $_SESSION['user_canal']!='foros'){$filtro.=" AND canal='".$_SESSION['user_canal']."' ";}
			$foro = new foro();
			$temas = $foro->getTemas($filtro);
			$id_tema_parent = $temas[0]['id_tema'];
		}

		echo '</div>';
	}
	else{
	  	ErrorMsg("No tienes acceso a la seecion");
	}
} ?>


	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
		
		</div>
	</div>
</div>


<?
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
			  <div class="panel-heading">'.$element['tarea_titulo'].'</div>
			  <div class="panel-body">
			  <p>'.$element['tarea_descripcion'].'</p>';

	
		//SOLO SE PODRÁN SUBIR ARCHIVOS SI ES UNA TAREA DE SUBIDA DE FICHEROS
		if ($element['tipo']=='fichero'){ 
			if ($element['activa_links']==1){
				echo'<div class="panel-info"><a target="_blank" href="docs/showfile.php?t=1&file='.$element['tarea_archivo'].'">Descargar tarea <span class="fa fa-angle-double-right"></span></a></div>';
			
			echo '<div class="panel-info trigger-tarea">Realizar tarea <span class="fa fa-angle-double-right"></span></div>';			
			echo' <div class="form-tareas" id="subir-tarea-'.$element['id_tarea'].'">
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
			$archivos = $na_areas->getTareasUser(" AND user_tarea='".$_SESSION['user_name']."' AND id_tarea=".$element['id_tarea']." AND id_area=".$id_area." ");
			echo '<p>Archivos subidos: '.count($archivos).'</p>';
			foreach($archivos as $archivo):
					echo '<p>
							<a class="user-file" target="_blank" href="docs/showfile.php?t=1&file='.$archivo['file_tarea'].'">
							<span class="fa fa-download"></span>
							 subido el '.strftime(DATE_FORMAT_SHORT,strtotime($archivo['fecha_tarea'])).'</a>
						  </p>';
			endforeach;
		}
		elseif ($element['tipo']=='formulario'){ 
			//echo'<div class="panel-info"><a href="?page=areas_form&id='.$element['id_tarea'].'">Acceder al formulario <span class="fa fa-angle-double-right"></span></a></div>';
		}


		echo '<div class="panel-info trigger-documentacion">Documentación <span class="fa fa-angle-double-right"></span></div>
				<div class="documentacion-tareas">';
		documentosTarea($element['id_tarea']);

		echo '</div>
		</div></div>';
	}
  endforeach; 	
  if ($contador_tareas==0){ 
  	echo '<div class="alert alert-info"><i class="fa fa-info-circle"></i> No hay tareas activas.</div>';
  }
}

function documentosTarea($id_tarea){
	$na_areas = new na_areas();
	//FICHEROS
	$documentos = $na_areas->getTareasDocumentos(" AND id_tarea=".$id_tarea." AND documento_tipo='fichero' ");
	if (count($documentos)>0){
		//echo '<h5>Ficheros</h5>';
		foreach($documentos as $documento):
				echo '<div class="panel-documentos">
						<a target="_blank" href="docs/showfile.php?t=1&file='.$documento['documento_file'].'">
						<i class="fa fa-file"></i>
						'.$documento['documento_nombre'].'</a>
					  </div>';
		endforeach;
	}
	//ENLACES
	$documentos = $na_areas->getTareasDocumentos(" AND id_tarea=".$id_tarea." AND documento_tipo='enlace' ");
	if (count($documentos)>0){
		//echo '<h5>Enlaces</h5>';
		foreach($documentos as $documento):
				echo '<div class="panel-documentos">					
						<a target="_blank" href="'.$documento['documento_file'].'">
						<i class="fa fa-globe"></i>
						'.$documento['documento_nombre'].'</a>
						<div style="clear:both"></div>
					  </div>';
		endforeach;
	}	

	//echo '<br />';
	//VIDEOS
	$documentos = $na_areas->getTareasDocumentos(" AND id_tarea=".$id_tarea." AND documento_tipo='video' ");
	if (count($documentos)>0){
		//echo '<h5>Videos</h5>';
		foreach($documentos as $documento):
			echo '<div class="panel-documentos">';				  
			playVideo("video".$documento['id_documento'],PATH_VIDEOS.$documento['documento_file'],240,180); 
			echo '<p>'.$documento['documento_nombre'].'</p>';
			echo '</div>';
		endforeach;
	}	

	//PODCAST
	$documentos = $na_areas->getTareasDocumentos(" AND id_tarea=".$id_tarea." AND documento_tipo='podcast' ");
	if (count($documentos)>0){
		//echo '<h5>Audio</h5>';
		foreach($documentos as $documento):
			echo '<div class="panel-documentos">';				  
			playVideo("podcast".$documento['id_documento'],"docs/audio/".$documento['documento_file'],240,24,'bottom'); 
			echo '<p>'.$documento['documento_nombre'].'</p>';
			echo '</div>';
		endforeach;
	}
}
?>
