<?php
$base_dir = str_replace('modules/batallas/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");
include_once($base_dir . "modules/batallas/classes/class.batallas.php");

session::ValidateSessionAjax();
$batallas = new batallas();

$module_config = getModuleConfig("batallas");
$puntos_batalla = $module_config['options']['battle_points'];

//datos del usuario
$users = new users();
$user_data = $users->getUsers("AND username='".$_SESSION['user_name']."' ");
$puntos_reservados = connection::sumReg("batallas", "puntos", " AND finalizada=0 AND (user_create='".$_SESSION['user_name']."' or user_retado='".$_SESSION['user_name']."') ");
$puntos_disponibles = $user_data[0]['puntos'] - $puntos_reservados;

//datos del contrincante
$contrincante = getContrincante($puntos_batalla);

function getContrincante($puntos_batalla){
	$users = new users();
	$filtro_canal = ($_SESSION['user_canal'] != 'admin' ? " AND canal='".$_SESSION['user_canal']."' " : "");
	$contrincante = $users->getUsers($filtro_canal." AND puntos>'".$puntos_batalla."' AND perfil<>'admin' AND disabled=0 AND confirmed=1 AND username<>'".$_SESSION['user_name']."' ORDER BY rand(" . time() . " * " . time() . ") LIMIT 1 ");
	$puntos_reservados_contrincante = connection::sumReg("batallas", "puntos", " AND finalizada=0 AND (user_create='".$contrincante[0]['username']."' or user_retado='".$contrincante[0]['username']."') ");
	$puntos_disponibles_contrincante = $contrincante[0]['puntos'] - $puntos_reservados_contrincante;
	if ($puntos_disponibles_contrincante >= $puntos_batalla){
		return $contrincante;
	}
	else{
		return 0;
	}
}

?>
<html>
	<head>

		<script type="text/javascript" src="js/libs/jquery-1.10.1.min.js"></script>
		<script type="text/javascript" src="css/libs/bootstrap-sass-3.2.0/assets/javascripts/bootstrap.js"></script>
		<script>
			$(document).ready(function(){

				$("#form-batalla-fin").submit(function(e) {

					e.preventDefault();

					$(".alert-message").html("").css("display","none");	   
					var resultado_ok=true;  

				    var name;
					$('input[type="radio"]',this).each(function() {
						if(name == $(this).attr("name")) return;
						name = $(this).attr("name");
						var checked = $(":radio[name="+name+"]:checked");
						if(checked.length == 0) {
							resultado_ok=false;
						}
					}); 
									
					if (resultado_ok==true) {
						this.submit();
					}
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
//if (trim($_POST['batalla-puntos']) == "") echo '<div class="alert alert-warning">Introduce los puntos que deseas jugar</div>';
//elseif ($puntos_disponibles < $_POST['batalla-puntos']) echo '<div class="alert alert-warning">Estas jugando más puntos de los que dispones</div>';
if ($puntos_disponibles < $puntos_batalla) echo '<div class="alert alert-warning">No dispones de puntos suficientes</div>';
//elseif ($puntos_disponibles_contrincante < $puntos_batalla) echo '<div class="alert alert-warning">Tu contrincante no tiene puntos suficientes</div>';
elseif ($contrincante == 0) echo '<div class="alert alert-warning">No se encuentra contrincario</div>';
else{ 
		if ($batallas->insertBatalla($_SESSION['user_name'], $contrincante[0]['username'], $_POST['batalla-categoria'], $puntos_batalla, $contrincante[0]['canal'])){
			//obtener preguntas de la batalla
			$preguntas = $batallas->getBatallasPreguntas(" AND activa=1 AND pregunta_tipo='".$_POST['batalla-categoria']."' ORDER BY rand(" . time() . " * " . time() . ") LIMIT 3");

			//insertar respuestas de partida
			$id_batalla = connection::SelectMaxReg("id_batalla","batallas"," AND user_create='".$_SESSION['user_name']."' ORDER BY id_batalla DESC");
			foreach($preguntas as $pregunta):
				$batallas->insertBatallaRespuesta($id_batalla, $_SESSION['user_name'], $pregunta['id_pregunta'], '');
				$batallas->insertBatallaRespuesta($id_batalla, $contrincante[0]['username'], $pregunta['id_pregunta'], '');
		  	endforeach;		

		  	//marcar la batalla como empezada
			$batallas->insertBatallaLucha($id_batalla,$_SESSION['user_name'],0,0,1);
			
			$i=1;

			echo '<p class="text-danger text-center">ATENCIÓN!!: no cierres esta ventana o perderás la batalla</p>';
			echo '<h3 class="text-center">Luchas contra <b>'.$contrincante[0]['nick'].'</b></h3>';
			echo '<form method="post" name="form-batalla-fin" id="form-batalla-fin" action="">';
			echo '  <input type="hidden" name="id_batalla" value="'.$id_batalla.'" />
					<input type="hidden" name="batalla-create" value="1" />';
			echo '<div class="inset">';
			foreach($preguntas as $pregunta):
				echo '<div class="section inset">';
				echo '<h4 class="text-primary">'.$pregunta['pregunta'].'</h4>';
				echo '<input type="radio" name="respuesta'.$i.'" value="1"> '.$pregunta['respuesta1'].'<br>';
				echo '<input type="radio" name="respuesta'.$i.'" value="2"> '.$pregunta['respuesta2'].'<br>';
				echo '<input type="radio" name="respuesta'.$i.'" value="3"> '.$pregunta['respuesta3'].'<br>';
				echo '<input type="hidden" name="id_pregunta'.$i.'" value="'.$pregunta['id_pregunta'].'">';
				echo '</div>';
				$i++;
		  	endforeach;	
		  	echo '</div>
			<span class="alert-message alert alert-warning" id="batalla-alert"></span>
		  	<br /><input type="submit" name="batalla-go-btn" id="batalla-go-btn" value="Finalizar batalla" class="btn btn-primary btn-block" /><br />';
		  	echo "</form>";
		}
		else{

			echo '<p>error al crear batalla, inténtela otra vez.</p>';

		}

} ?>