<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

foroController::exportTemasAction();


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
<?php }
function ini_page_body ($ini_conf){
	//CONTROL NIVEL DE ACCESO
	$perfiles_autorizados = array("admin");
	session::AccessLevel($perfiles_autorizados);

	$filtro_temas = (isset($_POST['tipo_search']) and $_POST['tipo_search']!="") ? " AND tipo_tema LIKE '%".$_POST['tipo_search']."%' " : "";
	$find_tipo = (isset($_POST['tipo_search']) and $_POST['tipo_search']!="") ? $_POST['tipo_search'] : "";

	session::getFlashMessage( 'actions_message' );
	foroController::cancelTemaAction();
	foroController::changeTipoAction();
	$elements = foroController::getListTemasAction(15, " AND id_tema_parent<>0 AND activo=1 and itinerario='' ".$filtro_temas);?>

	<div id="page-info">Temas en los foros</div>
	<div class="row inset row-top">
		<div class="col-md-9">
			<p>Hay los siguientes <b>TEMAS</b> (<?php echo $elements['total_reg'];?>) creados en los foros</p>
			<table class="table">
				<tr>
				<th width="40px">&nbsp;</th>
				<th>ID</th>
				<th><?php echo strTranslate("Name");?></th>
				<th><?php echo strTranslate("Author");?></th>
				<th>Canal</th>
				<th><span class="fa fa-comment" title="<?php echo strTranslate("Comments");?>"></span></th>
				<th><span class="fa fa-eye" title="<?php echo strTranslate("Visits");?>"></span></th>
				</tr>

				<?php foreach($elements['items'] as $element):
				$num_comentarios = connection::countReg("foro_comentarios"," AND estado=1 AND id_tema=".$element['id_tema']." ");
				$num_visitas = connection::countReg("foro_visitas"," AND id_tema=".$element['id_tema']." ");	  
				echo '<tr>';
				echo '<td nowrap="nowrap">
						<span class="fa fa-ban icon-table" title="Eliminar"
						    onClick="Confirma(\'¿Seguro que desea eliminar el tema '.$element['id_tema'].'?\',
							\'?page=admin-validacion-foro-temas&pag='.(isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1).'&act=tema_ko&id='.$element['id_tema'].'&u='.$element['user'].'\')">
						</span>

						<span class="fa fa-download icon-table" title="Exportar datos"
							onClick="location.href=\'?page=admin-validacion-foro-temas&export=true&id='.$element['id_tema'].'\'">
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
			Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);
				echo '		</div>';	
			// echo '<div class="col-md-4">
			// 			<div class="panel panel-default">
			// 			<div class="panel-heading">Buscar tema</div>
			// 			<div class="panel-body">';
			// SearchTemas($find_tipo);
			// echo '		</div>
			// 			</div>';		
			// echo '</div>';?>
	</div>
	<?php
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
