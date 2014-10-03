<?php
/**
* @Libreria de archivos descargables para el usuario
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.1.1
*
*/	
class info{
 
	  public function getInfo($filter = ""){
	    $Sql="SELECT i.*,t.nombre_info AS tipo,c.name_campaign AS campana FROM info i 
	    	  LEFT JOIN info_tipo t ON i.tipo_info=t.id_tipo 
	    	  LEFT JOIN campaigns c ON i.id_campaign=c.id_campaign 
	    	  WHERE 1=1 ".$filter;
	    return connection::getSQL($Sql); 
	  }

	  public function getInfoTipos($filter = ""){
	    $Sql="SELECT * FROM info_tipo
	    	  WHERE 1=1 ".$filter;
	    return connection::getSQL($Sql);
	  }	  
	  
	  public function deleteInfo($id,$documento){
		unlink(PATH_INFO.$documento);
		$Sql="DELETE FROM info
			  WHERE id_info=".$id;
		return connection::execute_query($Sql);
      } 

	  public function insertInfo($fichero,$titulo,$canal,$tipo,$id_campaign){
		//SUBIR FICHERO
		$nombre_archivo = time().'_'.str_replace(" ","_",$fichero['name']);
		$nombre_archivo = strtolower($nombre_archivo);
		$nombre_archivo=NormalizeText($nombre_archivo);
	
		if (move_uploaded_file($fichero['tmp_name'], PATH_INFO.$nombre_archivo)){
			//INSERTAR REGISTRO EN LA BBDD  
			$Sql="INSERT INTO info (titulo_info,file_info,canal_info,tipo_info,id_campaign) 
				 VALUES
				 ('".$titulo."','".$nombre_archivo."','".$canal."',".$tipo.",".$id_campaign.")";
			if (connection::execute_query($Sql)){ return 0;}
			else { return 1;}		   
		}else{ return 2;} 
      }  

      public function updateInfo($id,$document_file,$title,$canal,$tipo,$id_campaign){
		if ($document_file['name']!='') {
			$nombre_archivo = time().'_'.str_replace(" ","_",$document_file['name']);
			$nombre_archivo = strtolower($nombre_archivo);
			$nombre_archivo=NormalizeText($nombre_archivo);	
			if (move_uploaded_file($document_file['tmp_name'], PATH_INFO.$nombre_archivo)){
				$SqlUpdate="file_info='".$nombre_archivo."', ";
			}
			else{ErrorMsg('Error al subir el documento.');return false;}
		}
		else {$SqlUpdate="";}
		 
		$Sql="UPDATE info SET
			 titulo_info='".$title."',
			 ".$SqlUpdate."
			 canal_info='".$canal."', 
			 tipo_info=".$tipo.",
			 id_campaign=".$id_campaign." 
			 WHERE id_info=".$id;
		return connection::execute_query($Sql);
      }	 
}
?>
