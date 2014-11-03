<?php
$elements = infoController::getListAction(20);
?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<h1><?php echo strTranslate("Info_Documents");?></h1>
		<div class="table-responsive">
			<table class="table">
				<tr>
					<th width="40px">&nbsp;</th>
					<th><?php echo strTranslate("Name");?></th>
					<th><?php echo strTranslate("Campaign");?></th>
					<th><?php echo strTranslate("Type");?></th>
				</tr>
				<?php foreach($elements['items'] as $element): ?>
				<tr>
					<td><a title="<?php echo strTranslate("Download_file");?>" href="?page=user-info&id=<?php echo $element['id_info'];?>&exp=<?php echo $element['file_info'];?>"><i class="fa fa-download icon-table"></i></a></td>
					<td><a href="?page=user-info&id=<?php echo $element['id_info'];?>"><?php echo $element['titulo_info'];?></a></td>
					<td><?php echo $element['campana'];?></td>
					<td><?php echo $element['tipo'];?></td>
				</tr>   
				<?php endforeach;  ?>
			</table>
		</div>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>

	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
		</div>	
	</div>
</div>