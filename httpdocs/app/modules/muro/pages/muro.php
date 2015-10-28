<?php
$base_dir = str_replace('modules/muro/pages', '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");
include_once($base_dir . "modules/muro/classes/class.muro.php");
include_once($base_dir . "modules/muro/templates/comment.php");

?>
<!DOCTYPE html>
<html lang="es">
	<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/styles.css" />
	<link rel="stylesheet" type="text/css" href="css/libs/customscrollbar/jquery.mCustomScrollbar.css" />
	<script language="JavaScript" src="js/libs/customscrollbar/jquery.mCustomScrollbar.min.js"></script>
	<script language="JavaScript" src="app/modules/muro/resources/js/muro-respuestas-ajax.js"></script>
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

			$(".user-tip").tooltip({
				'placement': 'left',
				'container': 'body'
			});
			
			$("#muro-home").mCustomScrollbar();
		});
	</script>
	</head>
	<body>
		<div id="responder-form" style="display: none"></div>
		<?php
		session::ValidateSessionAjax();
		$muro = new muro(); 
		$filtro = "";
		if ($_SESSION['user_canal'] != 'admin') $filtro = " AND c.canal='".$_SESSION['user_canal']."' ";
		$filtro .= " AND tipo_muro='principal' AND estado=1 AND id_comentario_id=0 ORDER BY date_comentario DESC LIMIT 20";
		$comentarios_muro = $muro->getComentarios($filtro);
		echo '<div id="muro-home">'; 
		foreach($comentarios_muro as $comentario_muro):
			commentMuro($comentario_muro);
		endforeach;
		if (count($comentarios_muro) == 0):?>
		<div class="alert alert-warning"><?php e_strTranslate("No_comments_on_wall");?></div>
		<?php endif;?>
		</div>
		<div class="ver-mas">
			<a href="muro-comentarios?id=principal">
			<span class="fa fa-search"></span> <?php e_strTranslate("More_comments");?></a>
		</div>
	</body>
</html>