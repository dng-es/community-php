<?php 
/**
 * Print HTML paginator
 * @param 	int  		$pag         	Número de página actual
 * @param 	int  		$reg         	Número de registros por página
 * @param 	int  		$total_reg   	Total de registros
 * @param 	string  	$pag_dest    	URL de destino
 * @param 	string  	$title       	Título del paginador
 * @param 	string  	$find_reg    	Cadena de busqueada. Dato que el paginador tiene que arrastrar
 * @param 	integer 	$num_paginas 	Número máximo de páginas a mostrar en el paginador
 * @param 	string  	$addClass    	Clase CSS
 */
function PaginatorIncidences($pag, $reg, $total_reg, $pag_dest, $title, $find_reg = "", $find_reg2 = "", $num_paginas = 10, $addClass = "", $pagecount_dest = "pag"){
	$total_pag = ceil($total_reg / $reg);
	if ($total_pag > 1){
		$separator = (strpos($pag_dest, "?") == 0  ? "?" : "&");
		$reg_ini = (($pag - 1) * $reg) + 1;
		$reg_end = $pag * $reg;
		if ($reg_ini > $total_reg) $reg_ini = $total_reg;
		if ($reg_end > $total_reg) $reg_end = $total_reg;
		echo '<div class="pagination-centered">
				<ul class="pagination">';
		//echo '<span class="messages"> '.$title.' '.$total_reg.' ('.$reg_ini.'-'.$reg_end.')</span>';
		if(($pag - 1) > 0) echo '<li><a href="'.$pag_dest.$separator.$pagecount_dest.'=1&regs='.$reg.'&f='.$find_reg.'&f2='.$find_reg2.'">&laquo;</a></li>';
		else echo '<li class="disabled"><a href="#">&laquo;</a></li>';
		
		$pagina_inicial = $pag - 1;
		if ($pagina_inicial <= 0) $pagina_inicial = 1;
		$pagina_final = $pagina_inicial + $num_paginas;
		
		if ($pag > 1) echo '<li><a href="'.$pag_dest.$separator.$pagecount_dest.'='.($pag - 1).'&regs='.$reg.'&f='.$find_reg.'&f2='.$find_reg2.'">anterior</a></li>';
		else echo '<li class="disabled"><a href="#">anterior</a></span></li>';
		
		for ($i = $pagina_inicial; $i <= $pagina_final; $i++){
			if($i <= $total_pag){
				if ($pag == $i) echo '<li class="active"><a href="#">'.$pag.'</a></li>';
				else echo '<li><a href="'.$pag_dest.$separator.$pagecount_dest.'='.$i.'&regs='.$reg.'&f='.$find_reg.'&f2='.$find_reg2.'">'.$i.'</a></li>';
			}
		}
		
		if ($pag < $total_pag) echo '<li><a href="'.$pag_dest.$separator.$pagecount_dest.'='.($pag+1).'&regs='.$reg.'&f='.$find_reg.'&f2='.$find_reg2.'">siguiente</a></li>';
		else echo '<li class="disabled"><a href="#">siguiente</a></li>';
		
		if(($pag + 1) <= $total_pag) echo '<li><a href="'.$pag_dest.$separator.$pagecount_dest.'='.$total_pag.'&regs='.$reg.'&f='.$find_reg.'&f2='.$find_reg2.'">&raquo;</a></li>';
		else echo '<li class="disabled"><a href="#">&raquo;</a></li>';
		echo '</ul>
			</div>';
	}
}
?>