<?php
addJavascripts(array(getAsset("emociones")."js/emociones-graph.js"));
addCss(array(getAsset("emociones")."css/styles.css"));

function graphEmocion(){ 
	$emociones = new emociones();
	$elements = $emociones->getEmociones(" AND active=1 ");

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
	<div class="row">
		<div class="col-md-12 graph-panel">
			<form id="formEmociones" role="form" action="emociones" method="post">
				<label for="semana">Selecciona la semana</label>
				<select class="form-control" id="semana" name="semana">
					<option <?php echo (isset($_POST['semana']) and $_POST['semana']==" '".$semana1[0][0]."' AND '".$semana1[1][0]."' ") ? 'selected="selected" ' : '';?> value=" '<?php echo $semana1[0][0];?>' AND '<?php echo $semana1[1][0];?>' ">semana del <?php echo $semana1[0][1];?> al <?php echo $semana1[1][1];?></option>
					<option <?php echo (isset($_POST['semana']) and $_POST['semana']==" '".$semana2[0][0]."' AND '".$semana2[1][0]."' ") ? 'selected="selected" ' : '';?> value=" '<?php echo $semana2[0][0];?>' AND '<?php echo $semana2[1][0];?>' ">semana del <?php echo $semana2[0][1];?> al <?php echo $semana2[1][1];?></option>
					<option <?php echo (isset($_POST['semana']) and $_POST['semana']==" '".$semana3[0][0]."' AND '".$semana3[1][0]."' ") ? 'selected="selected" ' : '';?> value=" '<?php echo $semana3[0][0];?>' AND '<?php echo $semana3[1][0];?>' ">semana del <?php echo $semana3[0][1];?> al <?php echo $semana3[1][1];?></option>
					<option <?php echo (isset($_POST['semana']) and $_POST['semana']==" '".$semana4[0][0]."' AND '".$semana4[1][0]."' ") ? 'selected="selected" ' : '';?> value=" '<?php echo $semana4[0][0];?>' AND '<?php echo $semana4[1][0];?>' ">semana del <?php echo $semana4[0][1];?> al <?php echo $semana4[1][1];?></option>
				</select>
			</form>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-body">
			<div class="container-centro">
				<?php 
				$maximo = 0;
				foreach($elements as $element):
					$emociones_total = connection::countReg("emociones_user", " AND id_emocion=".$element['id_emocion']." AND date_emocion BETWEEN ".$filtro_fecha." ");
					$maximo = ($emociones_total>$maximo ? $emociones_total : $maximo);		
				endforeach;?>

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
					<?php 
					$i = 0;
					$ancho_bar = str_replace(",", ".", (100 / count($elements)));
					foreach($elements as $element):
						$emociones_usuario = connection::countReg("emociones_user", " AND id_emocion=".$element['id_emocion']." AND user_emocion='".$_SESSION['user_name']."' AND date_emocion BETWEEN ".$filtro_fecha." ");
						$emociones_total = connection::countReg("emociones_user", " AND id_emocion=".$element['id_emocion']." AND date_emocion BETWEEN ".$filtro_fecha." ");

						$altura_user = round(($emociones_usuario * 300) / $maximo, 0);
						$altura_total = round(($emociones_total * 300) / $maximo, 0);
						//echo "U: ".$altura_user. " - T: ".$altura_total;
						?>
						<div style="width: <?php echo $ancho_bar;?>%;float:left;">
							<div style="height:350px; position:relative;padding-left:<?php echo ($i==0) ? '54' : '32';?>px;border-bottom:1px solid #999">
								<div class="graph-user" style="height: <?php echo $altura_user;?>px" title="<?php echo $emociones_usuario;?>"></div>
								<div class="graph-total" style="height: <?php echo $altura_total;?>px; <?php echo ($i==0) ? 'left: 64px' : '';?>" title="<?php echo $emociones_total;?>"></div>
							</div>
							<div>
								<div class="graph-bottom" style="margin-left: <?php echo ($i==0) ? '54' : '32';?>px;"></div>
								<a href="emociones?id=<?php echo $element['id_emocion'];?>&i=<?php echo $filtro_fecha;?>"><img class="emocion-graph-img" style="height: 50px; top:-5px; position: relative; left: 5px; <?php echo ($i==0) ? 'margin-left: 22px' : '';?>" src="images/banners/<?php echo $element['image_emocion'];?>"  title="<?php echo $element['name_emocion'];?>" /></a>
							</div>
						</div>
						<?php 
						$i++;
					endforeach; ?>
				</div>
				<div class="emociones-legend">
					<div class="row">
						<div class="col-md-6"><span class="graph-total-user"></span> tu estado de ánimo</div>
						<div class="col-md-6"><span class="graph-total-all"></span> total de usuarios</div>
					</div>
					<div class="row">
						<div class="col-md-12"><small class="text-muted">Pincha en la emoción para ver el detalle.</small></div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>