<?php
/**
 * Funcion para obtener variables del paginador
 * @param	int			$reg			Número de registros por página
 * @return	array						Array con parámetros para el paginador
 */
function PaginatorPagesAlerts($reg){
	$find_reg = "";
	$pag = 1;
	$inicio = 0;
	if (isset($_GET["pag_a"]) && $_GET["pag_a"] != ""){
		$pag = $_GET["pag_a"];
		$inicio = ($pag - 1) * $reg;
	}
	return array('find_reg' => $find_reg,
				'pag' => $pag,
				'inicio' =>$inicio);
}
?>