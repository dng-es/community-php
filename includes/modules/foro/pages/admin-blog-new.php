<?php

addJavascripts(array("js/libs/ckeditor/ckeditor.js", 
					 "js/libs/ckfinder/ckfinder.js", 
					 "js/bootstrap.file-input.js", 
					 getAsset("foro")."js/admin-blog-new.js"));

//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);

$accion=$_GET['act'];
$accion1=$_GET['act1'];
$id = 0;

if ($accion=='edit'){ $id=$_GET['id'];}
if ($accion=='edit' and $_GET['accion2']=='ok' and $accion1!="del"){ UpdateData();}
elseif ($accion=='new' and $_GET['accion2']=='ok'){ $id=InsertData();$accion="edit";}

$foro = new foro();
$elements = array();
$elements=$foro->getTemas(" AND id_tema=".$id." ");  
?>
<div class="row row-top">
	<div class="col-md-9">
		<h1>Entradas en el blog</h1>
		<form id="formData" name="formData" method="post" enctype="multipart/form-data" action="?page=admin-blog-new&act=<?php echo $accion;?>&amp;id=<?php echo $id;?>&amp;accion2=ok" role="form">
		<div class="col-md-9">

			<label for="nombre" class="sr-only">Título de la entrada:</label>
			<input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $elements[0]['nombre'];?>" placeholder="título de la entrada" />
			<label for="descripcion">Cuerpo de la entrada:</label>
			<textarea cols="40" rows="5" name="descripcion"><?php echo $elements[0]['descripcion'];?></textarea>
			<script type="text/javascript">

			var editor=CKEDITOR.replace('descripcion',{customConfig : 'config-page.js'});
			CKFinder.setupCKEditor(editor, 'js/libs/ckfinder/') ;

			</script>
			
		</div>
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading">Entrada en el blog</div>
				<div class="panel-body">
					
					<input type="submit" name="SubmitData" class="btn btn-primary btn-block" value="Guardar entrada" />
					<hr />
					<?php
						if ($accion=='edit'){
							$num_comentarios = connection::countReg("foro_comentarios"," AND estado=1 AND id_tema=".$id." ");
							echo '<a target="_blank" href="?page=blog&id='.$id.'" title="ver entrada">Ver entrada</a><br />';
							echo '<a href="?page=admin-blog-foro&id='.$id.'" title="comentario">Comentarios de la entrada ('.$num_comentarios.')</a><br />';
						}
					?>
					<a href="?page=admin-blog" title="Exportar">Ir a todas las entradas</a><br />
					<a href="?page=admin-blog-new&act=new" title="nuevo usuario">Crear nueva entrada</a>  
					
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Etiquetas de la entrada</div>
				<div class="panel-body">
					<p>Introduce las etiquetas de la entrada:</p>
					<input type="text" name="etiquetas" id="etiquetas" class="form-control" value="<?php echo $elements[0]['tipo_tema'];?>" />
					Etiquetas existentes: 
					<?php
						$categorias = $foro->getCategorias(" AND ocio=1 ");
						foreach($categorias as $categoria):
							echo '<a href="#">'.$categoria.'</a> ';
						endforeach;
						?>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Imágen principal</div>
				<div class="panel-body">
					<p>Selecciona la imágen principal de la entrada:</p>
					<?php
						if ($elements[0]['imagen_tema']!=""){
							echo '<img src="images/foro/'.$elements[0]['imagen_tema'].'" style="width: 100%" class="responsive" />';
						}
					?>
					<input type="file" name="imagen-tema" id="imagen-tema" class="btn btn-primary btn-block" title="seleccionar imágen" />
				</div>
			</div>
		</div>
		</form>
	</div>
	<?php menu::adminMenu();?>
</div>


<?php 
function UpdateData(){
	$foro = new foro();
	if ($foro->updateTema($_REQUEST['id'],$_POST['nombre'],$_POST['descripcion'],$_POST['etiquetas'],$_FILES['imagen-tema'])) {
			OkMsg("Entrada modificada correctamente.");}
}

function InsertData(){
	$foro = new foro();
	if ($foro->InsertTema(0,$_POST['nombre'],$_POST['descripcion'],$_FILES['imagen-tema'],$_SESSION['username'],CANAL1,0,1,'',0,1,$_POST['etiquetas'])) {
			OkMsg("Entrada insertada correctamente.");}
	return foro::SelectMaxReg("id_tema","foro_temas"," AND ocio=1 ");
}
?>