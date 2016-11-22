<?php
addJavascripts(array(getAsset("videos")."js/admin-videos.js"));

$videos = new videos();
$find_reg = "";
$filtro = " AND estado=1 ORDER BY id_file DESC";
if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del') $videos->cambiarEstado($_REQUEST['id'],2);

//EXPORT EXCEL - SHOW AND GENERATE
if (isset($_REQUEST['export']) and $_REQUEST['export'] == true){
	$elements = $videos->getVideos($filtro);
	download_send_headers("data_" . date("Y-m-d") . ".csv");
	echo array2csv($elements);
	die();
}

//SHOW PAGINATOR
$reg = 25;
if (isset($_GET["pag"])) {$pag = $_GET["pag"];}
if (!isset($pag)) { $inicio = 0; $pag = 1;}
else { $inicio = ($pag - 1) * $reg;}
$total_reg = connection::countReg("galeria_videos",$filtro);

$elements=$videos->getVideos($filtro.' LIMIT '.$inicio.','.$reg);
?>

<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Videos"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Video_list"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		videosController::changeTags();
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default"> 
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $total_reg;?></b> <?php echo strtolower(strTranslate("Items"));?>.</a></li>
					<li><a href="<?php echo $_REQUEST['page'];?>?export=true"><?php e_strTranslate("Export");?></a></li>
				</ul>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="40px"></th>
							<th><?php e_strTranslate("Video");?></th>
							<th><?php e_strTranslate("Tags");?></th>
							<th><?php e_strTranslate("Author");?></th>
							<th><i class="fa fa-comment"></i></th>
						</tr>
						
						<?php foreach($elements as $element):
							$num_comentarios = connection::countReg("galeria_videos_comentarios", " AND estado=1 AND id_file=".$element['id_file']." ");
							echo '<tr>';
							echo '<td nowrap="nowrap">
									<span class="fa fa-ban icon-table" title="'.strTranslate("Delete").'"
										onClick="Confirma(\''.strTranslate("Are_you_sure_to_delete").'\',
										\'admin-videos?pag='.$pag.'&act=del&id='.$element['id_file'].'\')">
									</span>
								</td>';
							echo '<td>'.$element['titulo'];
							echo '<br /><em class="text-muted"><small>'.getDateFormat($element['date_video'], "LONG").'</small></em>';
							echo '</td>';?>
							<td><input type="text" name="tipo_video" id="tipo_video_<?php echo $element['id_file'];?>" value="<?php echo $element['tipo_video'];?>" /> <button data-pag="<?php echo $pag;?>" data-id="<?php echo $element['id_file'];?>" class="btn btn-default trigger-tags btn-xs">modificar</button></td>
							<?php
							echo '<td>'.$element['user_add'].'</td>';
							echo '<td>';
					   	if ($num_comentarios == 0) echo $num_comentarios;
					    else echo '<a href="admin-videos-comentarios?id='.$element['id_file'].'">'.$num_comentarios.'</a>';
							echo '</td>';
							echo '</tr>';
						endforeach;?>
					</table>
				</div>
				<?php Paginator($pag, $reg, $total_reg, 'admin-videos', 'Videos', $find_reg);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>