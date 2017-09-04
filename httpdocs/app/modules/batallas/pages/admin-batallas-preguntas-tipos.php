<div class="row row-top">
	<div class="app-main section-admin">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Battles"), "ItemUrl"=>"admin-batallas"),
			array("ItemLabel"=>strTranslate("Battles_questions_list"), "ItemUrl"=>"admin-batallas-preguntas"),
			array("ItemLabel"=>strTranslate("Categories"), "ItemClass"=>"active"),
		));
		session::getFlashMessage('actions_message');
		batallasRespuestasController::activeAllAction();
		$elements = batallasRespuestasController::getListTypesAction(20);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">    
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'],"admin-batallas-preguntas-tipos","searchForm",strTranslate("Search"), strTranslate("Search"),"","navbar-form navbar-left");?>
					</div>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th><?php e_strTranslate("Category");?></th>
							<th class="text-center"><?php e_strTranslate("Activate");?></th>
							<th class="text-center"><?php e_strTranslate("Deactivate");?></th>
							<th class="text-center"><?php e_strTranslate("Active");?></th>
							<th class="text-center"><?php e_strTranslate("Inactive");?></th>
						</tr>
						<?php foreach($elements['items'] as $element): 
							$num_questions_active = connection::countReg("batallas_preguntas", " AND pregunta_tipo='".$element['categoria']."' AND activa=1 ");
							$num_questions_inactive = connection::countReg("batallas_preguntas", " AND pregunta_tipo='".$element['categoria']."' AND activa=0 ");?>
						<tr>
							<td><?php echo $element['categoria'];?></td>

							<td class="text-center"><button title="Click para cambiar el estado" class="btn btn-success" onClick="Confirma('¿Seguro que deseas activar de todas las preguntas de la categoría?', 'admin-batallas-preguntas-tipos?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['categoria'].'&a=1';?>'); return false"><?php e_strTranslate("Activate");?></button></td>
							
							<td class="text-center"><button title="Click para cambiar el estado" class="btn btn-danger" onClick="Confirma('¿Seguro que deseas desactivar de todas las preguntas de la categoría?', 'admin-batallas-preguntas-tipos?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['categoria'].'&a=0';?>'); return false"><?php e_strTranslate("Deactivate");?></button></td>

							<td class="text-center"><?php echo $num_questions_active;?></td>
							<td class="text-center"><?php echo $num_questions_inactive;?></td>
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