<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
templateload("blog","foro");
templateload("comment","foro");
templateload("addcomment","foro");
$menu_admin=0;
function ini_page_header ($ini_conf) {?>
	<!-- ficheros tooltip -->  
	<script type="text/javascript" src="js/jquery.bettertip.pack.js"></script>      
	<script type="text/javascript">
		$(function(){
				BT_setOptions({openWait:250, closeWait:0, cacheEnabled:true});
		})
	</script>
	<!-- fin ficheros tooltip --> 
	<!-- textarea -->
	<script src="js/jquery.jtextarea.js"></script>
	<script>
		$(document).ready(function(){
			 $(".jtextareaComentar").jtextarea({maxSizeElement: 600,
			 cssElement: { display: "inline-block",color: "#666666",background: "transparent"}});		
		})
	</script>
	<!-- fin textarea -->

	<script type="text/javascript">
		jQuery(document).ready(function(){
			$("#archivo-cmb").change(function(){
				var valor = $(this).val(),
					myarr = valor.split(",");
				window.location = "?page=blog-list&m=" + myarr[0] + "&a=" + myarr[1];
			});
		});
	</script>

	<script language="JavaScript" src="<?php echo getAsset("foro");?>js/foro-comentario.js"></script>
					
<?php }
function ini_page_body ($ini_conf){
	$foro = new foro();
	

	echo '<div id="page-info"><img src="images/blog-logo.png" /><span>Blog de la comunidad</span></div>';
	echo '<div class="row row-top">
			<div class="col-md-9 inset">';


	session::getFlashMessage( 'actions_message' );	
	foroController::createRespuestaAction();
	foroController::votarAction();								
	
	//OBTENCION DE LOS DATOS DEL FORO 
	if (isset($_REQUEST['id'])){$id_tema=$_REQUEST['id'];}
	if (isset($_REQUEST['f'])){$id_tema=$_REQUEST['f'];} 
	if (isset($id_tema) and $id_tema!=""){
		if ($_SESSION['user_perfil']!="admin" and $_SESSION['user_perfil']!="formador" and $_SESSION['user_perfil']!="foros") {
			$filtro_tema=" AND (canal='".$_SESSION['user_canal']."' OR   canal='admin') ";
			$filtro_comentarios=" AND c.id_tema=".$id_tema." ";
		}
		$filtro_tema .= " AND id_tema=".$id_tema." AND activo=1 AND ocio=1 ";
		$tema = $foro->getTemas($filtro_tema); 
	}

	echo '<div class="message-form" id="alertas-mensajes" style="display: none"></div>';

	if (isset($id_tema) and $id_tema!=""){

	//SHOW PAGINATOR
	//if ($_SESSION['user_perfil']!='admin' and $_SESSION['user_perfil']!='formador') 
	//{ $filtro_comentarios .= " AND t.canal='".$_SESSION['user_canal']."' ";}
	if (isset($_POST['find_reg'])) {$filtro_comentarios=" AND c.id_tema=".$_POST['find_reg']." ";$find_reg=$_POST['find_reg'];}
	if (isset($id_tema)) {$filtro_comentarios=" AND c.id_tema=".$id_tema." ";$find_reg=$id_tema;} 
	
	if ($filtro_comentarios==""){$filtro_comentarios=" AND c.id_tema=0 ";}
	$filtro_comentarios .= " AND estado=1 ";
	 
	$reg = 10;
	if (isset($_GET["pag"])) {$pag = $_GET["pag"];}
	if (!$pag) { $inicio = 0; $pag = 1;}
	else { $inicio = ($pag - 1) * $reg;}
	$total_reg = foro::countReg("foro_comentarios c",$filtro_comentarios);
	$num_visitas=$foro->countReg("foro_visitas"," AND id_tema=".$id_tema." ");

	echo '<h2>'.$tema[0]['nombre'].'</h2>
		<p class="legend"><span class="fa fa-comment"></span> '.$total_reg.' comentarios <span class="fa fa-eye"></span> '.$num_visitas.' visitas</span></p>
		'.$tema[0]['descripcion'];

	//enlaces de pagina siguiente y anterior
	$anterior_disabled="";
	$anterior = $foro->getTemas(" AND activo=1 AND ocio=1 AND id_tema>".$id_tema." ORDER BY id_tema ASC  LIMIT 1");
	if (count($anterior)!=1){$anterior_disabled = "disabled";$anterior_enlace="#";}
	else{$anterior_enlace = "?page=blog&id=".$anterior[0]['id_tema'];}

	$siguiente_disabled="";
	$siguiente = $foro->getTemas(" AND activo=1 AND ocio=1 AND id_tema<".$id_tema." ORDER BY id_tema DESC LIMIT 1");
	if (count($siguiente)!=1){$siguiente_disabled = "disabled";$siguiente_enlace="#";}
	else{$siguiente_enlace='?page=blog&id='.$siguiente[0]['id_tema'];}
	// echo '<ul class="pager">
	// 				<li class="previous '.$anterior_disabled .'"><a href="'.$anterior_enlace.'">&larr; Entrada anterior</a></li>
	// 				<li class="next '.$siguiente_disabled .'"><a href="'.$siguiente_enlace.'">Entrada siguiente &rarr;</a></li>
	// 			</ul>';    


	if (count($tema)>0){	
		//INSERTAR VISITA EN EL FORO
		$foro->insertVisita($_SESSION['user_name'],$id_tema,0);
		//INSERTAR NUEVOS COMENTARIOS EN EL BLOG

		echo '<div class="insert-comment">
				<p>¿Qué piensas de este artículo? déjanos tu comentario</p>';
				addForoComment($id_tema);
		echo '</div>';


		
		echo '<div class="panel-container-foro">';
		$filtro_comentarios.= " ORDER BY date_comentario DESC";
		$comentarios_foro = $foro->getComentarios($filtro_comentarios.' LIMIT '.$inicio.','.$reg); 
		foreach($comentarios_foro as $comentario_foro):
			commentForo($comentario_foro,"blog");
		endforeach;	
		echo '</div>';
		
		if ($total_reg==0){ echo '<div class="alert alert-warning">Todavía no se han insertado comentarios en este foro.</div>';}
		else {Paginator($pag,$reg,$total_reg,'blog&id='.$id_tema,'comentarios',$find_reg,10,"selected-foro");}

		//ENTRADAS SIMILARES
		echo '<div class="blog-similares">
				<h4>También te puede interesar</h4>';
		$filtro_etiquetas = "";
		$etiquetas = explode(",",$tema[0]['tipo_tema']);
		foreach($etiquetas as $etiqueta):
				$filtro_etiquetas .= " OR tipo_tema LIKE '%".$etiqueta."%' ";
		endforeach;
		$filtro_etiquetas = substr($filtro_etiquetas, 3);
		$filtro_etiquetas = " AND (".$filtro_etiquetas.") AND id_tema<>".$tema[0]['id_tema']." ";
		$elements = $foro->getTemas(" AND ocio=1 AND activo=1 ".$filtro_etiquetas." ORDER BY rand() DESC LIMIT 4 "); 
		foreach($elements as $element):
			echo '<div class="modal-img-container-info">
					<div class="modal-img-container">
							<a href="?page=blog&id='.$element['id_tema'].'"><img src="images/foro/'.$element['imagen_tema'].'" title="'.$element['nombre'].'" /></a>
					</div>
					<p>'.$element['nombre'].'</p>
				</div>';
		endforeach; 
		echo '</div>';

		//enlaces de pagina siguiente y anterior
		echo '<ul class="pager">
						<li class="previous '.$anterior_disabled .'"><a href="'.$anterior_enlace.'">&larr; Entrada anterior</a></li>
						<li class="next '.$siguiente_disabled .'"><a href="'.$siguiente_enlace.'">Entrada siguiente &rarr;</a></li>
					</ul>';
		}
	}

	echo '</div>';

////////////////////////////////////////////////////////
//LATERAL DERRECHO
////////////////////////////////////////////////////////
	echo '<div class="col-md-3 lateral lateral-container">';
	//BUSCADOR
	echo '<div class="lateral-container-int">';
	searchBlog();
	echo '</div>';

	//ENTRADAS RECIENTES
	echo '	<h4>Entradas recientes</h4>';
	$elements = $foro->getTemas(" AND ocio=1 AND activo=1 ORDER BY id_tema DESC LIMIT 3 "); 
	entradasBlog($elements);

	//ARCHIVO BLOG
	echo '<h4>Archivos</h4>
		  <div class="lateral-container">';
	$elements = $foro->getArchivoBlog();
	archivoBlog($elements);
	echo '</div>';

	//CATEGORIAS
	$elements = $foro->getCategorias(" AND ocio=1 ");
	echo '<h4>Categorias</h4>';
	categoriasBlog($elements);

		
		echo '</div>';
	echo '</div>';
}
?>