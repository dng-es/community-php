<?php
//EXPORT DATA
batallasRespuestasController::exportListAction();

addJavascripts(array(getAsset("batallas")."js/admin-batallas-preguntas.js"));
?>
<div class="row row-top">
	<div class="app-main section-admin">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Battles"), "ItemUrl"=>"admin-batallas"),
			array("ItemLabel"=>strTranslate("Battles_questions_list"), "ItemClass"=>"active"),
		));
		session::getFlashMessage('actions_message');
		batallasRespuestasController::activeAction();
		$elements = batallasRespuestasController::getListAction(20);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">    
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php e_strTranslate("Export");?></a></li>
					<li><a href="admin-cargas-batallas"><?php e_strTranslate("Import_questions");?></a></li>
					<li><a href="admin-batallas-preguntas-tipos"><?php e_strTranslate("Categories");?></a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'],"admin-batallas-preguntas","searchForm",strTranslate("Search"), strTranslate("Search"),"","navbar-form navbar-left");?>
					</div>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th><?php e_strTranslate("Battle_question");?></th>
							<th class="text-center"><?php e_strTranslate("Battle_answer");?></th>
							<th class="text-center"><?php e_strTranslate("Battle_answer");?></th>
							<th class="text-center"><?php e_strTranslate("Battle_answer");?></th>
							<th class="text-center"><?php e_strTranslate("Active");?></th>
							<th><?php e_strTranslate("Channel");?></th>
							<th><?php e_strTranslate("Type");?></th>
						</tr>
						<?php foreach($elements['items'] as $element): ?>
						<tr>
							<td><?php echo $element['pregunta'];?></td>
							<td class="text-center"><button type="button" class="btn btn-default popover-dismiss" data-toggle="popover" title="<?php e_strTranslate("Battle_answer");?> 1" data-content="<?php echo $element['respuesta1'];?>">1</button></td>
							<td class="text-center"><button type="button" class="btn btn-default popover-dismiss" data-toggle="popover" title="<?php e_strTranslate("Battle_answer");?> 2" data-content="<?php echo $element['respuesta2'];?>">2</button></td>
							<td class="text-center"><button type="button" class="btn btn-default popover-dismiss" data-toggle="popover" title="<?php e_strTranslate("Battle_answer");?> 3" data-content="<?php echo $element['respuesta3'];?>">3</button></td>
							
							<td class="text-center"><span title="Click para cambiar el estado" class="pointer label<?php echo ($element['activa'] == 0 ? " label-danger" : " label-success");?>" onClick="Confirma('¿Seguro que deseas cambiar el estado?', 'admin-batallas-preguntas?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['id_pregunta'].'&a='.$element['activa'];?>'); return false"><?php echo ($element['activa'] == 1 ? strTranslate("App_Yes") : strTranslate("App_No"));?></span></td>
							<td><?php echo $element['canal_pregunta'];?></td>
							<td><?php echo $element['pregunta_tipo'];?></td>
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