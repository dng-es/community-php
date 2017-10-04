<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Infotopdf_Documents"), "ItemClass"=>"active"),
		));
		session::getFlashMessage( 'actions_message' ); 
		infotopdfController::deleteAction();
		$elements = infotopdfController::getListAction(20);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default"> 
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-infotopdf-doc?act=new">Nuevo documento</a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'],"admin-infotopdf","searchForm",strTranslate("Search"), strTranslate("Search"),"","navbar-form navbar-left");?>
					</div>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="50px">&nbsp;</th>
							<th>Documento</th>
							<th>Tipo</th>
							<th>Campaña</th>
						</tr>
						<?php foreach($elements['items'] as $element):?>
						<tr>
							<td nowrap="nowrap">
								<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Delete");?>"
									onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-infotopdf?pag=<?php echo $elements['pag'];?>&act=del&d=<?php echo $element['file_info'];?>&id=<?php echo $element['id_info'];?>'); return false"><i class="fa fa-trash icon-table"></i>
								</button>

								<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Edit");?>" onClick="location.href='admin-infotopdf-doc?act=edit&id=<?php echo $element['id_info'];?>'; return false"><i class="fa fa-edit icon-table"></i>
								</button>								
							</td>
							<td><a target="_blank" href="<?php echo PATH_INFO.$element['file_info'];?>"><?php echo $element['titulo_info'];?></a></td>
							<td><?php echo $element['tipo'];?></td>
							<td><?php echo $element['campana'];?></td>
						</tr>
						<?php endforeach;?>
					</table>
				</div>
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>