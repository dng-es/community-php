<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_admin=1;
function ini_page_header ($ini_conf) {
//VALIDAR CONTENIDOS
  if (isset($_REQUEST['act'])) { 	
	$users = new users();
	$muro = new muro();
    
	if ($_REQUEST['act']=='muro_ok'){
	  $muro->cambiarEstado($_REQUEST['id'],1);
	  $users->sumarPuntos($_REQUEST['u'],PUNTOS_MURO,PUNTOS_MURO_MOTIVO);
	}
	elseif ($_REQUEST['act']=='muro_ko'){
		$muro->cambiarEstado($_REQUEST['id'],2);
		$users->restarPuntos($_REQUEST['u'],PUNTOS_MURO,PUNTOS_MURO_MOTIVO);
	}
	header("Location: ?page=admin-validacion-muro"); 
  }
?>
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
<?php }
function ini_page_body ($ini_conf){
  //CONTROL NIVEL DE ACCESO
  $perfiles_autorizados = array("admin");
  session::AccessLevel($perfiles_autorizados);
  
  echo '<div id="page-info">Validación comentario muro</div>';
  echo '<div class="row inset row-top">';
  echo '	<div class="col-md-9">';				
  			getMuroPendientes();  
  echo '	</div>';
  echo '</div>';
}

///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////
function getMuroPendientes()
{
	$muro = new muro();
	$calculo = strtotime("-4 days");
	$fecha_ayer= date("Y-m-d", $calculo);
	$pendientes = $muro->getComentarios(" AND date_comentario>='".$fecha_ayer."' AND estado=1 AND tipo_muro IN ('principal','responsable') ORDER BY date_comentario DESC");

	if (count($pendientes)==0){
		echo '<p>No hay mensajes en el <span class="comunidad-color">MURO</span> insertados ultimamente (fecha: '.$fecha_ayer.').<br />
	  		Puntos a otorgar por mensaje: <span class="comunidad-color">'.PUNTOS_MURO.'.</span></p>';
	}
	else{
	  echo '<p>Hay los siguientes mensajes en el <span class="comunidad-color">MURO</span> insertados ultimamente (fecha: '.$fecha_ayer.').<br />
	  		Puntos a otorgar por mensaje: <span class="comunidad-color">'.PUNTOS_MURO.'.</span></p>';
	  echo '<table class="table table-striped">';
	  echo '<tr>';
	  echo '<th width="40px">&nbsp;</th>';
	  echo '<th>ID</th>';
	  echo '<th>Muro</th>';
	  echo '<th>Usuario</th>';
	  echo '<th>Canal</th>';
	  echo '<th>Fecha</th>';
	  echo '</tr>';
  
	  foreach($pendientes as $element):
			echo '<tr>';
			echo '<td nowrap="nowrap">
					<span class="fa fa-ban icon-table" title="Eliminar"
					    onClick="Confirma(\'¿Seguro que desea eliminar el comentario '.$element['id_comentario'].'?\',
						\'?page=admin-validacion-muro&act=muro_ko&id='.$element['id_comentario'].'&u='.$element['user_comentario'].'\')">
					</span>			
				 </td>';					
			echo '<td><a href="#" class="abrir-modal" title="MensajeMuro'.$element['id_comentario'].'">'.$element['id_comentario'].'</a>

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
			echo '<td>'.$element['tipo_muro'].'</td>';
			echo '<td>'.$element['user_comentario'].'</td>';
			echo '<td>'.$element['canal_comentario'].'</td>';
			echo '<td>'.strftime(DATE_TIME_FORMAT,strtotime($element['date_comentario'])).'</td>';			
			echo '</tr>';   
	  endforeach;
	  echo '</table><br />';	
	}
}
?>
