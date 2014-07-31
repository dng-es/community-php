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
<?php }
function ini_page_body ($ini_conf){
	//CONTROL NIVEL DE ACCESO
	$perfiles_autorizados = array("admin");
	session::AccessLevel($perfiles_autorizados);

	session::getFlashMessage( 'actions_message' );
	muroController::validateAction();
	muroController::cancelAction();			
	$elements = muroController::getListAction(15, " AND estado=1 AND tipo_muro IN ('principal','responsable') ORDER BY date_comentario DESC"); ?>

	<div class="row row-top">
		<div class="col-md-9">
			<h1>Validación de comentarios del muro</h1>
			<p>Hay los siguientes mensajes en el <b>MURO</b> (<?php echo $elements['total_reg'];?>). Puntos a otorgar por mensaje: <span class="comunidad-color"><?php echo PUNTOS_MURO;?>.</span></p>
			<table class="table">
			<tr>
			<th width="40px">&nbsp;</th>
			<th>ID</th>
			<th>Muro</th>
			<th><?php echo strTranslate("User");?></th>
			<th>Canal</th>
			<th><?php echo strTranslate("Date");?></th>
			</tr>
		 	<?php foreach($elements['items'] as $element):
				echo '<tr>';
				echo '<td nowrap="nowrap">
						<span class="fa fa-ban icon-table" title="Eliminar"
						    onClick="Confirma(\'¿Seguro que desea eliminar el comentario '.$element['id_comentario'].'?\',
							\'?page=admin-validacion-muro&act=muro_ko&id='.$element['id_comentario'].'&pag='.(isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1).'&u='.$element['user_comentario'].'\')">
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
			Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
		</div>
		<?php menu::adminMenu();?>
	</div>
	<?php
}
?>