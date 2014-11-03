<?php
//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);

addJavascripts(array("js/jquery.numeric.js", getAsset("cuestionarios")."js/admin-cuestionario-revs.js"));

cuestionariosController::ExportFormUserAction();
cuestionariosController::ExportFormAllAction();

//OBTENER DATOS DEL CUESTIONARIO
$cuestionarios = new cuestionarios();
$id_cuestionario =$_REQUEST['id'];
$cuestionario=cuestionariosController::getItemAction($id_cuestionario);
?>

<div class="row row-top">
	<div class="col-md-9">
		<h1>Revisiones cuestionario <small><?php echo $cuestionario[0]['nombre'];?></small></h1>
		<?php
		session::getFlashMessage( 'actions_message' );
		cuestionariosController::RevisarFormAction(); 
		cuestionariosController::FinalizacionDeleteAction(); 
		$filtro = " AND id_cuestionario=".$id_cuestionario." ORDER BY user_tarea";
		$revisiones = $cuestionarios->getFormulariosFinalizados($filtro);   
		?>
		<ul class="nav nav-pills navbar-default">
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo count($revisiones);?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>  
			<li><a href="?page=admin-cuestionarios">Volver al listado</a></li>
			<li><a href="?page=admin-cuestionario-revs&t3=1&id=<?php echo $id_cuestionario;?>"><?php echo strTranslate("Export");?></a></li>
		</ul>
		
		<?php


		if (count($revisiones)==0){
			echo '<br /><div class="tareas-row alert alert-warning">Los usuarios todavia no han finalizado el cuestionario.</div>';
		}
		else{
			echo '<table class="table">
					<tr>
						<th width="70px"></th>
						<th>'.strTranslate("User").'</th>
						<th>Puntuación</th>
						<th>'.strTranslate("Date").'</th>
						<th>Respuestas</th>
					</tr>';
			foreach($revisiones as $revision):
				if ($revision['revision']==1){
					$imagen_revision='<i class="fa fa-check icon-ok"></i>';
					$destino_validar_revision="";
					$btn = "";
					$txt = ' disabled="disabled" ';
				}
				else {
					$imagen_revision='<i class="fa fa-exclamation icon-alert"></i>';
					$destino_validar_revision='';
					$btn = '<button type="submit" class="btn btn-default">validar</button>';
					$txt = "";
				}
								
				echo '<tr>';        
				echo '<td><span span class="fa fa-ban icon-table" onClick="Confirma(\'¿Seguro que desea eliminar la finalización del cuestionario?\',
						\'?page=admin-cuestionario-revs&act_f=del&id='.$id_cuestionario.'&ut='.$revision['user_tarea'].'\')" 
						title="Eliminar finalizacion" /></span>

						<a href="?page=admin-cuestionario-revs&t='.$revision['user_tarea'].'&id='.$id_cuestionario.'" class="fa fa-download icon-table" title="descargar"></a>
						<a href="#" '.$destino_validar_revision.'>'.$imagen_revision.'</a>
					</td>';        
				//echo '<td><a href="?page=mensajes&n='.$revision['nick'].'">'.$revision['user_tarea'].' ('.$revision['name'].')</a></td>'; 
				echo '<td>'.$revision['user_tarea'].' ('.$revision['name'].')</a></td>'; 
				echo '<td>
						<form role="form" class="form-inline" method="post" action="?page=admin-cuestionario-revs&id='.$id_cuestionario.'" name="rev_'.$revision['user_tarea'].'" id="rev_'.$revision['user_tarea'].'">
							<input type="hidden" name="id_tarea_rev" id="id_tarea_rev" value="'.$id_cuestionario.'" />
							<input type="hidden" name="user_rev" id="user_rev" value="'.$revision['user_tarea'].'" />
							<input type="text" '.$txt.' name="puntos_rev" id="puntos_rev" size="2" style="width: 50px;text-align:center" class="entero form-control" value="'.$revision['puntos'].'" />
							'.$btn.'
						</form>
					</td>';
				echo '<td>('.getDateFormat($revision['date_finalizacion'], "DATE_TIME").')</td>';
				echo '<td><a href="#" onclick="createDialog('.$id_cuestionario.',\''.$revision['user_tarea'].'\')">ver respuestas</a></td>';       
				echo '</tr>';
			endforeach;
			echo '</table>

					<!-- Modal -->
					<div class="modal fade modal-resp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title" id="myModalLabel">Respuestas del usuario</h4>
								</div>
								<div class="modal-body">


								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->';

			echo '<div id="dialog-confirm" title="Respuestas del usuario" style="display:none">
					<div id="dialog-info"></div>
				</div>';
		}  
?>

	</div>
	<?php menu::adminMenu();?>
</div>