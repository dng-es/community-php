<?php
//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);

//EXPORT TIENDAS
usersTiendasController::exportListAction();  
?>

<div class="row row-top">
	<div class="col-md-9">
		<h1>Listado de tiendas</h1>
		<?php
		session::getFlashMessage( 'actions_message' ); 
		$elements = usersTiendasController::getListAction(15);
		?>
		<ul class="nav nav-pills navbar-default">
			<li class="disabled"><a href="#">Total <b><?php echo $elements['total_reg'];?></b> registros</a></li>       
			<div class="pull-right">
				<?php SearchForm($reg,"?page=users-tiendas","searchForm","buscar tienda","Buscar","","navbar-form navbar-left");?>
			</div>
		</ul>
		<div class="table-responsive">
			<table class="table">
				<tr>
					<th>Cód.</th>
					<th>Nombre</th>
					<th>Regional</th>   
					<th>Responsable</th>
					<th>Tipo.</th>
				</tr>
				<?php foreach($elements['items'] as $element):?>
				<tr>			
					<td><?php echo $element['cod_tienda'];?></td>
					<td><?php echo $element['nombre_tienda'];?></td>
					<td><?php echo $element['regional_tienda'];?></td>	
					<td><?php echo $element['responsable_tienda'];?></td>
					<td><?php echo $element['tipo_tienda'];?></td>
				</tr>   
			<?php endforeach;?>
			</table>
		</div>
	<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>