<?php

addJavascripts(array(getAsset("blog")."js/admin-blog-foro.js"));

//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);

$foro = new foro(); 
$users = new users();

//VALIDAR CONTENIDOS
if (isset($_REQUEST['act'])) { 	 
if ($_REQUEST['act']=='foro_ok'){
  $foro->cambiarEstado($_REQUEST['id'],1);
  $users->sumarPuntos($_REQUEST['u'],PUNTOS_FORO,PUNTOS_FORO_MOTIVO);
}
elseif ($_REQUEST['act']=='tema_ko'){$foro->cambiarEstadoTema($_REQUEST['id'],0);}
elseif ($_REQUEST['act']=='foro_ko'){
	$foro->cambiarEstado($_REQUEST['id'],2);
	$users->restarPuntos($_REQUEST['u'],PUNTOS_MURO,PUNTOS_MURO_MOTIVO);
}
header("Location: ?page=admin-blog-foro&id=".$_REQUEST['idt']); 
}

//EXPORT EXCEL - SHOW AND GENERATE
if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
  $foro = new foro(); 
  $elements_exp=$foro->getComentariosExport(" AND c.id_tema=".$_REQUEST['id']." ");
  $file_name='exported_file'.date("YmdGis");
  ExportExcel('./docs/export/',$file_name,$elements_exp);}    

if (isset($_POST['tipo_search']) and $_POST['tipo_search']!="") {$filtro_temas.=" AND tipo_tema LIKE '%".$_POST['tipo_search']."%' ";$find_tipo=$_POST['tipo_search'];}

$foro = new foro();
$calculo = strtotime("-4 days");
$fecha_ayer= date("Y-m-d", $calculo);
$id_tema= $_REQUEST['id'];
$pendientes = $foro->getComentarios(" AND c.estado=1 AND c.id_tema=".$id_tema." ORDER BY id_comentario DESC");
?>
<div class="row row-top">
	<div class="col-md-9">
		<h1>Comentarios en <?php echo strTranslate("Blog");?></h1>
		<ul class="nav nav-pills navbar-default">       
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo count($pendientes);?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
			<li><a href="?page=admin-blog-new&act=edit&id=<?php echo $_REQUEST['id'];?>"><?php echo strtolower(strTranslate("Edit"));?></a></li>
			<li><a href="?page=blog&id=<?php echo $_REQUEST['id'];?>">Ver entrada</a></li>
		</ul>
		<?php if (count($pendientes)==0): ?>
		<div class="alert alert-danger">No hay mensajes en la entrada</div>
		<?php else: ?>
		<div class="table-responsive">
			<table class="table table-striped">
				<tr>
				<th width="40px">&nbsp;</th>
				<th>ID</th>
				<th>Comentario</th>
				<th>Autor</th>
				<th>Fecha</th>
				</tr>
			  <?php foreach($pendientes as $element):
					echo '<tr>';
					echo '<td nowrap="nowrap">					
							<span class="fa fa-ban icon-table" title="Eliminar"
							    onClick="Confirma(\'¿Seguro que desea eliminar el comentario '.$element['id_comentario'].'?\',
								\'?page=admin-blog-foro&act=foro_ko&id='.$element['id_comentario'].'&idt='.$id_tema.'&u='.$element['user_comentario'].'\')">
							</span>			
						 </td>';					
					echo '<td>'.$element['id_comentario'].'</td>';
					echo '<td><em class="legend">'.$element['comentario'].'</em></td>';
					echo '<td>'.$element['user_comentario'].'</td>';
					echo '<td>'.getDateFormat($element['date_comentario'], "SHORT").'</td>';		
					echo '<tr>';   
			  endforeach;?>
			</table>
		</div>
	<?php endif;?>
	</div>
	<?php menu::adminMenu();?>
</div>