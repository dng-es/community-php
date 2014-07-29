<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
$menu_admin=0;
function ini_page_header ($ini_conf) {?>
	<script language="JavaScript" src="<?php echo getAsset("muro");?>js/muro-comentarios-responder-ajax.js"></script>
	<!-- ficheros tooltip -->
	<link rel="stylesheet" type="text/css" href="css/jquery.bettertip.css" />     
	<script type="text/javascript" src="js/jquery.bettertip.pack.js"></script>      
	<script type="text/javascript">
			$(function(){
					BT_setOptions({openWait:250, closeWait:0, cacheEnabled:true});
			})
	</script>
	<!-- fin ficheros tooltip -->
<?php }
function ini_page_body ($ini_conf){
	$muro = new muro();
	if (isset($_REQUEST['id']) and $_REQUEST['id']!="" ){$id_comentario=$_REQUEST['id'];}
	else {$id_comentario=0;}
	
	//OBTENER DATOS DEL COMENTARIO
	$filtro_comentario = " AND id_comentario=".$id_comentario." ";					   
	$comentario_muro = $muro->getComentarios($filtro_comentario);
	
	$cabeceras = new headers();

 
///////////////////////////////////////////////////////////////////////////////////////////
//	CUERPO			///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////   

	echo '<div id="page-info">Respuestas en el muro</div>';
	echo '<div class="row inset row-top">';
	echo '<div class="col-md-9">';

	//SOLO LOS COMERCIALES,FORMADORES Y ADMIN PUEDEN INSERTAR COMENTARIOS
	if ($_SESSION['user_perfil']=='admin' or $_SESSION['user_perfil']=='usuario' or $_SESSION['user_perfil']=='formador' or $_SESSION['user_perfil']=='responsable' or $_SESSION['user_perfil']=='forosIns')
	{				
	echo '<div id="muro-insert">
					<form id="form-responder-muro" name="form-responder-muro" action="" method="post" role="form">
					<input type="hidden" name="id_comentario_responder" id ="id_comentario_responder" value="'.$id_comentario.'" />
					<p>insertar nueva respuesta al comentario:</p>';
	echo '  <textarea maxlength="160" class="form-control" id="texto-responder" name="texto-responder"></textarea>
					<button class="btn btn-primary" type="button" id="muro-submit" name="muro-submit">Responder</button>
					</form>
				</div>
				<div id="result-muro"></div>';
	}
	//MOSTRAR DATOS DEL COMENTARIO ORIGINAL
	echo '<div class="respuesta-original">
					<b>'.$comentario_muro[0]['nick'].' escribi&oacute;:</b> <em>'.$comentario_muro[0]['comentario'].'</em>
				</div>';

	//echo '<h2 class="h2Seccion">respuestas al comentario en el muro de: <span style="font-weight: bold">'.$comentario_muro[0]['nick'].'</span></h2>';
	//OBTENER RESPUESTAS DEL COMENTARIO
	echo '<div id="cargando" style="display:none"><i class="fa fa-spinner fa-spin ajax-load"></i></div>
				<div id="destino"></div>';  

	echo '</div></div>';
}
?>