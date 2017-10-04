<?php
//EXPORT EXCEL - SHOW AND GENERATE
$filtro = " AND ocio=1 AND activo=1 ORDER BY id_tema DESC ";
blogController::exportListAction($filtro);
?>
<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Blog"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Posts_list"), "ItemClass"=>"active"),
		));

		session::getFlashMessage('actions_message');
		blogController::cambiarEstadoAction();
		$elements = foroController::getListTemasAction(15, $filtro);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-blog-new"><?php e_strTranslate("New_post");?></a></li>
					<li><a href="<?php echo $_REQUEST['page'];?>?export=true"><?php e_strTranslate("Export");?></a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'], "admin-blog", "searchForm", strTranslate("Search"), strTranslate("Search"), "", "navbar-form navbar-left");?>
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
						<?php foreach($elements['items'] as $element):
						$num_comentarios = connection::countReg("foro_comentarios", " AND estado=1 AND id_tema=".$element['id_tema']." ");
						$num_visitas = connection::countReg("foro_visitas", " AND id_tema=".$element['id_tema']." ");?>
						<tr>
							<td nowrap="nowrap">
								<button type="button" class="btn btn-default btn-xs" title="Eliminar"
									onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-blog?pag=<?php echo $elements['pag'];?>&act=del&id=<?php echo $element['id_tema'];?>'); return false;"><i class="fa fa-trash icon-table"></i>
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
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], 'admin-blog', 'Entradas', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>