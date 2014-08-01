<?php
//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_select=5;

function ini_page_header ($ini_conf) {?>

<?php }
function ini_page_body ($ini_conf){

	session::getFlashMessage( 'actions_message' ); 
	campaignsController::deleteAction();
	$elements = campaignsController::getListAction(20);

	?>
	<div class="row row-top">
	  	<div class="col-md-9"> 
	  		<h1>Campañas</h1>
  			<nav class="navbar navbar-default" role="navigation">
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		            <ul class="nav navbar-nav">       
		              <li><a href="?page=admin-campaign&act=new">Nueva campaña</a></li>
		            </ul>
  				</div>
        	</nav>
        	<p>Total <b><?php echo $elements['total_reg'];?></b> registros</p>
			<table class="table">
				<tr>
					<th width="40px">&nbsp;</th>
					<th>Nombre</th>
					<th>Tipo</th>
					<th>Descripcion</th>
					<th>Novedad</th>
				</tr>
				<?php foreach($elements['items'] as $element): ?>
					<tr>
					<td nowrap="nowrap">
						<a class="fa fa-edit icon-table" title="Ver/editar"
							onClick="location.href='?page=admin-campaign&id=<?php echo $element['id_campaign'];?>'; return false;">
						</a>

						<a class="fa fa-ban icon-table" title="Eliminar"
							onClick="Confirma('¿Seguro que deseas eliminar la campaña?', '?page=admin-campaigns&pag=<?php echo $elements['pag'];?>&act=del&id=<?php echo $element['id_campaign'];?>'); return false;">
						</a>
					</td>			
					<td><?php echo $element['name_campaign'];?></td>
					<td><?php echo $element['tipo'];?></td>
					<td><?php echo $element['desc_campaign'];?></td>
					<td align="center"><span class="label<?php echo ($element['novedad']==0 ? " label-warning" : " label-success");?>"><?php echo ($element['novedad']==0 ? "No" : "Sí");?></span></td>
					</tr>
				<?php endforeach;?>
			</table>
			<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
		</div>
		<?php menu::adminMenu();?>
	</div>
<?php
}
?>