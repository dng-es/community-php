<?php
class videos{
	public function getVideos($filter = ""){
		$Sql = "SELECT v.*,u.*,v.canal AS canal_file FROM galeria_videos v 
				JOIN users u ON u.username=v.user_add WHERE 1=1 ".$filter; //echo $Sql."<br />";
		return connection::getSQL($Sql); 
	}

	public function getVideosPromociones($filter = ""){
		$Sql = "SELECT v.*,u.*,v.canal AS canal_file,IFNULL(p.nombre_promocion,'') AS reto FROM galeria_videos v 
				JOIN users u ON u.username=v.user_add 
				LEFT JOIN promociones p ON p.id_promocion=v.id_promocion 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql); 
	}

	public function cambiarEstado($id, $estado, $seleccionado=0){
		$Sql = "UPDATE galeria_videos SET
				estado=".$estado.",
				seleccion_reto=".$seleccionado."
				WHERE id_file=".$id."";
		return connection::execute_query($Sql);
	}

	public function cambiarNombre($id){
		$Sql = "UPDATE galeria_videos SET
				name_file=concat(name_file,'.mp4')
				WHERE id_file=".$id."";
		return connection::execute_query($Sql);
	}

	public function cambiarTags($id, $tags){
		$Sql = "UPDATE galeria_videos SET
				tipo_video='".$tags."'
				WHERE id_file=".$id."";
		return connection::execute_query($Sql);
	}	

	public function convertirVideo($video, $ruta_video, $ruta_video_export){
		//convertir video a MP4
		//exec("ffmpeg -i ".$ruta_video.$video." -vcodec libx264 -vpre hq -acodec libfaac ".$ruta_video_export.$video.".mp4");
		exec("ffmpeg -i ".$ruta_video.$video." -vcodec libx264 ".$ruta_video_export.$video.".mp4");
		//echo "ffmpeg -i ".$ruta_video.$video." -vcodec libx264 ".$ruta_video_export.$video.".mp4";
		//exec("ffmpeg -i ".$ruta_video.$video." -vcodec mpeg4 -s qvga -r 16 -acodec libfaac -ar 22050 -ac 2 -ab 48k ".$ruta_video_export.$video.".mp4");
		//exec("ffmpeg -i ".$ruta_video.$video." -f mp4 -vcodec mpeg4 -b 400k -r 24 -s 320x240 -aspect 4:3 -acodec aac -ar 22050 -ac 2 -ab 48k ".$ruta_video_export.$video.".mp4");
		//sacar imagen del video
		exec("ffmpeg -y -ss 2 -i ".$ruta_video.$video." -f mjpeg -vframes 1 -s 400x300 -an ".$ruta_video_export.$video.".mp4.jpg",$output2);
		return true;
	}

	public function insertFile($fichero, $path_archivo, $canal, $titulo, $id_promocion = 0, $formacion = 0, $tipo_video = "", $movil = 0){
		global  $videos_types;
		$ext = substr($fichero['name'], strrpos($fichero['name'],".") + 1);
		$nombre_archivo = time().'.'.$ext;
		$tipo_archivo = $fichero['type'];
		$tamano_archivo = $fichero['size'];
		if (!(in_array(strtoupper($ext), $videos_types) && ($tamano_archivo <= MAX_SIZE_VIDEOS))) return 0;
		else{
			$video = $fichero['tmp_name'];
			if (move_uploaded_file($fichero['tmp_name'], $path_archivo.$nombre_archivo)){
				//INSERTAR REGISTRO EN LA BBDD  
				$Sql = "INSERT INTO galeria_videos (titulo,name_file,user_add,canal,id_promocion,formacion,tipo_video) VALUES (
						'".$titulo."',
						'".$nombre_archivo."',
						'".$_SESSION['user_name']."',
						'".$canal."',
						".$id_promocion.",
						".$formacion.",
						'".$tipo_video."'
						)";
				if (connection::execute_query($Sql)) return 1;
				else return 2;
			}
			else return 3;
		}
	}

	public function InsertVotacion($id, $usuario){
		//VERIFICAR QUE EL USUARIO NO SE VOTE A SI MISMO
		if (connection::countReg("galeria_videos"," AND id_file=".$id." AND user_add='".$usuario."' ") == 0){
			//VERIFICAR NO VOTO CON ANTERIORIDA AL MISMO ARCHIVO
			if (connection::countReg("galeria_videos_votaciones"," AND id_file=".$id." AND user_votacion='".$usuario."' ") == 0){
				//INSERTAR COMENTARIO
				$Sql = "INSERT INTO galeria_videos_votaciones (id_file,user_votacion) VALUES (
						".$id.",'".$usuario."')";
				connection::execute_query($Sql);
				
				//SUMAR VOTACION
				$Sql = "UPDATE galeria_videos
						SET videos_puntos=videos_puntos+1 
						WHERE id_file=".$id;
				connection::execute_query($Sql);
				return 1;
			}
			else return 2;
		}
		else return 3;
	}

	public function sumVideoView($id){
		$Sql = "UPDATE galeria_videos SET
				views=views+1 
				WHERE id_file=".$id."";
		return connection::execute_query($Sql);
	}

	public function insertVideoView($id, $username){
		if (self:: sumVideoView($id)){
			$Sql = "INSERT INTO galeria_videos_views (id_file, username) VALUES (".$id.",'".$username."')";
			return connection::execute_query($Sql);
		}
	}

	//////////////////////////////////////////////////////////
	// VIDEOS COMMENTS
	//////////////////////////////////////////////////////////

	public function getComentariosVideo($filter = ""){
		$Sql = "SELECT c.*,u.* FROM galeria_videos_comentarios c
				JOIN users u ON u.username=c.user_comentario
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);  
	}

	public function InsertComentario($id_file, $texto_comentario, $usuario, $estado){
		$Sql = "INSERT INTO galeria_videos_comentarios (id_file,comentario,user_comentario,estado) VALUES 
			 (".$id_file.",'".$texto_comentario."','".$usuario."',".$estado.")";
		if (connection::execute_query($Sql)) return "Comentario insertado correctamente.";
		else return "Se ha producido un error en la inserción del comentario. Por favor, inténtalo más tarde.";
	}

	public function cambiarEstadoComentario($id, $estado){
		$Sql = "UPDATE galeria_videos_comentarios SET
				estado=".$estado."
				WHERE id_comentario=".$id."";
		return connection::execute_query($Sql);
	}

	public function InsertVotacionVideo($id, $usuario){
		//VERIFICAR QUE EL USUARIO NO SE VOTE A SI MISMO
		if (connection::countReg("galeria_videos_comentarios"," AND id_comentario=".$id." AND user_comentario='".$usuario."' ") == 0){
			//VERIFICAR NO VOTO CON ANTERIORIDA AL MISMO ARCHIVO
			if (connection::countReg("galeria_videos_comentarios_votaciones"," AND id_comentario=".$id." AND user_votacion='".$usuario."' ") == 0){
				//INSERTAR COMENTARIO
				$Sql = "INSERT INTO galeria_videos_comentarios_votaciones (id_comentario,user_votacion) VALUES (
						".$id.",'".$usuario."')";
				connection::execute_query($Sql);
				
				//SUMAR VOTACION
				$Sql = "UPDATE galeria_videos_comentarios
						SET votaciones=votaciones+1 
						WHERE id_comentario=".$id;

				connection::execute_query($Sql);
				return 1;
			}
			else return 2;
		}
		else return 3;
	}

	public function getTags($filter = ""){
		$Sql = "SELECT GROUP_CONCAT(tipo_video) AS tag FROM galeria_videos WHERE tipo_video<>'' AND estado=1 ".$filter;
		$result = connection::getSQL($Sql);
		$registros = $registros = str_replace(', ',',',$result[0]['tag']);
		$registros =  explode(",", $registros);
		$registros = array_count_values($registros);
		return $registros;  
	}	
}
?>