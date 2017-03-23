<?php
/**
 * Print HTML paginator
 * @param	Int			$pag			Número de página actual
 * @param	Int			$reg			Número de registros por página
 * @param	Int			$total_reg		Total de registros
 * @param	String		$pag_dest		URL de destino
 * @param	String		$title			Título del paginador
 * @param	String		$find_reg		Cadena de busqueada. Dato que el paginador tiene que arrastrar
 * @param	String		$find_tipo		Cadena de busqueada. Dato que el paginador tiene que arrastrar
 * @param	Integer		$marcado		Cadena de busqueada . Dato que el paginador tiene que arrastrar
 * @param	Integer		$num_paginas	Número máximo de páginas a mostrar en el paginador
 * @return  String		String			HTML paginator
 */
function ForoPaginator($pag, $reg, $total_reg, $pag_dest, $title, $find_reg = "", $find_tipo = "", $marcado = 0, $num_paginas = 10){
	$total_pag = ceil($total_reg / $reg);
	if ($total_reg > 0 && $total_pag > 1){
		$separator = (strpos($pag_dest, "?") == 0  ? "?" : "&");
		$reg_ini = (($pag - 1) * $reg) + 1;
		$reg_end = $pag * $reg;
		if ($reg_ini > $total_reg) $reg_ini = $total_reg;
		if ($reg_end > $total_reg) $reg_end = $total_reg;
		echo '<div class="pagination-centered">
				<ul class="pagination">';
		//echo '<span class="messages"> '.$title.' '.$total_reg.' ('.$reg_ini.'-'.$reg_end.')</span>';
		if(($pag - 1) > 0) echo '<li><a href="'.$pag_dest.$separator.'pag=1&regs='.$reg.'&f='.$find_reg.'&t='.$find_tipo.'&m='.$marcado.'">&laquo;</a></li>';
		else echo '<li class="disabled"><a href="#">&laquo;</a></li>';

		$pagina_inicial = $pag - 1;
		if ($pagina_inicial <= 0) $pagina_inicial = 1;
		$pagina_final = $pagina_inicial + $num_paginas;

		for ($i = $pagina_inicial; $i <= $pagina_final; $i++){
			if($i <= $total_pag){
				if ($pag == $i) echo '<li class="active"><a href="#">'.$pag.'</a></li>';
				else echo '<li><a href="'.$pag_dest.$separator.'pag='.$i.'&regs='.$reg.'&f='.$find_reg.'&t='.$find_tipo.'&m='.$marcado.'">'.$i.'</a></li>';
			}
		}

		if(($pag + 1) <= $total_pag) echo '<li><a href="'.$pag_dest.$separator.'pag='.$total_pag.'&regs='.$reg.'&f='.$find_reg.'&t='.$find_tipo.'&m='.$marcado.'">&raquo;</a></li>';
		else echo '<li class="disabled"><a href="#">&raquo;</a></li>';

		echo '</ul>
		</div>';
	}
} ?>