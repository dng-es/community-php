<?php
$base_dir = str_replace( ((strrpos( __DIR__ , "\\" ) === false) ? 'modules/batallas/pages' : 'modules\\batallas\\pages')  , '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
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
	$filtro_canal = (($_SESSION['user_canal'] != 'admin' and $_SESSION['user_canal'] != '') ? " AND canal='".$_SESSION['user_canal']."' " : "");
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
elseif ($contrincante == 0) echo '<div class="alert alert-warning">No se encuentra contrincante</div>';
else{ 
	$preguntas = $batallas->getBatallasPreguntas(" AND (canal_pregunta='".$_SESSION['user_canal']."' OR canal_pregunta='') AND activa=1 AND pregunta_tipo='".$_POST['batalla-categoria']."' ORDER BY rand(" . time() . " * " . time() . ") LIMIT 3");
	if (count($preguntas) == 3):

		if ($batallas->insertBatalla($_SESSION['user_name'], $contrincante[0]['username'], $_POST['batalla-categoria'], $puntos_batalla, $contrincante[0]['canal'])):
			//obtener preguntas de la batalla

			//insertar respuestas de partida
			$id_batalla = connection::SelectMaxReg("id_batalla", "batallas", " AND user_create='".$_SESSION['user_name']."' ORDER BY id_batalla DESC");
			foreach($preguntas as $pregunta):
				$batallas->insertBatallaRespuesta($id_batalla, $_SESSION['user_name'], $pregunta['id_pregunta'], '');
				$batallas->insertBatallaRespuesta($id_batalla, $contrincante[0]['username'], $pregunta['id_pregunta'], '');
		  	endforeach;		

		  	//marcar la batalla como empezada
			$batallas->insertBatallaLucha($id_batalla,$_SESSION['user_name'], 0, 0, 1);
			
			$i=1;
			?>
			<p class="text-danger text-center">ATENCIÓN!!: no cierres esta ventana o perderás la batalla</p>
			<h3 class="text-center">Luchas contra <b><?php echo $contrincante[0]['nick'];?></b></h3>
			<form method="post" name="form-batalla-fin" id="form-batalla-fin" action="">
				<input type="hidden" name="id_batalla" value="<?php echo $id_batalla;?>" />
				<input type="hidden" name="batalla-create" value="1" />
				<?php foreach($preguntas as $pregunta):?>
					<div class="section inset">
						<h4 class="text-primary"><?php echo $pregunta['pregunta'];?></h4>
						<input type="radio" name="respuesta<?php echo $i;?>" value="1"> <?php echo $pregunta['respuesta1'];?><br />
						<input type="radio" name="respuesta<?php echo $i;?>" value="2"> <?php echo $pregunta['respuesta2'];?><br />
						<input type="radio" name="respuesta<?php echo $i;?>" value="3"> <?php echo $pregunta['respuesta3'];?><br />
						<input type="hidden" name="id_pregunta<?php echo $i;?>" value="<?php echo $pregunta['id_pregunta'];?>">
					</div>
					<?php $i++;?>
			  	<?php endforeach;	?>
				<span class="alert-message alert alert-warning" id="batalla-alert"></span><br />
			  	<input type="submit" name="batalla-go-btn" id="batalla-go-btn" value="Finalizar batalla" class="btn btn-primary btn-block" /><br />
		  	</form>
		<?php else:?>
			<div class="alert alert-warning">error al crear batalla, inténtela otra vez.</div>
		<?php endif;?>
	<?php else:?>
		<div class="alert alert-warning">No se encuentran preguntas</div>
	<?php endif;?>
<?php } ?>