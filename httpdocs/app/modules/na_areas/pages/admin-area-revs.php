<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/na_areas/pages' : 'modules\\na_areas\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "modules/class.headers.php");
include_once($base_dir . "modules/pages/classes/class.pages.php");
if(file_exists($base_dir . "modules/recompensas/classes/class.recompensas.php")) include_once($base_dir . "modules/recompensas/classes/class.recompensas.php");
include_once($base_dir . "modules/class.footer.php");

//VALIDAR REVISIONES FORMULARIOS
if (isset($_POST['id_tarea_rev']) && $_POST['id_tarea_rev'] != '' ) na_areasController::RevisarFormAction();

//ELIMINACION DE FINALIZACION DE FORMULARIO
if (isset($_REQUEST['act_f']) && $_REQUEST['act_f'] == "del") na_areasController::FinalizacionDeleteAction();

//DESCARGAR FORMULARIO
if (isset($_REQUEST['t']) && $_REQUEST['t'] != "") na_areasController::ExportFormUserAction();

//EXPORT REVS
if (isset($_REQUEST['t3']) && $_REQUEST['t3'] == "1") na_areasController::ExportFormAllAction();

//DESCARGAR FICHERO USUARIO-FICHEROS
if (isset($_REQUEST['t2']) && $_REQUEST['t2'] == "1") na_areasController::ExportFileUserAction();

//VALIDAR REVISIONES FICHEROS
if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'rev_ok' ) na_areasController::validateRevAction();

addJavascripts(array("js/jquery.numeric.js", getAsset("na_areas")."js/admin-area-docs.js"));

//OBTENER DATOS DE LA TAREA
$na_areas = new na_areas();
$id_area = intval($_REQUEST['a']);
$id_tarea = intval($_REQUEST['id']);
$tarea = $na_areas->getTareas(" AND id_tarea=".$id_tarea." ");
$id_recompensa = (isset($tarea[0]['id_recompensa']) ? $tarea[0]['id_recompensa'] : 0);
?>

<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Na_areas"), "ItemUrl"=>"admin-areas"),
			array("ItemLabel"=>"Revisiones ".$tarea[0]['tarea_titulo'], "ItemClass"=>"active"),
		));
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li><a href="admin-area?act=edit&id=<?php echo $id_area;?>">Volver al curso</a></li>
					<li><a href="admin-area-revs?t3=1&a=<?php echo $id_area;?>&id=<?php echo $id_tarea;?>"><?php e_strTranslate("Export");?></a></li>
				</ul>

				<?php
				if (count($tarea)==1){
					$id_grupo = 0; 
					if(isset($_POST['grupo_search']) && $_POST['grupo_search'] != "") $id_grupo = intval($_POST['grupo_search']);
					if(isset($_POST['id_grupo_rev']) && $_POST['id_grupo_rev'] != "") $id_grupo = intval($_POST['id_grupo_rev']);
					if(isset($_REQUEST['idg']) && $_REQUEST['idg'] != "") $id_grupo = intval($_REQUEST['idg']);

					//grupos de la tarea
					$grupos_tarea = $na_areas->getGruposTareas(" AND id_area=".$id_area." AND id_tarea=".$id_tarea." ");
					if (count($grupos_tarea) > 0){
						echo '<form action="admin-area-revs?a='.$id_area.'&id='.$id_tarea.'" method="post" id="frm_search" name="frm_search">
								<select name="grupo_search" id="grupo_search" class="cuadroTexto cuadroTextoSelect" style="width:300px !important">
									<option value="0">-----todos los grupos de la tarea-----</option>';
						foreach($grupos_tarea as $grupo_tarea):
							$selected = "";
							if ($id_grupo == $grupo_tarea['id_grupo']) $selected = ' selected="selected" ';
							echo '<option value="'.$grupo_tarea['id_grupo'].'" '.$selected.'>'.$grupo_tarea['grupo_nombre'].'</option>';
						endforeach;
						echo '  </select>
								<div id="btn_search" style="margin:-4px 0 0 5px">filtrar grupo</div>
							</form>';
					}
					if ($tarea[0]['tipo'] == 'formulario') revisionesFormulario($id_tarea, $id_area, $id_grupo, $id_recompensa);
					else revisionesFicheros($id_tarea, $id_area, $id_grupo, $id_recompensa);
				}
				else ErrorMsg("Error al cargar la tarea");
				?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>


<?php
function revisionesFicheros($id_tarea, $id_area, $id_grupo, $id_recompensa){
	$na_areas = new na_areas();
	$users = new users();
	$filtro = " AND id_tarea=".$id_tarea." ";
	if ($id_grupo != 0) $filtro .= " AND user_tarea IN (SELECT grupo_username FROM na_areas_grupos_users WHERE id_grupo=".$id_grupo.") ";
	$filtro .= " ORDER BY fecha_tarea DESC ";
	$revisiones = $na_areas->getTareasUser($filtro);
	

	if (count($revisiones) == 0)
		echo '<div class="alert alert-info">Los usuarios todavia no han enviado archivos para esta tarea.</div>';
	else{
	echo '<br /><p>Pincha <a href="admin-area-revs?t2=1&a='.$id_area.'&idg='.$id_grupo.'&id='.$id_tarea.'">aquí</a> para descargar el fichero con todos los usuarios que han subidos el fichero de la tarea.</p>';
		echo '<div class="table-responsive">
				<table class="table">
				<tbody>';
				foreach($revisiones as $revision):
					$usuario_rev=$users->getUsers(" AND username='".$revision['user_tarea']."' ");
					if ($revision['revision'] == 1){
						$imagen_revision='<i class="fa fa-check icon-ok"></i>';
						$destino_validar_revision = "onClick='return false'";}
					else {
						$imagen_revision='<i class="fa fa-exclamation icon-alert"></i>';
						$destino_validar_revision = 'onClick="Confirma(\'¿Seguro que desea marcar como revisada la tarea del usuario '.$revision['user_tarea'].'?\',
									\'admin-area-revs?act=rev_ok&a='.$id_area.'&p=3&id='.$id_tarea.'&idg='.$id_grupo.'&idr='.$revision['id_tarea_user'].'\'); return false"';}
					echo '<tr>';
					echo '<td><a href="inbox?n='.$usuario_rev[0]['nick'].'">'.$revision['user_tarea'].' ('.$usuario_rev[0]['name'].')</a> ';  
					echo '<a href="#" '.$destino_validar_revision.'>'.$imagen_revision.'</a></td>';
					echo '<td>('.getDateFormat($revision['fecha_tarea'], "DATE_TIME").')</td>';
					echo '<td><a href="docs/showfile.php?t=1&file='.$revision['file_tarea'].'" target="_blank">descargar</a></td>';
					echo '<td style="width: 80px; text-align: center">'.$revision['canal'].'</td>';
					echo '<td>'.$revision['nombre_grupo'].'</td>';
					echo '<td><b>'.$revision['tarea_titulo'].'</b></td>';
					echo '<td>'.$revision['username_creator'].'</td>';      
					echo '</tr>';
				endforeach;?>
				</tbody>
			</table>
		</div>
	<?php }
}

function revisionesFormulario($id_tarea, $id_area, $id_grupo, $id_recompensa){
	$na_areas = new na_areas();
	$users = new users();
	$filtro = " AND id_tarea=".$id_tarea." ";
	if ($id_grupo != 0 ) $filtro .= " AND f.user_tarea IN (SELECT grupo_username FROM na_areas_grupos_users WHERE id_grupo=".$id_grupo.") ";
	$filtro .= " ORDER BY date_finalizacion DESC";
	$revisiones = $na_areas->getFormulariosFinalizados($filtro);

	if (count($revisiones) == 0)
		echo '<div class="tareas-row">Los usuarios todavia no han finalizado los formularios para esta tarea.</div>';
	else{?>
		<div class="table-responsive">
			<table class="table table-hover table-striped">
				<tr>
					<th width="100px"></th>
					<th><?php e_strTranslate("User");?></th>
					<th>Puntuación</th>
					<th><?php e_strTranslate("Date");?></th>
					<th>Respuestas</th>
				</tr>
			<?php foreach($revisiones as $revision):
				if ($revision['revision'] == 1){
					$imagen_revision = '<i class="fa fa-check icon-ok"></i>';
					$btn = "";
					$txt = ' disabled="disabled" ';
				}
				else {
					$imagen_revision = '<i class="fa fa-exclamation icon-alert"></i>';
					$btn = '<button type="submit" class="btn btn-default">validar</button>';
					$txt = "";
				}

				echo '<tr>';
				echo '<td>
						<button type="button" class="btn btn-default btn-xs" onClick="Confirma(\'¿Seguro que desea eliminar la finalización del formulario?\', \'admin-area-revs?a='.$id_area.'&act_f=del&id='.$id_tarea.'&ut='.$revision['user_tarea'].'\'); return false" 
							title="Eliminar finalizacion" /><i class="fa fa-trash icon-table"></i>
						</button>

						<button type="button" class="btn btn-default btn-xs" onClick="location.href=\'admin-area-revs?t='.$revision['user_tarea'].'&a='.$id_area.'&id='.$id_tarea.'\'" title="descargar"><i class="fa fa-download icon-table"></i>
						</button>
						<span>'.$imagen_revision.'</span>
					</td>';
				//echo '<td><a href="inbox?n='.$revision['nick'].'">'.$revision['user_tarea'].' ('.$revision['name'].')</a></td>'; 
				echo '<td>'.$revision['user_tarea'].' ('.$revision['name'].')</a></td>'; 
				echo '<td>
						<form role="form" class="form-inline" method="post" action="admin-area-revs?a='.$id_area.'&id='.$id_tarea.'" name="rev_'.$revision['user_tarea'].'" id="rev_'.$revision['user_tarea'].'">
							<input type="hidden" name="id_tarea_rev" id="id_tarea_rev" value="'.$id_tarea.'" />
							<input type="hidden" name="id_recompensa_rev" id="id_recompensa_rev" value="'.$id_recompensa.'" />
							<input type="hidden" name="id_grupo_rev" id="id_grupo_rev" value="'.$id_grupo.'" />
							<input type="hidden" name="id_area_rev" id="id_area_rev" value="'.$id_area.'" />
							<input type="hidden" name="user_rev" id="user_rev" value="'.$revision['user_tarea'].'" />
							<input type="text" '.$txt.' name="puntos_rev" id="puntos_rev" size="2" style="width: 50px;text-align:center" class="entero form-control" value="'.$revision['puntos'].'" />
							'.$btn.'
						</form>
					</td>';
				echo '<td>('.getDateFormat($revision['date_finalizacion'], "DATE_TIME").')</td>';
				echo '<td><a href="#" onclick="createDialog('.$id_tarea.',\''.$revision['user_tarea'].'\'); return false;">ver respuestas</a></td>';
				echo '</tr>';
			endforeach; ?>
			</table>
		</div>

		<!-- Modal -->
		<div class="modal fade modal-resp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Respuestas del usuario</h4>
					</div>
					<div class="modal-body"></div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div id="dialog-confirm" title="Respuestas del usuario" style="display:none">
			<div id="dialog-info"></div>
		</div>
	<?php }
} ?>