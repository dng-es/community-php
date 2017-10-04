<?php
function graphEmocion($user_graph = true, $tiendas_graph = false, $destination = "emociones"){ ?>
	<div class="row">
		<div class="col-md-12 panel-header-form">
			<?php $filtro_fecha = searchGraph($destination);?>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-body">
			<?php showGraph($user_graph, $tiendas_graph, $filtro_fecha);?>
		</div>
	</div>
<?php } 

function showGraph($user_graph, $tiendas_graph, $filtro_fecha, $filtro_user = ""){
	$emociones = new emociones();
	$elements = $emociones->getEmociones(" AND active=1 ");

	if ($user_graph) printGraph($elements, $user_graph, $tiendas_graph, $filtro_fecha, $filtro_user);
	if ($tiendas_graph) printGraph($elements, $user_graph, $tiendas_graph, $filtro_fecha, $filtro_user);
}

function searchGraph($destination){
	//Semana 1
	$semana1 = semanaFecha(date("Y"), date("m"), date("d"));

	//Semana 2
	$nuevafechaIni = strtotime ( '-7 day' , strtotime ( $semana1[0][0] ) );
	$semana2 = semanaFecha(date ( 'Y' , $nuevafechaIni ), date ( 'm' , $nuevafechaIni ), date ( 'd' , $nuevafechaIni ));

	//Semana 3
	$nuevafechaIni = strtotime ( '-14 day' , strtotime ( $semana1[0][0] ) );
	$semana3 = semanaFecha(date ( 'Y' , $nuevafechaIni ), date ( 'm' , $nuevafechaIni ), date ( 'd' , $nuevafechaIni ));

	//Semana 4
	$nuevafechaIni = strtotime ( '-21 day' , strtotime ( $semana1[0][0] ) );
	$semana4 = semanaFecha(date ( 'Y' , $nuevafechaIni ), date ( 'm' , $nuevafechaIni ), date ( 'd' , $nuevafechaIni ));

	if(isset($_POST['semana']) && $_POST['semana'] != "") $filtro_fecha = $_POST['semana'];
	elseif(isset($_REQUEST['i']) && $_REQUEST['i'] != "") $filtro_fecha = $_REQUEST['i'];
	else $filtro_fecha = " '".trim($semana1[0][0])."' AND '".trim($semana1[1][0])."'";
	?>
	<form id="formEmociones" role="form" action="<?php echo $destination;?>" method="post">
		<?php if(isset($_REQUEST['id'])):?>
			<input type="hidden" name="id" value="<?php echo sanitizeInput($_REQUEST['id']);?>">
		<?php endif?>
		<label for="semana">Selecciona la semana</label>
		<select class="form-control" id="semana" name="semana">
			<option <?php echo (isset($filtro_fecha) && trim($filtro_fecha) == "'".$semana1[0][0]."' AND '".$semana1[1][0]."'") ? 'selected="selected" ' : '';?> value=" '<?php echo $semana1[0][0];?>' AND '<?php echo $semana1[1][0];?>' ">semana del <?php echo $semana1[0][1];?> al <?php echo $semana1[1][1];?></option>
			<option <?php echo (isset($filtro_fecha) && trim($filtro_fecha) == "'".$semana2[0][0]."' AND '".$semana2[1][0]."'") ? 'selected="selected" ' : '';?> value=" '<?php echo $semana2[0][0];?>' AND '<?php echo $semana2[1][0];?>' ">semana del <?php echo $semana2[0][1];?> al <?php echo $semana2[1][1];?></option>
			<option <?php echo (isset($filtro_fecha) && trim($filtro_fecha) == "'".$semana3[0][0]."' AND '".$semana3[1][0]."'") ? 'selected="selected" ' : '';?> value=" '<?php echo $semana3[0][0];?>' AND '<?php echo $semana3[1][0];?>' ">semana del <?php echo $semana3[0][1];?> al <?php echo $semana3[1][1];?></option>
			<option <?php echo (isset($filtro_fecha) && trim($filtro_fecha) == "'".$semana4[0][0]."' AND '".$semana4[1][0]."'") ? 'selected="selected" ' : '';?> value=" '<?php echo $semana4[0][0];?>' AND '<?php echo $semana4[1][0];?>' ">semana del <?php echo $semana4[0][1];?> al <?php echo $semana4[1][1];?></option>
		</select>
	</form>
<?php 
	return $filtro_fecha;
}

function printGraph($elements, $user_graph = true, $tiendas_graph = false, $filtro_fecha, $filtro_user = ""){
	$emociones = new emociones(); 
	$maximo = 0;
	$i = 0;
	$ancho_bar = str_replace(",", ".", (100 / count($elements)));

	$id_tienda = (isset($_REQUEST['id']) ? $_REQUEST['id'] : '');
	$id_tienda = (isset($_POST['id']) ? $_POST['id'] : $id_tienda);


	//filtro tienda/s
	if($user_graph){
		$filtro_tienda_total = " AND u.empresa='".$_SESSION['user_empresa']."' ";
	}
	else{
		$filtro_tienda_total = "";
		//Filtro según perfil
		if ($_SESSION['user_perfil'] == 'responsable') $filtro_tienda_total = " AND u.empresa IN (SELECT cod_tienda FROM users_tiendas WHERE responsable_tienda='".$_SESSION['user_name']."') ";
		if ($_SESSION['user_perfil'] == 'regional') $filtro_tienda_total = " AND u.empresa IN (SELECT cod_tienda FROM users_tiendas WHERE regional_tienda='".$_SESSION['user_name']."') ";
		
		//$filtro_tienda_total .= ($id_tienda != '' ? " AND u.empresa='".sanitizeInput($id_tienda)."' " : "");		
	}
	foreach($elements as $element):
		$emociones_total = connection::countReg("emociones_user eu, users u ", $filtro_tienda_total." AND u.username=eu.user_emocion AND id_emocion=".$element['id_emocion']." AND date_emocion BETWEEN ".$filtro_fecha." ");
		$maximo = ($emociones_total > $maximo ? $emociones_total : $maximo);		
	endforeach;?>

	<div class="container-centro">
		<div id="emociones-graph-container">
			<div id="emociones-graph-container-bar">
				<?php if($maximo > 0):?>
				<span class="graph-y" style="bottom: 300px"><?php echo $maximo;?></span>
				<span class="graph-y" style="bottom: 225px"><?php echo round($maximo/2, 2) + round($maximo/4, 2);?></span>
				<span class="graph-y" style="bottom: 150px"><?php echo round($maximo/2, 2);?></span>
				<span class="graph-y" style="bottom: 75px"><?php echo round($maximo/4, 2);?></span>
				<?php endif;?>
			</div>

			<div id="graph-y-container">
				<?php if($maximo > 0):?>
				<div style="bottom: 300px"></div>
				<div style="bottom: 225px"></div>
				<div style="bottom: 150px"></div>
				<div style="bottom: 75px"></div>
				<?php endif;?>
			</div>
			<?php foreach($elements as $element):		
				printGraphItem($user_graph, $tiendas_graph, $element, $ancho_bar, $i, $maximo, $id_tienda, $filtro_fecha, $filtro_tienda_total, $filtro_user);
				$i++;
			endforeach; ?>
		</div>
		<?php printGraphLegend($user_graph, $tiendas_graph);?>
	</div>
<?php } 

function printGraphItem($user_graph, $tiendas_graph, $element, $ancho_bar, $i, $maximo, $id_tienda, $filtro_fecha, $filtro_tienda_total, $filtro_user){
	$emociones_total = connection::countReg("emociones_user eu, users u ", $filtro_tienda_total." AND u.username=eu.user_emocion AND id_emocion=".$element['id_emocion']." AND date_emocion BETWEEN ".$filtro_fecha." ");

	if($user_graph){
		$emociones_usuario = connection::countReg("emociones_user e, users u", $filtro_user." AND u.username=e.user_emocion AND id_emocion=".$element['id_emocion']." AND user_emocion='".$_SESSION['user_name']."' AND date_emocion BETWEEN ".$filtro_fecha." ");
		$link_emocion = "emociones?ide=".$element['id_emocion']."&i=".$filtro_fecha;
	}
	else{
		$filtro_responsable = "";
		//Filtro según perfil
		if ($_SESSION['user_perfil'] == 'responsable') 
			$filtro_responsable = " AND u.empresa IN (SELECT cod_tienda FROM users_tiendas WHERE responsable_tienda='".$_SESSION['user_name']."') ";
		
		if ($_SESSION['user_perfil'] == 'regional') 
			$filtro_responsable = " AND u.empresa IN (SELECT cod_tienda FROM users_tiendas WHERE regional_tienda='".$_SESSION['user_name']."') ";
		
		//filtro tienda
		$filtro_tienda = ($id_tienda != '' ? " AND u.empresa='".sanitizeInput($id_tienda)."' " : "");
		$link_emocion = "emociones-responsable?ide=".$element['id_emocion']."&i=".$filtro_fecha."&id=".$id_tienda;
		$emociones_usuario = connection::countReg("emociones_user e, users u ", $filtro_user." AND u.username=e.user_emocion AND id_emocion=".$element['id_emocion']." ".$filtro_responsable.$filtro_tienda." AND date_emocion BETWEEN ".$filtro_fecha." ");
	}

	$altura_user = ($maximo > 0 ? round(($emociones_usuario * 300) / $maximo, 0) : 0);
	$altura_total = ($maximo > 0 ? round(($emociones_total * 300) / $maximo, 0) : 0);
	?>
	<div style="width: <?php echo $ancho_bar;?>%;float:left;">
		<div style="height:350px; position:relative;padding-left:<?php echo ($i==0) ? '44' : '32';?>px;border-bottom:1px solid #999">
			<div class="graph-bar graph-bar-user" data-height="<?php echo $altura_user;?>px" title="<?php echo $emociones_usuario;?>"></div>
			<div class="graph-bar graph-bar-total" data-height="<?php echo $altura_total;?>px" style="<?php echo ($i==0) ? 'left: 55px' : '';?>" title="<?php echo $emociones_total;?>"></div>
		</div>
		<div>
			<div class="graph-bottom" style="margin-left: <?php echo ($i==0) ? '44' : '32';?>px;"></div>
			<a href="<?php echo $link_emocion;?>"><img class="emocion-graph-img" style="height: 35px; top:-5px; position: relative; left: 15px; <?php echo ($i==0) ? 'margin-left: 12px' : '';?>" src="images/emociones/<?php echo $element['image_emocion'];?>"  title="<?php echo $element['name_emocion'];?>" /></a>
		</div>
	</div>
<?php } 

function printGraphLegend($user_graph, $tiendas_graph){?>
	<div class="emociones-legend">
		<div class="row">
			<?php if($user_graph):?>
			<div class="col-md-6"><span class="graph-total-user"></span> tu estado de ánimo</div>
			<div class="col-md-6"><span class="graph-total-all"></span> total de usuarios</div><br />
			<?php else:?>
			<div class="col-md-6"><span class="graph-total-user"></span> estado de ánimo de la tienda</div>
			<div class="col-md-6"><span class="graph-total-all"></span> total de usuarios</div><br />		
			<br /><span class="text-muted">El total es respecto a todas las tiendas bajo tu jerarquía.</span>
			<?php endif?>
			<br /><span class="text-muted">Pincha en la emoción para ver el detalle.</span>
		</div>
	</div>
<?php } ?>