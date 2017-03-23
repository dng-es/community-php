<?php
session::getFlashMessage('actions_message');
muroController::validateAction();
muroController::cancelAction();
$elements = muroController::getListAction(15, " AND estado=1 AND tipo_muro IN ('principal','responsable') ORDER BY date_comentario DESC"); ?>

<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Wall"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Comments_on_wall"), "ItemClass"=>"active"),
		));
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default"> 
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?>. <?php echo ucfirst(strTranslate("APP_points"));?> a otorgar por mensaje: <b><?php echo PUNTOS_MURO;?></b></a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'],"admin-validacion-muro","searchForm",strTranslate("Search"), strTranslate("Search"),"","navbar-form navbar-left");?>
					</div>
				</ul>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="40px">&nbsp;</th>
							<th>ID</th>
							<th><?php e_strTranslate("Comment");?></th>
							<th><?php e_strTranslate("Channel");?></th>
						</tr>
						<?php foreach($elements['items'] as $element):
							echo '<tr>';
							echo '<td nowrap="nowrap">
									<button type="button" class="btn btn-default btn-xs" title="'.strTranslate("Delete").'" 
										onClick="Confirma(\''.strTranslate("Are_you_sure_to_delete").'?\',
										\'admin-validacion-muro?act=muro_ko&id='.$element['id_comentario'].'&pag='.(isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1).'&u='.$element['user_comentario'].'\'); return false;"><i class="fa fa-trash icon-table"></i>
									</button>
								</td>';
							echo '<td>'.$element['id_comentario'].'</td>';
							echo '<td>
								'.$element['comentario'].'<br />
								<em class="legend">'.getDateFormat($element['date_comentario'], "DATE_TIME").'</em><br />
								'.$element['user_comentario'].'
								</td>';
							echo '<td>'.$element['canal_comentario'].'</td>';
							echo '</tr>';
						endforeach;?>
					</table>
				</div>
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>