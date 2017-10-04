<?php
$perfiles_autorizados = array("admin", "responsable", "regional");
session::AccessLevel($perfiles_autorizados);

templateload("graph", "emociones");

addJavascripts(array(getAsset("emociones")."js/emociones-graph.js"));
addCss(array(getAsset("emociones")."css/styles.css"));

$id_tienda = (isset($_REQUEST['id']) ? $_REQUEST['id'] : '');
$id_tienda = (isset($_POST['id']) ? $_POST['id'] : $id_tienda);
$id_tienda = sanitizeInput($id_tienda);

if ($id_tienda == ''){
	//Filtro según perfil
	$filtro_empresa = "";
	if ($_SESSION['user_perfil'] == 'responsable') $filtro_empresa = " AND u.empresa IN (SELECT cod_tienda FROM users_tiendas WHERE responsable_tienda='".$_SESSION['user_name']."') ";
	if ($_SESSION['user_perfil'] == 'regional') $filtro_empresa = " AND u.empresa IN (SELECT cod_tienda FROM users_tiendas WHERE regional_tienda='".$_SESSION['user_name']."') ";
}
else{
	$filtro_empresa = " AND u.empresa='".$id_tienda."' ";
}

$title = ($id_tienda != '' ? " ".strtolower(strTranslate("Group_user")).": <b>".$id_tienda."</b>" : " ".strtolower(strTranslate("Group_user")));
$elements = emocionesController::getListUserAction(20, " AND e.active=1 ".$filtro_empresa);

?>
<div class="row row-top">
	<br />
	<div class="row">
		<div class="col-md-5 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-body">
					<h2><?php echo strTranslate("Emotions_history").$title;?></h2>
					<a class="pull-right" href="emociones-home"><small>Nueva emoción <i class="fa fa-angle-double-right" aria-hidden="true"></i></small></a>
					<div class="table-responsive">
						<table class="table table-striped">	
							<?php foreach($elements['items'] as $element):?>
								<tr>
								<td nowrap="nowrap" width="60px">
									<img style="height: 50px" src="images/emociones/<?php echo $element['image_emocion'];?>" />
								</td>					
								<td>
									<b><?php echo $element['name_emocion'];?></b><br />
									<?php echo $element['desc_emocion_user'];?>
									<small class="text-muted pull-right"><b><?php echo $element['user_emocion'];?></b> | <?php echo $element['name'];?> <?php echo $element['surname'];?> | <?php echo $element['empresa'];?></small><br />
									<small class="text-muted pull-right"><?php echo ucfirst(getDateFormat($element['date_emocion'], "LONG"));?> - 
									<?php echo getDateFormat($element['date_emocion'], 'TIME');?></small>
								</td>
								</tr>
							<?php endforeach;?>
						</table>
					</div>
					<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
				</div>
			</div>
		</div>
		<div class="col-md-5">
			<?php graphEmocion(false, true, "emociones-responsable");?>
		</div>
	</div>
</div>