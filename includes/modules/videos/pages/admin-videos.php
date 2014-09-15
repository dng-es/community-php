<?php
//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);

$videos = new videos();  
$find_reg = "";
$filtro = " AND estado=1 ORDER BY id_file DESC";
if (isset($_REQUEST['act']) and $_REQUEST['act']=='del') { $videos->cambiarEstado($_REQUEST['id'],2);}

//SHOW PAGINATOR
$reg = 35;
if (isset($_GET["pag"])) {$pag = $_GET["pag"];}
if (!isset($pag)) { $inicio = 0; $pag = 1;}
else { $inicio = ($pag - 1) * $reg;}
$total_reg = connection::countReg("galeria_videos",$filtro);
?>

<div class="row row-top">
	<div class="col-md-9">
		<div id="page-info"><?php echo strTranslate("Video_list");?></div>
		<?php
		//EXPORT EXCEL - SHOW AND GENERATE
		if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
			$elements=$videos->getVideos($filtro);
			$file_name='exported_file'.date("YmdGis");
			ExportExcel('./docs/export/',$file_name,$elements);
		}

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
			echo '<td>'.strftime(DATE_FORMAT_SHORT,strtotime($element['date_video'])).'</td>';
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