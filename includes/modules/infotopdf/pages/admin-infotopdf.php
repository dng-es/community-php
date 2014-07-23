<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_select=5;
function ini_page_header ($ini_conf) {?>

<?php }
function ini_page_body ($ini_conf){
	//CONTROL NIVEL DE ACCESO
	$perfiles_autorizados = array("admin");
	session::AccessLevel($perfiles_autorizados);

	session::getFlashMessage( 'actions_message' ); 
	infotopdfController::deleteAction();
	$elements = infotopdfController::getListAction(20);
	?>
	<div id="page-info">Gestión de documentos</div>
	<div class="row inset row-top">
		<div class="col-md-12">
			<nav class="navbar navbar-default" role="navigation">
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">       
						<li><a href="?page=admin-infotopdf-doc&act=new">Nuevo documento</a></li>
					</ul>
				</div>
			</nav>
			<table class="table">
				<tr>
					<th width="50px">&nbsp;</th>
					<th>Documento</th>
					<th>Tipo</th>
					<th>Campaña</th>
				</tr>
				<?php foreach($elements['items'] as $element): ?>
				<tr>
					<td nowrap="nowrap">
						  <a href="?page=admin-infotopdf-doc&act=edit&id=<?php echo $element['id_info'];?>" title="Editar documento">
						  <span class="fa fa-edit icon-table"></span></a>
						  <a href="#" onClick="Confirma('¿Seguro que desea eliminar el documento?', '?page=admin-infotopdf&pag=<?php echo $elements['pag'];?>&act=del&d=<?php echo $element['file_info'];?>&id=<?php echo $element['id_info'];?>')" 
						  title="Eliminar documento" /><span class="fa fa-ban icon-table"></span></a>
					   </td>     
					<td><a target="_blank" href="<?php echo PATH_INFO.$element['file_info'];?>"><?php echo $element['titulo_info'];?></a></td>
					<td><?php echo $element['tipo'];?></td>
					<td><?php echo $element['campana'];?></td>
				</tr>   
				<?php endforeach;  ?>
			</table>
			<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
		</div>
	</div>
<?php
}
?>