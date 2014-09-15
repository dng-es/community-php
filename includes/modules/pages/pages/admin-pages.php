<?php
//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);

session::getFlashMessage( 'actions_message' ); 
pagesController::deleteAction();
$elements = pagesController::getListAction(3);
?>

<div class="row row-top">
	<div class="col-md-9">
		<h1>Gestion de páginas</h1>
		<nav class="navbar navbar-default" role="navigation">
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">       
					<li><a href="?page=admin-page">Nueva página</a></li>
				</ul>
			</div>
		</nav>

		<p>Total <b><?php echo $elements['total_reg'];?></b> registros</p>
		<table class="table">
		<tr>
		<th width="40px">&nbsp;</th>
		<th>Nombre</th>
		</tr>		
		<?php foreach($elements['items'] as $element): ?>
			<tr>
			<td nowrap="nowrap">
				<span class="fa fa-edit icon-table" title="Ver/editar"
					onClick="location.href='?page=admin-page&p=<?php echo $element['page_name'];?>'">
				</span>

				<span class="fa fa-ban icon-table" title="Eliminar"
					onClick="Confirma('¿Seguro que deseas eliminar la página?', '?page=admin-pages&pag=<?php echo $pag;?>&act=del&id=<?php echo $element['page_name'];?>')">
				</span>
			</td>						
			<td><?php echo $element['page_name'];?></td>
			</tr>
		<?php endforeach; ?>
		</table>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>