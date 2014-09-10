<?php
//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);

//EXPORT USERS
if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
	$users = new users();
	$elements=$users->getTiendas("");
	exportCsv($elements);
}  

define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

$users = new users();
if (isset($_POST['find_reg'])) {$filtro=" AND nombre_tienda LIKE '%".$_POST['find_reg']."%' ";$find_reg=$_POST['find_reg'];}
if (isset($_REQUEST['f'])) {$filtro=" AND nombre_tienda LIKE '%".$_REQUEST['f']."%' ";$find_reg=$_REQUEST['f'];} 
$filtro.=" ORDER BY nombre_tienda";

//SHOW PAGINATOR
$reg = 50;
if (isset($_GET["pag"])) {$pag = $_GET["pag"];}
if (!$pag) { $inicio = 0; $pag = 1;}
else { $inicio = ($pag - 1) * $reg;}
$total_reg = $users->countReg("users_tiendas",$filtro);
$elements=$users->getTiendas($filtro.' LIMIT '.$inicio.','.$reg);?>

<div class="row row-top">
	<div class="col-md-9">
		<h1>Listado de tiendas</h1>
		<nav class="navbar navbar-default" role="navigation">
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">       
	<?php
	echo '<li><a href="?page='.$_REQUEST['page'].'&export=true&q='.$find_text.'">Exportar CSV</a></li>
			</ul>';
	SearchForm($reg,"?page=users-tiendas","searchForm","buscar tienda","Buscar","","navbar-form navbar-left");
	echo '</div>
			</nav>';
	echo '<p>Total <b>'.$total_reg.'</b> registros</p>';
	echo '<table class="table" >';
	echo '<tr>';
	echo '<th>Cód.</th>';
	echo '<th>Nombre</th>';
	echo '<th>Regional</th>';    
	echo '<th>Responsable</th>';
	echo '<th>Tipo.</th>';
	echo '</tr>';

	foreach($elements as $element):
	echo '<tr>';			
	echo '<td>'.$element['cod_tienda'].'</td>';
	echo '<td>'.$element['nombre_tienda'].'</td>';
	echo '<td>'.$element['regional_tienda'].'</td>';	
	echo '<td>'.$element['responsable_tienda'].'</td>';
	echo '<td>'.$element['tipo_tienda'].'</td>';
	echo '</tr>';   
	endforeach;
	echo '</table>';
	Paginator($pag,$reg,$total_reg,'users-tiendas','Usuarios',$find_reg);?>
	</div>
	<?php menu::adminMenu();?>
</div>