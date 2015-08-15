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
$titulo_page="";
?>

<div class="row row-top">
	<div class="app-main">
		

		<?php
		//OBTENER SUBTEMAS DE FORO
		$reg = 10;
		if (isset($_GET["pag"])) {$pag = $_GET["pag"];}
		if (!isset($pag)) { $inicio = 0; $pag = 1;}
		else { $inicio = ($pag - 1) * $reg;}

		$filtro_blog = ($_SESSION['user_canal']=='admin' ? "" : " AND (canal='".$_SESSION['user_canal']."' OR canal='todos') ");
		$filtro_subtemas = $filtro_blog." AND t.activo=1 AND t.ocio=1 ";
		//filtro por año y mes
		if (isset($_REQUEST['a']) and isset($_REQUEST['m']) and $_REQUEST['m']!="" and $_REQUEST['a']!=""){
			$nombre=strftime("%B",mktime(0, 0, 0, $_REQUEST['m'], 1, 2000));
			$filtro_subtemas .= " AND MONTH(t.date_tema)=".$_REQUEST['m']." AND YEAR(t.date_tema)=".$_REQUEST['a'];
			$titulo_page = "<b>".ucfirst($nombre).", ".$_REQUEST['a']."</b>";
			$url_filters = "&a=".$_REQUEST['a']."&m=".$_REQUEST['m'];
		}
		else if (isset($_REQUEST['c']) and $_REQUEST['c']!="") {
			$filtro_subtemas.=" AND t.tipo_tema LIKE '%".$_REQUEST['c']."%' ";
			$find_tipo = $_REQUEST['c'];
			$titulo_page = "<b>".ucfirst($_REQUEST['c'])."</b>";
			$url_filters = "&c=".$_REQUEST['c'];
		}
		else if (isset($_REQUEST['find_reg']) and $_REQUEST['find_reg']!="") {
			$filtro_subtemas.=" AND t.nombre LIKE '%".$_REQUEST['find_reg']."%' ";$find_reg=$_REQUEST['find_reg'];
			$titulo_page = strTranslate("Search_results")." <b>".$_REQUEST['find_reg']."</b>";
		}
		else if (isset($_REQUEST['f']) and $_REQUEST['f']!="") {
			$filtro_subtemas.=" AND t.nombre LIKE '%".$_REQUEST['f']."%' ";$find_reg=$_REQUEST['f'];
			$titulo_page = strTranslate("Search_results")." <b>".$_REQUEST['f']."</b>";
		}	  
		else if (isset($_POST['tipo-sel']) and $_POST['tipo-sel']==1) {
			$filtro_subtemas.= " AND t.tipo_tema LIKE '%".$_POST['find_tipo']."%' ";
			$find_tipo=$_POST['find_tipo'];
		}

		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Blog"), "ItemUrl"=>"#"),
			array("ItemLabel"=>$titulo_page, "ItemClass"=>"active"),
		));

		$total_reg = connection::countReg("foro_temas t",$filtro_subtemas);
		$sub_temas = $foro->getTemas($filtro_subtemas,' LIMIT '.$inicio.','.$reg);
		foreach($sub_temas as $sub_tema):
		echo '<div class="row">
				<div class="col-md-12">';
		ForoList($sub_tema,"blog");	  
		echo '	</div>
			 </div>';			
		endforeach;  

		Paginator($pag,$reg,$total_reg,'blog-list'.$url_filters,'',$find_reg); ?>	 

	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<?php
			//BUSCADOR
			searchBlog();
					  
			//ENTRADAS RECIENTES
			echo '<h4>'.strTranslate("Last_blog").'</h4>';
			$elements = $foro->getTemas($filtro_blog." AND ocio=1 AND activo=1 ORDER BY id_tema DESC LIMIT 3 "); 
			entradasBlog($elements);

			//ARCHIVOS BLOG
			echo '<h4>'.strTranslate("Archive").'</h4>
				  <div class="lateral-container">';
			$elements = $foro->getArchivoBlog($filtro_blog);
			archivoBlog($elements);
			echo '</div>';

			//CATEGORIAS
			$elements = $foro->getCategorias($filtro_blog." AND ocio=1 ");
			echo '<h4>'.strTranslate("Categories").'</h4>';
			categoriasBlog($elements); ?>
		</div>
	</div>
</div>