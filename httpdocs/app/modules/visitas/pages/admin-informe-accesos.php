<?php
set_time_limit(0);
ini_set('memory_limit', '-1');

//EXPORT ACCESOS
visitasController::exportAction();

$total1=0;
$total2=0;
$total3=0;
$media1=0;
$media2=0;
$media3=0;
$pagina_excluidas = "'admin','admin-informe-accesos','admin-informe-participaciones', 'admin-informe-puntuaciones','admin-users','admin-user','admin-users-tiendas','cargas-users','admin-area','admin-message','Inicio sesion','admin-validacion-foro',
					 'admin-messages','admin-message-proccess','admin-message-proccess-step1',
					 'admin-areas','admin-area-revs','admin-area-form','admin-area-docs','admin-config','admin-page', 'admin-puntos','admin-mystery','admin-validacion-fotos',
					 'admin-campaigns-types','admin-campaigns','admin-infotopdf-doc','admin-intotopdf','admin-validacion-foto-temas','admin-cuestionarios','admin-cuestionario','admin-cuestionario-revs',
					 'admin-videos','admin-premios','cargas-puntos-process','admin-pages','admin-novedades','admin-blog-new','admin-destacados','admin-validacion-foro-temas',
					 'admin-blog-foro','admin-modules','admin-campaign','admin-validacion-foro-comentarios','admin-blog','admin-templates','admin-validacion-videos',
					 'cargas-horas-process','admin-fotos-comentarios','admin-info','admin-info-doc','admin-canales','admin-canal','admin-cargas-tiendas','admin-validacion-muro','admin-albumes',
					 'admin-videos-comentarios','admin-cargas-users'";
					 
addJavascripts(array("js/bootstrap-datepicker.js", 
					 "js/bootstrap-datepicker.es.js", 
					 "js/libs/highcharts/highcharts.js",
					 "js/libs/highcharts/modules/exporting.js"));

global $total1,$total2,$total3,$media1,$media2,$media3,$pagina_excluidas;

if (isset($_POST['generate-stats']) and !isset($_POST['export-stats'])):
	$filtro_informe=" AND fecha BETWEEN '".$_POST['fecha_ini']." 00:00:00' AND '".$_POST['fecha_fin']." 23:59:59' ";
else:
	$filtro_informe = " AND fecha>=DATE_ADD(NOW(), INTERVAL -1 MONTH) ";
endif;


$visitas = new visitas();
//DATOS VISITAS POR PAGINAS
$filtro = $filtro_informe." AND webpage NOT IN (".$pagina_excluidas.") ";
$elements = $visitas->getAccessTopPages($filtro);
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
$output_x = substr($output_x, 0,strlen($output_x)-1);
$output_y = substr($output_y, 0,strlen($output_y)-1);


//DATOS VISITAS POR DIA
 $elements = visitas::getAccessPages($filtro_informe." AND webpage NOT IN (".$pagina_excluidas.") ");
 $visitas = 0;
 $output_x2 = "";
 $output_y2 = "";
 foreach($elements as $element):
	$visitas+=$element['contador'];
	$output_y2 .= $element['contador'].",";
	$output_x2 .= "'".$element['anio']."-".($element['mes']-1)."-".$element['dia']."',";
 endforeach;
$media = round(($visitas/count($elements)),2);
$output_x2 = substr($output_x2, 0,strlen($output_x2)-1);
$output_y2 = substr($output_y2, 0,strlen($output_y2)-1);
$media2 = str_replace(",", ".",$media);
$total2 = $visitas;


//DATOS VISITAS UNICAS
$elements = visitas::getAccessUnique($filtro_informe." AND webpage='Inicio sesion' ");
$visitas = 0;
$output_x3 = "";
$output_y3 = "";
foreach($elements as $element):
	$visitas+=$element['contador'];
	$output_y3 .= $element['contador'].",";
	$output_x3 .= "'".$element['anio']."-".($element['mes']-1)."-".$element['dia']."',";
endforeach;
$media = round(($visitas/count($elements)),2);
$output_x3 = substr($output_x3, 0,strlen($output_x3)-1);
$output_y3 = substr($output_y3, 0,strlen($output_y3)-1);
$media3 = str_replace(",", ".",$media);
$total3 = $visitas;


//DATOS VISITAS POR NAVEGADOR
$outputBrowser="";
$elements = visitas::getAccessBrowser($filtro_informe." AND webpage NOT IN (".$pagina_excluidas.") ");

foreach($elements as $element):
	$outputBrowser.='{name: "'.$element['browser'].'",y: '.$element['contador'].'},';
endforeach;
$outputBrowser = substr($outputBrowser, 0,strlen($outputBrowser)-1);


//DATOS VISITAS POR PLATAFORMA
$outputPlatform="";
$elements = visitas::getAccessPlatform($filtro_informe." AND webpage NOT IN (".$pagina_excluidas.") ");
foreach($elements as $element):
	$outputPlatform.='{name: "'.$element['platform'].'",y: '.$element['contador'].'},';
endforeach;
$outputPlatform = substr($outputPlatform, 0,strlen($outputPlatform)-1);


?>
		<script type="text/javascript">


$(function () {
    $('#containerVisitas').highcharts({
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
        },
        series: [{
            name: 'Visitas',
            data: [<?php echo $output_y;?>]

        }]
    });

    $('#containerVisitasDias').highcharts({
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
        series: [{
            name: 'Visitas',
            data: [<?php echo $output_y2;?>]
        }]
    });


    $('#containerVisitasUnicas').highcharts({
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
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: "Porcentaje",
            colorByPoint: true,
            data: [<?php echo $outputBrowser;?>]
        }]
    });

	$('#containerPlatform').highcharts({
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
                    enabled: false
                },
                showInLegend: true
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

  
	global $total1,$total2,$total3,$media1,$media2,$media3;

	$visitas = new visitas();

	//VACIAR LOGS
	if (isset($_REQUEST['act']) and $_REQUEST['act']=='del') { $visitas->deleteVisitas();}

	if (isset($_POST['fecha_ini'])){
		$fecha_ini = $_POST['fecha_ini'];
		$fecha_fin = $_POST['fecha_fin'];
	}
	else{
		$fecha_fin = date('Y-m-d');
		$fecha_ini = strtotime ( '-1 month' , strtotime ( $fecha_fin ) ) ;
		$fecha_ini = date ( 'Y-m-d' , $fecha_ini );
	}?>

	<div class="row row-top">
		<div class="app-main">
			<?php
			menu::breadcrumb(array(
				array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
				array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
				array("ItemLabel"=>strTranslate("Reports"), "ItemUrl"=>"#"),
				array("ItemLabel"=>strTranslate("Report")." <b>".strTranslate("Visits")."</b>", "ItemClass"=>"active"),
			));
			?>

			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default panel-ranking">
						<div class="panel-body nopadding">
							<div class="row">
								<div class="col-md-8 inset">
									<h4>Usuarios activos</h4>
									Total usuarios activos en la comunidad
								</div>
								<div class="col-md-4 label-success inset panel-color">
									<?php 
										$num_users = number_format(connection::countReg("users", " AND disabled=0 AND registered=1 AND confirmed=1 "), 0, ',', '.');
									?>
									<p class="text-center"><big><?php echo $num_users;?></big><br />
										<?php echo strTranslate("Users");?>
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
								<div class="col-md-8 inset">
									<h4>Tiendas activos</h4>
									Total <?php echo strtolower(strTranslate("Groups_user"));?> activas en la comunidad
								</div>
								<div class="col-md-4 label-info inset panel-color">
									<?php 
										$num_empresas = number_format(connection::countReg("users_tiendas", " AND activa=1 "), 0, ',', '.');
									?>
									<p class="text-center"><big><?php echo $num_empresas;?></big><br />
										<?php echo strTranslate("Groups_user");?>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">				
					<div class="panel panel-default panel-ranking">
						<div class="panel-body">
							<p>Puedes filtrar los informes de acceso por fechas: <span class="text-danger text-small">En los informes gráficos no se muestran los accesos al panel de administración.</span></p>
							<div class="row">
								<div class="col-md-5">
									<form name="inf-accesos" id="inf-accesos" method="post" action="<?php echo $_REQUEST['page'];?>" role="form" class="">
										<input type="hidden" name="export_fechas" id="export_fechas" value="1" />

										<div class="row">
											<div class="col-xs-6">
												<label for="fecha_ini">Fecha inicio:</label>
												<div id="datetimepicker1" class="input-group date">
													<input data-format="yyyy/MM/dd" readonly type="text" id="fecha_ini" class="form-control" name="fecha_ini" placeholder="Fecha inicio" value="<?php echo $fecha_ini;?>"></input>
												<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
												</div>

												<script>
												jQuery(document).ready(function(){
													$("#datetimepicker1").datetimepicker({
													  language: "es-ES"
													});
												});
												</script>
											</div>
											<div class="col-xs-6">
												<label for="fecha_fin">Fecha fin:</label>
												<div id="datetimepicker2" class="input-group date">
													<input data-format="yyyy/MM/dd" readonly type="text" id="fecha_fin" class="form-control" name="fecha_fin" placeholder="Fecha fin" value="<?php echo $fecha_fin;?>"></input>
												<span class="input-group-addon add-on"><i class="glyphicon glyphicon-calendar"></i></span>
												</div>

												<script>
												jQuery(document).ready(function(){
													$("#datetimepicker2").datetimepicker({
													  language: "es-ES"
													});
												});
												</script>
											</div>
										</div>
										<span id="fecha-alert" class="alert-message alert alert-danger"></span>
									</div>
									<div class="col-md-7">
										<br />
										<button type="submit" class="btn btn-primary" name="generate-stats">Generar gráficos</button>
										<button type="submit" class="btn btn-primary" name="export-stats">Exportar CSV</button>
										<a class="btn btn-primary" href="#" onClick="Confirma('¿Seguro que desea eliminar todos los registros?.\nLa información borrada no podrá ser recuperada.', 'admin-informe-accesos?act=del')" title="Vaciar registros" />Vaciar registros de accesos</a>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>



			<div class="row">
				<div class="col-md-12">
				<div class="panel panel-default panel-ranking">
					<div class="panel-body nopadding">		
							<div id="containerVisitas" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default panel-ranking">
						<div class="panel-body nopadding">
							<div id="containerVisitasDias" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default panel-ranking">
						<div class="panel-body nopadding">
							<div id="containerVisitasUnicas" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default panel-ranking">
					<div class="panel-body nopadding">
							<div id="containerBrowser" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default panel-ranking">
						<div class="panel-body nopadding">
							<div id="containerPlatform" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
						</div>
					</div>
				</div>
			</div>	
		</div>
	<?php menu::adminMenu();?>
</div>