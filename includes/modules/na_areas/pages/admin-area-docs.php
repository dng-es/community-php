<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
function ini_page_header ($ini_conf) {
?>	
	  <script language="JavaScript" src="<?php echo getAsset("na_areas");?>js/admin-area-docs.js"></script>
	  <script language="JavaScript" src="js/bootstrap.file-input.js"></script>
	  <script language="javascript" type="text/javascript">
		  $(document).ready(function(){
			$('input[type=file]').bootstrapFileInput();
		  });
	  </script> 
<?php }
function ini_page_body ($ini_conf){
	//CONTROL NIVEL DE ACCESO
	$session = new session();
	$perfiles_autorizados = array("admin");
	$session->AccessLevel($perfiles_autorizados);
	$na_areas = new na_areas();

	$id_area=$_REQUEST['a'];
	$id_tarea=$_REQUEST['id'];

	?>

	<div id="page-info">Documentacion de la tarea</div>
	<div class="row inset row-top">
		<div class="col-md-8">

	<?php
	session::getFlashMessage( 'actions_message' );

	//insertar documento
	if (isset($_POST['id_tarea']) and $_POST['id_tarea']!=""){ 
		$mensaje = $na_areas->insertTareaDoc($id_tarea,$_POST['tipo'],$_POST['nombre-documento'],$_FILES['nombre-fichero'],$_POST['documento-link']);
		session::setFlashMessage( 'actions_message', $mensaje, "alert alert-warning"); 
		redirectURL($_SERVER['REQUEST_URI']);
	}        

	//eliminar documento
	if (isset($_REQUEST['act']) and $_REQUEST['act']=='del') { 
		if($na_areas->deleteTareaDoc($_REQUEST['idd'])){
			session::setFlashMessage( 'actions_message', "Documento eliminado correctamente.", "alert alert-success"); 
		}
		else {
			session::setFlashMessage( 'actions_message', "Error al eliminar el documento.", "alert alert-danger"); 
		}
		redirectURL("?page=admin-area-docs&a=".$id_area."&id=".$id_tarea);
	}

	//OBTENER DATOS DE LA TAREA
	$tarea=$na_areas->getTareas(" AND id_tarea=".$id_tarea." ");
	$elements=$na_areas->getTareasDocumentos(" AND id_tarea=".$id_tarea." "); 

	if (count($elements)>0){
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
	<div class="col-md-4">
	<div class="panel panel-default">
		<div class="panel-heading">Gestión de cursos</div>
			<div class="panel-body">
			<p><b>Tarea</b>: <?php echo $tarea[0]['tarea_titulo'];?></p>         
				<a href="?page=admin-area&act=edit&id=<?php echo $id_area;?>">volver a la gestión del curso</a>
			</div>
		</div>
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
		</div>
	</div>
<?php 
}
?>