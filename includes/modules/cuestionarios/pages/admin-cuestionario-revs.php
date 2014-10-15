<?php
//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);

addJavascripts(array("js/jquery.numeric.js", getAsset("cuestionarios")."js/admin-cuestionario-revs.js"));

cuestionariosController::ExportFormUserAction();
cuestionariosController::ExportFormAllAction();
?>

<div class="row row-top">
	<div class="col-md-9">
		<?php
		session::getFlashMessage( 'actions_message' );
		cuestionariosController::RevisarFormAction(); 
		cuestionariosController::FinalizacionDeleteAction(); 

		//OBTENER DATOSL CUESTIONARIO
		$cuestionarios = new cuestionarios();
		$id_cuestionario =$_REQUEST['id'];
		$cuestionario=cuestionariosController::getItemAction($id_cuestionario);
		?>
		<h1>Revisiones cuestionario <small><?php echo $cuestionario[0]['nombre'];?></small></h1>
		<ul class="nav nav-pills navbar-default">      
			<li><a href="?page=admin-cuestionarios">Volver al listado</a></li>
			<li><a href="?page=admin-cuestionario-revs&t3=1&id=<?php echo $id_cuestionario;?>"><?php echo strTranslate("Export");?></a></li>
		</ul>
		
		<?php revisionesFormulario($id_cuestionario,$id_grupo);?>
	</div>
	<?php menu::adminMenu();?>
</div>

<?php
function revisionesFormulario($id_cuestionario,$id_grupo){
		$cuestionarios = new cuestionarios();
		$users = new users();
		$filtro = " AND id_cuestionario=".$id_cuestionario." ORDER BY user_tarea";
		$revisiones = $cuestionarios->getFormulariosFinalizados($filtro);   

		if (count($revisiones)==0){
			echo '<div class="tareas-row">Los usuarios todavia no han finalizado lel cuestionario.</div>';
		}
		else{
			echo '<table class="table">';
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
				echo '<td width="70px"><span span class="fa fa-ban icon-table" onClick="Confirma(\'¿Seguro que desea eliminar la finalización del cuestionario?\',
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
				echo '<td>('.strftime(DATE_TIME_FORMAT,strtotime($revision['date_finalizacion'])).')</td>';
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
}
?>