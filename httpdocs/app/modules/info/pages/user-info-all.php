<?php
$filtro = ((isset($_REQUEST['id']) and $_REQUEST['id'] > 0) ? " AND i.id_campaign=".$_REQUEST['id'] : "");
$elements = infoController::getListAction(20, $filtro);
?>
<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Info_Documents"), "ItemUrl"=>"info-campaigns"),
			array("ItemLabel"=>$elements['items'][0]['campana'], "ItemClass"=>"active"),
		));?>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
					<th width="40px">&nbsp;</th>
					<th><?php echo strTranslate("Name");?></th>
					<th><?php echo strTranslate("Campaign");?></th>
					<th><?php echo strTranslate("Type");?></th>
				</tr>
				<?php foreach($elements['items'] as $element): 
				$enlace = ($element['download']==1 ? ' href="user-info?id='.$element['id_info'].'&exp='.$element['file_info'].'" ' : ' target="_blank" href="'.$element['file_info'].'" ');
				?>
				<tr>
					<td><a title="<?php echo strTranslate("Download_file");?>" <?php echo $enlace;?> ><i class="fa fa-download icon-table"></i></a></td>
					<td><a href="user-info?id=<?php echo $element['id_info'];?>"><?php echo $element['titulo_info'];?></a></td>
					<td><?php echo $element['campana'];?></td>
					<td><?php echo $element['tipo'];?></td>
				</tr>   
				<?php endforeach;  ?>
			</table>
		</div>
		<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
	</div>

	<div class="app-sidebar">
		<div class="panel-interior">
			<h4>
				<span class="fa-stack fa-sx">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-file fa-stack-1x fa-inverse"></i>
				</span>
				<?php echo strTranslate("Info_Documents");?>
			</h4>
			<p>Documentos de apoyo listos para descargar.</p>
			<p class="text-center"><i class="fa fa-file-o fa-big"></i></p>
		</div>	
	</div>
</div>