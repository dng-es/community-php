<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/incidencias/pages' : 'modules\\incidencias\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "modules/class.headers.php");

addJavascripts(array("js/bootstrap3-typeahead.min.js",
					getAsset("incidencias")."js/categorias.js",
					getAsset("incidencias")."js/admin-incidence.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incidences"), "ItemUrl"=>"admin-incidences"),
			array("ItemLabel"=>strTranslate("Incidences_list"), "ItemUrl"=>"admin-incidences"),
			array("ItemLabel"=>strTranslate("Incidence"), "ItemClass"=>"active"),
		));

		session::getFlashMessage('actions_message');
		incidenciasController::updateAdminAction();
		$id = intval(isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
		if ($id > 0){
			$filter = " AND id_incidencia=".$id." ";
			$elements = incidenciasController::getListAction(35, $filter);

			$date_incidencia = $elements['items'][0]['date_incidencia'];
			$texto_incidencia = $elements['items'][0]['texto_incidencia'];
			$solucion_incidencia = $elements['items'][0]['solucion_incidencia'];
			$username_incidencia = $elements['items'][0]['username_incidencia'];
			$estado_incidencia = $elements['items'][0]['estado_incidencia'];
			$categoria_incidencia = $elements['items'][0]['categoria_incidencia'];

			$estados = incidenciasController::getListEstadosAction(9999, " AND id_incidencia=".$id." ");
		}

		?>
		<div class="panel panel-info">
			<div class="panel-heading">
				<?php e_strTranslate("Incidence");?> <?php echo ($id > 0 ? sprintf("%04d", $id) : "");?>
			</div>
			<div class="panel-body">
				<form name="formData" id ="formData" role="form" action="" method="post">
					<input type="hidden" name="id" value="<?php echo $id;?>">
					<div class="row" style="overflow:visible">
						<div class="form-group col-md-3 <?php echo ($id == 0 ? 'hidden' : '');?>">
							<label for="date_incidencia">Fecha apertura</label>
							<input class="form-control" disabled name="date_incidencia" id="date_incidencia" type="text" value="<?php echo getDateFormat($date_incidencia, 'DATE_TIME');?>">
						</div>

						<div class="form-group col-md-3 <?php echo ($id == 0 ? 'hidden' : '');?>">
							<label for="username_incidencia"><?php e_strTranslate("User");?></label>
							<input class="form-control" disabled name="username_incidencia" id="username_incidencia" type="text" value="<?php echo $username_incidencia;?> - <?php echo $elements['items'][0]['name'];?> <?php echo $elements['items'][0]['surname'];?>">
						</div>
						<div class="form-group col-md-3 <?php echo ($id == 0 ? 'hidden' : '');?>">
							<label for="categoria_incidencia"><?php e_strTranslate("Type");?></label>
							<input autocomplete="off" data-provide="typeahead" class="form-control" name="categoria_incidencia" id="categoria_incidencia" type="text" value="<?php echo $categoria_incidencia;?>">
						</div>

						<div class="form-group col-md-3 <?php echo ($id == 0 ? 'hidden' : '');?>">
							<label for="estado_incidencia">Estado</label>
							<br />

							<span class="label<?php echo ($estados['items'][0]['estado_cambio'] == 0 ? " label-info" : ($estados['items'][0]['estado_cambio'] == 1 ? " label-success" : " label-danger"));?>"><?php echo ($estados['items'][0]['estado_cambio'] == 0 ? 'Pendiente' : ($estados['items'][0]['estado_cambio'] == 1 ? "Finalizada" : "Cancelada"));?></span> <small class="text-muted"><?php echo getDateFormat($estados['items'][0]['date_estado_cambio'], 'DATE_TIME');?> - <?php echo $estados['items'][0]['username_estado_cambio'];?></small>
							<br />
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-6">
							<label for="texto_incidencia"><?php e_strTranslate("Description");?></label>
							<textarea rows="10" class="form-control" name="texto_incidencia" id="texto_incidencia" disabled="disabled" data-alert="<?php e_strTranslate("Required_field");?>"><?php echo $texto_incidencia;?></textarea>
							<br />
							<div class="row">
								<div class="col-md-4 col-sm-4 col-xs-4 nopadding">
									<button class="btn btn-success btn-block <?php echo $estado_incidencia == 1 ? 'disabled' : '';?>" id="finalizarBtn"><small>Finalizar <?php e_strTranslate("Incidence");?></small></button>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4 nopadding">
									<button class="btn btn-danger btn-block <?php echo $estado_incidencia == 2 ? 'disabled' : '';?>" id="cancelarBtn"><small>Cancelar <?php e_strTranslate("Incidence");?></small></button>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4 nopadding">
									<button class="btn btn-info btn-block <?php echo $estado_incidencia == 0 ? 'disabled' : '';?>" id="pendienteBtn"><small>Pendiente <?php e_strTranslate("Incidence");?></small></button>
								</div>
							</div>		
						</div>
						<div class="form-group col-md-6">
							<label for="solucion_incidencia">Solución</label>
							<textarea rows="10" class="form-control" name="solucion_incidencia" id="solucion_incidencia" data-alert="<?php e_strTranslate("Required_field");?>"><?php echo $solucion_incidencia;?></textarea>
							<br />
							<div class="row">
								<div class="col-md-4 col-sm-4 col-xs-4 nopadding">
									<button type="submit" class="btn btn-primary btn-block"><small>Modificar solución</small></button>
								</div>
								<div class="col-md-8 col-sm-8 col-xs-8">
									<div class="checkbox checkbox-primary">
										<input type="checkbox" class="styled" id="enviar_email" name="enviar_email" checked>
										<label for="enviar_email">Enviar emails de notificación</label>
									</div>
								</div>

							</div>
						</div>
					</div>
				</form>
				<div class="form-group col-md-12 <?php echo ($id == 0 ? 'hidden' : '');?>">
					<h3>Histórico de Estados</h3>
					<?php foreach ($estados['items'] as $key=>$estado):?>
					<span class="label<?php echo ($estado['estado_cambio'] == 0 ? " label-info" : ($estado['estado_cambio'] == 1 ? " label-success" : " label-danger"));?>"><?php echo ($estado['estado_cambio'] == 0 ? 'Pendiente' : ($estado['estado_cambio'] == 1 ? "Finalizada" : "Cancelada"));?></span> <small class="text-muted"><?php echo getDateFormat($estado['date_estado_cambio'], 'DATE_TIME');?> - <?php echo $estado['username_estado_cambio'];?></small>
					<br />
				<?php endforeach;?>
				</div>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>