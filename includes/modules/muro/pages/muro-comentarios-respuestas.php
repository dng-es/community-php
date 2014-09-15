<?php
addJavascripts(array(getAsset("muro")."js/muro-comentarios-responder-ajax.js"));

$muro = new muro();
if (isset($_REQUEST['id']) and $_REQUEST['id']!="" ){$id_comentario=$_REQUEST['id'];}
else {$id_comentario=0;}

//OBTENER DATOS DEL COMENTARIO
$filtro_comentario = " AND id_comentario=".$id_comentario." ";					   
$comentario_muro = $muro->getComentarios($filtro_comentario);   
?>
<div id="page-info">Respuestas en el muro</div>
<div class="row inset row-top">
	<div class="col-md-9">
		<?php
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
		?>
		<div id="cargando" style="display:none">
			<i class="fa fa-spinner fa-spin ajax-load"></i>
		</div>
		<div id="destino"></div>
	</div>
</div>