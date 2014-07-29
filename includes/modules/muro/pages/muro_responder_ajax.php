<?php
$base_dir = str_replace('modules/muro/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/class.users.php");
include_once($base_dir . "modules/muro/class.muro.php");

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
  

if(isset($_REQUEST['id']) and $_REQUEST['id']!=""){$id_comentario=$_REQUEST['id'];}
else{$id_comentario=0;}

templateload("tipuser","users");

$filtro=" AND id_comentario_id=".$id_comentario." ORDER BY date_comentario DESC";
$comentarios_muro = $muro->getComentarios($filtro);
echo '<div class="">';
  foreach($comentarios_muro as $comentario_muro):
	$votado = connection::countReg("muro_comentarios_votaciones"," AND id_comentario=".$comentario_muro['id_comentario']." AND user_votacion='".$_SESSION['user_name']."' ");
	if ($_SESSION['user_name']==$comentario_muro['user_comentario']) {$votado_user=1;}
	else {$votado_user=0;}
				echo '<div class="media">';
			userFicha($comentario_muro,0);
			echo '		<p class="comunidad-color"><b>'.$comentario_muro['nick'].'</b> <span class="date-format-ago" data-date="'.$comentario_muro['date_comentario'].'">'.strftime(DATE_TIME_FORMAT,strtotime($comentario_muro['date_comentario'])).'</span> respondió :';
		    //SOLO LOS FORMADORES Y ADMIN PUEDEN VER EL CANAL
		    if ($_SESSION['user_perfil']=='admin' or $_SESSION['user_perfil']=='formador'){  echo ' (canal '.$comentario_muro['canal_comentario'].')';}
			echo '		</p>
						<p id="texto-comentario-'.$comentario_muro['id_comentario'].'">'.$comentario_muro['comentario'].'</p>
						
						
						<div>
							<span class="muro-votado" id="'.$comentario_muro['id_comentario'].'" value="'.$votado.'"></span>
							
							<span class="muro-votado-user" id="user_'.$comentario_muro['id_comentario'].'" value="'.$votado_user.'"></span>
							<span class="murogusta fa fa-heart '.$comentario_muro['id_comentario'].'" 
								value="'.$comentario_muro['id_comentario'].'" 
								href="'.$comentario_muro['votaciones'].'" 
								title="votar comentario">
								'.$comentario_muro['votaciones'].'
							</span>
						</div>';

			echo '<div id="muro-result-megusta'.$comentario_muro['id_comentario'].'" class="muro-result-megusta"></div>';
		  echo ' <hr>
				</div>';  
  endforeach;
  if(count($comentarios_muro)==0){ echo '<p style="clear: both">No hay respuesta para este comentario del muro</p>';}	
  echo '</div>';			
?> 

</body>
</html>
