<?php

addJavascripts(array("js/bootstrap.file-input.js", getAsset("na_areas")."js/admin-area-docs.js"));

$na_areas = new na_areas();
$id_area=$_REQUEST['a'];
$id_tarea=$_REQUEST['id'];

//OBTENER DATOS DE LA TAREA
$tarea = $na_areas->getTareas(" AND id_tarea=".$id_tarea." ");
$elements = $na_areas->getTareasDocumentos(" AND id_tarea=".$id_tarea." ");
?>

<div class="row row-top">
	<div class="col-md-9 inset">
		<ol class="breadcrumb">
			<li><a href="?page=home"><?php echo strTranslate("Home");?></a></li>
			<li><a href="?page=admin"><?php echo strTranslate("Administration");?></a></li>
			<li><a href="#"><?php echo strTranslate("Na_areas");?></a></li>
			<li><a href="?page=admin-areas"><?php echo strTranslate("Na_areas_list");?></a></li>
			<li class="active">Documentacion de la tarea <b><?php echo $tarea[0]['tarea_titulo'];?></b></li>
		</ol>
		
		<?php
		session::getFlashMessage( 'actions_message' );
		na_areasController::insertDocAction();
		na_areasController::deleteDocAction();
		?>

		<ul class="nav nav-pills navbar-default">     
			<li><a href="?page=admin-area&act=edit&id=<?php echo $id_area;?>">Volver a la gestión del curso</a></li>
		</ul>

		<div class="panel panel-default">
			<div class="panel-heading">Cargar nuevo documento</div>
			<div class="panel-body">
				<form id="formImport" name="formImport" enctype="multipart/form-data" method="post" action="?page=admin-area-docs&a=<?php echo $id_area;?>&id=<?php echo $id_tarea;?>" role="form">
				<input type="hidden" name="id_tarea" id="id_tarea" value="<?php echo $id_tarea;?>" />
				<label for="nombre-documento">titulo del documento:</label>
				<input id="nombre-documento" name="nombre-documento" type="text" class="form-control" />
				<label for="tipo">tipo de documento:</label><br />

				<input type="radio" name="tipo" id="tipo" value="fichero" checked="checked" />fichero<br />
				<input type="radio" name="tipo" id="tipo" value="podcast" />audio / podcast<br />
				<input type="radio" name="tipo" id="tipo" value="video" />video<br />
				<input type="radio" name="tipo" id="tipo" value="enlace" />enlace
				<input type="text" name="documento-link" id="documento-link" value="http://" class="form-control">

				<label for="nombre-fichero" style="clear:both">selecciona el fichero / video / audio: </label>
				<input id="nombre-fichero" name="nombre-fichero" type="file" class="btn btn-default" title="Seleccionar fichero" />
				<span id="fichero-alert" class="alert-message alert alert-danger"></span>

				<br /><br />
				<button id="inputFile" name="inputFile" class="btn btn-primary">Cargar documentación</button>
				</form>
			</div>
		</div>

	<?php if (count($elements)>0){
		echo '<table class="table">';
		echo '<tr">';
		echo '<th width="40px">&nbsp;</th>';
		echo '<th>Documento</th>';
		echo '<th>Tipo</th>';
		echo '</tr>';
		foreach($elements as $element):
			echo '<tr>';
			echo '<td nowrap="nowrap">
			<span class="fa fa-ban icon-table" onClick="Confirma(\'¿Seguro que desea eliminar el documento '.$element['documento_nombre'].'?\',
			  \'?page=admin-area-docs&act=del&a='.$id_area.'&id='.$id_tarea.'&idd='.$element['id_documento'].'\')" title="eliminar documento" />
			</span>
			</td>';
			$ruta="docs/showfile.php?t=1&file=";
			if ($element['documento_tipo']=='enlace'){$ruta="";}
			elseif ($element['documento_tipo']=='video'){$ruta=PATH_VIDEOS;}
			echo '<td><a target="_blank" href="'.$ruta.$element['documento_file'].'">'.$element['documento_nombre'].'<a></td>';
			echo '<td>'.$element['documento_tipo'].'</td>';
			echo '</tr>';   
		endforeach;
		echo '</table>';
	}
	else{
		echo '<p>No hay documentos en la tarea</p>';
	}
	?>
  
	</div>
	<?php menu::adminMenu();?>
</div>