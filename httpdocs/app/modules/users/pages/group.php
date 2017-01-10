<?php
//addJavascripts(array(getAsset("users")."js/group.js"));
addJavascripts(array(getAsset("alerts")."js/alerts.js"));

templateload("panels", "alerts");

$cod_empresa = (isset($_REQUEST['id']) ? $_REQUEST['id'] : "");
session::getFlashMessage('actions_message'); 
usersController::deleteAction();
$elements = usersController::getListAction(35, " AND empresa='".$cod_empresa."' AND disabled=0 ");
$elements['items'] = arraySort($elements['items'], 'perfil', SORT_ASC);
$empresa = usersTiendasController::getItemAction($cod_empresa);
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Group_user"), "ItemClass"=>"active"),
		));
		?>
		<div class="row">
			<div class="col-md-7">
				<div class="table-responsive">
					<table class="table table-striped table-hover">	
						<?php foreach($elements['items'] as $element):
								$foto = usersController::getUserFoto($element['foto']); ?>
								<tr>
									<td width="50px"><img src="<?php echo $foto;?>" class="comment-mini-img" /></td>
									<td>
										<span class="pull-right label <?php echo ($element['perfil'] == 'responsable' ? 'label-success' : 'label-warning');?>"><?php echo $element['perfil'];?></span>
										<a href="user-profile?n=<?php echo $element['nick'];?>"><?php echo $element['nick'];?></a> - <?php echo $element['name'].' '.$element['surname'];?>
										<p class="text-muted"><?php echo $element['email'];?></p>
									</td>
									<td><?php $element['nombre_tienda'];?></td>
								</tr>
						<?php endforeach; ?>
					</table>
				</div>
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
			</div>
			<div class="col-md-5">
				<div class="panel panel-default">
					<div class="panel-body">
						<h3><?php echo $empresa['nombre_tienda'];?></h3>
						<p>
							<?php echo $empresa['direccion_tienda'];?><br />
							<?php echo $empresa['cpostal_tienda'];?> <?php echo $empresa['ciudad_tienda'];?> - <?php echo $empresa['provincia_tienda'];?>
						</p>
						<p class="text-muted">
							<?php echo $empresa['telefono_tienda'];?><br />
							<?php echo $empresa['email_tienda'];?>
						</p>
					</div>
				</div>
				<?php panelAlerts();?>
			</div>
		</div>
	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<p class="text-center"><i class="fa fa-envelope fa-big"></i></p>
		</div>
	</div>
</div>