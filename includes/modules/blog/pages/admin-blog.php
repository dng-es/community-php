<?php
//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);

include_once ("includes/users/class.users.php");
$foro = new foro();
$filtro = " AND ocio=1 AND activo=1 ";
if (isset($_POST['find_reg'])) {$filtro.=" AND nombre LIKE '%".$_POST['find_reg']."%' ";$find_reg=$_POST['find_reg'];}
if (isset($_REQUEST['f'])) {$filtro.=" AND nombre LIKE '%".$_REQUEST['f']."%' ";$find_reg=$_REQUEST['f'];}

$filtro.=" ORDER BY id_tema DESC ";
if (isset($_REQUEST['act']) and $_REQUEST['act']=='del') { $foro->cambiarEstadoTema($_REQUEST['id'],0);}

//SHOW PAGINATOR
$reg = 15;
if (isset($_GET["pag"])) {$pag = $_GET["pag"];}
if (!$pag) { $inicio = 0; $pag = 1;}
else { $inicio = ($pag - 1) * $reg;}
$total_reg = connection::countReg("foro_temas",$filtro);


//EXPORT EXCEL - SHOW AND GENERATE
if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
	$elements=$foro->getTemas($filtro);
	$file_name='exported_file'.date("YmdGis");
	ExportExcel('./docs/export/',$file_name,$elements);}

$elements=$foro->getTemas($filtro.' LIMIT '.$inicio.','.$reg); ?>
<div class="row row-top">
	<div class="col-md-9">
		<h1>Entradas en <?php echo strTranslate("Blog");?></h1>
		<ul class="nav nav-pills navbar-default">       
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo count($elements);?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
			<li><a href="?page=admin-blog-new&act=new">Nueva entrada</a></li>
			<li><a href="?page=<?php echo $_REQUEST['page'];?>&export=true&q=<?php echo $find_text;?>"><?php echo strTranslate("Export");?></a></li>
		</ul>

		<div class="table-responsive">
			<table class="table">
			<tr>
			<th width="40px"></th>
			<th>Título</th>
			<th></th>
			<th><span class="fa fa-eye"></span></th>
			<th><span class="fa fa-comment"></span></th>
			</tr>
			<?php foreach($elements as $element):
				$num_comentarios = connection::countReg("foro_comentarios"," AND estado=1 AND id_tema=".$element['id_tema']." ");
				$num_visitas = connection::countReg("foro_visitas"," AND id_tema=".$element['id_tema']." ");
				echo '<tr>';
				echo '<td nowrap="nowrap">
						<span class="fa fa-edit icon-table" title="Ver/editar entrada"
							onClick="location.href=\'?page=admin-blog-new&act=edit&id='.$element['id_tema'].'\'">
						</span>
						
						<span class="fa fa-ban icon-table" title="Eliminar"
							onClick="Confirma(\'¿Seguro que desea eliminar la entrada?\',
							\'?page=admin-blog&pag='.$pag.'&act=del&id='.$element['id_tema'].'\')">
						</span>
					 </td>';
							
				echo '<td>'.$element['nombre'].'</td>';
				echo '<td><em class="legend">'.getDateFormat($element['date_tema'], "LONG").'</em><br />';
				echo $element['user'].'</td>';
				echo '<td>'.$num_visitas.'</td>';
				echo '<td>';
				if ($num_comentarios==0){ echo $num_comentarios;}
				else{ echo '<a href="?page=admin-blog-foro&id='.$element['id_tema'].'">'.$num_comentarios.'</a>';}
				echo '</td>';
				echo '</tr>';   
			endforeach;?>
			</table>
		</div>
		<?php Paginator($pag,$reg,$total_reg,'admin-blog','Entradas',$find_reg);?>
	</div>
	<?php menu::adminMenu();?>
</div>