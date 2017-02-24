<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/incidencias/pages' : 'modules\\incidencias\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "modules/class.headers.php");

addJavascripts(array("js/bootstrap-textarea.js", getAsset("incidencias")."js/incidence.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("My_incidences"), "ItemUrl"=>"myincidences"),
			array("ItemLabel"=>strTranslate("New_incidence"), "ItemClass"=>"active"),
		));

		session::getFlashMessage('actions_message');
		incidenciasController::createAction();
		incidenciasController::updateAction();
		$id = intval(isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
		if ($id > 0){
			$filter = " AND username_incidencia='".$_SESSION['user_name']."' AND id_incidencia=".$id." ";
			$elements = incidenciasController::getListAction(35, $filter);

			$date_incidencia = $elements['items'][0]['date_incidencia'];
			$texto_incidencia = $elements['items'][0]['texto_incidencia'];
			$solucion_incidencia = $elements['items'][0]['solucion_incidencia'];
			$estado_incidencia = intval($elements['items'][0]['estado_incidencia']);
			$estados = incidenciasController::getListEstadosAction(9999, " AND id_incidencia=".$elements['items'][0]['id_incidencia']." ");
		}
		else{
			$date_incidencia = '';
			$texto_incidencia = '';
			$estado_incidencia = '';
			$estados['items'] = array();
		}
		?>
		<div class="panel panel-info">
			<div class="panel-heading">
				<?php e_strTranslate("Incidence");?> <?php echo ($id > 0 ? sprintf("%04d", $id) : "");?>
			</div>
			<div class="panel-body">
				<form name="formData" id ="formData" role="form" action="" method="post">
					<input type="hidden" name="id" value="<?php echo $id;?>">
					
					<div class="row">
						<div class="form-group col-md-4 <?php echo ($id == 0 ? 'hidden' : '');?>">
							<label for="date_incidencia">Fecha apertura</label>
							<input class="form-control" disabled name="date_incidencia" id="date_incidencia" type="text" value="<?php echo getDateFormat($date_incidencia, 'DATE_TIME');?>">
						</div>

						<div class="form-group col-md-8 <?php echo ($id == 0 ? 'hidden' : '');?>">
							<label for="estado_incidencia">Estado</label>
							<br />

							<span class="label<?php echo ($estados['items'][0]['estado_cambio'] == 0 ? " label-info" : ($estados['items'][0]['estado_cambio'] == 1 ? " label-success" : " label-danger"));?>"><?php echo ($estados['items'][0]['estado_cambio'] == 0 ? 'Pendiente' : ($estados['items'][0]['estado_cambio'] == 1 ? "Finalizada" : "Cancelada"));?></span> <small class="text-muted"><?php echo getDateFormat($estados['items'][0]['date_estado_cambio'], 'DATE_TIME');?></small>
							<br />

						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-6">
							<label for="texto_incidencia"><?php e_strTranslate("Description");?></label>
							<textarea rows="10" class="form-control" name="texto_incidencia" id="texto_incidencia" data-alert="<?php e_strTranslate("Required_field");?>"><?php echo $texto_incidencia;?></textarea>
						</div>

						<div class="form-group col-md-6">
							<label for="solucion_incidencia">Solución</label>
							<textarea rows="10" class="form-control" disabled="disabled" name="solucion_incidencia" id="solucion_incidencia" data-alert="<?php e_strTranslate("Required_field");?>"><?php echo $solucion_incidencia;?></textarea>
						</div>
					</div>

					<div class="form-group col-md-12">
					<?php if($estado_incidencia === 0 || $estado_incidencia === ''):?>
							<input type="submit" class="btn btn-primary" name="submitBtn" id="submitBtn" value="<?php e_strTranslate("Save_data");?> <?php e_strTranslate("Incidence");?>" />


					<?php if($estado_incidencia === 0):?>
							<button type="button" class="btn btn-danger" id="cancelarBtn">Cancelar <?php e_strTranslate("Incidence");?></button>
					<?php endif;?>

					<?php else:?>
							<button type="button" class="btn btn-info" id="reopenBtn">Reabrir <?php e_strTranslate("Incidence");?></button>
					<?php endif;?>
					</div>
				</form>
				<div class="form-group col-md-12 <?php echo ($id == 0 ? 'hidden' : '');?>">
					<h3>Histórico de estados</h3>
					<?php foreach ($estados['items'] as $key=>$estado):?>
					<span class="label<?php echo ($estado['estado_cambio'] == 0 ? " label-info" : ($estado['estado_cambio'] == 1 ? " label-success" : " label-danger"));?>"><?php echo ($estado['estado_cambio'] == 0 ? 'Pendiente' : ($estado['estado_cambio'] == 1 ? "Finalizada" : "Cancelada"));?></span> <small class="text-muted"><?php echo getDateFormat($estado['date_estado_cambio'], 'DATE_TIME');?></small>
						<br />
				<?php endforeach;?>
				</div>
			</div>
		</div>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior hidden-xs">
			<h3><?php e_strTranslate("My_incidences");?></h3>
			<p class="text-center"><i class="fa fa-life-ring fa-big"></i></p>
		</div>
	</div>
</div>