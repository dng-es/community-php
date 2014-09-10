<?php
//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);

//EXPORT ACCESOS
visitasController::exportAction();

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

	$total1=0;
	$total2=0;
	$total3=0;
	$media1=0;
	$media2=0;
	$media3=0;
	$pagina_excluidas = "'admin','informe-accesos','informe-participaciones', 'informe-puntuaciones','users','user','users-tiendas','cargas-users','admin-area','admin-message','Inicio sesion','admin-validacion-foro',
						 'admin-messages','admin-message-proccess','admin-message-proccess-step1',
						 'admin-areas','admin-area-revs','admin-area-form','admin-area-docs','admin-config','admin-page', 'admin-puntos','admin-mystery'";

addJavascripts(array("js/bootstrap-datepicker.js", 
					 "js/bootstrap-datepicker.es.js", 
					 "js/libs/amcharts/amcharts.js"));



	global $total1,$total2,$total3,$media1,$media2,$media3,$pagina_excluidas;

	if (isset($_POST['generate-stats']) and !isset($_POST['export-stats'])):
		$filtro_informe=" AND fecha BETWEEN '".$_POST['fecha_ini']." 00:00:00' AND '".$_POST['fecha_fin']." 23:59:59' ";
	else:
		$filtro_informe = " AND fecha>=DATE_ADD(NOW(), INTERVAL -1 MONTH) ";
	endif;


	$visitas = new visitas();
	//DATOS VISITAS POR PAGINAS
	$output="";

	$filtro=$filtro_informe." AND webpage NOT IN (".$pagina_excluidas.") ";
	$elements = $visitas->getAccessTopPages($filtro);
	$visitas = 0;
	$output="[";
	foreach($elements as $element):
		$visitas+=$element['contador'];
		$output.='{webpage: "'.$element['webpage'].'",visits: '.$element['contador'].'},';
	endforeach;
	$media = round(($visitas/count($elements)),2);
	$media1=str_replace(",", ".",$media);
	$total1=$visitas;
	$output = substr($output, 0,strlen($output)-1);
	$output.="]";
	$informe1 = $output;

	//DATOS VISITAS POR DIA
	$output="";
	 $elements = visitas::getAccessPages($filtro_informe." AND webpage NOT IN (".$pagina_excluidas.") ");
	 $output="[";
	 $visitas = 0;
	 foreach($elements as $element):
		$visitas+=$element['contador'];
		$output.="{date: new Date(".$element['anio'].", ".($element['mes']-1).", ".$element['dia']."),price: ".$element['contador']."},";
	 endforeach;
	$media = round(($visitas/count($elements)),2);
	$output = substr($output, 0,strlen($output)-1);
	$output.="]";
	$media2=str_replace(",", ".",$media);
	$total2=$visitas;
	$informe2 = $output;

	//DATOS VISITAS UNICAS
	$output="";
	$elements = visitas::getAccessPages($filtro_informe." AND webpage='Inicio sesion' ");
	$output="[";
	$visitas = 0;
	foreach($elements as $element):
		$visitas+=$element['contador'];
		$output.="{date: new Date(".$element['anio'].", ".($element['mes']-1).", ".$element['dia']."),price: ".$element['contador']."},";
	endforeach;
	$media = round(($visitas/count($elements)),2);
	$output = substr($output, 0,strlen($output)-1);
	$output.="]";
	$media3=str_replace(",", ".",$media);
	$total3=$visitas;
	$informe3 = $output;

	//DATOS VISITAS POR NAVEGADOR
	$output="";
	$elements = visitas::getAccessBrowser($filtro_informe." AND webpage NOT IN (".$pagina_excluidas.") ");
	$output="[";
	foreach($elements as $element):
		$output.='{browser: "'.$element['browser'].'",value: '.$element['contador'].'},';
	endforeach;
	$output = substr($output, 0,strlen($output)-1);
	$output.="]";
	$informe4 = $output;	

	//DATOS VISITAS POR PLATAFORMA
	$output="";
	$elements = visitas::getAccessPlatform($filtro_informe." AND webpage NOT IN (".$pagina_excluidas.") ");
	$output="[";
	foreach($elements as $element):
		$output.='{platform: "'.$element['platform'].'",value: '.$element['contador'].'},';
	endforeach;
	$output = substr($output, 0,strlen($output)-1);
	$output.="]";
	$informe5 = $output;

?>

		<script type="text/javascript">
			jQuery(document).ready(function(){
				

			$(".loading").css("display", "inline");
			showInfoPages();    
			showInfoAccess();
			showMasVisitadas();
			showBrowsers();
			showPlatforms();

				function showInfoPages(){		

					var chart;
					var average=<?php echo $media2;?>;
					var chartData=<?php echo $informe2;?>;
					var arrayVariables;


						AmCharts.ready(function () {

							AmCharts.dayNames = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
							AmCharts.shortDayNames = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
							AmCharts.monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
							AmCharts.shortMonthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

							// SERIAL CHART    
							chart = new AmCharts.AmSerialChart();
							chart.pathToImages = "js/amcharts/images/";
							chart.zoomOutButton = {
								backgroundColor: '#000000',
								backgroundAlpha: 0.15
							};
							
							chart.dataProvider = chartData;
							chart.categoryField = "date";

							// AXES
							// category
							var categoryAxis = chart.categoryAxis;
							categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
							categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
							categoryAxis.dashLength = 1;
							categoryAxis.gridAlpha = 0.15;
							categoryAxis.axisColor = "#DADADA";

							// value                
							var valueAxis = new AmCharts.ValueAxis();
							valueAxis.axisColor = "#DADADA";
							valueAxis.dashLength = 1;
							valueAxis.logarithmic = true; // this line makes axis logarithmic
							chart.addValueAxis(valueAxis);

							// GUIDE for average
							var guide = new AmCharts.Guide();
							guide.value = average;
							guide.lineColor = "#CC0000";
							guide.dashLength = 4;
							guide.label = "media: "+average;
							guide.inside = true;
							guide.lineAlpha = 1;
							valueAxis.addGuide(guide);

							// GRAPH
							var graph = new AmCharts.AmGraph();
							graph.type = "smoothedLine";
							graph.bullet = "round";
							graph.bulletColor = "#FFFFFF";
							graph.bulletBorderColor = "#00BBCC";
							graph.bulletBorderThickness = 2;
							graph.bulletSize = 7;
							graph.title = "Price";
							graph.valueField = "price";
							graph.lineThickness = 2;
							graph.lineColor = "#00BBCC";
							chart.addGraph(graph);

							// CURSOR
							var chartCursor = new AmCharts.ChartCursor();
							chartCursor.cursorPosition = "mouse";
							chart.addChartCursor(chartCursor);

							// SCROLLBAR
							var chartScrollbar = new AmCharts.ChartScrollbar();
							chart.addChartScrollbar(chartScrollbar);

							// WRITE
							chart.write("chartdiv2");
							$("#loading2").css("display", "none");
					});
				}

				function showInfoAccess(){		
					var chart;
	        		var average=<?php echo $media3;?>;
					var chartData=<?php echo $informe3;?>;
					var arrayVariables;

						AmCharts.ready(function () {

			                AmCharts.dayNames = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
							AmCharts.shortDayNames = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
							AmCharts.monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
							AmCharts.shortMonthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

			                // SERIAL CHART    
			                chart = new AmCharts.AmSerialChart();
			                chart.pathToImages = "js/amcharts/images/";
			                chart.zoomOutButton = {
			                    backgroundColor: '#000000',
			                    backgroundAlpha: 0.15
			                };
							

			                chart.dataProvider = chartData;
			                chart.categoryField = "date";

			                // AXES
			                // category
			                var categoryAxis = chart.categoryAxis;
			                categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
			                categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
			                categoryAxis.dashLength = 1;
			                categoryAxis.gridAlpha = 0.15;
			                categoryAxis.axisColor = "#DADADA";

			                // value                
			                var valueAxis = new AmCharts.ValueAxis();
			                valueAxis.axisColor = "#DADADA";
			                valueAxis.dashLength = 1;
			                valueAxis.logarithmic = true; // this line makes axis logarithmic
			                chart.addValueAxis(valueAxis);

			                // GUIDE for average
			                var guide = new AmCharts.Guide();
			                guide.value = average;
			                guide.lineColor = "#CC0000";
			                guide.dashLength = 4;
			                guide.label = "media: "+average;
			                guide.inside = true;
			                guide.lineAlpha = 1;
			                valueAxis.addGuide(guide);	                


			                // GRAPH
			                var graph = new AmCharts.AmGraph();
			                graph.type = "smoothedLine";
			                graph.bullet = "round";
			                graph.bulletColor = "#FFFFFF";
			                graph.bulletBorderColor = "#00BBCC";
			                graph.bulletBorderThickness = 2;
			                graph.bulletSize = 7;
			                graph.title = "Price";
			                graph.valueField = "price";
			                graph.lineThickness = 2;
			                graph.lineColor = "#00BBCC";
			                chart.addGraph(graph);

			                // CURSOR
			                var chartCursor = new AmCharts.ChartCursor();
			                chartCursor.cursorPosition = "mouse";
			                chart.addChartCursor(chartCursor);

			                // SCROLLBAR
			                var chartScrollbar = new AmCharts.ChartScrollbar();
			                chart.addChartScrollbar(chartScrollbar);

			                // WRITE
			                chart.write("chartdiv3");
			                $("#loading3").css("display", "none");

					});
				}


				function showMasVisitadas(){		
					var chart;
					var average=<?php echo $media1;?>;
					var chartData=<?php echo $informe1;?>;
					var arrayVariables;


						AmCharts.ready(function () {

							// SERIAL CHART
							chart = new AmCharts.AmSerialChart();
							chart.dataProvider = chartData;
							chart.categoryField = "webpage";
							chart.startDuration = 1;

							// AXES
							// category
							var categoryAxis = chart.categoryAxis;
							categoryAxis.labelRotation = 25;
							categoryAxis.gridPosition = "start";

							// value
							// in case you don't want to change default settings of value axis,
							// you don't need to create it, as one value axis is created automatically.
							
							// value                
							var valueAxis = new AmCharts.ValueAxis();
							chart.addValueAxis(valueAxis);

							// GUIDE for average
							var guide = new AmCharts.Guide();
							guide.value = average;
							guide.lineColor = "#CC0000";
							guide.dashLength = 4;
							guide.label = "media: "+average;
							guide.inside = true;
							guide.lineAlpha = 1;
							valueAxis.addGuide(guide);

							// GRAPH
							var graph = new AmCharts.AmGraph();
							graph.valueField = "visits";
							graph.balloonText = "[[category]]: [[value]]";
							graph.type = "column";
							graph.lineAlpha = 0;
							graph.fillAlphas = 0.8;
							chart.addGraph(graph);

							chart.write("chartdiv1");
							$("#loading1").css("display", "none");
					});
				}				

				function showBrowsers(){		
					var chart;
					var chartData=<?php echo $informe4;?>;
					var arrayVariables;


					AmCharts.ready(function () {
						// PIE CHART
						chart = new AmCharts.AmPieChart();
						chart.dataProvider = chartData;
						chart.titleField = "browser";
						chart.valueField = "value";
						chart.outlineColor = "#ffffff";
						chart.outlineAlpha = 0.8;
						chart.outlineThickness = 0;
						// this makes the chart 3D
						chart.depth3D = 15;
						chart.angle = 30;

						//FULL WIDTH/HEIGHT
						chart.labelsEnabled = false;
						chart.autoMargins = false;
						chart.marginTop = "6%";
						chart.marginBottom = "10%";
						chart.marginLeft = "6%";
						chart.marginRight = "6%";
						chart.pullOutRadius = 0;

						// LEGEND
						legend = new AmCharts.AmLegend();
						legend.position = "right";
						legend.switchType = "v";
						legend.markerType = "circle";
						legend.switchable = true;
						chart.addLegend(legend);

						// WRITE
						chart.write("chartdiv4");
						$("#loading4").css("display", "none");
					});
				}		

				function showPlatforms(){		
					var chart;
					var chartData=<?php echo $informe5;?>;
					var arrayVariables;


					AmCharts.ready(function () {
						// PIE CHART
						chart = new AmCharts.AmPieChart();
						chart.dataProvider = chartData;
						chart.titleField = "platform";
						chart.valueField = "value";
						chart.outlineColor = "#ffffff";
						chart.outlineAlpha = 0.8;
						chart.outlineThickness = 0;
						// this makes the chart 3D
						chart.depth3D = 15;
						chart.angle = 30;

						//FULL WIDTH/HEIGHT
						chart.labelsEnabled = false;
						chart.autoMargins = false;
						chart.marginTop = "6%";
						chart.marginBottom = "10%";
						chart.marginLeft = "6%";
						chart.marginRight = "6%";
						chart.pullOutRadius = 0;

						// LEGEND
						legend = new AmCharts.AmLegend();
						legend.position = "right";
						legend.switchType = "v";
						legend.markerType = "circle";
						legend.switchable = true;
						//legend.valueWidth = 80;
						chart.addLegend(legend);

						// WRITE
						chart.write("chartdiv5");
						$("#loading5").css("display", "none");
					});
				}												
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
		<div class="col-md-9">
			<h1>Accesos a la aplicación</h1>
			<div class="col-md-12">
  				<p>Puedes filtrar los informes de acceso por fechas:</p>
				<form name="inf-accesos" id="inf-accesos" method="post" action="?page=<?php echo $_REQUEST['page'];?>" role="form" class="">
					<input type="hidden" name="export_fechas" id="export_fechas" value="1" />

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
					<span id="fecha-alert" class="alert-message alert alert-danger"></span>

					<br />
					<button type="submit" class="btn btn-primary" name="generate-stats">Generar gráficos</button>
					<button type="submit" class="btn btn-primary" name="export-stats">Exportar CSV</button>
					<a class="btn btn-primary" href="#" onClick="Confirma('¿Seguro que desea eliminar todos los registros?.\nLa información borrada no podrá ser recuperada.', '?page=informe-accesos&act=del')" title="Vaciar registros" />Vaciar registros de accesos</a>
					<br /><br />
					<p>En los informes gráficos no se muestran los accesos al panel de administración.</p>
					<hr />
				</form>
			</div>
  <?php

  echo '<div>';
  echo '<h2>Páginas visitadas: visitas realizadas por página.</h2>
		<p>total páginas visitadas: '.$total1.'<br />
		media de visitas por página: '.$media1.'</p>
		<div style="height:18px;position:relative;width:200px;display:block;top:0px;left:0.1%;background:#fff;z-index:100000000"></div>
		<div id="chartdiv1" class="access-stats">
			<div id="loading1" class="loading"><i class="fa fa-spinner fa-spin ajax-load"></i></div>
		</div>
		<h2><b>Páginas vistas por día</b>: número de paginas que se han visto cada día.</h2>
		<p>total páginas visitadas: '.$total2.'<br />
		media de páginas visitadas: '.$media2.'</p>
		<div style="height:18px;position:relative;width:200px;display:block;top:0px;left:0.1%;background:#fff;z-index:100000000"></div>
		<div id="chartdiv2" class="access-stats">
			<div id="loading2" class="loading"><i class="fa fa-spinner fa-spin ajax-load"></i></div>
		</div>

		<h2>Visitas únicas por día: número de accesos únicos realizados a la Web cada día.</h2>
		<p>total visitas únicas: '.$total3.'<br />
		media visitas únicas: '.$media3.'</p>
		<div style="height:18px;position:relative;width:200px;display:block;top:0px;left:0.1%;background:#fff;z-index:100000000"></div>
		<div id="chartdiv3"  class="access-stats">
			<div id="loading3" class="loading"><i class="fa fa-spinner fa-spin ajax-load"></i>></div>
		</div>';?>

	<div class="">
		<div class="" style="width:100%">
			<h2>Visitas por navegador</h2>
			<div style="height:18px;position:relative;width:180px;display:block;top:0px;left:0.1%;background:#fff;z-index:100000000"></div>
			<div id="chartdiv4" class="access-stats">
				<div id="loading4" class="loading"><i class="fa fa-spinner fa-spin ajax-load"></i></div>
			</div> 
		</div>
		<div class="" style="width:100%">
			<h2>Visitas por plataforma (SO).</h2>
			<div style="height:18px;position:relative;width:180px;display:block;top:0px;left:0.1%;background:#fff;z-index:100000000"></div>
			<div id="chartdiv5" class="access-stats">
				<div id="loading5" class="loading"><i class="fa fa-spinner fa-spin ajax-load"></i></div>
			</div>
		</div>
	</div>	
	</div>
	</div>
	<?php menu::adminMenu();?>
</div>