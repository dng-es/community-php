<?php
//EXPORT REGS.
if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
	$na_areas = new na_areas();
	$elements = $na_areas->getAreas(" AND estado=1");
	download_send_headers("data_" . date("Y-m-d") . ".csv");
	echo array2csv($elements);
	die();
} 

//DESCARGAR USUARIOS DEL AREA
if ((isset($_REQUEST['id']) and $_REQUEST['id']!="") and !isset($_REQUEST['act'])){
	$na_areas = new na_areas();
	$elements = $na_areas->getAreasUsers(" AND id_area=".$_REQUEST['id']);
	download_send_headers("data_" . date("Y-m-d") . ".csv");
	echo array2csv($elements);
	die();
}

//CAMBIAR ESTADO
if (isset($_REQUEST['act']) and $_REQUEST['act']=='del') {
	$na_areas = new na_areas();
	$estado = $_REQUEST['e'];
	$na_areas->estadoArea($_REQUEST['id'],$estado);
}	

$na_areas = new na_areas();
$find_reg = "";
$find_text = "";
$filtro = "";

if (isset($_POST['find_reg'])) {$filtro.=" AND area_nombre LIKE '%".$_POST['find_reg']."%' ";$find_reg=$_POST['find_reg'];}
if (isset($_REQUEST['f'])) {$filtro.=" AND area_nombre LIKE '%".$_REQUEST['f']."%' ";$find_reg=$_REQUEST['f'];}
$filtro .= " AND estado<>2  ORDER BY id_area DESC";


//SHOW PAGINATOR
$reg = 10;
$pag = 1;
$inicio = 0;
if (isset($_GET["pag"]) and $_GET["pag"]!="") {
	$pag = $_GET["pag"];
	$inicio = ($pag - 1) * $reg;
}
$total_reg = connection::countReg("na_areas",$filtro); 
$elements=$na_areas->getAreas($filtro.' LIMIT '.$inicio.','.$reg); 	

?>

<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Na_areas"), "ItemUrl"=>"admin-areas"),
			array("ItemLabel"=> strTranslate("Na_areas_list"), "ItemClass"=>"active"),
		));
		?>
		<ul class="nav nav-pills navbar-default">     
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $total_reg;?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>    
			<li><a href="admin-area?act=new"><?php echo strTranslate("Na_areas_new");?></a></li>
			<li><a href="<?php echo $_REQUEST['page'];?>?export=true&q=<?php echo $find_text;?>"><?php echo strTranslate("Export");?></a></li>
			<div class="pull-right">
				<?php echo SearchForm($elements['reg'],"admin-areas","searchForm",strTranslate("Search"), strTranslate("Search"),"","navbar-form navbar-left");?>
			</div>

		</ul>

		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
					<th width="40px">&nbsp;</th>
					<th><?php echo strTranslate("Na_areas");?></th>
					<th><?php echo strTranslate("Channel");?></th>
				</tr>		
				<?php foreach($elements as $element): ?>
					<?php
					if($element['estado'] == 1){
						$imagen_revision = '<i class="fa fa-check icon-ok"></i>';
						$valor_activar = 0;
						$texto_activar = "desactivar";
					}
					else{
						$imagen_revision = '<i class="fa fa-exclamation icon-alert"></i>';
						$valor_activar = 1;
						$texto_activar = "activar";
					}
					?>
						<tr>
						<td nowrap="nowrap">
							<span class="fa fa-edit icon-table" title="<?php echo strTranslate("Edit");?>"
								onClick="location.href='admin-area?act=edit&id=<?php echo $element['id_area'];?>'">
							</span>

							<span class="fa fa-ban icon-table" title="<?php echo strTranslate("Delete");?>"
								onClick="Confirma('<?php echo strTranslate("Are_you_sure_to_delete");?>', 'admin-areas?pag=<?php echo $pag;?>&act=del&id=<?php echo $element['id_area'];?>&e=2')">
							</span>

							<a href="admin-areas?id=<?php echo $element['id_area'];?>" class="fa fa-download icon-table" title="Descargar usuarios"></a>

							<a href="#" onClick="Confirma('¿Seguro que quieres <?php echo $texto_activar;?> el curso?', 'admin-areas?act=del&e=<?php echo $valor_activar;?>&id=<?php echo $element['id_area'];?>')" 
							title="<?php echo $texto_activar;?> curso" /><?php echo $imagen_revision;?></a>
						</td>						
						<td><?php echo $element['area_nombre'];?>
						<br /><em class="text-muted"><small><?php echo getDateFormat($element['area_fecha'], "LONG");?></small></em></td>
						<td><?php echo $element['area_canal'];?></td>
						</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<?php Paginator($pag,$reg,$total_reg,'admin-areas','Areas',$find_reg);?>
	</div>
	<?php menu::adminMenu();?>
</div>