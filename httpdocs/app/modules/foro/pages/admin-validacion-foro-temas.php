<?php
foroController::exportTemasAction();

addJavascripts(array(getAsset("foro")."js/admin-validacion-foro-temas.js"));

$filtro_temas = (isset($_POST['tipo_search']) and $_POST['tipo_search'] != "") ? " AND tipo_tema LIKE '%".$_POST['tipo_search']."%' " : "";
$find_tipo = (isset($_POST['tipo_search']) and $_POST['tipo_search'] != "") ? $_POST['tipo_search'] : "";

if (isset($_POST['find_reg'])) {
	$filtro_temas .= " AND nombre LIKE '%".$_POST['find_reg']."%' ";
	$find_reg = $_POST['find_reg'];
}
if (isset($_REQUEST['f'])) {
	$filtro_temas .= " AND nombre LIKE '%".$_REQUEST['f']."%' ";
	$find_reg = $_REQUEST['f'];
}

session::getFlashMessage( 'actions_message' );
foroController::cancelTemaAction();
foroController::changeTipoAction();
$elements = foroController::getListTemasAction(15, " AND id_tema_parent<>0 AND activo=1 and itinerario='' ".$filtro_temas." ORDER BY id_tema DESC ");?>

<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Forums"), "ItemUrl"=>"#"),
			array("ItemLabel"=>"Temas en los foros", "ItemClass"=>"active"),
		));?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default"> 
					<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'], "admin-validacion-foro-temas", "searchForm", strTranslate("Search"), strTranslate("Search"), "", "navbar-form navbar-left");?>	
					</div>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="40px">&nbsp;</th>
							<th>ID</th>
							<th><?php echo strTranslate("Name");?></th>
							<th><?php echo strTranslate("Author");?></th>
							<th><?php echo strTranslate("Channel");?></th>
							<th><span class="fa fa-comment" title="<?php echo strTranslate("Comments");?>"></span></th>
							<th><span class="fa fa-eye" title="<?php echo strTranslate("Visits");?>"></span></th>
						</tr>

						<?php foreach($elements['items'] as $element):
						$num_comentarios = connection::countReg("foro_comentarios", " AND estado=1 AND id_tema=".$element['id_tema']." ");
						$num_visitas = connection::countReg("foro_visitas", " AND id_tema=".$element['id_tema']." ");	  
						echo '<tr>';
						echo '<td nowrap="nowrap">
								<span class="fa fa-ban icon-table" title="Eliminar" 
									onClick="Confirma(\'¿Seguro que desea eliminar el tema '.$element['id_tema'].'?\',
									\'admin-validacion-foro-temas?pag='.(isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1).'&act=tema_ko&id='.$element['id_tema'].'&u='.$element['user'].'\')">
								</span>

								<span class="fa fa-download icon-table" title="Exportar datos"
									onClick="location.href=\'admin-validacion-foro-temas?export=true&id='.$element['id_tema'].'\'">
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
						$responsables = ($element['responsables'] == 1 ? 'SI' : 'NO');
						echo '<td>'.$element['nombre'];
						echo '<br /><em class="text-muted"><small>'.getDateFormat($element['date_tema'], "LONG").'</small></em>';
						echo '</td>';
						echo '<td>'.$element['user'].'</td>';
						echo '<td>'.$element['canal'].'</td>';
						echo '<td align="center">'.$num_comentarios.'</td>';
						echo '<td align="center">'.$num_visitas.'</td>';
						echo '</tr>';
					endforeach;?>
					</table>
				</div>
				<br />
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $find_reg);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>

<?php
function SearchTemas($tipo_tema){
	$marcado = ($marca_tipo == 1 ? ' checked="checked" ' : '');
	?>
	<form name="SearchTemas" id="SearchTemas" action="" method="post" role="form">
		<select name="tipo_search" id="tipo_search" class="form-control">
		<option value="">---Todos---</option>
		<?php ComboTiposTemas($tipo_tema);?>
		</select>
		<br />
		<button type="submit" id="find-btn" class="btn btn-primary">buscar</button>
	</form>
<?php }
?>