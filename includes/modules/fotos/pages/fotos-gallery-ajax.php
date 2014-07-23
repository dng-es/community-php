<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script src="js/jquery.js"></script>

	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/bootstrap.min.js"></script>

	<LINK rel="stylesheet" type="text/css" href="css/styles.css" />
	<link href="css/font-awesome.min.css" rel="stylesheet">

	<script src="<?php echo getAsset("fotos");?>js/fotos-gallery-ajax.js"></script>
</head>
<body>
<?php
include_once("includes/constants.php");
include_once("includes/core/functions.core.php");
include_once("includes/core/class.connection.php");
include_once("includes/core/class.session.php");
include_once("includes/users/class.users.php");
include_once("includes/fotos/class.fotos.php");
include_once("includes/fotos/templates/gallery.php");
session::ValidateSessionAjax();

templateload("tipuser","users");

$fotos = new fotos();
$id_galeria = 0;
if(isset($_REQUEST['id']) and $_REQUEST['id']!=""){$id_galeria=$_REQUEST['id'];}
//OBTENCION DE LAS FOTOS
$filtro = " AND estado=1 AND id_album=".$id_galeria." ";
if ($_SESSION['user_canal']!='admin' and $_SESSION['user_perfil']!='formador'){$filtro.=" AND f.canal='".$_SESSION['user_canal']."' ";}
$files_galeria = $fotos->getFotos($filtro." ORDER BY id_file DESC ");

echo '  <div class="row">
			<div class="col-md-7">';
showFotoModal($files_galeria[0],true,0,0);

//insertar comentario
echo '<form action="" method="post" role="form" id="form-comentario" name="form-comentario">
		<input type="hidden" name="id_file" id="id_file" value="'.$files_galeria[0]['id_file'].'" />
		<textarea class="form-control" name="respuesta-texto" id="respuesta-texto" placeholder="Nuevo comentario"></textarea>
		<div id="respuesta-alert" class="alert-message alert alert-danger"></div>
		<button type="submit" class="btn btn-default">Publicar</button>
	  </form>

	  <div id="respuestas-result" class="alert-message alert alert-success"></div>
	  <div id="respuestas-textos"></div>';

echo '	</div>
		<div class="col-md-5">';
echo '      <div class="gallery clearfix">';
foreach($files_galeria as $element):
	echo '<div class="modal-img-container gallery clearfix">
			<img id="img-mini'.$element['id_file'].'" class="blanco-negro" src="'.PATH_FOTOS.$element['name_file'].'" title="'.$element['titulo'].'" data-id="'.$element['id_file'].'" data-votaciones="'.$element['fotos_puntos'].'" data-fecha="'.strftime(DATE_FORMAT_SHORT,strtotime($element['date_foto'])).'" data-nick="'.$element['nick'].'" />
		  </div>';
endforeach;
echo '      </div>';
echo '    </div>
	  </div>';
?>

</body>
</html>


<?php
function showFotoModal($file_galeria,$votaciones=true,$movil=0,$reto=0){
	$fotos = new fotos();
	if (strlen($file_galeria['titulo'])>30){ $titulo = substr($file_galeria['titulo'],0,28)."...";}
	else {$titulo = $file_galeria['titulo'];}

	$nick = $file_galeria['nick'];
	if ($nick==""){$nick="(sin nick)";}

	echo '<div class="thumbnail">
			<a href="'.PATH_FOTOS.$file_galeria['name_file'].'" rel="prettyPhoto[gallery1]">
			<img title="'.$file_galeria['titulo'].'" src="'.PATH_FOTOS.$file_galeria['name_file'].'" id="modal-img-main" /></a>
			<div class="caption"><span id="image-titulo">'.$titulo.'</span>';
	if ($_SESSION['user_perfil']=='admin'){ echo ' <span class="comunidad-color"><b>id:</b></span> <span id="image-id">'.$file_galeria['id_file'].'</span>';}
	echo '	<div class="img-info"><a id="a'.$file_galeria['id_file'].'" href="$a'.$file_galeria['id_file'].'Tip?width=350" 
			class="betterTip comunidad-color" title="Datos del usuario <em>'.$file_galeria['nick'].'</em>">
			<b><span id="image-nick">'.$nick.'</span></b></a> - <span id="image-fecha">'.strftime(DATE_FORMAT_SHORT,strtotime($file_galeria['date_foto'])).'</span></div>';							
	userTip($file_galeria['id_file'],$file_galeria,userEstrellas($file_galeria['participaciones']),$movil);				
			

	$votado = $fotos->countReg("galeria_fotos_votaciones", " AND id_file=".$file_galeria['id_file']." AND user_votacion='".$_SESSION['user_name']."' ");
	echo ' <a href="#" data-id="'.$file_galeria['id_file'].'" data-v="'.$votado.'"  title="votar foto" class="fa fa-heart trigger-votar">'.$file_galeria['fotos_puntos'].'</a>';

	echo '<div class="alert-votacion muro-result-megusta"></div>';
	
	echo '</div></div>';		  
}
?>