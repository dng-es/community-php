<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

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

	session::getFlashMessage( 'actions_message' );
	foroController::validateComentarioAction();
	foroController::cancelComentarioAction();
	$elements = foroController::getListComentariosAction(15, " AND estado=1 ORDER BY id_comentario DESC");?>
	
	<div class="row row-top">
		<div class="col-md-9">
			<h1>Comentarios en los foros</h1>
				<p>Hay los siguientes <b>MENSAJES</b> (<?php echo $elements['total_reg'];?>) en los foros. Puntos a otorgar por mensaje: <span class="comunidad-color"><?php echo PUNTOS_FORO;?>.</span></p>
				<table class="table">
				<tr>
				<th width="40px">&nbsp;</th>
				<th>ID</th>
				<th>Autor</th>
				<th>Canal</th>
				<th>Fecha</th>
				<th>Tema</th>
				</tr>
				<?php foreach($elements['items'] as $element):
					echo '<tr>';
					echo '<td nowrap="nowrap">					
							<span class="fa fa-ban icon-table" title="Eliminar"
							    onClick="Confirma(\'¿Seguro que desea eliminar el comentario '.$element['id_comentario'].'?\',
								\'?page=admin-validacion-foro-comentarios&pag='.(isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1).'&act=foro_ko&id='.$element['id_comentario'].'&u='.$element['user_comentario'].'\')">
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
				Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);	?>
		</div>
		<?php menu::adminMenu();?>
	</div>
	<?php
}
?>