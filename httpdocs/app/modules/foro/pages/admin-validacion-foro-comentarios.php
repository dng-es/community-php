<?php
$filter = " AND estado=1";
//EXPORT COMMENTS
foroController::exportCommentsAction($filter);
?>
<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Forums"), "ItemUrl"=>"admin-validacion-foro-temas"),
			array("ItemLabel"=>"Comentarios en los foros", "ItemClass"=>"active"),
		));
		session::getFlashMessage( 'actions_message' );
		foroController::validateComentarioAction();
		foroController::cancelComentarioAction();
		$elements = foroController::getListComentariosAction(15, $filter);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?>. <?php echo ucfirst(strTranslate("APP_points"));?> a otorgar por mensaje: <b><?php echo PUNTOS_FORO;?></b></a></li>
					<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php e_strTranslate("Export");?></a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'],"admin-validacion-foro-comentarios","searchForm",strTranslate("Search"), strTranslate("Search"),"","navbar-form navbar-left");?>
					</div>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
					<tr>
						<th width="40px">&nbsp;</th>
						<th>ID</th>
						<th><?php e_strTranslate("Comment");?></th>
					</tr>
					<?php foreach($elements['items'] as $element):
						echo '<tr>';
						echo '<td nowrap="nowrap">
								<button type="button" class="btn btn-default btn-xs" title="Eliminar"
								    onClick="Confirma(\'¿Seguro que desea eliminar el comentario '.$element['id_comentario'].'?\',
									\'admin-validacion-foro-comentarios?pag='.(isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1).'&act=foro_ko&id='.$element['id_comentario'].'&u='.$element['user_comentario'].'\'); return false;"><i class="fa fa-trash icon-table"></i>
								</button>
							 </td>';
						echo '<td>'.$element['id_comentario'].'</td>';
						echo '<td>
								'.$element['comentario'].'<br />
								<em class="legend">'.getDateFormat($element['date_comentario'], "LONG").'</em><br />
								'.$element['user_comentario'].' ('.$element['canal'].')  - '.strTranslate("Forum").': '.$element['nombre'].'<br />';
						echo '</tr>';
					endforeach;?>
					</table>
				</div>
				<br />
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>