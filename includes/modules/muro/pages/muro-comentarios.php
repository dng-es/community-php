<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);
include_once ("includes/muro/templates/reply.php");
$menu_admin=0;
function ini_page_header ($ini_conf) {?>
	<script language="JavaScript" src="<?php echo getAsset("muro");?>js/muro-comentarios-todos-ajax.js"></script>
    <!-- ficheros tooltip -->
    <link rel="stylesheet" type="text/css" href="css/jquery.bettertip.css" />     
    <script type="text/javascript" src="js/jquery.bettertip.pack.js"></script>      
    <script type="text/javascript">
        $(function(){
            BT_setOptions({openWait:250, closeWait:0, cacheEnabled:true});
        })
    </script>
    <!-- fin ficheros tooltip -->  
    <script>
		$(document).ready(function(){
		   	$(".comunidad-panel").fadeIn(1000);	
		})
	</script>
<?php }
function ini_page_body ($ini_conf){
  $muro = new muro();	
  if (isset($_REQUEST['id']) and $_REQUEST['id']!="" ){$id_comentario=$_REQUEST['id'];}
  else {$id_comentario=0;}
  
  //OBTENCION DE LOS COMENTARIOS DEL MURO
  if (isset($_REQUEST['c'])){$nombre_muro=$_REQUEST['c'];}
  if (isset($_POST['tipo_responder'])){$nombre_muro=$_POST['tipo_responder'];}
  if (isset($_POST['tipo_muro'])){$nombre_muro=$_POST['tipo_muro'];}
  if ($nombre_muro==""){$nombre_muro="principal";}  
  if (isset($_REQUEST['pag'])){$pagina=$_REQUEST['pag'];}
  else{$pagina=1;}
  
  $cabeceras = new headers();
  echo '<div id="page-info">El muro</div>';
  echo '<div class="row inset row-top">
  			<div class="col-md-9">';  

///////////////////////////////////////////////////////////////////////////////////////////
//	LATERAL DERECHO			///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////   
  echo '<span id="tipo_muro" value="'.$nombre_muro.'"></span>
		<span id="pagina" value="'.$pagina.'"></span>';
	  //SOLO LOS COMERCIALES,FORMADORES Y ADMIN PUEDEN INSERTAR COMENTARIOS
	  if ($_SESSION['user_perfil']=='admin' or $_SESSION['user_perfil']=='usuario' or $_SESSION['user_perfil']=='formador' or $_SESSION['user_perfil']=='responsable' or $_SESSION['user_perfil']=='forosIns')
	  {				
	echo '
		  <div id="muro-insert">
		  <form id="muro-form" name="coment-form" action="" method="post" role="form">
		  <input type="hidden" name="tipo_muro" id ="tipo_muro" value="principal" />';		  
	echo '<p>insertar nuevo comentario en el muro:</p>
		  <textarea maxlength="160" class="form-control muro-texto" id="texto-comentario" name="texto-comentario"></textarea>';
	if ($_SESSION['user_perfil']=='admin' or $_SESSION['user_perfil']=='formador'){
		echo '<select name="canal_comentario" id="canal_comentario" class="form-control">
				<option value="comercial">Canal comerciales</option>
				<option value="gerente">Canal gerentes</option>
			</select>';	
    }
	else {$posicion_alerta=' style=" top: -54px"';}
	echo '  <button class="muro-enviar btn btn-primary" type="button" id="muro-submit" value="Enviar" name="coment-submit">Enviar</button>   
		  </form>
		  </div>';
	  }
	  
	  echo '<div id="result-muro" '.$posicion_alerta.'></div>';
  echo '<div id="destino">
  			<div id="cargando" style="display:none"><i class="fa fa-spinner fa-spin ajax-load"></i></div>
  		</div>';		
  echo '</div></div>';
  
  replyMuro();
	
}	  	
?>