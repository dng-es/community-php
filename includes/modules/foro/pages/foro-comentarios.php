<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);


templateload("addcomment","foro");
templateload("comment","foro");

$menu_admin=0;
function ini_page_header ($ini_conf) {?>
	<script language="JavaScript" src="<?php echo getAsset("foro");?>js/foro-comentario.js"></script>     
	
	<!-- ficheros tooltip -->
	<link rel="stylesheet" type="text/css" href="css/jquery.bettertip.css" />     
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
		 cssElement: { display: "inline-block",color: "#cccccc",background: "transparent"}});		
	})
	</script>
	<!-- fin textarea -->       
<?php }
function ini_page_body ($ini_conf){
	$foro = new foro();	

///////////////////////////////////////////////////////////////////////////////////////////
//	LATERAL IZQUIERDO		///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

	echo '<div id="page-info">Foros</div>';
	echo '<div class="row row-top">
					<div class="col-md-8 inset">';

	session::getFlashMessage( 'actions_message' );
	foroController::createRespuestaAction();
	foroController::votarAction();
	
	//OBTENCION DE LOS DATOS DEL FORO
	if (isset($_REQUEST['id'])){$id_tema=$_REQUEST['id'];}
	if (isset($_REQUEST['f'])){$id_tema=$_REQUEST['f'];}
	if (isset($id_tema) and $id_tema!=""){
		$find_reg = $id_tema;
		$filtro_tema = " AND id_tema=".$id_tema." AND activo=1 ";
		
		if ($_SESSION['user_perfil']!="admin" and $_SESSION['user_perfil']!="formador" and $_SESSION['user_perfil']!="foros") {
			$filtro_tema .= " AND canal='".$_SESSION['user_canal']."' ";	
		}	
		
		$tema = $foro->getTemas($filtro_tema); 
		
		//VOLVER ATRAS: SI ES UN FORO DE AREAS VOLVERA A LA PAGINA DE AREAS,
		//SI ES OTRO TIPO DE FORO VOLVERA A LA PAGINA DE SUBFOROS
		if ($tema[0]['id_area']<>0) { $volver="areas_det&id=".$tema[0]['id_area'];}  
		else { $volver="foro-subtemas&id=".$tema[0]['id_tema_parent'];}
			
		if (count($tema)>0){			
			//PAGINATOR
			$reg = 5;
			$pag = 1;
			$inicio = 0;
			if (isset($_GET["pag"]) and $_GET["pag"]!="") {
				$pag = $_GET["pag"];
				$inicio = ($pag - 1) * $reg;
			}

			$filtro_comentarios = " AND c.id_tema=".$id_tema." AND estado=1 AND id_comentario_id=0";
			$total_reg = foro::countReg("foro_comentarios c",$filtro_comentarios);
			$total_reg_resp = foro::countReg("foro_comentarios c"," AND c.id_tema=".$id_tema." AND estado=1 ");
			$num_visitas = $foro->countReg("foro_visitas"," AND id_tema=".$id_tema." ");

			echo '<h2>'.$tema[0]['nombre'].'</h2>
				<p class="legend"><span class="fa fa-comment"></span> '.$total_reg_resp.' '.strTranslate("Comments").' <span class="fa fa-eye"></span> '.$num_visitas.' '.strTranslate("Visits").' <i class="fa fa-mail-reply"></i> <a href="?page='.$volver.'" title="'.strTranslate("Go_back").'">'.strTranslate("Go_back").'</a></p>
				<p>'.$tema[0]['descripcion'].'</p>';

			echo '<div class="panel-container-foro">';
			$filtro_comentarios.= " ORDER BY date_comentario DESC";
			$comentarios_foro = $foro->getComentarios($filtro_comentarios.' LIMIT '.$inicio.','.$reg); 
			foreach($comentarios_foro as $comentario_foro):
				commentForo($comentario_foro);
			endforeach;	
			echo '</div>';
			
			if ($total_reg==0){ echo '<div class="alert alert-warning">Todavía no se han insertado comentarios en este foro.</div>';}
			else {Paginator($pag,$reg,$total_reg,'foro-comentarios','comentarios',$find_reg,10,"selected-foro");}
		}
	}

///////////////////////////////////////////////////////////////////////////////////////////
//  LATERAL DERECHO     ///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////  
?> 
	</div>
	<div class="col-md-4 lateral">
		<div class="insert-foro">
			<h4>Inserta comentario</h4>
			<p>Inserta un nuevo comentario en el foro. Máximo 600 caracteres.</p>
			<?php 

			addForoComment($id_tema); 

			//INSERTAR VISITA EN EL FORO
			if (!isset($_POST['texto-comentario'])){
				$foro->insertVisita($_SESSION['user_name'],$id_tema,0);
			}
		?>
		</div>
	</div>
</div>
<?php
}
?>