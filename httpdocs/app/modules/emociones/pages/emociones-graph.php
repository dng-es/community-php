<?php
addJavascripts(array(getAsset("emociones")."js/mociones-graph.js"));

$elements = emocionesController::getListAction(2000, " AND active=1 ");

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

if(isset($_POST['semana']) and $_POST['semana']!="") $filtro_fecha = $_POST['semana'];
else $filtro_fecha = " '".trim($semana1[0][0])."' AND '".trim($semana1[1][0])."'";

?>
<div class="row row-top">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="col-md-12">
				<div id="page-info">¿cómo has estado?</div>
				<div class="clearfix"></div>
				<br />
				<form id="formEmociones" role="form" action="?page=emociones-graph" method="post">
				<select class="form-control" id="semana" name="semana">
					<option <?php echo (isset($_POST['semana']) and $_POST['semana']==" '".$semana1[0][0]."' AND '".$semana1[1][0]."' ") ? 'selected="selected" ' : '';?> value=" '<?php echo $semana1[0][0];?>' AND '<?php echo $semana1[1][0];?>' ">semana del <?php echo $semana1[0][1];?> al <?php echo $semana1[1][1];?></option>
					<option <?php echo (isset($_POST['semana']) and $_POST['semana']==" '".$semana2[0][0]."' AND '".$semana2[1][0]."' ") ? 'selected="selected" ' : '';?> value=" '<?php echo $semana2[0][0];?>' AND '<?php echo $semana2[1][0];?>' ">semana del <?php echo $semana2[0][1];?> al <?php echo $semana2[1][1];?></option>
					<option <?php echo (isset($_POST['semana']) and $_POST['semana']==" '".$semana3[0][0]."' AND '".$semana3[1][0]."' ") ? 'selected="selected" ' : '';?> value=" '<?php echo $semana3[0][0];?>' AND '<?php echo $semana3[1][0];?>' ">semana del <?php echo $semana3[0][1];?> al <?php echo $semana3[1][1];?></option>
					<option <?php echo (isset($_POST['semana']) and $_POST['semana']==" '".$semana4[0][0]."' AND '".$semana4[1][0]."' ") ? 'selected="selected" ' : '';?> value=" '<?php echo $semana4[0][0];?>' AND '<?php echo $semana4[1][0];?>' ">semana del <?php echo $semana4[0][1];?> al <?php echo $semana4[1][1];?></option>
				</select>
				</form>
			</div>
		</div>
	</div>

	<div class="container-centro">
			<?php 
			$maximo = 0;
			foreach($elements['items'] as $element):
				$emociones_total = connection::countReg("emociones_user", " AND id_emocion=".$element['id_emocion']." AND date_emocion BETWEEN ".$filtro_fecha." ");
				$maximo = ($emociones_total>$maximo ? $emociones_total : $maximo);		
			endforeach;
			?>

			<div id="emociones-graph-container">
				<div id="emociones-graph-container-bar">
	<!-- 					<div>100%</div>
					<div>80%</div>
					<div>60%</div>
					<div>40%</div>
					<div>20%</div> -->
				</div>
				<?php 
				$i=0;
				foreach($elements['items'] as $element):
					$emociones_usuario = connection::countReg("emociones_user", " AND id_emocion=".$element['id_emocion']." AND user_emocion='".$_SESSION['user_name']."' AND date_emocion BETWEEN ".$filtro_fecha." ");
					$emociones_total = connection::countReg("emociones_user", " AND id_emocion=".$element['id_emocion']." AND date_emocion BETWEEN ".$filtro_fecha." ");

					$altura_user = ($emociones_usuario * 300) / $maximo;
					$altura_total = ($emociones_total * 300) / $maximo;
					
					?>
					<div style="width: <?php echo ($i == 0) ? '12' : '11';?>%;float:left;">
						<div style="height:350px; position:relative;padding-left:<?php echo ($i==0) ? '54' : '32';?>px;border-bottom:1px solid #fff">
							<div class="graph-user" style="height: <?php echo $altura_user;?>px" title="<?php echo $emociones_usuario;?>"></div>
							<div class="graph-total" style="height: <?php echo $altura_total;?>px; <?php echo ($i==0) ? 'left: 64px' : '';?>" title="<?php echo $emociones_total;?>"></div>
						</div>
						<div>
							<div style="background-color:#eb5f21;margin-left: <?php echo ($i==0) ? '54' : '32';?>px; width:10px; height:15px;"></div>
							<a href="?page=emociones&id=<?php echo $element['id_emocion'];?>&i=<?php echo $filtro_fecha;?>"><img class="emocion-graph-img" style="height: 50px; top:-5px; <?php echo ($i==0) ? 'margin-left: 22px' : '';?>" src="images/banners/<?php echo $element['image_emocion'];?>"  title="<?php echo $element['name_emocion'];?>" /></a>
						</div>
					</div>
				<?php 
				$i++;
				endforeach;?>
			</div>
			<p>pincha en la emoción para ver el detalle.</p>
			<div class="emociones-legend row">
				<div class="col-md-6"><span style="width:10px; height:10px; background-color:#eb5f21; display:inline-block;margin-right:5px"></span> tu estado de ánimo</div>
				<div class="col-md-6"><span style="width:10px; height:10px; background-color:#fff; display:inline-block;margin-right:5px"></span> total de usuarios</div>
				</div>
			</div>
	</div>
</div>