<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_admin=1;
templateload("cmbAlbumes","fotos");
function ini_page_header ($ini_conf) {
  //VALIDAR CONTENIDOS
  if (isset($_REQUEST['act'])) { 	
	$users = new users();
	$fotos = new fotos();
    
	if ($_REQUEST['act']=='foto_ok'){
	  $fotos->cambiarEstado($_REQUEST['id'],1);
	  $fotos->updateFotoAlbum($_REQUEST['id'],$_REQUEST['ida']);
	  $users->sumarPuntos($_REQUEST['u'],PUNTOS_FOTO,PUNTOS_FOTO_MOTIVO);
	}
	elseif ($_REQUEST['act']=='foto_ko'){$fotos->cambiarEstado($_REQUEST['id'],2,0);}

	header("Location: ?page=admin-validacion-fotos"); 
  }
?>
		<!-- ficheros ventana modal -->
		<script type="text/javascript">
			jQuery(document).ready(function(){
				$(".abrir-modal").click(function(event) {
					event.preventDefault()
					$(this).next("div .modal").modal();
				});

				$(".trigger-validar").click(function(event) {		
					var id_file = $(this).attr("data-id"),
						id_album = $("#nombre_album_" + id_file).val(),
						user_add = $(this).attr("data-user");
					if (id_album > 0){
						Confirma('¿Seguro que desea validar la foto?', '?page=admin-validacion-fotos&act=foto_ok&id=' + id_file + '&ida=' + id_album + '&u=' + user_add);
					}
					else{
						alert("Debes seleccionar un album para la foto");
					}
				});
				
			});
		</script>
        <!-- fin ficheros ventana modal -->
<?php }
function ini_page_body ($ini_conf){
  //CONTROL NIVEL DE ACCESO
  $perfiles_autorizados = array("admin");
  session::AccessLevel($perfiles_autorizados);
  
  echo '<div id="page-info">Validación de fotos</div>
		<div class="row inset row-top">
			<div class="col-md-9">';						
  getFotosPendientes();	  
  echo '	</div>

  			<div class="col-md-3">
			  <div class="panel panel-default">
			    <div class="panel-heading">Validación Fotos</div>
			    <div class="panel-body">
			      <p>Tienes las siguientes FOTOS pendientes de validar.<br /> 
	  				Puntos a otorgar por foto: <b>'.PUNTOS_FOTO.'</b>.</p>
			    </div>
			  </div>

			  <div class="panel panel-default">
			    <div class="panel-heading">Álbumes de fotos</div>
			    <div class="panel-body">
			      <p><a href="?page=admin-albumes">Gestión albumes de fotos</a></p>
			    </div>
			  </div>
			</div>
  		</div>';
}

///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////

function getFotosPendientes()
{
	$fotos = new fotos();
	$pendientes = $fotos->getFotos(" AND estado=0 AND id_promocion=0 ");
	$albumes = $fotos->getFotosAlbumes("");
	if (count($pendientes)==0){
		echo '<div class="alert alert-danger">No hay FOTOS pendientes de validar.</div>';
	}
	else{
	  echo '<table class="table table-striped">';
	  echo '<tr>';
	  echo '<th width="40px">&nbsp;</th>';
	  echo '<th>Álbum</th>';
	  echo '<th>Usuario</th>';
	  echo '<th>Canal</th>';
	  echo '<th>Título foto</th>';
	  echo '<th>Fecha</th>';
	  echo '</tr>';
  
	  foreach($pendientes as $element):

			echo '<tr>';
			echo '<td nowrap="nowrap">			
					<span class="fa fa-ban icon-table" onClick="Confirma(\'¿Seguro que desea eliminar la foto?\',
						\'?page=admin-validacion-fotos&act=foto_ko&id='.$element['id_file'].'&u='.$element['user_add'].'\')" 
						title="Eliminar" />
					</span>

					<span class="fa fa-check-circle icon-table trigger-validar" data-id="'.$element['id_file'].'" data-user="'.$element['user_add'].'"	title="Validar" />
					</span>';
										


			echo'</td>';
			echo '<td>';
			ComboAlbumes(0,$albumes,"nombre_album_" .$element['id_file']);
			echo '</td>';					
			echo '<td>'.$element['user_add'].'</td>';
			echo '<td>'.$element['canal_file'].'</td>';
			echo '<td><a href="#" class="abrir-modal" title="MensajeFoto'.$element['id_file'].'">'.$element['titulo'].'</a>

					<!-- Modal -->
					<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					        <h4 class="modal-title" id="myModalLabel">Foto</h4>
					      </div>
					      <div class="modal-body">
							<img src="'.PATH_FOTOS.$element['name_file'].'" class="galeria-fotos" style="width:100%" />
					      </div>
					    </div><!-- /.modal-content -->
					  </div><!-- /.modal-dialog -->
					</div><!-- /.modal -->

				 </td>';
			echo '<td>'.strftime(DATE_FORMAT_SHORT,strtotime($element['date_foto'])).'</td>';			
			echo '</tr>';   
	  endforeach;
	  echo '</table><br />';	
	}
}
?>
