<?php
class infotopdf{
 
	public function getInfo($filter = ""){
		$Sql = "SELECT i.*,t.nombre_info AS tipo,c.name_campaign AS campana FROM infotopdf i 
				LEFT JOIN infotopdf_tipo t ON i.tipo_info=t.id_tipo 
				LEFT JOIN campaigns c ON i.id_campaign=c.id_campaign 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function getInfoTipos($filter = ""){
		$Sql = "SELECT * FROM infotopdf_tipo
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function deleteInfo($id, $documento){
		unlink(PATH_INFO.$documento);
		$Sql = "DELETE FROM infotopdf
				WHERE id_info=".$id;
		return connection::execute_query($Sql);
	}

	public function insertInfo($fichero, $titulo, $canal, $tipo, $id_campaign, $cuerpo_info){
		//SUBIR FICHERO
		$nombre_archivo = time().'_'.str_replace(" ", "_", $fichero['name']);
		$nombre_archivo = NormalizeText($nombre_archivo);

		if (move_uploaded_file($fichero['tmp_name'], PATH_INFO.$nombre_archivo)){

			//generar miniatura
			imgThumbnail($nombre_archivo, PATH_INFO, 200, 100);
			//INSERTAR REGISTRO EN LA BBDD
			$Sql="INSERT INTO infotopdf (titulo_info,file_info,canal_info,tipo_info,id_campaign,cuerpo_info) 
					VALUES
					('".$titulo."','".$nombre_archivo."','".$canal."',".$tipo.",".$id_campaign.",'".$cuerpo_info."')";
			if (connection::execute_query($Sql)) return "";
			else  return "Ocurrió algún error al subir el contenido. No pudo guardarse 1.";
		}
		else return "Ocurrió algún error al subir el contenido. No pudo guardarse 2.";
	}

	public function updateInfo($id, $document_file, $title, $canal, $tipo, $id_campaign, $cuerpo_info){
		if ($document_file['name'] != ''){
			$nombre_archivo = time().'_'.str_replace(" ", "_", $document_file['name']);
			$nombre_archivo = NormalizeText($nombre_archivo);
			if (move_uploaded_file($document_file['tmp_name'], PATH_INFO.$nombre_archivo)){
				//generar miniatura
				imgThumbnail($nombre_archivo, PATH_INFO, 200, 100);
				$SqlUpdate = "file_info='".$nombre_archivo."', ";
			}
			else{ ErrorMsg('Error al subir el documento.'); return false;}
		}
		else $SqlUpdate = "";

		$Sql = "UPDATE infotopdf SET
				titulo_info='".$title."',
				".$SqlUpdate."
				canal_info='".$canal."', 
				cuerpo_info = '".$cuerpo_info."', 
				tipo_info=".$tipo.",
				id_campaign=".$id_campaign." 
				WHERE id_info=".$id;
		return connection::execute_query($Sql);
	}
}
?>
