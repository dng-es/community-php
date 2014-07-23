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
$menu_admin=1;
function ini_page_header ($ini_conf) {?>

<?php }
function ini_page_body ($ini_conf){
  echo '<div class="row inset row-top">';
  echo '<div class="col-md-12">
          <h2>Listado de tiendas</h2>';


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

  
  echo '<nav class="navbar navbar-default" role="navigation">';
  echo '<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">       
        <li><a href="?page='.$_REQUEST['page'].'&export=true&q='.$find_text.'">Exportar CSV</a></li>
      </ul>';
  SearchForm($reg,"?page=users-tiendas","searchForm","buscar tienda","Buscar","","navbar-form navbar-left");
  echo '</div>
        </nav>';

  $elements=$users->getTiendas($filtro.' LIMIT '.$inicio.','.$reg); 
  
  echo '<p>Total <b>'.$total_reg.'</b> registros</p>';
  //SHOW DATA
  echo '<table class="table" >';
  echo '<tr>';
  echo '<th>Cód.</th>';
  echo '<th>Nombre</th>';
  echo '<th>Regional</th>';    
  echo '<th>Responsable</th>';
  echo '<th>Tipo.</th>';
  echo '</tr>';
  
  $color_row='TableRow';
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
  Paginator($pag,$reg,$total_reg,'users-tiendas','Usuarios',$find_reg);
  echo '</div>';
  echo '</div>';
}
?>
