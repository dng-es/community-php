<?php
$base_dir = str_replace('modules/muro/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/class.users.php");
include_once($base_dir . "modules/muro/class.muro.php");
include_once($base_dir . "modules/muro/templates/comment.php");

?>
<!DOCTYPE html>
	<html lang="es">
		<head>
		<meta charset="utf-8">
		<script type="text/javascript" src="js/jquery.js"></script>

		<!-- Bootstrap core -->
	    <link href="css/bootstrap.min.css" rel="stylesheet">
	    <script src="js/bootstrap.min.js"></script>

		<LINK rel="stylesheet" type="text/css" href="css/styles.css" />
		<script language="JavaScript" src="includes/modules/muro/resources/js/muro-comentario.js"></script>
		<script language="JavaScript" src="includes/modules/muro/resources/js/muro-respuestas-ajax.js"></script>
		
		<!-- tooltip -->	
		<link rel="stylesheet" type="text/css" href="css/jquery.bettertip.css" />     
		<script type="text/javascript" src="js/jquery.bettertip.pack.js"></script> 
		<script type="text/javascript">
				$(function(){
						BT_setOptions({openWait:250, closeWait:0, cacheEnabled:true});
				})
		</script>
		<!-- fin tooltip -->   
		
		<!-- fechas -->
		<script type="text/javascript">
				jQuery(document).ready(function(){
					var ahora = "<?php echo users::timeServer();?>";
					ahora = ahora.replace(" ","T") + "Z";
					$(".date-format-ago").each(function(){
							 var date2 = $(this).attr("data-date").replace(" ","T") + "Z";
							 var date = prettyDate(ahora,date2);
							 if (date) {
									$(this).text(date);
							 }
					});
				});
		</script>
		<!-- fin fechas -->        
</head>
<body> 
	<div id="responder-form" style="height: 40px; display:none"></div> 
<?php
session::ValidateSessionAjax();
$muro=new muro();
	

//OBTENER COMENTARIOS DEL MURO
if (isset($_REQUEST['c'])){$nombre_muro=$_REQUEST['c'];}
if (isset($_POST['tipo_responder'])){$nombre_muro=$_POST['tipo_responder'];}
if (isset($_POST['tipo_muro'])){$nombre_muro=$_POST['tipo_muro'];}
if ($nombre_muro==""){$nombre_muro="principal";}
if ($_SESSION['user_perfil']!='admin' and $_SESSION['user_perfil']!='formador') { $filtro_comentarios .= " AND c.canal='".$_SESSION['user_canal']."' ";}
$filtro_comentarios .= " AND id_comentario_id=0 AND estado=1 AND tipo_muro='".$nombre_muro."' 
						 AND tipo_muro IN ('principal','responsable') ORDER BY date_comentario DESC";

//SHOW PAGINATOR
$reg = 10;
$inicio = 0;
if (isset($_GET["pag"])) {$pag = $_GET["pag"];}
if (!$pag) { $inicio = 0; $pag = 1;}
else { $inicio = ($pag - 1) * $reg;}
$total_reg = connection::countReg("muro_comentarios c",$filtro_comentarios);
		
$comentarios_muro = $muro->getComentarios($filtro_comentarios.' LIMIT '.$inicio.','.$reg);
echo '<div id="muro-home" style="height: 100% !important">';
foreach($comentarios_muro as $comentario_muro):
	commentMuro($comentario_muro);
endforeach;
Paginator($pag,$reg,$total_reg,'muro-comentarios&c='.$nombre_muro,'comentarios',$find_reg,10,"selected-muro");
if(count($comentarios_muro)==0){ echo '<p>No hay comentarios en el muro</p>';}	
echo '</div>';
?> 

</body>
</html>