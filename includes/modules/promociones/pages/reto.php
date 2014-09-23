<?php
include_once ("includes/fotos/templates/gallery.php");
include_once ("includes/videos/templates/gallery.php");
include_once ("includes/fotos/templates/addfile.php");
include_once ("includes/videos/templates/addfile.php");
include_once ("includes/promociones/templates/comment.php");
include_once ("includes/promociones/templates/addcomment.php");


templateload("player","videos");


addJavascripts(array("js/bootstrap.file-input.js", "js/libs/jwplayer/jwplayer.js", "js/modal.js"));


$muro = new muro();
$promociones = new promociones();
$videos = new videos();
$fotos = new fotos();

//VOTAR COMENTARIO
if (isset($_REQUEST['idv']) and $_REQUEST['idv']!="") { 
$mensaje = $muro->InsertVotacion($_REQUEST['idv'],$_SESSION['user_name']);
echo '<script>$(document).ready(function(){ MostrarVideos();})</script>';}

//VOTAR VIDEO
if (isset($_REQUEST['idvv']) and $_REQUEST['idvv']!="") { 
$mensaje = $videos->InsertVotacion($_REQUEST['idvv'],$_SESSION['user_name']);}

//VOTAR FOTO
if (isset($_REQUEST['idvf']) and $_REQUEST['idvf']!="") { 
$mensaje = $fotos->InsertVotacion($_REQUEST['idvf'],$_SESSION['user_name']);}

//INSERTAR COMENTARIO
if (isset($_POST['texto-comentario']) and $_POST['texto-comentario']!=""){
if ($_SESSION['user_perfil']!='admin' and $_SESSION['user_perfil']!='formador'){$canal=$_SESSION['user_canal'];}
else { $canal=$_POST['canal-comentario'];}	  
$mensaje = $promociones->InsertComentario($canal,
														$_POST['texto-comentario'],
														$_SESSION['user_name'],
														0,
														$_POST['tipo_muro'],
														$_POST['tipo_comentario']);}

//INSERTAR FOTO
if (isset($_POST['titulo-foto']) and $_POST['titulo-foto']!=""){
if ($_SESSION['user_perfil']!='admin' and $_SESSION['user_perfil']!='formador'){$canal=$_SESSION['user_canal'];}
else { $canal=$_POST['canal-foto'];}
$mensaje = $promociones->insertFile($_FILES['nombre-foto'],
												$canal,
												$_POST['titulo-foto'],
												$_POST['id_promocion'],
												$_POST['tipo_envio'],
												$_POST['tipo-fichero']);}
												
//INSERTAR VIDEO
if (isset($_POST['titulo-video']) and $_POST['titulo-video']!=""){
if ($_SESSION['user_perfil']!='admin' and $_SESSION['user_perfil']!='formador'){$canal=$_SESSION['user_canal'];}
else { $canal=$_POST['canal-video'];}
$mensaje = $promociones->insertFile($_FILES['nombre-video'],
												$canal,
												$_POST['titulo-video'],
												$_POST['id_promocion'],
												$_POST['tipo_envio'],
												$_POST['tipo-fichero']);}													

//DATOS DEL RETO ACTIVO
echo '<div class="row row-top">';
echo '<h1>El reto</h1>';
echo '	<div class="col-md-8 col-lg-9 inset">';
$id_promocion=$_REQUEST['id'];
$promocion = $promociones->getPromociones(" AND active=1 AND id_promocion='".$id_promocion."' LIMIT 1 ");
if (count($promocion)==1) {

	$nombre_promocion=$promocion[0]['nombre_promocion'];
	$fecha_actual = strtotime(date("Y-m-d H:i:00",time()));  
	$fecha_inicio = strtotime($promocion[0]['date_comentarios']." 00:00:00");  
	$fecha_fin = strtotime($promocion[0]['date_fin_comentarios']." 11:59:59"); 
	if($fecha_actual < $fecha_inicio){
	   $insert_comentarios=1;
	   if($promocion[0]['galeria_videos']==1){$insert_videos=1;}
	   if($promocion[0]['galeria_fotos']==1){$insert_fotos=1;}
	}
	else{ 
		$insert_comentarios=0;
		$insert_videos=0;
		$insert_fotos=0;
	}
  
///////////////////////////////////////////////////////////////////////////////////////////
//	LATERAL IZQUIERDO		///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////
  
  echo '<div class="row">';
  echo '<div class="col-md-12">';
  if ($mensaje!=""){ErrorMsg($mensaje);}

///////////////////////////////////////////////////////////////////////////////////  
//DESCRIPCION DEL RETO
///////////////////////////////////////////////////////////////////////////////////	
		
	echo '<h2>'.$promocion[0]['nombre_promocion'].'</h2>
		  <p>'.$promocion[0]['texto_promocion'].'</b>';
		 
///////////////////////////////////////////////////////////////////////////////////  
//PRIEMRA FASE DEL RETO: INSERTAR COMENTARIOS, VIDEOS Y FOTOS
///////////////////////////////////////////////////////////////////////////////////	
	  if($fecha_actual < $fecha_inicio){
		//COMENTARIOS ENVIADOS (FASE 1): MOSTRAR 5 DE FORMA ALEATORIA
		echo '<div id="panel-textos">';
		if ($_SESSION['user_canal']!='admin' and $_SESSION['user_canal']!='formador'){$filtro=" AND c.canal='".$_SESSION['user_canal']."' ";}
		$filtro.=" AND tipo_muro='".$promocion[0]['nombre_promocion']."' AND estado=1 ORDER BY date_comentario DESC ";		
		
		//SHOW PAGINATOR
		$reg = 5;
		$inicio = 0;
		if (isset($_GET["pag"])) {$pag = $_GET["pag"];}
		if (!$pag) { $inicio = 0; $pag = 1;}
		else { $inicio = ($pag - 1) * $reg;}
		$total_reg = muro::countReg("muro_comentarios c",$filtro);


		$comentarios_muro = $muro->getComentarios($filtro.' LIMIT '.$inicio.','.$reg);
        
		echo '<h2 class="h2Seccion">Retos recibidos en modo texto</h2>';
		if (count($comentarios_muro)==0){ echo '<p>en este reto no hay comentarios.</p>';} 
		else {	
			foreach($comentarios_muro as $comentario_muro):
			  showComentarioPromocion($comentario_muro,$promocion[0]['id_promocion'],true);
			endforeach;
			echo '<br />';
			Paginator($pag,$reg,$total_reg,'reto&id='.$id_promocion,'comentarios',$find_reg,10,"selected-muro");
		}		
		echo '</div>';
		
		//VIDEOS ENVIADOS (FASE 1)
		if ($promocion[0]['galeria_videos']==1){
			$filtro="";
			if ($_SESSION['user_canal']!='admin' and $_SESSION['user_canal']!='formador'){$filtro=" AND v.canal='".$_SESSION['user_canal']."' ";}
			$filtro.=" AND id_promocion=".$promocion[0]['id_promocion']." AND estado=1 ";
       
            //SHOW PAGINATOR
    		$reg = 4;
    		$inicio = 0;
    		if (isset($_GET["pag"])) {$pagv = $_GET["pag"];}
    		if (!$pag) { $inicio = 0; $pag = 1;}
    		else { $inicio = ($pag - 1) * $reg;}
    		$total_reg = muro::countReg("galeria_videos v",$filtro);
    		
			$videos_reto1 = $videos->getVideos($filtro.' LIMIT '.$inicio.','.$reg);
			 
			echo '<div id="panel-videos">';
			echo '<h2 class="h2Seccion">Retos recibidos en modo video</h2>';
			if (count($videos_reto1)==0){ echo '<p>en este reto no hay videos.</p>';}
			else{ galleryVideos($videos_reto1,true,$id_promocion,4);}
			
			
			Paginator($pag,$reg,$total_reg,'reto&id='.$id_promocion,'videos',$find_reg,6,"selected-muro");				
			echo '</div>';
		}

		//FOTOS ENVIADOS (FASE 1)
		if ($promocion[0]['galeria_fotos']==1){
			$filtro="";
			if ($_SESSION['user_canal']!='admin' and $_SESSION['user_canal']!='formador'){$filtro=" AND f.canal='".$_SESSION['user_canal']."' ";}
			$filtro.=" AND id_promocion=".$promocion[0]['id_promocion']." AND estado=1 ";           
            
            //SHOW PAGINATOR
    		$reg = 4;
    		$inicio = 0;
    		if (isset($_GET["pag"])) {$pag = $_GET["pag"];}
    		if (!$pag) { $inicio = 0; $pag = 1;}
    		else { $inicio = ($pag - 1) * $reg;}
    		$total_reg = muro::countReg("galeria_fotos f",$filtro);	
			
			$fotos_reto = $fotos->getFotos($filtro.' LIMIT '.$inicio.','.$reg); 
			
			echo '<div id="panel-fotos" class="gallery clearfix">';
			echo '<h2 class="h2Seccion">Retos recibidos en modo foto</h2>';
			if (count($fotos_reto)==0){ echo '<p>en este reto no hay fotos.</p>';}


			galleryPhotos($fotos_reto,true,$id_promocion,4);



            echo '<div style="clear:both;margin-top:15px;overflow:hidden;display:inline-block;width:100%"></div>';
			Paginator($pag,$reg,$total_reg,'reto&id='.$id_promocion,'fotos',$find_reg,6,"selected-muro");							
			echo '</div>';
		}
    }

///////////////////////////////////////////////////////////////////////////////////  
//SEGUNDA FASE RETO: MOSTRAR MEJORES VIDEOS Y COMENTARIOS
///////////////////////////////////////////////////////////////////////////////////	
    if($fecha_actual > $fecha_inicio and $fecha_actual < $fecha_fin){	
		//MEJORES COMENTARIOS
		echo '<h2>los mejores textos</h2>
			  <p>A continuaci&oacute;n se muestran los textos seleccionados del reto. 
			  Puedes empezar a realizar tus votaciones para elegir los que mas te gustan:</p><br />';
			  
		if ($_SESSION['user_canal']!='admin' and $_SESSION['user_canal']!='formador'){$filtro=" AND c.canal='".$_SESSION['user_canal']."' ";}
		$filtro.=" AND tipo_muro='".$promocion[0]['nombre_promocion']."' AND estado=1 AND seleccion_reto=1 ORDER BY RAND()";		
		$comentarios_muro = $muro->getComentarios($filtro.""); 		
		if (count($comentarios_muro)==0){ echo '<p>en este reto no hay textos seleccionados.</p>';} 
		foreach($comentarios_muro as $comentario_muro):
		  showComentarioPromocion($comentario_muro,$promocion[0]['id_promocion'],true);
		endforeach;	

		//MEJORES VIDEOS	
		if ($promocion[0]['galeria_videos']==1){
			$filtro="";
			if ($_SESSION['user_canal']!='admin' and $_SESSION['user_canal']!='formador'){$filtro=" AND v.canal='".$_SESSION['user_canal']."' ";}
			$filtro.=" AND id_promocion=".$promocion[0]['id_promocion']." AND seleccion_reto=1 ORDER BY RAND()";	
            
             //SHOW PAGINATOR
    		$reg = 4;
    		$inicio = 0;
    		if (isset($_GET["pag"])) {$pagv = $_GET["pag"];}
    		if (!$pag) { $inicio = 0; $pag = 1;}
    		else { $inicio = ($pag - 1) * $reg;}
    		$total_reg = muro::countReg("galeria_videos v",$filtro);
			$videos_reto1 = $videos->getVideos($filtro.' LIMIT '.$inicio.','.$reg);
			 
			echo '<h2>los mejores videos</h2>
				  <p>A continuaci&oacute;n se muestran los videos seleccionados del reto. 
				  Puedes empezar a realizar tus votaciones para elegir los que mas te gustan:</p><br />';	
			if (count($videos_reto)==0){ echo '<p>en este reto no hay videos seleccionados.</p><br />';} 
			else{ galleryVideos($videos_reto,true,$id_promocion,4);}


 		    Paginator($pag,$reg,$total_reg,'reto&id='.$id_promocion,'videos',$find_reg,6,"selected-muro");
		}
		//MEJORES FOTOS
		if ($promocion[0]['galeria_fotos']==1){
			$filtro="";
			if ($_SESSION['user_canal']!='admin' and $_SESSION['user_canal']!='formador'){$filtro=" AND f.canal='".$_SESSION['user_canal']."' ";}
			$filtro.=" AND id_promocion=".$promocion[0]['id_promocion']." AND seleccion_reto=1 ORDER BY RAND()";
            
            //SHOW PAGINATOR
    		$reg = 4;
    		$inicio = 0;
    		if (isset($_GET["pag"])) {$pag = $_GET["pag"];}
    		if (!$pag) { $inicio = 0; $pag = 1;}
    		else { $inicio = ($pag - 1) * $reg;}
    		$total_reg = muro::countReg("galeria_fotos f",$filtro);	
			
			$fotos_reto = $fotos->getFotos($filtro.' LIMIT '.$inicio.','.$reg); 
			
			echo '<div class="gallery clearfix">'; 
			echo '<h2>las mejores fotos</h2>
				  <p>A continuaci&oacute;n se muestran las fotos seleccionadas del reto. 
				  Puedes empezar a realizar tus votaciones para elegir las que mas te gustan:</p><br />';		

			if (count($fotos_reto)==0){ echo '<p>en este reto no hay fotos seleccionadas.</p><br />';} 
			galleryPhotos($fotos_reto,true,$id_promocion,4);
			echo '  </div>';
		}	

    }
///////////////////////////////////////////////////////////////////////////////////     
//TERCERA FASE RETO: MOSTRAR LOS 3 VIDEOS,FOTOS Y COMENTARIOS MAS VOTADOS (YA NO SE PUEDE VOTAR MAS)
///////////////////////////////////////////////////////////////////////////////////  	
	$num_ganadores = 3; 
    if($fecha_actual > $fecha_fin){	  
		//MEJORES COMENTARIOS
		echo '<div id="panel-textos">
			  <p>A continuaci&oacute;n se muestran los textos ganadores del reto. 
			  Enhorabuena a los ganadores!.</p><br />';
		if ($_SESSION['user_canal']!='admin' and $_SESSION['user_canal']!='formador'){		
			$filtro=" AND c.canal='".$_SESSION['user_canal']."' ";
			$filtro.=" AND tipo_muro='".$promocion[0]['nombre_promocion']."' AND estado=1 AND seleccion_reto=1 ORDER BY votaciones DESC LIMIT ".$num_ganadores;
			$comentarios_muro = $muro->getComentarios($filtro); 		
			if (count($comentarios_muro)==0){ echo '<p>en este reto no hay comentarios ganadores.</p>';} 
			foreach($comentarios_muro as $comentario_muro):
			  showComentarioPromocion($comentario_muro,$promocion[0]['id_promocion'],false);
			endforeach;				
		}
		else
		{		
			echo '<h2>ganadores canal gerentes</h2>';
			$filtro=" AND c.canal='gerente' ";
			$filtro.=" AND tipo_muro='".$promocion[0]['nombre_promocion']."' AND estado=1 AND seleccion_reto=1 ORDER BY votaciones DESC LIMIT ".$num_ganadores;
			$comentarios_muro = $muro->getComentarios($filtro); 		
			if (count($comentarios_muro)==0){ echo '<p>en este reto no hay comentarios ganadores en el canal gerentes.</p><br />';} 
			foreach($comentarios_muro as $comentario_muro):
			  showComentarioPromocion($comentario_muro,$promocion[0]['id_promocion'],false);
			endforeach;
			
			echo '<h2>ganadores canal comerciales</h2>';
			$filtro=" AND c.canal='comercial' ";
			$filtro.=" AND tipo_muro='".$promocion[0]['nombre_promocion']."' AND estado=1 AND seleccion_reto=1 ORDER BY votaciones DESC LIMIT ".$num_ganadores;
			$comentarios_muro = $muro->getComentarios($filtro); 		
			if (count($comentarios_muro)==0){ echo '<p>en este reto no hay comentarios ganadores en el canal comerciales.</p><br />';} 
			foreach($comentarios_muro as $comentario_muro):
			  showComentarioPromocion($comentario_muro,$promocion[0]['id_promocion'],false);
			endforeach;						
		}
		echo '</div>';
		
		
		//MEJORES VIDEOS
		if ($promocion[0]['galeria_videos']==1){
			$filtro="";
			echo '<div id="panel-videos">';
			if ($_SESSION['user_canal']!='admin' and $_SESSION['user_canal']!='formador'){
				$filtro=" AND v.canal='".$_SESSION['user_canal']."' ";
				$filtro.=" AND id_promocion=".$promocion[0]['id_promocion']." AND seleccion_reto=1 ORDER BY videos_puntos DESC LIMIT ".$num_ganadores;
				$videos_reto = $videos->getVideos($filtro); 
				if (count($videos_reto)==0){ echo '<p>en este reto no hay videos ganadores.</p>';}
				else{ galleryVideos($videos_reto,false,$id_promocion,4);}		
			}
			else {				
				echo '<h2>ganadores canal gerentes</h2>';
				$filtro=" AND v.canal='gerente' ";
				$filtro.=" AND id_promocion=".$promocion[0]['id_promocion']." AND seleccion_reto=1 ORDER BY videos_puntos DESC LIMIT ".$num_ganadores;
				$videos_reto = $videos->getVideos($filtro); 
				if (count($videos_reto)==0){ echo '<p>en este reto no hay videos ganadores en el canal gerentes.</p>';}  
				else{ galleryVideos($videos_reto,false,$id_promocion,4);}
	
				echo '<h2>ganadores canal comerciales</h2>';
				$filtro=" AND v.canal='comercial' ";
				$filtro.=" AND id_promocion=".$promocion[0]['id_promocion']." AND seleccion_reto=1 ORDER BY videos_puntos DESC LIMIT ".$num_ganadores;
				$videos_reto = $videos->getVideos($filtro);				
				if (count($videos_reto)==0){ echo '<p>en este reto no hay videos ganadores en el canal comerciales.</p>';} 
				else{ galleryVideos($videos_reto,false,$id_promocion,4);}
			}				
			echo '</div>';
		}
		//MEJORES FOTOS
		if ($promocion[0]['galeria_fotos']==1){
			$filtro="";
			echo '<div id="panel-fotos" class="gallery clearfix">'; 
			if ($_SESSION['user_canal']!='admin' and $_SESSION['user_canal']!='formador'){
				$filtro=" AND f.canal='".$_SESSION['user_canal']."' ";
				$filtro.=" AND id_promocion=".$promocion[0]['id_promocion']." AND seleccion_reto=1 ORDER BY fotos_puntos DESC LIMIT ".$num_ganadores;
				$fotos_reto = $fotos->getFotos($filtro); 
				if (count($fotos_reto)==0){ echo '<p class="clearfix">en este reto no hay fotos ganadoras.</p><br />';} 
				galleryPhotos($fotos_reto,false,$id_promocion,4);

			}
			else{				
				echo '<h2 class="h2Seccion">ganadores canal gerente</h2>';	
				$filtro=" AND f.canal='gerente' ";
				$filtro.=" AND id_promocion=".$promocion[0]['id_promocion']." AND seleccion_reto=1 ORDER BY fotos_puntos DESC LIMIT ".$num_ganadores;
				$fotos_reto = $fotos->getFotos($filtro); 			
				if (count($fotos_reto)==0){ echo '<p>en este reto no hay fotos ganadoras en el canal gerentes.</p><br />';} 
				else{galleryPhotos($fotos_reto,false,$id_promocion,4);}
				


				echo '<h2>ganadores canal comerciales</h2>';
				$filtro=" AND f.canal='comercial' ";
				$filtro.=" AND id_promocion=".$promocion[0]['id_promocion']." AND seleccion_reto=1 ORDER BY fotos_puntos DESC LIMIT ".$num_ganadores;
				$fotos_reto = $fotos->getFotos($filtro); 											
				if (count($fotos_reto)==0){ echo '<p>en este reto no hay fotos ganadoras en el canal comerciales.</p><br />';}
				else{galleryPhotos($fotos_reto,false,$id_promocion,4);}
							
			}
			echo '</div>';
		}					
	} 
	echo '</div>';
  }
  else { echo '<p>No hay retos activos</p>';}
///////////////////////////////////////////////////////////////////////////////////////////
//	LATERAL DERECHO			///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////    
echo '</div>
		<div class="col-md-4 col-lg-3 nopadding lateral-container">
		<div class="panel-interior">';
			//FASE 1 DEL RETO: EXPLICACION DEL RETO
		if($fecha_actual < $fecha_inicio){ 	
			echo '<p>'.$promocion[0]['cabecera_promocion'].'</p>';
			
			//VIDEO PRINCIPAL DEL RETO ACTIVO
			$promocion_videos = $promociones->getPromocionesVideos(" AND id_promocion=".$promocion[0]['id_promocion']." ");
			if (count($promocion_videos)==0){
				echo '<img src="images/banners/'.$promocion[0]['imagen_promocion'].'" style="width:300px;height:210px;margin:0 0 20px 0" />';
			}
			else{
				playVideo("VideoPrincipal",PATH_VIDEOS.$promocion_videos[0]['ruta_video'],300,210);	
			}

			//INSERTAR COMENTARIO	  	
		  	if ($insert_comentarios==1){ addComment();}
		  	echo '<div class="alert-message alert alert-danger" id="alertas-reto"></div> ';

			//PANEL SUBIR FOTOS 
			if ($insert_fotos == 1){PanelSubirFoto($id_promocion);}

			echo '<div class="alert-message alert alert-danger" id="alertas-participa"></div> ';

			//PANEL SUBIR VIDEOS
		  	if ($insert_videos == 1){PanelSubirVideo($id_promocion);}
		}
		elseif($fecha_actual > $fecha_inicio and $fecha_actual < $fecha_fin){	
		  echo '<h2>Ya comienzan las votaciones!!!</h2>
		  		<p>Ya puedes empezar a votar los retos enviados, recuerda que no puedes votar tus propios retos y 
				solamente una vez a cada reto enviado. Entra en cada sección para ver los seleccionados y realizar tus votaciones.</p>
		  		<p>'.$promocion[0]['cabecera_promocion'].'</p>';	
		}
		elseif($fecha_actual > $fecha_fin){
		//FASE 3: GANADORES
		  echo '<h2>Ya tenemos ganadores!!!</h2>
		  		<p>Ya tenemos ganadores del reto, puedes entrar en cada sección para ver los ganadores</p>
		  		<p>'.$promocion[0]['cabecera_promocion'].'</p>';	
		}?>
		</div>
	</div>	
</div>