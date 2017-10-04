<?php
addJavascripts(array(
	"js/jquery.geturlparam.js",
	"js/bootstrap.file-input.js",
	"js/bootstrap-datepicker.js",
	"js/bootstrap-datepicker.es.js",
	"js/bootstrap-timepicker.min.js",
	"js/jquery.numeric.js",
	"js/bootstrap-textarea.min.js",
	"js/libs/fullcalendar-2.8.0/lib/moment.min.js",
	"js/libs/fullcalendar-2.8.0/fullcalendar.min.js",
	"js/libs/fullcalendar-2.8.0/lang/es.js",
	getAsset("alerts")."js/addalert.js",
	getAsset("alerts")."js/alerts-calendar.js"
));

addCss(array(
	"css/bootstrap-datetimepicker.min.css",
	"css/bootstrap-timepicker.min.css",
	"js/libs/fullcalendar-2.8.0/fullcalendar.min.css"
));

templateload("search", "core");
templateload("addalert", "alerts");?>
<div class="row row-top">
	<div class="col-md-10 col-md-offset-1">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("MOD_Alerts"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Calendar"), "ItemClass"=>"active"),
		));
		session::getFlashMessage('actions_message');
		alertsController::createUserAction();
		alertsController::deleteAction('alerts-calendar');

		$types = alertsTypesController::getListAction(9999, " AND estado_type=1 ");

		$search_text = (isset($_REQUEST['search']) && $_REQUEST['search'] != '') ? sanitizeInput($_REQUEST['search']) : '';
		?>
		<div class="row">
			<div class="col-md-4 nopadding">
				<?php 
				mainSearch("search-results", $search_text, 'alerts');
				?>
				<br />
			</div>
			<div class="col-md-8">
				<p><?php e_strTranslate("MOD_Alerts_info");?></p>
			</div>
		</div>
		<div id='cargandoCalendar' class="text-center"><big><i class="fa fa-spinner fa-spin"></i></big></div>
		<div id='calendar'></div>
		<br />
		<div class="panel panel-default">
			<div class="panel-body">
				<?php foreach($types['items'] as $type):?>
				<div class="col-md-2 col-sm-4 col-xs-6">
					<div style="display: block;padding-right: 15px;margin-bottom: 5px">
						<span class="label" style="background-color: <?php echo $type['color_type'];?>">&nbsp;</span>
						<small class="text-muted"><?php echo $type['name_type'];?></small>
					</div>
				</div>
				<?php endforeach;?>
			</div>
		</div>	

		<div class="panel panel-default">
			<div class="panel-heading"><?php e_strTranslate("MOD_Alert_new");?></div>	
			<div class="panel-body">
				<?php addAlert();?>
			</div>
		</div>
	</div>
	
</div>


<!-- Modal Calendario-->
	<div class="modal modal-wide fade" id="modal-calendar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="calendar_titulo"></h4>
				</div>
				<div class="modal-body" style="min-height: 200px">
					<div id="calendar_icon" style="position: absolute;font-size: 120px; top:0; right: 30px; color: #333; z-index:10"></div>
					<div id="calendar_text" style="z-index:11; position: relative"></div>
					<br />
					<div id="nombre_archivo" class=""></div>
					<div id="calendar_tipo" class=""></div>
					<div id="calendar_inicio" class=""></div>
					<div id="calendar_fin" class=""></div>
					<div id="calendar_tienda" class="" style="z-index:11; position: relative"></div>
				</div>


				<div class="modal-footer" id="calendar-footer">
					<input type="hidden" id="user_empresa" value="<?php echo utf8_encode($_SESSION['user_empresa']);?>" />
					<input type="hidden" id="user_perfil" value="<?php echo (($_SESSION['user_perfil'] == 'admin' || in_array($_SESSION['user_name'], $users_calendario)) ? 'admin' : $_SESSION['user_perfil'] );?>" />
					<?php if (1==1):?>
						<button type="button" class="btn btn-info" id="join_evento" data-evento="">Me inscribo!!</button>
					<?php endif;?>
					<?php if ($_SESSION['user_perfil'] == 'admin' || in_array($_SESSION['user_name'], $users_calendario) || $_SESSION['user_perfil'] == 'director' || $_SESSION['manager'] == 1 || $_SESSION['visual'] == 1 || $_SESSION['colider'] == 1):?>
						<button type="button" class="btn btn-danger" id="delete_evento" data-evento="">Eliminar evento</button>
					<?php endif;?>
				</div>


			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

