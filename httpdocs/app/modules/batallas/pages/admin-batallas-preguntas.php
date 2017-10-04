<?php
set_time_limit(0);
ini_set('memory_limit', '-1');

//EXPORT DATA
batallasRespuestasController::exportListAction();

addJavascripts(array(
	"js/bootstrap.file-input.js",
	"js/bootstrap-datepicker.js",
	"js/bootstrap-datepicker.es.js",
	getAsset("batallas")."js/admin-batallas-preguntas.js"
));




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
				<div class="row">
					<div class="form-group col-md-3">
						<div id="datetimepicker1" class="input-group date">
							<input value="" data-format="dd/MM/yyyy"  type="text" id="date_ini" class="form-control" placeholder="<?php e_strTranslate("Date_start");?>" name="date_ini" data-alert="<?php e_strTranslate("Required_date");?>"></input>
							<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
					</div>
					<div class="form-group col-md-3">
						<div id="datetimepicker2" class="input-group date">
							<input value="" data-format="dd/MM/yyyy"  type="text" id="date_fin" class="form-control" placeholder="<?php e_strTranslate("Date_end");?>" name="date_fin" data-alert="<?php e_strTranslate("Required_date");?>"></input>
							<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
					</div>
				</div>


				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a id="resumen" ><?php e_strTranslate("Export");?></a></li>
					<li><a id="detallado" >Detallado</a></li>
					<li><a href="admin-cargas-batallas"><?php e_strTranslate("Import_questions");?></a></li>
					<li><a href="admin-batallas-preguntas-tipos"><?php e_strTranslate("Categories");?></a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'],"admin-batallas-preguntas","searchForm",strTranslate("Search"), strTranslate("Search"),"","navbar-form navbar-left");?>
					</div>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="40px"></th>
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
							<td><button type="button" id="concreto" class="btn btn-default btn-xs"  onclick="location.href='?page=admin-batallas-preguntas&export=true&id=<?php echo $element['id_pregunta'];?>'" ><i class="fa fa-download" aria-hidden="true"></i></button></td>
							<td><?php echo $element['pregunta'];?></td>
							<td class="text-center"><button type="button" class="btn btn-default popover-trigger" data-toggle="popover" title="<?php e_strTranslate("Battle_answer");?> 1" data-content="<?php echo $element['respuesta1'];?>">1</button></td>
							<td class="text-center"><button type="button" class="btn btn-default popover-trigger" data-toggle="popover" title="<?php e_strTranslate("Battle_answer");?> 2" data-content="<?php echo $element['respuesta2'];?>">2</button></td>
							<td class="text-center"><button type="button" class="btn btn-default popover-trigger" data-toggle="popover" title="<?php e_strTranslate("Battle_answer");?> 3" data-content="<?php echo $element['respuesta3'];?>">3</button></td>

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