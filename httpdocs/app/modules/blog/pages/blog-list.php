<?php
addJavascripts(array(getAsset("foro")."js/foro-temas.js"));

templateload("tags","blog");
templateload("blog","blog");
templateload("list","blog");
templateload("paginator","foro");

$foro = new foro();
$find_reg = "";
$find_tipo = "";
$url_filters = "";
$titulo_page = "";

//OBTENER SUBTEMAS DE FORO
$reg = 10;
if (isset($_GET["pag"])) $pag = $_GET["pag"];
if (!isset($pag)){
	$inicio = 0; 
	$pag = 1;
}
else $inicio = ($pag - 1) * $reg;

$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal LIKE '%".$_SESSION['user_canal']."%' " : "");
$filtro_blog = $filtro_canal." AND t.activo=1 AND t.ocio=1 ";

//filtro por año y mes
if (isset($_REQUEST['a']) && isset($_REQUEST['m']) && $_REQUEST['m'] != "" && $_REQUEST['a'] != ""){
	$nombre=strftime("%B",mktime(0, 0, 0, $_REQUEST['m'], 1, 2000));
	$filtro_blog .= " AND MONTH(t.date_tema)=".$_REQUEST['m']." AND YEAR(t.date_tema)=".$_REQUEST['a'];
	$titulo_page = ucfirst($nombre).", ".$_REQUEST['a'];
	$url_filters = "?a=".$_REQUEST['a']."&m=".$_REQUEST['m'];
}
else if (isset($_REQUEST['c']) && $_REQUEST['c'] != "") {
	$filtro_blog.= " AND t.tipo_tema LIKE '%".$_REQUEST['c']."%' ";
	$find_tipo = $_REQUEST['c'];
	$titulo_page = ucfirst($_REQUEST['c']);
	$url_filters = "?c=".$_REQUEST['c'];
}
else if (isset($_REQUEST['find_reg']) && $_REQUEST['find_reg'] != "") {
	$filtro_blog.=" AND t.nombre LIKE '%".$_REQUEST['find_reg']."%' ";
	$find_reg = $_REQUEST['find_reg'];
	$titulo_page = strTranslate("Search_results").": ".$_REQUEST['find_reg'];
}
else if (isset($_REQUEST['f']) && $_REQUEST['f'] != "") {
	$filtro_blog.= " AND t.nombre LIKE '%".$_REQUEST['f']."%' ";
	$find_reg = $_REQUEST['f'];
	$titulo_page = strTranslate("Search_results").": ".$_REQUEST['f'];
}
else if (isset($_POST['tipo-sel']) && $_POST['tipo-sel'] == 1) {
	$filtro_blog .= " AND t.tipo_tema LIKE '%".$_POST['find_tipo']."%' ";
	$find_tipo = $_POST['find_tipo'];
}

$TITLE_META_PAGE = $titulo_page;
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Blog"), "ItemUrl"=>"#"),
			array("ItemLabel"=>$titulo_page, "ItemClass"=>"active"),
		));

		$total_reg = connection::countReg("foro_temas t", $filtro_blog);
		$sub_temas = $foro->getTemas($filtro_blog.' LIMIT '.$inicio.','.$reg);
		foreach($sub_temas as $sub_tema):
		echo '<div class="row">
				<div class="col-md-12">';
		ForoList($sub_tema,"blog");
		echo '	</div>
			 </div>';
		endforeach;

		Paginator($pag, $reg, $total_reg, 'blog-list'.$url_filters, '', $find_reg); ?>
	</div>
	<div class="app-sidebar">
		<div class="panel-interior full-height">
			<?php
			//BUSCADOR
			searchBlog();

			//ENTRADAS RECIENTES
			echo '<h4>'.strTranslate("Last_blog").'</h4>';
			$elements = $foro->getTemas($filtro_canal." AND ocio=1 AND activo=1 ORDER BY id_tema DESC LIMIT 3 "); 
			entradasBlog($elements);

			//ARCHIVOS BLOG
			echo '<h4>'.strTranslate("Archive").'</h4>
				  <div class="lateral-container">';
			$elements = $foro->getArchivoBlog($filtro_canal);
			archivoBlog($elements);
			echo '</div>';

			//CATEGORIAS
			$elements = $foro->getCategorias($filtro_canal." AND ocio=1 AND activo=1 ");
			echo '<h4>'.strTranslate("Categories").'</h4>';
			categoriasBlog($elements); ?>
		</div>
	</div>
</div>