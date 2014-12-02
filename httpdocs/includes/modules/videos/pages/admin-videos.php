<?php
$videos = new videos();  
$find_reg = "";
$filtro = " AND estado=1 ORDER BY id_file DESC";
if (isset($_REQUEST['act']) and $_REQUEST['act']=='del') { $videos->cambiarEstado($_REQUEST['id'],2);}

//EXPORT EXCEL - SHOW AND GENERATE
if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
	$elements = $videos->getVideos($filtro);
	download_send_headers("data_" . date("Y-m-d") . ".csv");
	echo array2csv($elements);
	die();
}

//SHOW PAGINATOR
$reg = 35;
if (isset($_GET["pag"])) {$pag = $_GET["pag"];}
if (!isset($pag)) { $inicio = 0; $pag = 1;}
else { $inicio = ($pag - 1) * $reg;}
$total_reg = connection::countReg("galeria_videos",$filtro);
?>

<div class="row row-top">
	<div class="col-md-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"?page=admin"),
			array("ItemLabel"=>strTranslate("Videos"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Video_list"), "ItemClass"=>"active"),
		));
		?>
		<ul class="nav nav-pills navbar-default"> 
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $total_reg;?></b> <?php echo strtolower(strTranslate("Items"));?>.</a></li>
			<li><a href="?page=<?php echo $_REQUEST['page'];?>&export=true"><?php echo strTranslate("Export");?></a></li>
		</ul>
		<?php

		//SHOW DATA
		$elements=$videos->getVideos($filtro.' LIMIT '.$inicio.','.$reg);
		echo '<table class="table table-striped" >';
		echo '<tr">';
		echo '<th width="40px"></th>';
		echo '<th>'.strTranslate("Video").'</th>';
		echo '<th>'.strTranslate("Date").'</th>';
		echo '<th>'.strTranslate("Author").'</th>';
		echo '<th><i class="fa fa-comment"></i></th>';
		echo '</tr>';
		
		foreach($elements as $element):
			$num_comentarios = connection::countReg("galeria_videos_comentarios"," AND estado=1 AND id_file=".$element['id_file']." ");
			echo '<tr>';
			echo '<td nowrap="nowrap">	
					<span class="fa fa-ban icon-table" title="'.strTranslate("Delete").'"
						onClick="Confirma(\'¿Seguro que deseas eliminar el video?\',
						\'?page=admin-videos&pag='.$pag.'&act=del&id='.$element['id_file'].'\')">
					</span>
				 </td>';
						
			echo '<td>'.$element['titulo'].'</td>';
			echo '<td>'.getDateFormat($element['date_video'], "SHORT").'</td>';
			echo '<td>'.$element['user_add'].'</td>';
			echo '<td>';
	   	if ($num_comentarios==0){ echo $num_comentarios;}
	    else{ echo '<a href="?page=admin-videos-comentarios&id='.$element['id_file'].'">'.$num_comentarios.'</a>';}
			echo '</td>';
			echo '<tr>';   
		endforeach;?>
		</table>
		<?php Paginator($pag,$reg,$total_reg,'admin-videos','Videos',$find_reg);?>
	</div>
	<?php menu::adminMenu();?>
</div>