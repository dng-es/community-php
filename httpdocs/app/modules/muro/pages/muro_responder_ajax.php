<?php
$base_dir = str_replace('modules/muro/pages', '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");
include_once($base_dir . "modules/muro/classes/class.muro.php");

?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/styles.css" />
		<script type="text/javascript" src="js/main.min.js"></script>
		<script language="JavaScript" src="app/modules/muro/resources/js/muro-comentario.js"></script>
		<script language="JavaScript" src="app/modules/muro/resources/js/muro-respuestas-ajax.js"></script>
		<!-- fechas -->
		<script type="text/javascript">
			jQuery(document).ready(function(){
				var ahora = "<?php echo connection::timeServer();?>";
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
	$muro = new muro();
	$id_comentario = ((isset($_REQUEST['id']) and $_REQUEST['id'] != "") ? $_REQUEST['id'] : 0);
	templateload("tipuser","users");

	$filtro = " AND id_comentario_id=".$id_comentario." ORDER BY date_comentario DESC";
	$comentarios_muro = $muro->getComentarios($filtro);
	echo '<div class="">';
	foreach($comentarios_muro as $comentario_muro):
		$votado = connection::countReg("muro_comentarios_votaciones"," AND id_comentario=".$comentario_muro['id_comentario']." AND user_votacion='".$_SESSION['user_name']."' ");
		if ($_SESSION['user_name'] == $comentario_muro['user_comentario']) $votado_user = 1;
		else $votado_user = 0;
		echo '<div class="media">
				<div class="pull-right text-primary">
					<span class="muro-votado" id="'.$comentario_muro['id_comentario'].'" value="'.$votado.'"></span>
					
					<span class="muro-votado-user" id="user_'.$comentario_muro['id_comentario'].'" value="'.$votado_user.'"></span>
					<span class="murogusta fa fa-heart '.$comentario_muro['id_comentario'].'" 
						value="'.$comentario_muro['id_comentario'].'" 
						href="'.$comentario_muro['votaciones'].'" 
						title="'.strTranslate("Vote_comment").'">
						'.$comentario_muro['votaciones'].'
					</span>
				</div>';
		userFicha($comentario_muro);
		echo '		<p class="comunidad-color"><b>'.$comentario_muro['nick'].'</b> <span class="date-format-ago" data-date="'.$comentario_muro['date_comentario'].'">'.getDateFormat($comentario_muro['date_comentario'], "DATE_TIME").'</span>:';
		//SOLO LOS ADMIN PUEDEN VER EL CANAL
		if ($_SESSION['user_canal'] == 'admin'){  echo ' ('.strTranslate("Channel").': '.$comentario_muro['canal_comentario'].')';}
		echo '		</p>
					<p id="texto-comentario-'.$comentario_muro['id_comentario'].'">'.$comentario_muro['comentario'].'</p>';

		echo '<div id="muro-result-megusta'.$comentario_muro['id_comentario'].'" class="text-danger"></div>';
		echo ' <hr>
			</div>';
	endforeach;
	if(count($comentarios_muro) == 0) echo '<div class="alert alert-warning">'.strTranslate("No_replies_for_this_comment").'.</div>';
	echo '</div>';
	?>
	</body>
</html>