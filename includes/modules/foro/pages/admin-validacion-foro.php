<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_admin=1;
function ini_page_header ($ini_conf) { ?>
	<!-- ficheros ventana modal -->
	<script type="text/javascript">
		jQuery(document).ready(function(){
			$(".abrir-modal").click(function(event) {
				event.preventDefault()
				$(this).next("div .modal").modal();
			});
			
		});
	</script>
	<!-- fin ficheros ventana modal -->
	<script>
		$(document).ready(function(){	
			$(".ui-modif-btn").click(function(){
				$("#form-login").submit();
			});	
		})
	</script>        
<?php }
function ini_page_body ($ini_conf){
  //CONTROL NIVEL DE ACCESO
  $perfiles_autorizados = array("admin");
  session::AccessLevel($perfiles_autorizados);

  $foro = new foro(); 
  $users = new users();
  $find_tipo = "";
  $filtro_temas = "";

  echo '<div id="page-info">Validación de foros</div>';
  echo '<div class="row inset row-top">';
  echo '	<div class="col-md-11">';

  //VALIDAR CONTENIDOS
  if (isset($_REQUEST['act'])) { 	 
	if ($_REQUEST['act']=='foro_ok'){
	  $foro->cambiarEstado($_REQUEST['id'],1);
	  $users->sumarPuntos($_REQUEST['u'],PUNTOS_FORO,PUNTOS_FORO_MOTIVO);
	}
	elseif ($_REQUEST['act']=='tema_ko'){$foro->cambiarEstadoTema($_REQUEST['id'],0);}
	elseif ($_REQUEST['act']=='foro_ko'){
		$foro->cambiarEstado($_REQUEST['id'],2);
		$users->restarPuntos($_REQUEST['u'],PUNTOS_MURO,PUNTOS_MURO_MOTIVO);
	}
	header("Location: ?page=admin-validacion-foro"); 
  }

   if (isset($_POST['find_tipo'])) { 	 
	$foro->cambiarTipoTema($_POST['id_tema_tipo'],$_POST['find_tipo']);
	//header("Location: ?page=admin-validacion-foro"); 
  }

	//EXPORT EXCEL - SHOW AND GENERATE
	if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
		$foro = new foro(); 
		$elements_exp=$foro->getComentariosExport(" AND c.id_tema=".$_REQUEST['id']." ");
		$file_name='exported_file'.date("YmdGis");
		ExportExcel('./docs/export/',$file_name,$elements_exp);
	}

	if (isset($_POST['tipo_search']) and $_POST['tipo_search']!="") {$filtro_temas.=" AND tipo_tema LIKE '%".$_POST['tipo_search']."%' ";$find_tipo=$_POST['tipo_search'];}
			
	//TEMAS FOROS
	getForosActivos($filtro_temas,$find_tipo);
	//COMENTARIOS FORO PENDIENTE DE VALIDAR
	getForoPendientes();	  
	echo '		</div>';	

	// echo '<div class="col-md-4">
	// 			<div class="panel panel-default">
	// 			<div class="panel-heading">Buscar tema</div>
	// 			<div class="panel-body">';
	// SearchTemas($find_tipo);
	// echo '		</div>
	// 			</div>';		
	// echo '</div>';

	echo '	</div>';
}

///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////

function getForosActivos($filtro_temas,$find_tipo)
{
	$foro = new foro();

	$temas = $foro->getTemas(" AND id_tema_parent<>0 AND activo=1 and itinerario='' ".$filtro_temas);  
	  echo '<p>Hay los siguientes <b>TEMAS</b> creados en los foros</p>';
	  echo '<p>Total <b>'.count($temas).'</b> registros</p>';
	  echo '<table class="table">';
	  echo '<tr>';
	  echo '<th width="40px">&nbsp;</th>';
	  echo '<th>ID</th>';
	  //echo '<th>Res.</th>';
	  //echo '<th>Tipo</th>';
	  echo '<th>Nombre</th>';
	  echo '<th>Autor</th>';
	  echo '<th>Canal</th>';
	  echo '<th><span class="fa fa-comment" title="Comentarios"></span></th>';
	  echo '<th><span class="fa fa-eye" title="Visitas"></span></th>';	  
	  echo '</tr>';
  

	  foreach($temas as $element):
			$num_comentarios=$foro->countReg("foro_comentarios"," AND estado=1 AND id_tema=".$element['id_tema']." ");
			$num_visitas=$foro->countReg("foro_visitas"," AND id_tema=".$element['id_tema']." ");	  
			echo '<tr>';
			echo '<td nowrap="nowrap">
					<span class="fa fa-ban icon-table" title="Eliminar"
					    onClick="Confirma(\'¿Seguro que desea eliminar el tema '.$element['id_tema'].'?\',
						\'?page=admin-validacion-foro&act=tema_ko&id='.$element['id_tema'].'&u='.$element['user'].'\')">
					</span>

					<span class="fa fa-download icon-table" title="Exportar datos"
						onClick="location.href=\'?page=admin-validacion-foro&export=true&id='.$element['id_tema'].'\'">
					</span>
							
				 </td>';					
			echo '<td><a href="#" class="abrir-modal" title="TemaForo'.$element['id_tema'].'">'.$element['id_tema'].'</a>

					<!-- Modal -->
					<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					        <h4 class="modal-title" id="myModalLabel">Tema en el foro</h4>
					      </div>
					      <div class="modal-body">
							<p><b>'.$element['user'].'</b> cre&oacute; el tema: '.$element['nombre'].'</p>
							<p><em>'.$element['descripcion'].'</em></p>
					      </div>
					    </div><!-- /.modal-content -->
					  </div><!-- /.modal-dialog -->
					</div><!-- /.modal -->

			</td>';
			if ($element['responsables']==1) {$responsables="SI";}
			else {$responsables="NO";}
			// echo '<td>'.$responsables.'</td>';
			// echo '<td nowrap="nowrap">
			// <form action="" method="post" role="form" class="form-inline">
			// <input type="hidden" name="id_tema_tipo" value="'.$element['id_tema'].'">
			// <input type="hidden" name="tipo_search" value="'.$find_tipo.'">
			// <select name="find_tipo" id="find_tipo" class="form-control">'.$element['tipo_tema'];				  
   //          ComboTiposTemas($element['tipo_tema']);
			// echo '</select>
			// <input type="submit" value="Modif." class="btn btn-default">
			// </form>
			// </td>';
			echo '<td>'.$element['nombre'].'</td>';
			echo '<td>'.$element['user'].'</td>';
			echo '<td>'.$element['canal'].'</td>';
			echo '<td align="center">'.$num_comentarios.'</td>';
			echo '<td align="center">'.$num_visitas.'</td>';			
			echo '</tr>';   
	  endforeach;
	  echo '</table><br />';	
}


function getForoPendientes()
{
	$foro = new foro();
	$calculo = strtotime("-4 days");
	$fecha_ayer= date("Y-m-d", $calculo);
	$pendientes = $foro->getComentarios(" AND t.id_area=0 AND t.ocio=0 AND date_comentario>='".$fecha_ayer."' AND estado=1 AND t.itinerario='' ORDER BY id_comentario DESC");
	if (count($pendientes)==0){
		echo '<p>No hay <b>MENSAJES</b> en los foros insertados ultimamente (fecha: '.$fecha_ayer.').<br />
	  		Puntos a otorgar por mensaje: <span class="comunidad-color">'.PUNTOS_FORO.'.</span></p>';
	}
	else{
	  echo '<p>Hay los siguientes <b>MENSAJES</b> en los foros insertados ultimamente (fecha: '.$fecha_ayer.').<br />
	  		Puntos a otorgar por mensaje: <span class="comunidad-color">'.PUNTOS_FORO.'.</span></p>';
	  echo '<p>Total <b>'.count($pendientes).'</b> registros</p>';	  		
	  echo '<table class="table">';
	  echo '<tr>';
	  echo '<th width="40px">&nbsp;</th>';
	  echo '<th>ID</th>';
	  echo '<th>Autor</th>';
	  echo '<th>Canal</th>';
	  echo '<th>Fecha</th>';
	  echo '<th>Tema</th>';
	  echo '</tr>';
  

	  foreach($pendientes as $element):
			echo '<tr>';
			echo '<td nowrap="nowrap">					
					<span class="fa fa-ban icon-table" title="Eliminar"
					    onClick="Confirma(\'¿Seguro que desea eliminar el comentario '.$element['id_comentario'].'?\',
						\'?page=admin-validacion-foro&act=foro_ko&id='.$element['id_comentario'].'&u='.$element['user_comentario'].'\')">
					</span>			
				 </td>';					
			echo '<td><a href="#" class="abrir-modal" title="MensajeForo'.$element['id_comentario'].'">'.$element['id_comentario'].'</a>

					<!-- Modal -->
					<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					        <h4 class="modal-title" id="myModalLabel">Comentario en el foro</h4>
					      </div>
					      <div class="modal-body">
							<p><b>'.$element['user_comentario'].'</b> escribió:</p>
							<p><em>'.$element['comentario'].'</em></p>
					      </div>
					    </div><!-- /.modal-content -->
					  </div><!-- /.modal-dialog -->
					</div><!-- /.modal -->

			</td>';
			echo '<td>'.$element['user_comentario'].'</td>';
			echo '<td>'.$element['canal'].'</td>';
			echo '<td>'.strftime(DATE_FORMAT_SHORT,strtotime($element['date_comentario'])).'</td>';	
			echo '<td>'.$element['nombre'].'</td>';		
			echo '</tr>';   
	  endforeach;
	  echo '</table><br />';	
	}
}


function SearchTemas($tipo_tema)
{	
	  echo '<form name="SearchTemas" id="SearchTemas" action="" method="post" role="form">';
	  if ($marca_tipo==1){$marcado=' checked="checked" ';}
	  else {$marcado='';}?>
      <select name="tipo_search" id="tipo_search" class="form-control">
      <option value="">---Todos---</option>
      <?php ComboTiposTemas($tipo_tema);?>
      </select>
      <br />
      <button type="submit" id="find-btn" class="btn btn-primary">buscar</button>
      </FORM>
<?php }
?>
