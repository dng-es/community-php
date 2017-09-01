<?php
$foro = new foro();
$filtro = " AND ocio=1 AND activo=1 ";

$find_reg = "";
if (isset($_POST['find_reg'])){
	$filtro .= " AND nombre LIKE '%".$_POST['find_reg']."%' ";
	$find_reg = $_POST['find_reg'];
}
if (isset($_REQUEST['f'])){
	$filtro .= " AND nombre LIKE '%".$_REQUEST['f']."%' ";
	$find_reg = $_REQUEST['f'];
}

$filtro .= " ORDER BY id_tema DESC ";
if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del') $foro->cambiarEstadoTema($_REQUEST['id'], 0);

//SHOW PAGINATOR
$reg = 15;
if (isset($_GET["pag"])) $pag = $_GET["pag"];
if (!isset($pag)) { $inicio = 0; $pag = 1;}
else $inicio = ($pag - 1) * $reg;
$total_reg = connection::countReg("foro_temas", $filtro);

//EXPORT EXCEL - SHOW AND GENERATE
if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
	$elements = $foro->getTemas($filtro);
	download_send_headers("data_" . date("Y-m-d") . ".csv");
	echo array2csv($elements);
	die();
}

$elements = $foro->getTemas($filtro.' LIMIT '.$inicio.','.$reg); ?>
<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Blog"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Posts_list"), "ItemClass"=>"active"),
		));?>

		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo count($elements);?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-blog-new"><?php e_strTranslate("New_post");?></a></li>
					<li><a href="<?php echo $_REQUEST['page'];?>?export=true"><?php e_strTranslate("Export");?></a></li>
					<div class="pull-right">
						<?php echo SearchForm($reg, "admin-blog", "searchForm", strTranslate("Search"), strTranslate("Search"), "", "navbar-form navbar-left");?>
					</div>
				</ul>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
					<tr>
					<th width="40px"></th>
					<th><?php e_strTranslate("Title");?></th>
					<th><?php e_strTranslate("Channel");?></th>
					<th class="text-center"><span class="fa fa-comment"></span></th>
					<th class="text-center"><span class="fa fa-eye"></span></th>
					</tr>
					<?php foreach($elements as $element):
						$num_comentarios = connection::countReg("foro_comentarios"," AND estado=1 AND id_tema=".$element['id_tema']." ");
						$num_visitas = connection::countReg("foro_visitas"," AND id_tema=".$element['id_tema']." ");?>
						<tr>
							<td nowrap="nowrap">
								<button type="button" class="btn btn-default btn-xs" title="Eliminar"
									onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-blog?pag=<?php echo $pag;?>&act=del&id=<?php echo $element['id_tema'];?>'); return false;"><i class="fa fa-trash icon-table"></i>
								</button>
								<button type="button" class="btn btn-default btn-xs" title="Ver/editar entrada" onClick="location.href='admin-blog-new?id=<?php echo $element['id_tema'];?>'; return false"><i class="fa fa-edit icon-table"></i>
								</button>
							</td>
							<td>
								<?php echo $element['nombre'];?><br />
								<em class="legend"><?php echo getDateFormat($element['date_tema'], "LONG");?></em><br />
								<?php echo $element['user'];?></td>
							<td><?php echo ucfirst($element['canal']);?></td>
							<td class="text-center" title="<?php echo $num_comentarios.' '.strtolower(strTranslate("Comments"));?>">
							<?php if ($num_comentarios == 0) echo $num_comentarios;
							else echo '<a href="admin-blog-foro?id='.$element['id_tema'].'">'.$num_comentarios.'</a>';?>
							</td>
							<td class="text-center" title="<?php echo $num_visitas.' '.strtolower(strTranslate("Visits"));?>"><?php echo $num_visitas;?></td>
						</tr>
					<?php endforeach;?>
					</table>
				</div>
				<?php Paginator($pag, $reg, $total_reg, 'admin-blog', 'Entradas', $find_reg);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>