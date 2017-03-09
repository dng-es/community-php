<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/batallas/pages' : 'modules\\batallas\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");
include_once($base_dir . "modules/batallas/classes/class.batallas.php");

session::ValidateSessionAjax();
$batallas = new batallas();

//datos del usuario
$users = new users();
$user_data = $users->getUsers("AND username='".$_SESSION['user_name']."' ");
$puntos_reservados = connection::sumReg("batallas", "puntos", " AND finalizada=0 AND (user_create='".$_SESSION['user_name']."' or user_retado='".$_SESSION['user_name']."') ");
$puntos_disponibles = $user_data[0]['puntos'] - $puntos_reservados;
?>
<html>
	<head>
		<script type="text/javascript" src="js/libs/jquery-1.10.1.min.js"></script>
		<script type="text/javascript" src="css/libs/bootstrap-sass-3.2.0/assets/javascripts/bootstrap.js"></script>
		<script>
			$(document).ready(function(){
				$("#form-batalla-fin").submit(function(e){
					e.preventDefault();
					$(".alert-message").html("").css("display","none");
					var form_ok = true;
					var name;
					$('input[type="radio"]',this).each(function() {
						if(name == $(this).attr("name")) return;
						name = $(this).attr("name");
						var checked = $(":radio[name="+name+"]:checked");
						if(checked.length == 0) {
							form_ok = false;
						}
					});

					if (form_ok == true) this.submit();
					else{
						$("#batalla-alert").html("Debes responder todas las preguntas.").fadeIn().css("display","block");
						return false;
					}
				});
			});
		</script>
	</head>
	<body>

<?php
if (isset($_POST['id']) && $_POST['id']!=""){
	$id_batalla = $_POST['id'];
	//obtener datos de la batalla
	$batalla_data = $batallas->getBatallas(" AND id_batalla=".$id_batalla." ");

	//obtener preguntas de la batalla
	$preguntas = $batallas->getBatallaRespuestasPreguntas($id_batalla,$_SESSION['user_name']);

	//marcar la batalla como empezada
	$batallas->insertBatallaLucha($id_batalla,$_SESSION['user_name'],0,0,1);

	//datos del contrincante
	$usuario_contrario = $batalla_data[0]['user_create'];
	$contrincante = $users->getUsers(" AND username='".$usuario_contrario."' AND disabled=0 AND confirmed=1 AND username<>'".$_SESSION['user_name']."' ");
	$puntos_reservados_contrincante = connection::sumReg("batallas", "puntos", " AND finalizada=0 AND (user_create='".$contrincante[0]['username']."' or user_retado='".$contrincante[0]['username']."') ");
	$puntos_disponibles_contrincante = $contrincante[0]['puntos'] - $puntos_reservados_contrincante;

	$i = 1;
	echo '<p class="text-danger text-center">ATENCIÓN!!: no cierres esta ventana o perderás la batalla</p>';
	echo '<h3 class="text-center">Luchas contra <b>'.$contrincante[0]['nick'].'</b></h3>';
	echo '<form method="post" name="form-batalla-fin" id="form-batalla-fin" action="">';
	echo '	<input type="hidden" name="id_batalla" value="'.$id_batalla.'" />
			<input type="hidden" name="batalla-play" value="1" />';
	echo '<div class="inset">';
	foreach($preguntas as $pregunta):
		echo '<div class="section inset">';
		echo '<h4 class="text-primary">'.$pregunta['pregunta'].'</h4>';
		echo '<input type="radio" name="respuesta'.$i.'" value="1">'.$pregunta['respuesta1'].'<br>';
		echo '<input type="radio" name="respuesta'.$i.'" value="2">'.$pregunta['respuesta2'].'<br>';
		echo '<input type="radio" name="respuesta'.$i.'" value="3">'.$pregunta['respuesta3'].'<br>';
		echo '<input type="hidden" name="id_pregunta'.$i.'" value="'.$pregunta['id_pregunta'].'">';
		echo '</div>';
		$i++;
	endforeach;
	echo '</div>
	<span class="alert-message alert alert-warning" id="batalla-alert"></span>
	<br /><input type="submit" name="batalla-go-btn" id="batalla-go-btn" class="btn btn-primary btn-block" value="Finalizar batalla" /><br />';
	echo "</form>";
}?>