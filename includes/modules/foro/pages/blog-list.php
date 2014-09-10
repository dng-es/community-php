<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

addJavascripts(array(getAsset("foro")."js/foro-temas.js"));


templateload("blog","foro");
templateload("list","foro");
templateload("paginator","foro");	
$foro = new foro();
$mensaje="";
$id_tema_parent="";
$canal="";

///////////////////////////////////////////////////////////////////////////////////////////
//	CENTRO		///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
echo '<div id="page-info"><img src="images/blog-logo.png" /><span>Blog de moda y últimas tendencias</span></div>';
echo '<div class="row inset row-top">
		<div class="col-md-9">';




if ($mensaje!=""){ErrorMsg($mensaje);}
echo '<div class="message-form" id="alertas-mensajes" style="display: none"></div>';
  $titulo_page="";

//OBTENER SUBTEMAS DE FORO
$reg = 10;
if (isset($_GET["pag"])) {$pag = $_GET["pag"];}
if (!$pag) { $inicio = 0; $pag = 1;}
else { $inicio = ($pag - 1) * $reg;}

$filtro_subtemas = " AND t.activo=1 AND t.ocio=1 ";
//filtro por año y mes
if (isset($_REQUEST['a']) and isset($_REQUEST['m']) and $_REQUEST['m']!="" and $_REQUEST['a']!=""){
	$nombre=strftime("%B",mktime(0, 0, 0, $_REQUEST['m'], 1, 2000));
	$filtro_subtemas .= " AND MONTH(t.date_tema)=".$_REQUEST['m']." AND YEAR(t.date_tema)=".$_REQUEST['a'];
	$titulo_page ="Entradas en el mes de <span class='legend'>".ucfirst($nombre).", año ".$_REQUEST['a']."</span>";
}
else if (isset($_POST['find_reg']) and $_POST['find_reg']!="") {
	$filtro_subtemas.=" AND t.nombre LIKE '%".$_POST['find_reg']."%' ";$find_reg=$_POST['find_reg'];
	$titulo_page ="Resultados de la búsqueda: <span class='legend'>".$_POST['find_reg']."</span>";
}
else if (isset($_REQUEST['f']) and $_REQUEST['f']!="") {
	$filtro_subtemas.=" AND t.nombre LIKE '%".$_REQUEST['f']."%' ";$find_reg=$_REQUEST['f'];
	$titulo_page ="Resultados de la búsqueda: <span class='legend'>".$_POST['find_reg']."</span>";
}	  
else if (isset($_POST['tipo-sel']) and $_POST['tipo-sel']==1) {
	$filtro_subtemas.=" AND t.tipo_tema LIKE '%".$_POST['find_tipo']."%' ";
	$find_tipo=$_POST['find_tipo'];$marca=1;
}
else if (isset($_REQUEST['m']) and $_REQUEST['m']==1) {
	$filtro_subtemas.=" AND t.tipo_tema LIKE '%".$_REQUEST['t']."%' ";
	$find_tipo=$_REQUEST['t'];$marca=1;
	$titulo_page ="Entradas categoría: <span class='legend'>".ucfirst($_REQUEST['t'])."</span>";
}
else if (isset($_REQUEST['c']) and $_REQUEST['c']!="") {
	$filtro_subtemas.=" AND t.tipo_tema LIKE '%".$_REQUEST['c']."%' ";
	$find_tipo=$_REQUEST['c'];$marca=1;
	$titulo_page ="Entradas categoría: <span class='legend'>".ucfirst($_REQUEST['c'])."</span>";
}


if ($titulo_page!=""){ echo '<h3>'.$titulo_page.'</h3>';}

$total_reg = $foro->getTemasComentarios($filtro_subtemas,'');
$total_reg = count($total_reg);
$sub_temas = $foro->getTemasComentarios($filtro_subtemas,' LIMIT '.$inicio.','.$reg);
foreach($sub_temas as $sub_tema):
echo '<div class="row">
		<div class="col-md-12">';
ForoList($sub_tema,"blog");	  
echo '	</div>
	 </div>';			
endforeach;  
ForoPaginator($pag,$reg,$total_reg,'blog-list&a='.$_REQUEST['a']."&m=".$_REQUEST['m'],'temas',$find_reg,$find_tipo,$marca);	 


echo '	</div>
		<div class="col-md-3">';
//BUSCADOR
searchBlog();
		  
//ENTRADAS RECIENTES
echo '<h4>Entradas recientes</h4>';
$elements = $foro->getTemas(" AND ocio=1 AND activo=1 ORDER BY id_tema DESC LIMIT 3 "); 
entradasBlog($elements);

//ARCHIVOS BLOG
echo '<h4>Archivos</h4>
	  <div class="lateral-container">';
$elements = $foro->getArchivoBlog();
archivoBlog($elements);
echo '</div>';

//CATEGORIAS
$elements = $foro->getCategorias(" AND ocio=1 ");
echo '<h4>Categorias</h4>';
categoriasBlog($elements);

echo '</div>
	</div>';
 

function SearchTemas($reg,$pag,$comentario,$marca_tipo,$tipo_tema){	
	echo '<div class="panel-interior">
		  <form action="'.$pag.'&regs='.$reg.'" method="post" role="form">';
	echo '<div class="form-group">
			<label for="find_reg">Búsqueda rápida</label> 
			<input id="find_reg" name="find_reg" type="text" value="'.$comentario.'" class="form-control" />
			<input type="hidden" name="registros_form" value="'.$reg.'" />
		  </div>
		  ';
 
	if ($_SESSION['user_perfil']=='admin'){
		if ($marca_tipo==1){$marcado=' checked="checked" ';}
		else {$marcado='';}?>
			  <div class="form-group">
			  <input name="tipo-sel" id="tipo-sel" value="1" type="checkbox" class="find_reg" <?php echo $marcado;?>/> 
			  <label for="">Tipo de tema:</label> 
			  <select name="find_tipo" id="find_tipo" class="form-control">
			  <?php ComboTiposTemas($tipo_tema);?>
			  </select>
			</div>
	<?php }

	echo '<button type="submit" class="btn btn-primary" title="Buscar">Buscar</button>
			</form>
		  </div>';	
}
function PaginatorTemas($pag,$reg,$total_reg,$pag_dest,$title,$find_reg="",$find_tipo="",$marcado=0,$num_paginas=10)
{
	$total_pag = ceil($total_reg / $reg);
	$reg_ini=(($pag-1)*$reg)+1;
	$reg_end=$pag*$reg;
	if ($reg_ini>$total_reg) {$reg_ini=$total_reg;}
	if ($reg_end>$total_reg) {$reg_end=$total_reg;}
	echo '<span class="pageslist">';
	//echo '<span class="messages"> '.$title.' '.$total_reg.' ('.$reg_ini.'-'.$reg_end.')</span>';
	if(($pag - 1) > 0) { echo '<a href="?page='.$pag_dest.'&pag=1&regs='.$reg.'&f='.$find_reg.'&t='.$find_tipo.'&m='.$marcado.'">primero</a>';}
	else { echo '<span class="disabled">primero</span>';}
	
	
	$pagina_inicial=$pag-1;
	if ($pagina_inicial<=0){$pagina_inicial=1;}
	$pagina_final=$pagina_inicial+$num_paginas;
	
	if ($pag>1){
		echo '<a href="?page='.$pag_dest.'&pag='.($pag-1).'&regs='.$reg.'&f='.$find_reg.'">anterior</a>';}
	else { echo '<span class="disabled">anterior</span>';}
	
	
	for ($i=$pagina_inicial; $i<=$pagina_final; $i++){
		if($i<=$total_pag){
		  if ($pag == $i) { echo '<span  class="selected selected-foro">'.$pag.'</span>';}
		  else { echo '<a href="?page='.$pag_dest.'&pag='.$i.'&regs='.$reg.'&f='.$find_reg.'&t='.$find_tipo.'&m='.$marcado.'">'.$i.'</a>';}
		}
	}
	
	if ($pag<$total_pag){
		echo '<a href="?page='.$pag_dest.'&pag='.($pag+1).'&regs='.$reg.'&f='.$find_reg.'">siguiente</a>';
	}
	else { echo '<span class="disabled">siguiente</span>';}
	
	if(($pag + 1)<=$total_pag) { echo '<a href="?page='.$pag_dest.'&pag='.$total_pag.'&regs='.$reg.'&f='.$find_reg.'&t='.$find_tipo.'&m='.$marcado.'">&uacute;ltimo</a>';}
	else { echo '<span class="disabled">&uacute;ltimo</span>';}
	echo '</span>';
}
?>