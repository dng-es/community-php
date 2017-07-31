<?php
addJavascripts(array("js/bootstrap.file-input.js", getAsset("na_areas")."js/admin-area-docs.js"));

$na_areas = new na_areas();
$id_area = intval($_REQUEST['a']);
$id_tarea = intval($_REQUEST['id']);

//OBTENER DATOS DE LA TAREA
$tarea = $na_areas->getTareas(" AND id_tarea=".$id_tarea." ");
$elements = $na_areas->getTareasDocumentos(" AND id_tarea=".$id_tarea." ");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Na_areas"), "ItemUrl"=>"admin-areas"),
			array("ItemLabel"=>"Volver al curso", "ItemUrl"=>"admin-area?act=edit&id=".$id_area),
			array("ItemLabel"=>"Documentación de la tarea <em>".$tarea[0]['tarea_titulo']."</em>", "ItemClass"=>"active"),
		));
		
		session::getFlashMessage( 'actions_message' );
		na_areasController::insertDocAction();
		na_areasController::deleteDocAction();
		?>

		<div class="panel panel-default">
			<div class="panel-heading">Cargar nuevo documento</div>
			<div class="panel-body">
				<form id="formImport" name="formImport" enctype="multipart/form-data" method="post" action="admin-area-docs?a=<?php echo $id_area;?>&id=<?php echo $id_tarea;?>" role="form">
					<input type="hidden" name="id_tarea" id="id_tarea" value="<?php echo $id_tarea;?>" />
					
					<div class="col-md-6">				
						<div class="form-group">
							<label for="nombre-documento">Titulo del documento:</label>
							<input id="nombre-documento" name="nombre-documento" type="text" class="form-control" />
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label for="tipo">Tipo de documento:</label>
							<div class="radio radio-primary">
								<input type="radio" name="tipo" id="tipo" value="fichero" checked="checked" /><label>Fichero</label>
							</div>

							<div class="radio radio-primary">
								<input type="radio" name="tipo" id="tipo" value="podcast" /><label>Audio / podcast</label>
							</div>

							<div class="radio radio-primary">
								<input type="radio" name="tipo" id="tipo" value="video" /><label>Vídeo</label><br />
								<input id="nombre-fichero" name="nombre-fichero" type="file" class="btn btn-default" title="Seleccionar fichero / audio / vídeo" />
								<span id="fichero-alert" class="alert-message alert alert-danger"></span>
							</div>
							
							<div class="radio radio-primary">
								<input type="radio" name="tipo" id="tipo" value="enlace" /><label>Enlace</label>
								<input type="text" name="documento-link" id="documento-link" value="http://" class="form-control">
							</div>
						</div>
					</div>

					<div class="form-group col-md-12">
						<button id="inputFile" name="inputFile" class="btn btn-primary">Cargar documentación</button>
					</div>
				</form>
			</div>
		</div>

		<?php if (count($elements) > 0): ?>
		<div class="panel panel-default">
			<div class="panel-heading">Documentación de la tarea</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-striped">
						<tr>
							<th width="40px">&nbsp;</th>
							<th>Documento</th>
							<th>Tipo</th>
						</tr>
						<?php foreach($elements as $element):
						echo '<tr>';
						echo '<td nowrap="nowrap">
						<span class="fa fa-ban icon-table" onClick="Confirma(\'¿Seguro que desea eliminar el documento '.$element['documento_nombre'].'?\',
						  \'admin-area-docs?act=del&a='.$id_area.'&id='.$id_tarea.'&idd='.$element['id_documento'].'\')" title="eliminar documento" />
						</span>
						</td>';
						$ruta = "docs/showfile.php?t=1&file=";
						if ($element['documento_tipo'] == 'enlace') $ruta = "";
						elseif ($element['documento_tipo'] == 'video') $ruta = PATH_VIDEOS;
						echo '<td><a target="_blank" href="'.$ruta.$element['documento_file'].'">'.$element['documento_nombre'].'<a></td>';
						echo '<td>'.$element['documento_tipo'].'</td>';
						echo '</tr>';
						endforeach ?>
					</table>
				</div>
			</div>
		</div>
		<?php else: ?>
		<p class="alert alert-info">No hay documentos en la tarea</p>
		<?php endif; ?>
	</div>
	<?php menu::adminMenu();?>
</div>