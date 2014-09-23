<?php

templateload("gallery","fotos");
templateload("addfile","fotos");

addCss(array("css/prettyPhoto.css"));

addJavascripts(array("js/bootstrap.file-input.js", 
					 "js/jquery.bettertip.pack.js", 
					 "js/jquery.prettyPhoto.js", 
					 getAsset("fotos")."js/fotos-gallery.js",
					 getAsset("fotos")."js/fotos.js"));

$fotos = new fotos();

//FILTROS
$busqueda="";
$mensaje = "";
$filtro_galerias = " AND activo=1 ";
$find_reg = "";
$filtro=" AND formacion=0 AND id_promocion=0 ";
if (isset($_POST['find_reg'])) {$filtro=" AND titulo LIKE '%".$_POST['find_reg']."%' ";$find_reg=$_POST['find_reg'];$busqueda=$_POST['find_reg'];}
if (isset($_REQUEST['f'])) {$filtro=" AND titulo LIKE '%".$_REQUEST['f']."%' ";$find_reg=$_REQUEST['f'];$busqueda=$_REQUEST['f'];} 

if ($_SESSION['user_canal']!='admin' and $_SESSION['user_perfil']!='formador'){$filtro.=" AND f.canal='".$_SESSION['user_canal']."' ";}
$filtro.=" AND estado=1 ";

//PAGINATOR
$reg = 4;
if (isset($_GET["pag"])) {$pag = $_GET["pag"];}
if (!isset($pag)) { $inicio = 0; $pag = 1;}
else { $inicio = ($pag - 1) * $reg;}
$total_reg = fotos::countReg("galeria_fotos_albumes f ",$filtro_galerias);

//OBTENCION DE LOS ALBUMES
$elements = $fotos->getFotosAlbumes($filtro_galerias." ORDER BY id_album DESC ".' LIMIT '.$inicio.','.$reg);

?>
<div class="row row-top">
	<div class="col-md-8 col-lg-9 inset">
		<h1><?php echo strTranslate("Photo_gallery");?></h1>
		<?php
		session::getFlashMessage( 'actions_message' );
		fotosController::voteAction();
		fotosController::createAction();
		if ($mensaje!=""){ErrorMsg($mensaje);}

		//fila filtros
		// echo '  <div class="row">
		// 					<div class="col-md-12">
		// 						<a href="?page=fotos&o=1&f='.$busqueda.'" class="Tam11">ordenar por votaciones &raquo;</a>  
		// 						<a href="?page=fotos&o=2&f='.$busqueda.'" class="Tam11">ordenar por fecha &raquo;</a>
		// 					</div>
		// 				</div>';
		foreach($elements as $element):
			//obtener fotos del album
			$filtro = " AND estado=1 AND id_album=".$element['id_album']." ORDER BY rand() LIMIT 4 ";
			$fotos_album = $fotos->getFotos($filtro);
			$num_fotos = $fotos->countReg("galeria_fotos", " AND estado=1 AND id_album=".$element['id_album']." ");
			echo '<div class="gallery-container">
					<p>'.$element['nombre_album'].' <span>('.$num_fotos.' fotos)</span></p>
					<div class="trigger-gallery-container">
						<img class="trigger-gallery blanco-negro" data-target="#myModal" data-album="'.$element['nombre_album'].'" data-id="'.$element['id_album'].'" src="'.PATH_FOTOS.$fotos_album[0]['name_file'].'" title="'.$fotos_album[0]['titulo'].'" />
				  	</div>';
			echo '	<div class="hidden-xs hidden-sm">';
			for ($i = 1; $i <= 3; $i++) {
			    echo '<div class="col-md-4 nopadding">
						<div class="gallery-container-mini">';
				//siel el album no tiene imagenes suficientes no se muestra la <imagen>
				if (isset($fotos_album[$i]['name_file'])){
					echo '		<img class="trigger-gallery blanco-negro gallery-container-mini-img'.$i.'" data-target="#myModal" data-id="'.$element['id_album'].'" src="'.PATH_FOTOS.$fotos_album[$i]['name_file'].'" title="'.$fotos_album[$i]['titulo'].'" />';
				}
				echo '	</div>
			    	  </div>';
			}
			echo '	</div>
				</div>';			  
		endforeach; ?>
	
		<?php Paginator($pag,$reg,$total_reg,'fotos-gallery','fotos',$find_reg,10,"selected-galeria"); ?>

	</div>
	<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">
			<?php PanelSubirFoto(0); 
			echo '<div class="alert-message alert alert-danger" id="alertas-participa"></div>';

			echo '<h4>Últimas fotos</h4>';
			$ultimas = $fotos->getFotosConAlbumes(" AND g.estado=1 AND g.id_promocion=0 ORDER BY g.id_file DESC LIMIT 3");
			foreach($ultimas as $element):
				echo '<div class="galeria-ultimos"><img class="trigger-gallery" data-target="#myModal" data-id="'.$element['id_album'].'" src="'.PATH_FOTOS.$element['name_file'].'" title="'.$element['titulo'].'" /></div>
					  <p><b>'.$element['titulo'].'</b><br />
					  Album: <b>'.$element['nombre_album'].'</b></p>';
			endforeach; ?>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal modal-wide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Album de fotos</h4>
			</div>
			<div class="modal-body">
				...
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->