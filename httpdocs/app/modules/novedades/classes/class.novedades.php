<?php
class novedades{
	public function getNovedades($filter = ""){
		$Sql = "SELECT n.*, c.canal_name 
				FROM novedades n 
				LEFT JOIN canales c On c.canal=n.canal 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertNovedades($titulo, $cuerpo, $activo, $canal, $perfil, $tipo, $orden){
		$Sql = "INSERT INTO novedades(titulo, cuerpo, activo, canal, perfil, tipo, date_novedad, orden) 
				VALUES ('".$titulo."','".$cuerpo."', ".$activo.", '".$canal."', '".$perfil."', '".$tipo."', NOW(), ".$orden.")";
		return connection::execute_query($Sql);
	}

	public function updateNovedades($id, $titulo, $cuerpo, $activo, $canal, $perfil, $tipo, $orden){
		$Sql = "UPDATE novedades SET
				activo=".$activo.",
				titulo='".$titulo."' ,
				cuerpo='".$cuerpo."' ,
				canal='".$canal."' ,
				perfil='".$perfil."' ,
				tipo='".$tipo."' ,
				orden=".$orden." ,
				date_novedad=NOW() 
				WHERE id_novedad=".$id." ";
		return connection::execute_query($Sql);
	}

	public function deleteNovedades($id){
		$Sql = "DELETE FROM novedades 
				WHERE id_novedad=".$id." ";
		return connection::execute_query($Sql);
	}
}
?>