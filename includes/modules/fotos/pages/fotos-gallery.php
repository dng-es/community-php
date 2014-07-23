<?php
///////////////////////////////////////////////////////////////////////////////////
// FRAMEWORK_DA
// Author: David Noguera Gutierrez
// License: GPL
// Date: 2010-09-18
// Please don't remove these lines
///////////////////////////////////////////////////////////////////////////////////
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

templateload("gallery","fotos");
templateload("addfile","fotos");

$menu_admin=0;
$menu_sel = 3;
function ini_page_header ($ini_conf) {?>
		<!-- Bootstrap input file -->
		<script type="text/javascript" src="js/bootstrap.file-input.js"></script>

		<!-- tooltip -->
		<link rel="stylesheet" type="text/css" href="css/jquery.bettertip.css" />     
		<script type="text/javascript" src="js/jquery.bettertip.pack.js"></script>      
		<script type="text/javascript">
				$(function(){
						BT_setOptions({openWait:250, closeWait:0, cacheEnabled:true});
				})
		</script>
		<!-- fin tooltip --> 
		<link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
		<script src="js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){
			$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animationSpeed:'slow',theme:'facebook',slideshow:4000, autoplay_slideshow: true});
			$(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animationSpeed:'slow',slideshow:50000});
			
			$("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
				custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
				changepicturecallback: function(){ initialize(); }
			});

			$("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
				custom_markup: '<div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
				changepicturecallback: function(){ _bsap.exec(); }
			});
		});
		</script>
		<script language="javascript" type="text/javascript">
			$(document).ready(function(){
				$(".trigger-gallery").click(function(){
					var id_album = $(this).attr("data-id"),
						nombre_abum = $(this).attr("data-album");
					$(".modal-body").load("fotos-gallery-ajax.php?id=" + id_album,function(){
						$("#myModalLabel").html(nombre_abum);
						$('#myModal').modal('show');
					})
				});

				resizeGallery();
				$(window).resize(function(event) {
					resizeGallery();
				});

				function resizeGallery(){
					var elem = $(".gallery-container-mini"),
						ancho = elem.width()*(0.7);
					elem.css("height",ancho);
					$(".gallery-container-mini img").css("min-height",ancho);	
				}		
			});
		</script>
<?php }
function ini_page_body ($ini_conf){
	$fotos = new fotos();
	
	//INSERTAR FOTO
	if (isset($_POST['titulo-foto']) and $_POST['titulo-foto']!=""){
	if ($_SESSION['user_perfil']!='admin' and $_SESSION['user_perfil']!='formador'){$canal=$_SESSION['user_canal'];}
	else { $canal=$_POST['canal-foto'];}
	if($_SESSION['user_perfil']=='formador'){$formacion=1;}
	else {$formacion=0;}
	$mensaje=$insercion_foto = $fotos->insertFile($_FILES['nombre-foto'],PATH_FOTOS,$canal,$_POST['titulo-foto'],0,$formacion);
	}
	
	//VOTAR FOTO
	if (isset($_REQUEST['idvf']) and $_REQUEST['idvf']!="") { 
		$mensaje=$insercion_votacion = $fotos->InsertVotacion($_REQUEST['idvf'],$_SESSION['user_name']);}
	?>
	<div id="page-info"><?php echo strTranslate("Photo_gallery");?></div>
	<div class="row row-top">
		<div class="col-md-9 inset">

 
<?php
	//FILTROS
	$busqueda="";
	$filtro_galerias = " AND activo=1 ";
	$find_reg = "";
	if ($filtro==""){$filtro=" AND formacion=0 AND id_promocion=0 ";}
	if (isset($_POST['find_reg'])) {$filtro=" AND titulo LIKE '%".$_POST['find_reg']."%' ";$find_reg=$_POST['find_reg'];$busqueda=$_POST['find_reg'];}
	if (isset($_REQUEST['f'])) {$filtro=" AND titulo LIKE '%".$_REQUEST['f']."%' ";$find_reg=$_REQUEST['f'];$busqueda=$_REQUEST['f'];} 
	
	if ($_SESSION['user_canal']!='admin' and $_SESSION['user_perfil']!='formador'){$filtro.=" AND f.canal='".$_SESSION['user_canal']."' ";}
	$filtro.=" AND estado=1 ";
	
	//PAGINATOR
	$reg = 4;
	if (isset($_GET["pag"])) {$pag = $_GET["pag"];}
	if (!$pag) { $inicio = 0; $pag = 1;}
	else { $inicio = ($pag - 1) * $reg;}
	$total_reg = fotos::countReg("galeria_fotos_albumes f ",$filtro_galerias);
	

	if ($mensaje!=""){ErrorMsg($mensaje);}

	//fila filtros
	// echo '  <div class="row">
	// 					<div class="col-md-12">
	// 						<a href="?page=fotos&o=1&f='.$busqueda.'" class="Tam11">ordenar por votaciones &raquo;</a>  
	// 						<a href="?page=fotos&o=2&f='.$busqueda.'" class="Tam11">ordenar por fecha &raquo;</a>
	// 					</div>
	// 				</div>';


	//OBTENCION DE LOS ALBUMES
	echo '  <div class="row">
						<div class="col-md-12">';
	echo '      <div class="gallery clearfix">';
	$elements = $fotos->getFotosAlbumes($filtro_galerias." ORDER BY id_album DESC ".' LIMIT '.$inicio.','.$reg);
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
	endforeach;
	
echo '<!-- Modal -->
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
		</div><!-- /.modal -->';

	echo '      </div>';
	echo '    </div>
			</div>'; 

	//fila paginador
	echo '  <div class="row">
				<div class="col-md-12">';
	Paginator($pag,$reg,$total_reg,'fotos-gallery','fotos',$find_reg,10,"selected-galeria");
	echo '  	</div>
			</div>';

	echo '</div>
		  <div class="col-md-3 lateral">';
	//buscador
	//SearchForm($reg,"?page=fotos","searchForm","Buscar foto por título","buscar");
	//PANEL SUBIR ARCHIVOS
	PanelSubirFoto(0); 
	echo '<div class="alert-message alert alert-danger" id="alertas-participa"></div>';

	echo '<h4>Últimas fotos</h4>';
	$ultimas = $fotos->getFotosConAlbumes(" AND g.estado=1 AND g.id_promocion=0 ORDER BY g.id_file DESC LIMIT 3");
	foreach($ultimas as $element):
		echo '<div class="galeria-ultimos"><img class="trigger-gallery" data-target="#myModal" data-id="'.$element['id_album'].'" src="'.PATH_FOTOS.$element['name_file'].'" title="'.$element['titulo'].'" /></div>
			  <p><b>'.$element['titulo'].'</b><br />
			  Album: <b>'.$element['nombre_album'].'</b></p>';
	endforeach;
	echo '</div>
		</div>';
}
?>