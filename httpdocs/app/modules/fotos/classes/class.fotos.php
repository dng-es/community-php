<?php
/**
* @Modulo de fotos, depends on Users module. 
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.0
*
*/	
class fotos{

	public function getFotos($filter = ""){
		$Sql="SELECT f.*,u.*,f.canal AS canal_file FROM galeria_fotos f 
			  JOIN users u ON u.username=f.user_add WHERE 1=1 ".$filter;
		return connection::getSQL($Sql); 
	}

	public function getFotosAlbumes($filter = ""){
		$Sql="SELECT * FROM galeria_fotos_albumes
			  WHERE 1=1 ".$filter;
		return connection::getSQL($Sql); 
	} 

	public function getFotosConAlbumes($filter = ""){
		$Sql="SELECT g.*,a.* FROM galeria_fotos g 
			  LEFT JOIN galeria_fotos_albumes a ON a.id_album=g.id_album 
			  WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);  
	} 	  

	public function getFotosPromociones($filter = ""){
		$Sql="SELECT f.*,u.*,f.canal AS canal_file,IFNULL(p.nombre_promocion,'') AS reto 
			  FROM galeria_fotos f 
			  LEFT JOIN promociones p ON p.id_promocion=f.id_promocion
			  JOIN users u ON u.username=f.user_add WHERE 1=1 ".$filter;
		return connection::getSQL($Sql); 
	}  	   

	public function cambiarEstado($id,$estado,$seleccion=0){
		$Sql="UPDATE galeria_fotos SET
			 estado=".$estado.",
			 seleccion_reto=".$seleccion."
			 WHERE id_file=".$id."";
		return connection::execute_query($Sql);
	}

	public function cambiarEstadoAlbum($id,$estado){
		$Sql="UPDATE galeria_fotos_albumes SET
			 activo=".$estado."
			 WHERE id_album=".$id."";
		return connection::execute_query($Sql);
	}  

	public function insertAlbum($nombre,$usuario){
		$Sql="INSERT INTO galeria_fotos_albumes (nombre_album, username_album) VALUES ('".$nombre."','".$usuario."')";
		return connection::execute_query($Sql);
	}  

	public function updateAlbum($id,$nombre,$usuario){
		$Sql="UPDATE galeria_fotos_albumes SET
			 nombre_album='".$nombre."',
			 username_album='".$usuario."'
			 WHERE id_album=".$id."";
		return connection::execute_query($Sql);
	}  

	public function updateFotoAlbum($id,$id_album){
		$Sql="UPDATE galeria_fotos SET
			 id_album=".$id_album." 
			 WHERE id_file=".$id."";
		return connection::execute_query($Sql);
	}               

	public function insertFile($fichero,$path_archivo,$canal,$titulo,$id_promocion=0,$formacion=0,$tipo_foto=''){
		global $fotos_types;
		//SUBIR FICHERO
		$ext = substr($fichero['name'], strrpos($fichero['name'],".") + 1);
		$nombre_archivo = time().'.'.$ext;
		$tamano_archivo = $fichero['size'];
		//compruebo si las características del archivo son las que deseo
		if (!(in_array(strtoupper($ext), $fotos_types) && ($tamano_archivo < MAX_SIZE_FOTOS))) {
			return 0;
		}else{
			if (move_uploaded_file($fichero['tmp_name'], $path_archivo.$nombre_archivo)){
				//INSERTAR REGISTRO EN LA BBDD  
				$Sql="INSERT INTO galeria_fotos (titulo,name_file,user_add,canal,id_promocion,formacion,tipo_foto) VALUES (
					 '".$titulo."',
					 '".$nombre_archivo."',
					 '".$_SESSION['user_name']."',
					 '".$canal."',
					 ".$id_promocion.",
					 ".$formacion.",
					 '".$tipo_foto."'
					 )";
				if (connection::execute_query($Sql)){ return 1;}
				else { return 2;}		   
			}else{ return 3;} 
		}
	}

	public function InsertVotacion($id,$usuario){
		//VERIFICAR QUE EL USUARIO NO SE VOTE A SI MISMO
		if (connection::countReg("galeria_fotos"," AND id_file=".$id." AND user_add='".$usuario."' ")==0){
			//VERIFICAR NO VOTO CON ANTERIORIDA AL MISMO ARCHIVO
			if (connection::countReg("galeria_fotos_votaciones"," AND id_file=".$id." AND user_votacion='".$usuario."' ")==0){
				//INSERTAR COMENTARIO
				$Sql="INSERT INTO galeria_fotos_votaciones (id_file,user_votacion) VALUES (
					 ".$id.",'".$usuario."')";
				connection::execute_query($Sql);
				
				//SUMAR VOTACION
				$Sql="UPDATE galeria_fotos
					  SET fotos_puntos=fotos_puntos+1 
					  WHERE id_file=".$id;
				connection::execute_query($Sql);			
				return 1;
			}
			else {return 2;}		
		}
		else {return 3;}
	}

//////////////////////////////////////////////////////////
// COMENTARIOS EN LAS FOTOS
//////////////////////////////////////////////////////////
	public function getComentariosFoto($filter = ""){
		$Sql="SELECT c.*,u.* FROM galeria_fotos_comentarios c
			  JOIN users u ON u.username=c.user_comentario
			  WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);  
	} 

	public function InsertComentario($id_file,$texto_comentario,$usuario,$estado){
		$Sql="INSERT INTO galeria_fotos_comentarios (id_file,comentario,user_comentario,estado) VALUES 
			 (".$id_file.",'".$texto_comentario."','".$usuario."',".$estado.")";
		if (connection::execute_query($Sql)){ return "Comentario insertado correctamente.";}
		else {return "Se ha producido un error en la inserción del comentario. Por favor, intétalo más tarde.";}		
    }	
	    
	public function cambiarEstadoComentario($id,$estado){
		$Sql="UPDATE galeria_fotos_comentarios SET
			 estado=".$estado."
			 WHERE id_comentario=".$id."";
		return connection::execute_query($Sql);
    }	

	public function InsertVotacionFoto($id,$usuario){
		//VERIFICAR QUE EL USUARIO NO SE VOTE A SI MISMO
		if (connection::countReg("galeria_fotos_comentarios"," AND id_comentario=".$id." AND user_comentario='".$usuario."' ")==0){
			//VERIFICAR NO VOTO CON ANTERIORIDA AL MISMO ARCHIVO
			if (connection::countReg("galeria_fotos_comentarios_votaciones"," AND id_comentario=".$id." AND user_votacion='".$usuario."' ")==0){
				//INSERTAR COMENTARIO
				$Sql="INSERT INTO galeria_fotos_comentarios_votaciones (id_comentario,user_votacion) VALUES (".$id.",'".$usuario."')";
				connection::execute_query($Sql);
				
				//SUMAR VOTACION
				$Sql="UPDATE galeria_fotos_comentarios
					  SET votaciones=votaciones+1 
					  WHERE id_comentario=".$id;

				connection::execute_query($Sql);			
				return strTranslate("Photos_comment_vote_ok");
			}
			else return strTranslate("Photos_comment_vote_repeat");	
		}
		else return strTranslate("Photos_comment_vote_own");
    }	  
}
?>