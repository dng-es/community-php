<?php
session::getFlashMessage( 'actions_message' );
infoController::deleteAction();
$elements = infoController::getListAction(20);
?>
<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Info_Documents"), "ItemUrl"=>"admin-info"),
			array("ItemLabel"=>strTranslate("Info_Documents_list"), "ItemClass"=>"active"),
		));?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Items");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-info-doc?act=new"><?php e_strTranslate("Info_Documents_new");?></a></li>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="50px">&nbsp;</th>
							<th><?php e_strTranslate("Name");?></th>
							<th><?php e_strTranslate("Channel");?></th>
							<th><?php e_strTranslate("Type");?></th>
							<th><?php e_strTranslate("Campaign");?></th>
							<th><center>Descargable</center></th>
						</tr>
						<?php foreach($elements['items'] as $element): 
						$enlace = ($element['download'] == 1 ? 'user-info?id='.$element['id_info'].'&exp='.$element['file_info'] : $element['file_info']);
						?>
						<tr>
							<td nowrap="nowrap">
								  <button type="button" class="btn btn-default btn-xs" onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-info?pag=<?php echo $elements['pag'];?>&act=del&d=<?php echo $element['file_info'];?>&id=<?php echo $element['id_info'];?>'); return false;"  title="<?php e_strTranslate("Delete");?>" /><span class="fa fa-trash icon-table"></span></button>
								  <a href="admin-info-doc?act=edit&id=<?php echo $element['id_info'];?>" title="<?php e_strTranslate("Edit");?>"><button type="button" class="btn btn-default btn-xs">
								  <span class="fa fa-edit icon-table"></span></button></a>
							   </td>     
							<td><a target="_blank" href="<?php echo $enlace;?>"><?php echo $element['titulo_info'];?></a></td>
							<td><?php echo $element['canal_info'];?></td>
							<td><?php echo $element['tipo'];?></td>
							<td><?php echo $element['campana'];?></td>
							<td align="center"><span class="label<?php echo ($element['download'] == 0 ? " label-warning" : " label-success");?>"><?php echo ($element['download'] == 1 ? strTranslate("App_Yes") : strTranslate("App_No"));?></span></td>
						</tr>   
						<?php endforeach;  ?>
					</table>
				</div>
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>