<?php
class destacados{
	public function getDestacados($filter = ""){
		$Sql = "SELECT * 
				FROM destacados 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function getDestacadosFile($filter = "", $tipo_destacado = 'foto'){
		if ($tipo_destacado == 'foto') $tabla_destacado = "galeria_fotos";
		elseif ($tipo_destacado == 'video') $tabla_destacado = "galeria_videos";

		$Sql = "SELECT * 
				FROM destacados d 
				LEFT JOIN ".$tabla_destacado." g ON g.id_file=d.destacado_id_file 
				LEFT JOIN users u On u.username=g.user_add
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function InsertDestacado($destacado_tipo, $destacado_id_file, $destacado_texto, $canal_destacado){
		$Sql = "UPDATE destacados SET 
				activo=0 
				WHERE canal_destacado='".$canal_destacado."'";
		connection::execute_query($Sql);

		$Sql = "INSERT INTO destacados (destacado_tipo,destacado_id_file,destacado_texto,canal_destacado,activo) VALUES (
				'".$destacado_tipo."',".$destacado_id_file.",'".$destacado_texto."','".$canal_destacado."',1)";
		return connection::execute_query($Sql);
	}
}
?>
