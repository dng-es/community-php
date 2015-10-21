<?php
templateload("cmbAlbumes","fotos");

addJavascripts(array(getAsset("fotos")."js/admin-validacion-fotos.js"));

//VALIDAR CONTENIDOS
if (isset($_REQUEST['act'])){
	$users = new users();
	$fotos = new fotos();

	if ($_REQUEST['act'] == 'foto_ok'){
		$fotos->cambiarEstado($_REQUEST['id'], 1);
		$fotos->updateFotoAlbum($_REQUEST['id'], $_REQUEST['ida']);
		$users->sumarPuntos($_REQUEST['u'], PUNTOS_FOTO,PUNTOS_FOTO_MOTIVO);
	}
	elseif ($_REQUEST['act'] == 'foto_ko') $fotos->cambiarEstado($_REQUEST['id'], 2, 0);

	header("Location: admin-validacion-fotos"); 
}

$fotos = new fotos();
$pendientes = $fotos->getFotos(" AND estado=0 AND id_promocion=0 ");
$albumes = $fotos->getFotosAlbumes(" AND activo=1 ORDER BY nombre_album");?>

<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Photos"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Photo_validation"), "ItemClass"=>"active"),
		));?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default"> 
					<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo count($pendientes);?></b> <?php echo strtolower(strTranslate("Items"));?>. <?php echo ucfirst(strTranslate("APP_points"));?> a otorgar por foto: <b><?php echo PUNTOS_FOTO;?></b></a></li>
				</ul>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="40px">&nbsp;</th>
							<th>Álbum</th>
							<th><?php echo strTranslate("Author");?></th>
							<th><?php echo strTranslate("Channel");?></th>
							<th><?php echo strTranslate("Title");?></th>
							<th><?php echo strTranslate("Date");?></th>
						</tr>
						<?php foreach($pendientes as $element):
							echo '<tr>';
							echo '<td nowrap="nowrap">
									<span class="fa fa-ban icon-table" onClick="Confirma(\''.strTranslate("Are_you_sure_to_delete").'\',
										\'admin-validacion-fotos?act=foto_ko&id='.$element['id_file'].'&u='.$element['user_add'].'\')" 
										title="'.strTranslate("Delete").'" />
									</span>

									<span class="fa fa-check-circle icon-table trigger-validar" data-id="'.$element['id_file'].'" data-user="'.$element['user_add'].'"	title="Validar" />
									</span>';
							echo'</td>';
							echo '<td>';
							ComboAlbumes(0, $albumes, "nombre_album_" .$element['id_file']);
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
									        <h4 class="modal-title" id="myModalLabel">'.strTranslate("Photo").'</h4>
									      </div>
									      <div class="modal-body">
											<img src="'.PATH_FOTOS.$element['name_file'].'" class="galeria-fotos" style="width:100%" />
									      </div>
									    </div><!-- /.modal-content -->
									  </div><!-- /.modal-dialog -->
									</div><!-- /.modal -->

								 </td>';
							echo '<td>'.getDateFormat($element['date_foto'], "SHORT").'</td>';
							echo '</tr>';   
						endforeach;?>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>