<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

templateload("cmbAlbumes","fotos");

addJavascripts(array(getAsset("fotos")."js/admin-validacion-fotos.js"));

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

//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);

$fotos = new fotos();
$pendientes = $fotos->getFotos(" AND estado=0 AND id_promocion=0 ");
$albumes = $fotos->getFotosAlbumes("");?>

<div class="row row-top">
	<div class="col-md-9">	
			<h1>Validación de fotos</h1>
		<p>Tienes las siguientes <b>FOTOS</b> (<?php echo count($pendientes);?>) pendientes de validar. Puntos a otorgar por foto: <b><?php echo PUNTOS_FOTO;?></b>.</p>
		<table class="table">
		<tr>
		<th width="40px">&nbsp;</th>
		<th>Álbum</th>
		<th>Usuario</th>
		<th>Canal</th>
		<th>Título foto</th>
		<th>Fecha</th>
		</tr>
		<?php foreach($pendientes as $element):
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
		endforeach;?>
		</table><br />	
	</div>
	<?php menu::adminMenu();?>
</div>