<?php
/**
* @Modulo premios del día (texto, foto, ...)
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 0.5
*
*/	
class premios extends connection{
 
	public function getPremios($filter = ""){
		$Sql="SELECT * FROM premios_dia WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function updatePremios($tipo,$cuerpo,$tipo_fondo){
		if (($tipo=='imagen' or $tipo=='video') and isset($cuerpo) and $cuerpo['name']!='') {
			$nombre_imagen = time().'_'.str_replace(" ","_",$cuerpo['name']);
			$nombre_imagen = strtolower($nombre_imagen);
			$nombre_imagen = NormalizeText($nombre_imagen);		
			if ($tipo=='imagen'){move_uploaded_file($cuerpo['tmp_name'], 'images/banners/'.$nombre_imagen);$cuerpo=$nombre_imagen;}
			if ($tipo=='video'){			
				if (move_uploaded_file($cuerpo['tmp_name'], PATH_VIDEOS.$nombre_imagen)){
					$videos=new videos();
					if ($videos->convertirVideo($nombre_imagen,PATH_VIDEOS,PATH_VIDEOS)){
						unlink (PATH_VIDEOS.$nombre_imagen);
						$cuerpo=$nombre_imagen.'.mp4';
					}
					else { return false;}
				}
			else { return false;}
			}		
		}
		$Sql="UPDATE premios_dia SET
			 tipo='".$tipo."',
			 fondo=".$tipo_fondo.",
			 cuerpo='".$cuerpo."'";
		return connection::execute_query($Sql);
	}	  
}
?>