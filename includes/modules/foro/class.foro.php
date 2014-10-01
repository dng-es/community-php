<?php
/**
* @Modulo de foros
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version  1.0
*
*/	
class foro extends connection{
 
	public function getTemas($filter = "") {
		$Sql="SELECT * FROM foro_temas WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);  
	}

	public function updateTemaArea($id_area,$nombre,$descripcion,$canal){
		$Sql="UPDATE foro_temas SET
			 nombre='".$nombre."',
			 descripcion='".$descripcion."',
			 canal='".$canal."'  
			 WHERE id_area=".$id_area." AND id_tema_parent=0";
		return connection::execute_query($Sql);
	}	  

	public function getTemasComentarios($filter = "",$limit=""){
		$Sql="SELECT DISTINCT temas.* FROM (SELECT t.* FROM foro_temas t
				LEFT JOIN foro_comentarios c ON c.id_tema=t.id_tema
				WHERE 1=1 ".$filter." ORDER BY c.date_comentario DESC) AS temas ".$limit;
		return connection::getSQL($Sql);  
	}	  
	  
	public function getComentarios($filter = ""){
		$Sql="SELECT c.*,t.*,u.* FROM foro_comentarios c
			  JOIN foro_temas t ON t.id_tema=c.id_tema 
			  JOIN users u ON u.username=c.user_comentario
			  WHERE 1=1 ".$filter;		  
		return connection::getSQL($Sql);
	}

	public function getComentariosPanel($filter = ""){
		$Sql="SELECT c.id_tema,t.canal AS canal_tema,nombre FROM foro_comentarios c
			  JOIN foro_temas t ON t.id_tema=c.id_tema 
			  WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}		  

	public function getComentariosExport($filter = ""){
		$Sql="SELECT c.*,t.nombre AS Tema FROM foro_comentarios c
			  JOIN foro_temas t ON t.id_tema=c.id_tema 
			  WHERE c.user_comentario<>'' ".$filter;			  
		return connection::getSQL($Sql);
	}

	  public function InsertTema($id_tema_parent,$nombre,$descripcion,$imagen_tema,$user,$canal,$responsables,$activo,$itinerario='',$id_area=0,$ocio=0,$tipo = ""){
		$nombre=nl2br(str_replace("'","´",$nombre));
		$descripcion=nl2br(str_replace("'","´",$descripcion));

	  	if (isset($imagen_tema['name']) and $imagen_tema['name']!=""){ 
	  		$imagen_tema = self::insertTemaFoto($imagen_tema);
	  	}

		$Sql="INSERT INTO foro_temas (id_tema_parent,nombre,descripcion,imagen_tema,user,canal,responsables,activo,itinerario,id_area,ocio,tipo_tema) VALUES 
			 (".$id_tema_parent.",'".$nombre."','".$descripcion."','".$imagen_tema."','".$user."','".$canal."',".$responsables.",".$activo.",'".$itinerario."',".$id_area.",".$ocio.",'".$tipo."')";
		return connection::execute_query($Sql);		
      }	
         
	  public function InsertComentario($id,$texto_comentario,$usuario,$estado,$id_comentario_id = 0){
		$texto_comentario=nl2br(str_replace("'","´",$texto_comentario));
		$Sql="INSERT INTO foro_comentarios (id_tema,comentario,user_comentario,estado,id_comentario_id) VALUES 
			 (".$id.",'".$texto_comentario."','".$usuario."',".$estado.",".$id_comentario_id.")";
		if (connection::execute_query($Sql)){ 
		  //puntuacion semanal
		  if(connection::countReg("foro_comentarios"," AND user_comentario='".$usuario."' AND WEEK(date_comentario)=WEEK(NOW()) AND YEAR(date_comentario)=YEAR(NOW())")==1){
			  users::sumarPuntos($usuario,PUNTOS_FORO_SEMANA,PUNTOS_FORO_SEMANA_MOTIVO);}
		  if ($estado==1){users::sumarPuntos($usuario,PUNTOS_FORO,PUNTOS_FORO_MOTIVO);}
		  
		  return true;
		}
		else {return false;}		
      }	   
	  
	  public function InsertVotacion($id,$usuario){
		//VERIFICAR QUE EL USUARIO NO SE VOTE A SI MISMO
		if (connection::countReg("foro_comentarios"," AND id_comentario=".$id." AND user_comentario='".$usuario."' ")==0){
			//VERIFICAR NO VOTO CON ANTERIORIDA AL MISMO COMENTARIO
			if (connection::countReg("foro_comentarios_votaciones"," AND id_comentario=".$id." AND user_votacion='".$usuario."' ")==0){
				//INSERTAR COMENTARIO
				$Sql="INSERT INTO foro_comentarios_votaciones (id_comentario,user_votacion) VALUES (
					 ".$id.",'".$usuario."')";
				connection::execute_query($Sql);
				
				//SUMAR VOTACION
				$Sql="UPDATE foro_comentarios
					  SET votaciones=votaciones+1 
					  WHERE id_comentario=".$id;
				connection::execute_query($Sql);	
				return "Votación realizada con &eacute;xito.";
			}
			else {return "Ya has votado este comentario.";}		
		}
		else {return "No puedes votar tus propios comentarios.";}
      }

	  public function cambiarTipoTema($id,$tipo){
		$Sql="UPDATE foro_temas SET
			 tipo_tema='".$tipo."'
			 WHERE id_tema=".$id."";
		return connection::execute_query($Sql);
      }	

	  public function cambiarEstadoTema($id,$activo){
		$Sql="UPDATE foro_temas SET
			 activo=".$activo."
			 WHERE id_tema=".$id."";
		return connection::execute_query($Sql);
      }

	  public function cambiarEstado($id,$estado){
		$Sql="UPDATE foro_comentarios SET
			 estado=".$estado."
			 WHERE id_comentario=".$id."";
		return connection::execute_query($Sql);
      }
	  
	  public function insertVisita($username,$id_tema,$movil=0){
		$Sql = "INSERT INTO foro_visitas (username,id_tema,movil) VALUES ('".$username."',".$id_tema.",".$movil.");";
		connection::execute_query($Sql);
	  }

	  public function updateTema($id,$nombre,$descripcion,$etiquetas,$foto){
	  	$nombre = str_replace("'", "´", $nombre);
	  	$descripcion = str_replace("'", "´", $descripcion);
	  	$Sql_imagen = "";
	  	if ($foto['name']!=""){ 
	  		//subir foto nueva
	  		$nombre_imagen = self::insertTemaFoto($foto);
	  		$Sql_imagen = "imagen_tema='".$nombre_imagen."',";
	  	}
		$Sql="UPDATE foro_temas SET
			 nombre='".$nombre."',
			 descripcion='".$descripcion."',
			 ".$Sql_imagen."
			 tipo_tema='".$etiquetas."'
			 WHERE id_tema=".$id."";
		return connection::execute_query($Sql);
      }	 

      public function insertTemaFoto($fichero){
		//SUBIR FICHERO
		$nombre_archivo = time().'_'.str_replace(" ","_",$fichero['name']);
		$nombre_archivo = strtolower($nombre_archivo);
		$nombre_archivo=NormalizeText($nombre_archivo);
		
		$tipo_archivo = $fichero['type'];
		$tamano_archivo = $fichero['size'];
		//compruebo si las características del archivo son las que deseo
		if (!((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg")) && ($tamano_archivo < MAX_SIZE_FOTOS))) {
			return false;
		}else{
			if (move_uploaded_file($fichero['tmp_name'], "images/foro/".$nombre_archivo)){
				return $nombre_archivo;		
			}else{ return false;} 
		}
      }

	  public function getArchivoBlog(){
	    $Sql="SELECT MONTH(date_tema) AS mes,YEAR(date_tema) AS ano,COUNT(id_tema) AS contador FROM foro_temas WHERE ocio=1 AND activo=1 GROUP BY MONTH(date_tema),YEAR(date_tema) ORDER BY ano DESC,mes DESC ";
	    return connection::getSQL($Sql);  
	  }      

	  public function getCategorias($filter = ""){
	    $Sql="SELECT DISTINCT tipo_tema AS categoria FROM foro_temas WHERE tipo_tema<>'' ".$filter;
	    $result=connection::execute_query($Sql);	
	    $registros = "";  
	    while ($registro = connection::get_result($result))  
	    {  
		  $registros .= ",".str_replace(", ", ",", $registro['categoria']);  
	    }
	    $registros = substr($registros, 1,strlen($registros));
	    $registros =  explode(",", $registros);
	    $registros = array_values(array_unique($registros));
	    return $registros;  
	  }

	public function getLastTemas($filter = "",$limit=3){
		$Sql="SELECT DISTINCT c.id_tema FROM `foro_comentarios` c
			LEFT JOIN foro_temas t ON t.id_tema=c.id_tema
			WHERE t.activo=1 ".$filter."
			ORDER BY c.id_comentario DESC
			LIMIT ".$limit;
		return connection::getSQL($Sql);  
	}
}
?>
