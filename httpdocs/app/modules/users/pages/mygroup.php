<?php
$perfiles_autorizados = array("admin", "responsable", "regional");
session::AccessLevel($perfiles_autorizados);

//EXPORT USERS
usersController::exportEquipoListAction();
alertsController::exportRegistroAction();


templateload("paginator", "alerts");
templateload("group", "users");
templateload("graph", "emociones");

addCss(array(
	"css/bootstrap-datetimepicker.min.css",
	"css/bootstrap-timepicker.min.css",
	getAsset("emociones")."css/styles.css"
));

addJavascripts(array(
	"js/bootstrap.file-input.js", 
	"js/bootstrap-datepicker.js", 
	"js/bootstrap-datepicker.es.js", 
	"js/bootstrap-timepicker.min.js", 
	"js/jquery.numeric.js", 
	"js/bootstrap-textarea.min.js",
	getAsset("users")."js/mygroup.js", 
	getAsset("users")."js/group.js", 
	getAsset("emociones")."js/emociones-graph.js"
));


$id_group = (isset($_REQUEST['id']) ? sanitizeInput($_REQUEST['id']) : "");
?>
<div class="row row-top">
	<div class="app-main" style="width: 100%">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("My_team"), "ItemClass"=>"active"),
		));

		$link_busqueda = "";
		if (isset($_POST['find_reg'])) $link_busqueda = "&f=".$_POST['find_reg'];
		if (isset($_REQUEST['f'])) $link_busqueda = "&f=".$_REQUEST['f']; 

		session::getFlashMessage( 'actions_message' ); 
		usersController::deleteEquipoAction();
		usersController::insertEquipoAction();
		usersController::updateEquipoAction();
		alertsController::deleteAction("mygroup");

		$filtro_id_group = ($id_group != "" ? " AND empresa='".$id_group."' " : "");
		$filtro_tienda = usersController::getTiendaFilter("cod_tienda");
		$elements = usersController::getListEquipoAction(5, " AND disabled=0 ".$filtro_tienda.$filtro_id_group);

		$users = new users();
		$centros = $users->getTiendas($filtro_tienda." AND activa=1 ORDER BY cod_tienda");
		?>
		
		<div class="row">
			<div class="col-md-12">
				<div class="row panel-header-form">
					<div class="col-md-4">
						<?php panelGroup($centros, $id_group);?>
					</div>
					<div class="col-md-4">
						<label>Buscar usuario</label>
						<?php echo SearchForm($elements['reg'],"mygroup","searchForm", "Buscar usuario", strTranslate("Search"), "", "", "get");?>
					</div>
					<div class="col-md-4">
						<?php $filtro_emocion = searchGraph($_SERVER['REQUEST_URI']);?>
					</div>
				</div>
			</div>
		</div>
		<br />
		
		<div class="row">
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading"><?php e_strTranslate("Users");?></div>
					<div class="panel-body">
						<ul class="nav nav-pills navbar-default">       
							<li class="disabled"><a href="#"><?php e_strTranslate("Total");?>: <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Users"));?></a></li>
							<li><a href="#" id="new-user-trigger"><?php e_strTranslate("New_user");?></a></li>
							<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php e_strTranslate("Export");?></a></li>


						</ul>
						<div id ="new-user-container" class="div-drop">
							<form id="add-form" name="add-form" action="" method="post" role="form" class="form-horizontal">
								<div class="row">
									<div class="col-md-12">
										<div class="row">
											<div class="col-md-3">
												<label class="control-label" for="id_username"><small><?php e_strTranslate("Username");?></small></label>
												<input type="text" name="id_username" id="id_username" class="form-control" value="" data-alert="<?php e_strTranslate("Required_field");?>" />
											</div>
											<div class="col-md-9">
												<label class="control-label" for="empresa_user"><small><?php e_strTranslate("Group_user");?>:</small></label>
												<select id="empresa_user" name="empresa_user" class="form-control" data-alert="<?php e_strTranslate("Required_field");?>">
													<option value="">--<?php e_strTranslate("Choose_group");?>--</option>
													<?php foreach($centros as $centro): ?>
														<option value="<?php echo $centro['cod_tienda'];?>"><?php echo $centro['cod_tienda'];?> - <?php echo $centro['nombre_tienda'];?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3">
												<label class=" control-label" for="user-nombre"><small><?php e_strTranslate("Name");?></small></label>
												<input maxlength="100" name="user-nombre" id="user-nombre" type="text" class="form-control" value="" data-alert="<?php e_strTranslate("Required_field");?>" />
											</div>
											<div class="col-md-3">
												<label class="control-label" for="user-apellidos"><small><?php e_strTranslate("Surname");?></small></label>
												<input maxlength="100" name="user-apellidos" id="user-apellidos" type="text" class="form-control" value="" data-alert="<?php e_strTranslate("Required_field");?>" />
											</div>
											<div class="col-md-3">
												<label class="control-label" for="user-email"><small>Email</small></label>
												<input maxlength="100" name="user-email" id="user-email" type="text" class="form-control" value="" data-alert="<?php e_strTranslate("Required_email");?>" />
											</div>
											<div class="col-md-3">
												<label class=" control-label" for="telefono"><small><?php e_strTranslate("Telephone");?></small></label>
												<input maxlength="100" name="telefono" id="telefono" type="text" class="form-control numeric" value="" data-alert="<?php e_strTranslate("Required_field");?>" />
											</div>
										</div>
										<div class="row">
											<div class="col-md-3 inset">
												<input type="submit" class="btn btn-primary btn-block" id="confirm-submit" name="confirm-submit" value="<?php e_strTranslate("Save_data");?>" />
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<tr>
								<th width="40px"></th>
								<th colspan="2"><?php e_strTranslate("User");?></th>
								<th width="60px"></th>
								</tr>	
								<?php foreach($elements['items'] as $element):?>
									<form action="<?php echo $_SERVER['REQUEST_URI'].$link_busqueda;?>" class="form-user-edit" role="form" method="post">
									<tr>
									<td nowrap="nowrap">
										<button type="button" class="btn btn-default btn-xs" title="Eliminar" onClick="Confirma('¿Seguro que deseas dar de baja al usuario <?php echo $element['username'];?>?', 'mygroup?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['username'];?>'); return false;"><i class="fa fa-trash icon-table"></i>
										</button>
									</td>
									<td width="40%">
										<em class="text-primary"><?php echo $element['username'];?></em> <?php echo $element['name'];?> <?php echo $element['surname'];?><br />
										<em class="text-warning"><small><?php echo $element['email'];?></small></em><br />
										<?php if($element['telefono'] != ""):?>
										<small><?php e_strTranslate('Telephone');?> <?php echo $element['telefono'];?></small><br />
										<?php endif;?>
										<em class="text-muted">
											<?php echo $element['perfil'];?> 
											<?php echo $element['cod_tienda'];?> 
											<small><?php echo $element['nombre_tienda'];?></small>
											</em>
									</td>
									<td>
										<input type="hidden" name="id_user_edit" id ="id_user_edit" value="<?php echo $element['username'];?>" />
										<select id="user_edit_empresa" name="user_edit_empresa" class="form-control input-xs <?php echo ($element['activa'] == 0 ? 'input-alert': '');?>" data-alert="<?php e_strTranslate("Required_field");?>">
											<option value="">--<?php e_strTranslate("Choose_group");?>--</option>
											<?php foreach($centros as $centro): ?>
												<option value="<?php echo $centro['cod_tienda'];?>" <?php echo ($centro['cod_tienda'] == $element['empresa'] ? ' selected="selected" ' : '');?>><?php echo $centro['cod_tienda'];?> - <?php echo $centro['nombre_tienda'];?></option>
											<?php endforeach;?>
										</select>
									</td>
									<td>
										<input type="submit" class="btn btn-primary btn-xs" value="modificar" />
									</td>
									</tr>
									</form>
								<?php endforeach;?>
							</table>
						</div>
						<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page']."?pag_a=".$elements_alerts['pag'], '', $elements['find_reg']);?>
					</div>
				</div>
			</div>
			

			<?php if(getModuleExist("alerts")):
				//aplicacion de filtros según la busqueda por tienda
				$filtro_tienda_search_user = "";
				$filtro_tienda_search_tienda = "";

				if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
					$filtro_tienda_search_user = " AND empresa='".sanitizeInput($_REQUEST['id'])."' ";
					$filtro_tienda_search_tienda = " AND cod_tienda='".sanitizeInput($_REQUEST['id'])."' ";
				}

				//aplicacion de filtros según la busqueda por usuario
				if ($elements['find_reg'] != ''){
					$filtro_tienda_search_user = " AND (username LIKE '%".$elements['find_reg']."%' OR name LIKE '%".$elements['find_reg']."%') ";
					$filtro_tienda_search_tienda = " AND cod_tienda IN (SELECT empresa FROM users WHERE username LIKE '%".$elements['find_reg']."%' OR name LIKE '%".$elements['find_reg']."%') ";
				}

				//aplicacion de filtro de fechas
				$filtro_emocion_alerts = "";
				// if ($filtro_emocion != ""){
				// 	$filtro_emocion_alerts = " AND (date_ini BETWEEN ".$filtro_emocion." OR date_fin BETWEEN ".$filtro_emocion.") ";
				// }

				$filtro_alerts = $filtro_emocion_alerts.alertsController::getFiltroAlerts($filtro_tienda_search_user, $filtro_tienda_search_tienda);

				$elements_alerts = alertsController::getListAction(6, " AND activa=1 ".$filtro_alerts, false);
			?>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading"><?php e_strTranslate("MOD_Alerts");?></div>
					<div class="panel-body">
						<ul class="nav nav-pills navbar-default">
							<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements_alerts['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
							<li><a href="user-alert"><?php e_strTranslate("MOD_Alert_new");?></a></li>
						</ul>


						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<tr>
								<th width="40px"></th>
								<th><?php e_strTranslate("MOD_Alert");?></th>
								<th><?php e_strTranslate("Date_start");?></th>
								<th><?php e_strTranslate("Date_end");?></th>
								</tr>	
								<?php foreach($elements_alerts['items'] as $element):?>
									<tr>
									<td nowrap="nowrap">
										<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Delete");?>"
											onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'mygroup?pag=<?php echo $elements_alerts['pag'].'&f='.$elements_alerts['find_reg'].'&act=dela&id='.$element['id_alert'];?>'); return false"><i class="fa fa-trash icon-table"></i>
										</button>

										<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Edit");?>" onClick="location.href='user-alert?ida=<?php echo $element['id_alert'];?>'; return false;"><i class="fa fa-edit icon-table"></i>
										</button>

										<?php if($element['registro'] == 1):?>
										<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Download");?>" onClick="location.href='mygroup?export_r=true&ida=<?php echo $element['id_alert'];?>'; return false;"><i class="fa fa-download icon-table"></i>
										</button>
										<?php endif;?>
									</td>
									<td>
										<?php echo $element['title_alert'];?>
										<p class="text-muted"><small><?php e_strTranslate("Destinatario");?>: <?php echo str_replace(",", ", ", $element['destination_alert']);?></small></p>
									</td>
									<td><?php echo getDateFormat($element['date_ini'], 'SHORT');?> <?php echo $element['time_ini'];?></td>
									<td><?php echo getDateFormat($element['date_fin'], 'SHORT');?> <?php echo $element['time_fin'];?></td>
									</tr>
								<?php endforeach; ?>
							</table>
						</div>
						<?php Paginator($elements_alerts['pag'], $elements_alerts['reg'], $elements_alerts['total_reg'], $_REQUEST['page']."?pag=".$elements['pag'], '', $elements_alerts['find_reg'], 7, "", "pag_a");?>
					</div>
				</div>
			</div>
			<?php endif;?>

			<?php if(getModuleExist("emociones")):
			$filtro_emocion_user = "";
			//aplicacion de filtros según la busqueda por usuario
			if ($elements['find_reg'] != ''){
				$filtro_emocion_user = " AND (username LIKE '%".$elements['find_reg']."%' OR name LIKE '%".$elements['find_reg']."%') ";
			}
			?>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading"><?php e_strTranslate("Emotions");?></div>
					<div class="panel-body">
						<?php showGraph(false, true, $filtro_emocion, $filtro_emocion_user);?>
					</div>
				</div>
			</div>
			<?php endif;?>

		</div>
	</div>
</div>