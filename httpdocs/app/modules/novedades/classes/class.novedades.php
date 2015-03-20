<?php
/**
* @Modulo Novedades
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.0
*
*/	
class novedades {
 
	public function getNovedades($filter = ""){
		$Sql="SELECT n.*, c.canal_name FROM novedades n 
		LEFT JOIN canales c On c.canal=n.canal WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function updateNovedades($cuerpo,$activo, $canal){
		$Sql="UPDATE novedades SET
			 activo=".$activo.",
			 cuerpo='".$cuerpo."' ,
			 date_novedad=NOW()
			 WHERE canal='".$canal."' ";
		return connection::execute_query($Sql);
	}	  
}
?>