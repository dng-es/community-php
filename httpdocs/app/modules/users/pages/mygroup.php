<?php
$perfiles_autorizados = array("admin", "responsable");
session::AccessLevel($perfiles_autorizados);

//EXPORT USERS
usersController::exportEquipoListAction();

addCss(array("css/bootstrap-datetimepicker.min.css"));

addJavascripts(array("js/bootstrap.file-input.js", 
					"js/bootstrap-datepicker.js", 
					"js/bootstrap-datepicker.es.js", 
					"js/jquery.numeric.js", 
					"js/bootstrap-textarea.min.js",
					getAsset("users")."js/mygroup.js", 
					getAsset("users")."js/group.js", 
					getAsset("alerts")."js/addalert.js"));


templateload("addalert", "alerts");
templateload("group", "users");

$id_group = (isset($_REQUEST['id']) ? sanitizeInput($_REQUEST['id']) : "");

?>
<div class="row row-top">
	<div class="app-main">
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
		alertsController::createAction();

		$filtro_id_group = ($id_group != "" ? " AND empresa='".$id_group."' " : "");
		$filtro_tienda = usersController::getTiendaFilter("cod_tienda");
		$elements = usersController::getListEquipoAction(20, " AND disabled=0 AND perfil='usuario' ".$filtro_tienda.$filtro_id_group);

		$users = new users();
		$centros = $users->getTiendas($filtro_tienda." AND activa=1 ORDER BY cod_tienda");
	?>
			<div class="col-md-12">
				<ul class="nav nav-pills navbar-default">       
					<li class="disabled"><a href="#">Total usuarios <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="#" id="new-user-trigger"><?php echo strTranslate("New_user");?></a></li>
					<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php echo strTranslate("Export");?></a></li>
				</ul>

				<div id ="new-user-container" class="div-drop">
					<form id="add-form" name="add-form" action="" method="post" role="form" class="form-horizontal">
						<div class="row">
							<div class="col-md-12">
								<div class="row">
							  		<div class="col-md-3">
										<label class="control-label" for="id_username"><small><?php echo strTranslate("Username");?></small></label>
										<input type="text" name="id_username" id="id_username" class="form-control" value="" data-alert="<?php echo strTranslate("Required_field");?>" />
									</div>
									<div class="col-md-9">
										<label class="control-label" for="empresa_user"><small><?php echo strTranslate("Group_user");?>:</small></label>
										<select id="empresa_user" name="empresa_user" class="form-control" data-alert="<?php echo strTranslate("Required_field");?>">
											<option value="">--<?php echo strTranslate("Choose_group");?>--</option>
										  	<?php foreach($centros as $centro): ?>
										  			<option value="<?php echo $centro['cod_tienda'];?>"><?php echo $centro['cod_tienda'];?> - <?php echo $centro['nombre_tienda'];?></option>	
										  	<?php endforeach; ?>
										</select>
									</div>

								</div>

						  		<div class="row">
									<div class="col-md-3">
										<label class=" control-label" for="user-nombre"><small><?php echo strTranslate("Name");?></small></label>
										<input maxlength="100" name="user-nombre" id="user-nombre" type="text" class="form-control" value="" data-alert="<?php echo strTranslate("Required_field");?>" />
									</div>
									<div class="col-md-3">							
										<label class="control-label" for="user-apellidos"><small><?php echo strTranslate("Surname");?></small></label>
										<input maxlength="100" name="user-apellidos" id="user-apellidos" type="text" class="form-control" value="" data-alert="<?php echo strTranslate("Required_field");?>" />
									</div>
									<div class="col-md-3">
										<label class="control-label" for="user-email"><small>Email</small></label>
										<input maxlength="100" name="user-email" id="user-email" type="text" class="form-control" value="" data-alert="<?php echo strTranslate("Required_email");?>" />
									</div>
									<div class="col-md-3">
										<label class=" control-label" for="telefono"><small><?php echo strTranslate("Telephone");?></small></label>
										<input maxlength="100" name="telefono" id="telefono" type="text" class="form-control numeric" value="" data-alert="<?php echo strTranslate("Required_field");?>" />
									</div>
								</div>	
								<div class="row">
									<div class="col-md-3 inset">
										<input type="submit" class="btn btn-primary btn-block" id="confirm-submit" name="confirm-submit" value="<?php echo strTranslate("Save_data");?>" />
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
						<th colspan="2">Usuario</th>
						<th width="60px"></th>
						</tr>	
						<?php foreach($elements['items'] as $element):?>
							<form action="<?php echo $_SERVER['REQUEST_URI'].$link_busqueda;?>" class="form-user-edit" role="form" method="post">
							<tr>
							<td nowrap="nowrap">								
								<button type="button" class="btn btn-default btn-xs" title="Eliminar" onClick="Confirma('¿Seguro que deseas dar de baja al usuario <?php echo $element['username'];?>?', 'mygroup?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['username'];?>'); return false;"><i class="fa fa-trash icon-table"></i>
								</button>
							</td>					
							<td width="60%">
								<em class="text-primary"><?php echo $element['username'];?></em> <?php echo $element['name'];?> <?php echo $element['surname'];?> 
								<em class="text-warning"><small><?php echo $element['email'];?></small></em><br />
								<em class="text-muted"><?php echo $element['cod_tienda'];?> <small><?php echo $element['nombre_tienda'];?></small></em>
								<?php if($element['telefono'] != ""):?>
								<br /><small><?php e_strTranslate('Telephone');?> <?php echo $element['telefono'];?></small>
								<?php endif;?>
							</td>
							<td>
								<input type="hidden" name="id_user_edit" id ="id_user_edit" value="<?php echo $element['username'];?>" />
								<select id="user_edit_empresa" name="user_edit_empresa" class="form-control input-xs <?php echo ($element['activa'] == 0 ? 'input-alert': '');?>" data-alert="<?php echo strTranslate("Required_field");?>">
									<option value="">--<?php echo strTranslate("Choose_group");?>--</option>
								  	<?php foreach($centros as $centro): ?>
								  			<option value="<?php echo $centro['cod_tienda'];?>" <?php echo ($centro['cod_tienda'] == $element['empresa'] ? ' selected="selected" ' : '');?>><?php echo $centro['cod_tienda'];?> - <?php echo $centro['nombre_tienda'];?></option>	
								  	<?php endforeach; ?>
								</select>
							</td>
							<td>
								<input type="submit" class="btn btn-primary btn-xs" value="modificar" />
							</td>
							</form>
							</tr>  
						<?php endforeach; ?>
					</table>
				</div>
				<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
			</div>
		</div>
		<div class="app-sidebar">
			<div class="panel-interior">
				<br />
				<?php panelGroup($centros, $id_group);?>
				<?php echo SearchForm($elements['reg'],"mygroup","searchForm", "Buscar usuario", strTranslate("Search"), "", "", "get");?>
				<?php if(getModuleExist("alerts")): ?>
				<br />
				<h4>
					<span class="fa-stack fa-sx">
						<i class="fa fa-circle fa-stack-2x"></i>
						<i class="fa fa-share-alt fa-stack-1x fa-inverse"></i>
					</span>
					Nueva alerta
				</h4>
				<?php addAlert();?>
			<?php endif; ?>
			</div>
		</div>
</div>