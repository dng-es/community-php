<?php
/**
* @Modulo el reto de las comunidades
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 0.5.1
* 
*/	
class promociones{
 
	  public function getPromociones($filter = ""){
	    $Sql="SELECT * FROM promociones WHERE 1=1 ".$filter;
	    return connection::getSQL($Sql);  
	  }
	  
	  public function insertPromocion($nombre_promocion,$cabecera_promocion,$texto_promocion,$imagen_promocion,$galeria_videos,$galeria_fotos,$date_comentarios,$date_fin_comentarios){
		//SE PONEN INACTIVOS TODOS LOS RETOS ACTUALES
		$Sql="UPDATE promociones SET active=0";
		connection::execute_query($Sql);

		$nombre_imagen='';
		if ($galeria_videos=='') {$galeria_videos=0;}
		if ($galeria_fotos=='') {$galeria_fotos=0;}
		if (isset($imagen_promocion) and $imagen_promocion['name']!='') {
			$nombre_imagen = time().'_'.str_replace(" ","_",$imagen_promocion['name']);
			$nombre_imagen = NormalizeText($nombre_imagen);
		
			move_uploaded_file($imagen_promocion['tmp_name'], 'images/banners/'.$nombre_imagen);
		}
		
		$Sql="INSERT INTO promociones 
			 (nombre_promocion,cabecera_promocion,texto_promocion,imagen_promocion,galeria_videos,galeria_fotos,active,date_comentarios,date_fin_comentarios) VALUES 
			 ('".$nombre_promocion."','".$cabecera_promocion."','".$texto_promocion."','".$nombre_imagen."',".$galeria_videos.",
			 ".$galeria_fotos.",1,'".$date_comentarios."','".$date_fin_comentarios."')";
		if (connection::execute_query($Sql)){ return "Reto insertado correctamente.";}
		else {return "Se ha producido un error en la inserci&oacute;n del reto. Por favor, int&eacute;ntelo m&aacute;s tarde.";}		
      }
	  
	  public function updatePromocion($id_promocion,$nombre_promocion,$cabecera_promocion,$texto_promocion,$imagen_promocion,$galeria_videos,$galeria_fotos,$date_comentarios,$date_fin_comentarios){
		$SqlUpdate='';
		if ($galeria_videos=='') {$galeria_videos=0;}
		if ($galeria_fotos=='') {$galeria_fotos=0;}
		if (isset($imagen_promocion) and $imagen_promocion['name']!='') {
			$nombre_imagen = time().'_'.str_replace(" ","_",$imagen_promocion['name']);
			$nombre_imagen = NormalizeText($nombre_imagen);
			if (move_uploaded_file($imagen_promocion['tmp_name'], 'images/banners/'.$nombre_imagen)){ $SqlUpdate="imagen_promocion='".$nombre_imagen."',";}
		}
		
		$Sql="UPDATE promociones SET 
			  nombre_promocion='".$nombre_promocion."',
			  texto_promocion='".$texto_promocion."',
			  ".$SqlUpdate."
			  galeria_videos=".$galeria_videos.",
			  cabecera_promocion='".$cabecera_promocion."',
			  galeria_fotos=".$galeria_fotos.",
			  date_comentarios='".$date_comentarios."',
			  date_fin_comentarios='".$date_fin_comentarios."'
			  WHERE id_promocion=".$id_promocion;
		if (connection::execute_query($Sql)){ return "Reto insertado correctamente.";}
		else {return "Se ha producido un error en la inserci&oacute;n del reto. Por favor, int&eacute;ntelo m&aacute;s tarde.";}
      }
	  
	  public function getPromocionesVideos($filter = ""){
	    $Sql="SELECT * FROM promociones_videos WHERE 1=1 ".$filter;
	    return connection::getSQL($Sql);  
	  }

	  public function InsertComentario($canal,$texto_comentario,$usuario,$estado,$tipo,$seccion_comentario){
		$Sql="INSERT INTO muro_comentarios (canal,comentario,user_comentario,estado,tipo_muro,seccion_comentario) VALUES 
			 ('".$canal."','".$texto_comentario."','".$usuario."',".$estado.",'".$tipo."','".$seccion_comentario."')";
		if (connection::execute_query($Sql)){ return "Tu comentario se ha subido correctamente,<br />en breve te comentaremos si est&aacute; validado.";}
		else {return "Se ha producido un error en la inserci&oacute;n de tu comentario. Por favor, int&eacute;ntelo m&aacute;s tarde.";}		
      }
	  public function insertFile($fichero,$canal,$titulo,$id_promocion,$tipo_envio,$tipo_fichero='',$movil=0){
		global  $videos_types,$fotos_types;
  		$videos = new videos();
		$fotos = new fotos();
		$ext = strtoupper(substr($fichero['name'], strrpos($fichero['name'],".") + 1));		
			
		if (in_array($ext, $fotos_types) && ($tipo_envio=='foto')) {
		  if ($movil==1){ $ruta_fotos='../'.PATH_FOTOS;}
		  else {$ruta_fotos=PATH_FOTOS;}
		  $resultado = $fotos->insertFile($fichero,$ruta_fotos,$canal,$titulo,$id_promocion,0,$tipo_fichero);
		}
		elseif (in_array($ext, $videos_types) && ($tipo_envio=='video')) {
		  if ($movil==1){ $ruta_videos='../'.PATH_VIDEOS_TEMP;}
		  else {$ruta_videos=PATH_VIDEOS_TEMP;}		  
		  $resultado = $videos->insertFile($fichero,$ruta_videos,$canal,$titulo,$id_promocion,0,$tipo_fichero);
		}
		else{ 
		  $resultado = "La extensión del archivo no es correcta. <br /><br />
		  (tipo: ".$ext.", t: ".$tipo_envio.").";
	    }
		return $resultado;
	}
	public function insertPromocionVideo($id_promocion,$fichero,$nombre,$texto){
		$videos=new videos();	  
	    global  $videos_types;
		$nombre_archivo = time().'_'.str_replace(" ","_",$fichero['name']);
		$nombre_archivo = NormalizeText($nombre_archivo);
		
		$tipo_archivo = $fichero['type'];
		$tamano_archivo = $fichero['size'];
		$ext = strtoupper(substr($fichero['name'], strrpos($fichero['name'],".") + 1));
		if (!(in_array($ext, $videos_types))) {
			return "La extensión o el tamaño de los archivos no es correcta. <br /><br />
				    Se permiten archivos .mp4, .mov, .3gp, .avi (".$ext.").";
		}else{
			$video = $fichero['tmp_name'];
			if (move_uploaded_file($fichero['tmp_name'], PATH_VIDEOS.$nombre_archivo)) {
			  if ($videos->convertirVideo($nombre_archivo,PATH_VIDEOS,PATH_VIDEOS)){
				  unlink (PATH_VIDEOS.$nombre_archivo);
				  $Sql="INSERT INTO promociones_videos (id_promocion,nombre_video,ruta_video,texto_video) VALUES (".$id_promocion.",'".$nombre."','".$nombre_archivo.".mp4','".$texto."')";
				  if (connection::execute_query($Sql)){ return true;}
				  else { return false;}
			  }
			}

		  }
      }	 
	public function deleteFile($id,$nombre_file){
		$Sql="DELETE FROM promociones_videos WHERE id_file=".$id;
		if (connection::execute_query($Sql)){ 
			unlink(PATH_VIDEOS.$nombre_file);
			unlink(PATH_VIDEOS.$nombre_file.".jpg");
			return "video eliminado correctamente";
			}
		else {return "Se ha producido un error. Por favor, int&eacute;ntelo m&aacute;s tarde.";}		
    }
	
	public static function emailValidacion($username,$id_promocion,$nombre_promocion){
		  global $ini_conf;
		  $users = new users();
		  $muro = new muro();
		  $videos = new videos();
		  $fotos = new fotos();
		  $userdata = $users->getUsers(" AND username='".$username."' ");
		  if (count($userdata)==1){
			  //VERIFICAR SI ES DE LOS PRIMEROS 100/USUARIOS_REGALO SELECCIONADOS
			  $validados_comentarios=$muro->getComentarios(" AND tipo_muro='".$nombre_promocion."' AND estado=1 AND u.perfil='usuario'");
			  $validados_videos=$videos->getVideos(" AND id_promocion=".$id_promocion." AND estado=1 AND u.perfil='usuario'");
			  $validados_fotos=$fotos->getFotos(" AND id_promocion=".$id_promocion." AND estado=1 AND u.perfil='usuario'");
			  
			  $validados_comentarios = count($validados_comentarios);
			  $validados_videos = count($validados_videos);
			  $validados_fotos = count($validados_fotos);			  
			  
			  $subject_mail="validacion contenido reto";
			  $body_mail="validacion contenido reto usuario: ".$userdata[0]['email'];
			  if (($validados_comentarios+$validados_videos+$validados_fotos)<=USUARIOS_REGALO and $userdata[0]['perfil']=='usuario'){
				  if ($userdata[0]['canal']=='comercial'){
					$subject_mail="enhorabuena ya tienes tu camiseta del universo canal";
			     	$body_mail="
¡El contenido que has enviado desde el reto ha sido validado!
Enhorabuena porque al ser uno de los ".USUARIOS_REGALO." primeros recibirás muy pronto tu camiseta.";
				  }
				  if ($userdata[0]['canal']=='gerente'){
					$subject_mail="enhorabuena ya tienes tu camiseta del universo canal";
					$body_mail="El contenido que has enviado desde el reto ha sido validado.
Enhorabuena porque al ser uno de los ".USUARIOS_REGALO." primeros recibirás muy pronto tu camiseta.";
				  }
			  }else {
				 if ($userdata[0]['canal']=='comercial'){
					$subject_mail="ya se ha validado tu aportacion al reto";
			     	$body_mail="El contenido que has enviado desde el reto ha sido validado!
Gracias por participar en este reto.";
				  }
				  if ($userdata[0]['canal']=='gerente'){
					$subject_mail="ya se ha validado tu aportacion al reto";
			     	$body_mail="
El contenido que has enviado desde el reto ha sido validado!
Gracias por participar en este reto.";
				  }
			  }
			  $from_mail=$ini_conf['ContactEmail'];
			  $to_mail=$userdata[0]['email'];
			  			  
			  //SendEmail($from_mail,$to_mail,$subject_mail,$body_mail,0,'comunidad Actytu Kiabi');
			  //$body_mail="Email enviado a ".$userdata[0]['username'].": ".$body_mail;
			  //SendEmail($from_mail,$ini_conf['ContactEmail'],$subject_mail,$body_mail,0,'comunidad Actytu Kiabi');
		  }
	}
	
	public static function emailValidacionSimple($username,$id_promocion,$nombre_promocion){
		  global $ini_conf;
		  $users = new users();
		  $muro = new muro();
		  $videos = new videos();
		  $fotos = new fotos();
		  $userdata = $users->getUsers(" AND username='".$username."' ");
		  if (count($userdata)==1){		  
			 
			 $subject_mail="ya se ha validado tu aportacion a la comunidad Actytu Kiabi";
			 $body_mail="
El contenido que has enviado desde el reto ha sido validado!
Gracias por participar en este reto.";

			  $from_mail=$ini_conf['ContactEmail'];
			  $to_mail=$userdata[0]['email'];
			  SendEmail($from_mail,$to_mail,$subject_mail,$body_mail,0,'comunidad Actytu Kiabi');
			  
			  $subject_mail="validacion contenido reto";
			  $body_mail="Email enviado a ".$userdata[0]['username'].": ".$body_mail;
			  SendEmail($from_mail,$ini_conf['ContactEmail'],$subject_mail,$body_mail,0,'comunidad Actytu Kiabi');
		  }
	}
	
	public static function emailCancelacionSimple($username,$id_promocion,$nombre_promocion){
		  global $ini_conf;
		  $users = new users();
		  $muro = new muro();
		  $videos = new videos();
		  $fotos = new fotos();
		  $userdata = $users->getUsers(" AND username='".$username."' ");
		  if (count($userdata)==1){		  
			 $subject_mail="aportacion a la comunidad Actytu Kiabi";
			 $body_mail="
Hola,

Hemos recibido tu reto, pero no cumple con los requisitos marcados.
Revisa de nuevo las instrucciones en la sección del reto: entra e inténtalo de nuevo.

Un Saludo.";

			  $from_mail=$ini_conf['ContactEmail'];
			  $to_mail=$userdata[0]['email'];
			  			  
			  SendEmail($from_mail,$to_mail,$subject_mail,$body_mail,0,'comunidad Actytu Kiabi');
			  
			  $subject_mail="cancelacion contenido reto";
			  $body_mail="Email enviado a ".$userdata[0]['username'].": ".$body_mail;
			  SendEmail($from_mail,$ini_conf['ContactEmail'],$subject_mail,$body_mail,0,'comunidad Actytu Kiabi');
		  }
	}		
}
?>