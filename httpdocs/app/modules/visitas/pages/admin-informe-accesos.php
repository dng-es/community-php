<?php
set_time_limit(0);
ini_set('memory_limit', '-1');

$total1 = 0;
$total2 = 0;
$total3 = 0;
$media1 = 0;
$media2 = 0;
$media3 = 0;

addJavascripts(array("js/bootstrap-datepicker.js", 
					"js/bootstrap-datepicker.es.js", 
					"js/libs/highcharts/highcharts.js",
					"js/libs/highcharts/modules/exporting.js"));

global $total1,$total2,$total3,$media1,$media2,$media3;

if (isset($_POST['generate-stats']) or isset($_POST['export-stats'])):
	$filtro_informe = " AND fecha BETWEEN '".$_POST['fecha_ini']." 00:00:00' AND '".$_POST['fecha_fin']." 23:59:59' ";
	$filtro_empresa = ((isset($_POST['empresa_sel']) && trim($_POST['empresa_sel']) != '') ? " AND empresa_access='".utf8_decode($_POST['empresa_sel'])."' " : "");
	$filtro_empresa_users = ((isset($_POST['empresa_sel']) && trim($_POST['empresa_sel']) != '') ? " AND empresa='".utf8_decode($_POST['empresa_sel'])."' " : "");
	$empresa_sel = $_POST['empresa_sel'];
else:
	$filtro_informe = " AND fecha>=DATE_ADD(NOW(), INTERVAL -1 MONTH) ";
	$filtro_empresa = "";
	$filtro_empresa_users = "";
	$empresa_sel = "";
endif;

$filtro_informe .= " AND perfil_access<>'admin' ".$filtro_empresa;

//TODO - FILTRO DUPLICADOS: se generan duplicados por los redirectURL
$filtro_duplicados = " AND seconds>0 ";

//EXPORT ACCESOS
visitasController::exportAction($filtro_informe.$filtro_duplicados);
visitasController::exportNaAreasAction($filtro_informe);
visitasController::exportGroupAction($filtro_informe." AND webpage<>'Inicio sesion' ");

$users = new users();
$tiendas = $users->getTiendas(" AND cod_tienda<>'' ");

//DATOS VISITAS POR PAGINAS
$elements = visitas::getAccessTopPages($filtro_informe.$filtro_duplicados);
$visitas = 0;
$output_x = "";
$output_y = "";
foreach($elements as $element):
	$visitas+=$element['contador'];
	$output_x .= "'".$element['webpage']."',";
	$output_y .= $element['contador'].",";
endforeach;
$media = round(($visitas/count($elements)),2);
$media1 = str_replace(",", ".",$media);
$total1 = $visitas;
$output_x = substr($output_x, 0, strlen($output_x) - 1);
$output_y = substr($output_y, 0, strlen($output_y) - 1);

//DATOS VISITAS POR HORA
$elements = visitas::getAccessHour($filtro_informe.$filtro_duplicados);
$visitas = 0;
$output_x5 = "";
$output_y5 = "";
foreach($elements as $element):
	$visitas+=$element['contador'];
	$output_x5 .= "'".$element['date_hour']."',";
	$output_y5 .= $element['contador'].",";
endforeach;
$media = round(($visitas/count($elements)), 2);
$media5 = str_replace(",", ".",$media);
$total5 = $visitas;
$output_x5 = substr($output_x5, 0, strlen($output_x5) - 1);
$output_y5 = substr($output_y5, 0, strlen($output_y5) - 1);

//DATOS VISITAS POR DIA
$elements = visitas::getAccessPages($filtro_informe.$filtro_duplicados);
$visitas = 0;
$output_x2 = "";
$output_y2 = "";
foreach($elements as $element):
	$visitas+=$element['contador'];
	$output_y2 .= $element['contador'].",";
	//$output_x2 .= "'".$element['anio']."-".($element['mes'] - 1)."-".$element['dia']."',";
	$output_x2 .= "'".$element['anio']."-".($element['mes'])."-".$element['dia']."',";
endforeach;
$media = round(($visitas/count($elements)), 2);
$output_x2 = substr($output_x2, 0, strlen($output_x2) - 1);
$output_y2 = substr($output_y2, 0, strlen($output_y2) - 1);
$media2 = str_replace(",", ".",$media);
$total2 = $visitas;

//DATOS VISITAS UNICAS
$elements = visitas::getAccessUnique($filtro_informe." AND webpage='Inicio sesion' ");
$visitas = 0;
$output_x3 = "";
$output_y3 = "";
foreach($elements as $element):
	$visitas += $element['contador'];
	$output_y3 .= $element['contador'].",";
	//$output_x3 .= "'".$element['anio']."-".($element['mes'] - 1)."-".$element['dia']."',";
	$output_x3 .= "'".$element['anio']."-".($element['mes'])."-".$element['dia']."',";
endforeach;
$media = round(($visitas/count($elements)), 2);
$output_x3 = substr($output_x3, 0, strlen($output_x3) - 1);
$output_y3 = substr($output_y3, 0, strlen($output_y3) - 1);
$media3 = str_replace(",", ".",$media);
$total3 = $visitas;

//DATOS VISITAS POR NAVEGADOR
$outputBrowser="";
$elements = visitas::getAccessBrowser($filtro_informe.$filtro_duplicados);

foreach($elements as $element):
	$outputBrowser .= '{name: "'.$element['browser'].'",y: '.$element['contador'].'},';
endforeach;
$outputBrowser = substr($outputBrowser, 0, strlen($outputBrowser) - 1);

//DATOS VISITAS POR PLATAFORMA
$outputPlatform = "";
$elements = visitas::getAccessPlatform($filtro_informe.$filtro_duplicados);
foreach($elements as $element):
	$outputPlatform .= '{name: "'.$element['platform'].'",y: '.$element['contador'].'},';
endforeach;
$outputPlatform = substr($outputPlatform, 0, strlen($outputPlatform) - 1);

?>
<script type="text/javascript">
$(function () {
	$("#datetimepicker1, #datetimepicker2").datetimepicker({
	  language: "es-ES"
	});

	$('#containerVisitas').highcharts({
		credits: false,
		chart: {
			type: 'column'
		},
		title: {
			text: 'Páginas visitadas'
		},
		subtitle: {
			text: 'visitas realizadas por página - total: <?php echo $total1;?> - media: <?php echo $media1;?>'
		},
		xAxis: {
			categories: [<?php echo $output_x;?>],
			crosshair: true
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Número de visitas'
			}
		},
		tooltip: {
			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				'<td style="padding:0"><b>{point.y:.0f} páginas</b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
			// ,
	  //       series: {
	  //           cursor: 'pointer',
	  //           point: {
	  //               events: {
	  //                   click: function () {
	  //                       alert('Category: ' + this.category + ', value: ' + this.y);
	  //                   }
	  //               }
	  //           }
	  //       }
		},
		series: [{
			name: 'Visitas',
			data: [<?php echo $output_y;?>],
			dataLabels: {
				enabled: true,
				rotation: -90,
				color: '#FFFFFF',
				align: 'right',
				format: '{point.y:.0f}', // one decimal
				y: 10, // 10 pixels down from the top
				style: {
					fontSize: '10px',
					fontFamily: 'Verdana, sans-serif'
				}
			}
		}]
	});

$('#containerHoras').highcharts({
		credits: false,
		chart: {
			type: 'column'
		},
		title: {
			text: 'Visitas por hora'
		},
		subtitle: {
			text: 'visitas realizadas por hora del servidor - total: <?php echo $total5;?> - media: <?php echo $media5;?>'
		},
		xAxis: {
			categories: [<?php echo $output_x5;?>],
			crosshair: true
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Número de visitas'
			}
		},
		tooltip: {
			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				'<td style="padding:0"><b>{point.y:.0f} páginas</b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}			
		},	
		series: [{
			name: 'Visitas',
			data: [<?php echo $output_y5;?>],
			dataLabels: {
				enabled: true,
				rotation: -90,
				color: '#FFFFFF',
				align: 'right',
				format: '{point.y:.0f}', // one decimal
				y: 10, // 10 pixels down from the top
				style: {
					fontSize: '10px',
					fontFamily: 'Verdana, sans-serif'
				}
			}
		}]
	});

	$('#containerVisitasDias').highcharts({
		credits: false,
		title: {
			text: 'Páginas vistas por día',
			x: -20 //center
		},
		subtitle: {
			text: 'número de paginas - total: <?php echo $total2;?> - media: <?php echo $media2;?>',
			x: -20
		},
		xAxis: {
			categories: [<?php echo $output_x2;?>]
		},
		yAxis: {
			title: {
				text: 'número de visitas'
			},
			plotLines: [{
				value: 0,
				width: 1,
				color: '#808080'
			}]
		},
		tooltip: {
			valueSuffix: ''
		},
		legend: {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'middle',
			borderWidth: 0
		},
		plotOptions: {
			line: {
				dataLabels: {
					enabled: true
				},
				enableMouseTracking: false
			}
		},
		series: [{
			name: 'Visitas',
			data: [<?php echo $output_y2;?>]
		}]
	});


	$('#containerVisitasUnicas').highcharts({
		credits: false,
		title: {
			text: 'Visitas únicas por día',
			x: -20 //center
		},
		subtitle: {
			text: 'número de paginas - total: <?php echo $total3;?> - media: <?php echo $media3;?>',
			x: -20
		},
		xAxis: {
			categories: [<?php echo $output_x3;?>]
		},
		yAxis: {
			title: {
				text: 'número de visitas'
			},
			plotLines: [{
				value: 0,
				width: 1,
				color: '#808080'
			}]
		},
		plotOptions: {
			line: {
				dataLabels: {
					enabled: true
				},
				enableMouseTracking: false
			}
		},
		tooltip: {
			valueSuffix: ''
		},
		legend: {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'middle',
			borderWidth: 0
		},
		series: [{
			name: 'Visitas',
			data: [<?php echo $output_y3;?>]
		}]
	});

	$('#containerBrowser').highcharts({
		credits: false,
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie'
		},
		title: {
			text: 'Visitas por navegador'
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b>: {point.percentage:.1f} %',
					style: {
						color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
					}
				}
			}
		},
		series: [{
			name: "Porcentaje",
			colorByPoint: true,
			data: [<?php echo $outputBrowser;?>]
		}]
	});

	$('#containerPlatform').highcharts({
		credits: false,
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie'
		},
		title: {
			text: 'Visitas por plataforma'
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b>: {point.percentage:.1f} %',
					style: {
						color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
					}
				}
			}
		},
		series: [{
			name: "Porcentaje",
			colorByPoint: true,
			data: [<?php echo $outputPlatform;?>]
		}]
	});
});

</script>
<?php
	global $total1, $total2, $total3, $media1, $media2, $media3;
	$visitas = new visitas();

	//VACIAR LOGS
	if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'del') $visitas->deleteVisitas();

	if (isset($_POST['fecha_ini'])){
		$fecha_ini = $_POST['fecha_ini'];
		$fecha_fin = $_POST['fecha_fin'];
	}
	else{
		$fecha_fin = date('Y-m-d');
		$fecha_ini = strtotime ('-1 month' , strtotime ($fecha_fin)) ;
		$fecha_ini = date ('Y-m-d' , $fecha_ini);
	}?>

	<div class="row row-top">
		<div class="app-main">
			<?php
			menu::breadcrumb(array(
				array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
				array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
				array("ItemLabel"=>strTranslate("Reports"), "ItemUrl"=>"admin"),
				array("ItemLabel"=>strTranslate("Report")." ".strTranslate("Visits"), "ItemClass"=>"active"),
			));
			?>

			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default panel-ranking">
						<div class="panel-body nopadding">
							<div class="row">
								<div class="col-md-8 inset panel-description">
									<?php 
									$num_users = connection::countReg("users", " AND disabled=0 AND registered=1 AND confirmed=1 ".$filtro_empresa_users);
									$tot_users = connection::countReg("users", " AND disabled=0 ".$filtro_empresa_users);
									?>
									<h4>Usuarios activos</h4>
									<div class="text-small">Total usuarios: <?php echo number_format($tot_users, 0, ',', '.');?></div>
									<div class="text-small">Total usuarios activos: <?php echo number_format($num_users, 0, ',', '.');?> (<?php echo round((($num_users * 100) / $tot_users), 2);?>%)</div>
								</div>
								<div class="col-md-4 label-success inset panel-color full-height">
									<p class="text-center"><big><?php echo number_format($num_users, 0, ',', '.');?></big><br />
										<?php e_strTranslate("Users");?>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="panel panel-default panel-ranking">
						<div class="panel-body nopadding">
							<div class="row">
								<div class="col-md-8 inset panel-description">
									<h4><?php e_strTranslate("Groups_user");?> activas</h4>
									<div class="text-small">Total <?php echo strtolower(strTranslate("Groups_user"));?> activas en la comunidad<br /><br /></div>
								</div>
								<div class="col-md-4 label-info inset panel-color full-height">
									<?php 
										$num_empresas = number_format(connection::countReg("users_tiendas", " AND activa=1 "), 0, ',', '.');
									?>
									<p class="text-center"><big><?php echo $num_empresas;?></big><br />
										<?php e_strTranslate("Groups_user");?>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row hidden-print">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-7 nopadding">
									<form name="inf-accesos" id="inf-accesos" method="post" action="<?php echo $_REQUEST['page'];?>" role="form" class="">
										<input type="hidden" name="export_fechas" id="export_fechas" value="1" />

										<div class="row">
											<div class="col-xs-4">
												<label for="fecha_ini">Fecha inicio:</label>
												<div id="datetimepicker1" class="input-group date">
													<input data-format="yyyy/MM/dd" readonly type="text" id="fecha_ini" class="form-control" name="fecha_ini" placeholder="Fecha inicio" value="<?php echo $fecha_ini;?>"></input>
												<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
												</div>
											</div>
											<div class="col-xs-4">
												<label for="fecha_fin">Fecha fin:</label>
												<div id="datetimepicker2" class="input-group date">
													<input data-format="yyyy/MM/dd" readonly type="text" id="fecha_fin" class="form-control" name="fecha_fin" placeholder="Fecha fin" value="<?php echo $fecha_fin;?>"></input>
												<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
												</div>
											</div>

											<div class="col-xs-4">
												<label for="empresa_sel"><?php e_strTranslate("Group_user");?>:</label>
												<select name="empresa_sel" id="empresa_sel" class="form-control">
													<option value="">---<?php e_strTranslate("Choose_group");?>---</option>
													<?php foreach($tiendas as $tienda):?>
														<option <?php echo ($empresa_sel == $tienda['cod_tienda'] ? ' selected="selected" ' : '');?> value="<?php echo $tienda['cod_tienda'];?>"><?php echo $tienda['cod_tienda'];?></option>
													<?php endforeach;?>
												</select>
											</div>
										</div>
										<span id="fecha-alert" class="alert-message alert alert-danger"></span>
									</div>
									<div class="col-md-5">
										<br />
										<button type="submit" class="btn btn-primary btn-xs" name="generate-stats">Generar gráficos</button>
										<button type="submit" class="btn btn-primary btn-xs" name="export-stats">Exportar CSV</button>
										<a href="#" onClick="window.print(); return false;" class="btn btn-primary btn-xs">Imprimir informe</a>
										<!-- <a class="btn btn-primary btn-xs" href="#" onClick="Confirma('¿Seguro que desea eliminar todos los registros?.\nLa información borrada no podrá ser recuperada.', 'admin-informe-accesos?act=del')" title="Vaciar registros" />Vaciar registros</a> -->
									</form>
								</div>
							</div>
							<br /><span class="text-danger text-small"><i class="fa fa-warning"></i> En los informes no se muestran los accesos por los usuarios administradores.</span>
						</div>
					</div>
				</div>
			</div>


			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body nopadding">
							<div id="containerVisitas" class="container-graph"></div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body nopadding">
							<div id="containerHoras" class="container-graph"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body nopadding">
							<div id="containerVisitasDias" class="container-graph"></div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body nopadding">
							<div id="containerVisitasUnicas" class="container-graph"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
					<div class="panel-body nopadding">
							<div id="containerBrowser" class="container-graph"></div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body nopadding">
							<div id="containerPlatform" class="container-graph"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body nopadding">
							<h5 class="text-center"><big>Accesos por <?php e_strTranslate("Group_user");?></big> <small><a href="admin-informe-accesos?export=group">Exportar</a></small></h5>
							<div class="table table-responsive">
								<table class="table table-striped table-hover">
									<tr>
										<th>Tienda</th>
										<th class="text-center"><?php e_strTranslate('Visits_title');?></th>
									</tr>
									<?php 
									$elements = visitas::getAccessGroup($filtro_informe." AND webpage<>'Inicio sesion' ");
									foreach($elements as $element):?>
										<tr>
											<td><?php echo utf8_encode($element[strTranslate('Name')]);?></td>
											<td class="text-center"><?php echo $element[strTranslate('Visits_title')];?></td>
										</tr>
									<?php endforeach;?>
								</table>
							</div>
						</div>
					</div>
				</div>
				<?php if(getModuleExist("na_areas")):?>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body nopadding">
							<h5 class="text-center"><big>Accesos a <?php e_strTranslate("Na_areas");?></big> <small><a href="admin-informe-accesos?export=na_areas">Exportar</a></small></h5>
							<div class="table table-responsive">
								<table class="table table-striped table-hover">
									<tr>
										<th>ID</th>
										<th><?php e_strTranslate("Na_areas");?></th>
										<th class="text-center"><?php e_strTranslate('Visits_title');?></th>
									</tr>
									<?php 
									$elements = visitas::getAccessNaAreas($filtro_informe);
									foreach($elements as $element):?>
										<tr>
											<td><?php echo $element['webpage_id'];?></td>
											<td><?php echo $element[strTranslate('Na_areas')];?></td>
											<td class="text-center"><?php echo $element[strTranslate('Visits_title')];?></td>
										</tr>
									<?php endforeach;?>
								</table>
							</div>
						</div>
					</div>
				</div>
			<?php endif;?>
			</div>
		</div>
	<?php menu::adminMenu();?>
</div>