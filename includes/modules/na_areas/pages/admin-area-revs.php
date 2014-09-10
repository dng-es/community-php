<?php
//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);

//VALIDAR REVISIONES FORMULARIOS
if ( isset($_POST['id_tarea_rev']) and $_POST['id_tarea_rev']!='' ) na_areasController::RevisarFormAction(); 

//ELIMINACION DE FINALIZACION DE FORMULARIO
if (isset($_REQUEST['act_f']) and $_REQUEST['act_f']=="del") na_areasController::FinalizacionDeleteAction(); 

//DESCARGAR FORMULARIO
if (isset($_REQUEST['t']) and $_REQUEST['t']!="") na_areasController::ExportFormUserAction();

//EXPORT REVS
if (isset($_REQUEST['t3']) and $_REQUEST['t3']=="1") na_areasController::ExportFormAllAction();

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

addJavascripts(array("js/jquery.numeric.js", getAsset("na_areas")."js/admin-area-docs.js"));

//OBTENER DATOS DE LA TAREA
$na_areas = new na_areas();
$id_area=$_REQUEST['a'];
$id_tarea=$_REQUEST['id'];
$tarea=$na_areas->getTareas(" AND id_tarea=".$id_tarea." ");
?>

<div class="row row-top">
	<div class="col-md-9">
		<h1>Revisiones</h1>
		<p>Tarea: <?php echo $tarea[0]['tarea_titulo'];?></p>
		<nav class="navbar navbar-default" role="navigation">
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">       
					<li><a href="?page=admin-area&act=edit&id=<?php echo $id_area;?>">Volver al curso</a></li>
					<li><a href="?page=admin-area-revs&t3=1&a=<?php echo $id_area;?>&id=<?php echo $id_tarea;?>"><?php echo strTranslate("Export");?></a></li>
				</ul>
			</div>
		</nav>
		<?php 
		//DESCARGAR FICHERO USUARIO-FICHEROS
		if (isset($_REQUEST['t2']) and $_REQUEST['t2']=="1"){
			$na_areas = new na_areas();
			$elements=$na_areas->getTareasUserExport($_REQUEST['id'],$_REQUEST['a']);
			$file_name='exported_file'.date("YmdGis");
			ExportExcel ("./docs/export/",$file_name,$elements,"xls",1);
		} 

		//DESCARGAR FICHERO USUARIO-FICHEROS
		// if (isset($_REQUEST['t3']) and $_REQUEST['t3']=="1"){
		//   $na_areas = new na_areas();
		//   $elements=$na_areas->getFormulariosFinalizados(" AND id_tarea=".$_REQUEST['id']." ORDER BY user_tarea"); 
		//   $file_name='exported_file'.date("YmdGis");

		//   $final = array();
		//   foreach($elements as $element):
		//     //nombre del grupo
		//     $nombre_grupo='';
		//     if (count($grupos=$na_areas->getUsuarioGrupoTarea($_REQUEST['id'],$_REQUEST['a']," AND grupo_username='".$element['user_tarea']."' "))>0){
		//        $nombre_grupo=$grupos[0]['grupo_nombre'];}
		//     $element['nombre_grupo']=$nombre_grupo;

		//     //respuestas del usuario
		//     $respuestas = $na_areas -> getFormulariosFinalizadosRespuestas($element['id_tarea'],$element['user_tarea']);
		//     $i=1;
		//     foreach($respuestas as $respuesta):
		//       $pregunta_texto="pregunta".$i;
		//       $element[$pregunta_texto]=$respuesta['respuesta_valor'];
		//       $i++;
		//     endforeach;    
		//     array_push($final, $element);
		//   endforeach;
			

		//   ExportExcel ("./docs/export/",$file_name,$final,"xls",1);
		// }
		
		//VALIDAR REVISIONES FICHEROS
		if ( isset($_REQUEST['act']) and $_REQUEST['act']=='rev_ok' ){
			$id_tarea_user=$_REQUEST['idr'];
			$na_areas->RevisarTareaUser($id_tarea_user,$_SESSION['user_name']);
		} 

		if (count($tarea)==1){  

			$id_grupo=0; 
			if(isset($_POST['grupo_search']) and $_POST['grupo_search']!="") {$id_grupo = $_POST['grupo_search'];}
			if(isset($_POST['id_grupo_rev']) and $_POST['id_grupo_rev']!="") {$id_grupo = $_POST['id_grupo_rev'];}
			if(isset($_REQUEST['idg']) and $_REQUEST['idg']!="") {$id_grupo = $_REQUEST['idg'];}

			//grupos de la tarea
			$grupos_tarea = $na_areas->getGruposTareas(" AND id_area=".$id_area." AND id_tarea=".$id_tarea." ");
			if (count($grupos_tarea)>0){
				echo '<form action="?page=admin-area-revs&a='.$id_area.'&id='.$id_tarea.'" method="post" id="frm_search" name="frm_search">
						<select name="grupo_search" id="grupo_search" class="cuadroTexto cuadroTextoSelect" style="width:300px !important">
							<option value="0">-----todos los grupos de la tarea-----</option>';
				foreach($grupos_tarea as $grupo_tarea):
					$selected="";
					if ($id_grupo==$grupo_tarea['id_grupo']){$selected=' selected="selected" ';}
					echo '<option value="'.$grupo_tarea['id_grupo'].'" '.$selected.'>'.$grupo_tarea['grupo_nombre'].'</option>';
				endforeach;
				echo '  </select>
						<div id="btn_search" style="margin:-4px 0 0 5px">filtrar grupo</div>
					</form>';
			}
			if ($tarea[0]['tipo']=='formulario'){revisionesFormulario($id_tarea,$id_area,$id_grupo);}
			else{revisionesFicheros($id_tarea,$id_area,$id_grupo);} 
		}
		else{ErrorMsg("Error al cargar la tarea");}
		?>
	</div>
	<?php menu::adminMenu();?>
</div>


<?php

function revisionesFicheros($id_tarea,$id_area,$id_grupo){
		$na_areas = new na_areas();
		$users = new users();
		$filtro = " AND id_tarea=".$id_tarea." ";
		if ($id_grupo!=0){$filtro.=" AND user_tarea IN (SELECT grupo_username FROM na_areas_grupos_users WHERE id_grupo=".$id_grupo.") ";;}
		$filtro.=" ORDER BY user_tarea";
		$revisiones = $na_areas->getTareasUser($filtro); 
		
		echo '<h3>documentos enviados a la tarea</h3>';
		echo '<p>pincha <a href="?page=admin-area-revs&t2=1&a='.$id_area.'&idg='.$id_grupo.'&id='.$id_tarea.'">aquí</a> para descargar el fichero con todos los usuarios que han subidos el fichero de la tarea.</p>';

		if (count($revisiones)==0){
			echo '<div class="tareas-row">Los usuarios todavia no han enviado archivos para esta tarea.</div>';
		}
		else{
			echo '<table class="table">
					<tbody>';
			foreach($revisiones as $revision):
				$usuario_rev=$users->getUsers(" AND username='".$revision['user_tarea']."' ");
				if ($revision['revision']==1){
					$imagen_revision='<i class="fa fa-check icon-ok"></i>';
					$destino_validar_revision="";}
				else {
					$imagen_revision='<i class="fa fa-exclamation icon-alert"></i>';
					$destino_validar_revision='onClick="Confirma(\'¿Seguro que desea marcar como revisada la tarea del usuario '.$revision['user_tarea'].'?\',
								\'?page=admin-area-revs&act=rev_ok&a='.$id_area.'&p=3&id='.$id_tarea.'&idg='.$id_grupo.'&idr='.$revision['id_tarea_user'].'\')"';}
								
				echo '<tr>';      
				echo '<td>a href="?page=mensajes&n='.$usuario_rev[0]['nick'].'">'.$revision['user_tarea'].' ('.$usuario_rev[0]['name'].')</a>';  
				echo '<a href="#" '.$destino_validar_revision.'>'.$imagen_revision.'</a></td>';
				echo '<td>('.strftime(DATE_TIME_FORMAT,strtotime($revision['fecha_tarea'])).')</td>';
				echo '<td><a href="docs/showfile.php?t=1&file='.$revision['file_tarea'].'" target="_blank">descargar</a></td>';
				echo '<td style="width: 80px; text-align: center">'.$revision['canal'].'</td>';
				echo '<td>'.$revision['nombre_grupo'].'</td>';
				echo '<td><b>'.$revision['tarea_titulo'].'</b></td>';
				echo '<td>'.$revision['username_creator'].'</td>';      
				echo '</tr>';
			endforeach;
			echo '</tbody></table>';
		}  
}

function revisionesFormulario($id_tarea,$id_area,$id_grupo){
		$na_areas = new na_areas();
		$users = new users();
		$filtro=" AND id_tarea=".$id_tarea." ";
		if ($id_grupo!=0){$filtro.=" AND f.user_tarea IN (SELECT grupo_username FROM na_areas_grupos_users WHERE id_grupo=".$id_grupo.") ";}
		$filtro.=" ORDER BY user_tarea";
		$revisiones = $na_areas->getFormulariosFinalizados($filtro);   

		if (count($revisiones)==0){
			echo '<div class="tareas-row">Los usuarios todavia no han finalizado los formularios para esta tarea.</div>';
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
				echo '<td width="70px"><span span class="fa fa-ban icon-table" onClick="Confirma(\'¿Seguro que desea eliminar la finalización del formulario?\',
						\'?page=admin-area-revs&a='.$id_area.'&act_f=del&id='.$id_tarea.'&ut='.$revision['user_tarea'].'\')" 
						title="Eliminar finalizacion" /></span>

						<a href="?page=admin-area-revs&t='.$revision['user_tarea'].'&a='.$id_area.'&id='.$id_tarea.'" class="fa fa-download icon-table" title="descargar"></a>
						<a href="#" '.$destino_validar_revision.'>'.$imagen_revision.'</a>
					</td>';        
				//echo '<td><a href="?page=mensajes&n='.$revision['nick'].'">'.$revision['user_tarea'].' ('.$revision['name'].')</a></td>'; 
				echo '<td>'.$revision['user_tarea'].' ('.$revision['name'].')</a></td>'; 
				echo '<td>
						<form role="form" class="form-inline" method="post" action="?page=admin-area-revs&a='.$id_area.'&id='.$id_tarea.'" name="rev_'.$revision['user_tarea'].'" id="rev_'.$revision['user_tarea'].'">
							<input type="hidden" name="id_tarea_rev" id="id_tarea_rev" value="'.$id_tarea.'" />
							<input type="hidden" name="id_grupo_rev" id="id_grupo_rev" value="'.$id_grupo.'" />
							<input type="hidden" name="id_area_rev" id="id_area_rev" value="'.$id_area.'" />
							<input type="hidden" name="user_rev" id="user_rev" value="'.$revision['user_tarea'].'" />
							<input type="text" '.$txt.' name="puntos_rev" id="puntos_rev" size="2" style="width: 50px;text-align:center" class="entero form-control" value="'.$revision['puntos'].'" />
							'.$btn.'
						</form>
					</td>';
				echo '<td>('.strftime(DATE_TIME_FORMAT,strtotime($revision['date_finalizacion'])).')</td>';
				echo '<td><a href="#" onclick="createDialog('.$id_tarea.',\''.$revision['user_tarea'].'\')">ver respuestas</a></td>';       
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