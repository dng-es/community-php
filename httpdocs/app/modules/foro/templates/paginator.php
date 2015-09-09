<?php
	function ForoPaginator($pag,$reg,$total_reg,$pag_dest,$title,$find_reg="",$find_tipo="",$marcado=0,$num_paginas=10)	{
		$total_pag = ceil($total_reg / $reg);
		if ($total_reg > 0 and $total_pag>1){
			$separator = (strpos($pag_dest, "?")==0  ? "?" : "&");
			$reg_ini=(($pag-1)*$reg)+1;
			$reg_end=$pag*$reg;
			if ($reg_ini>$total_reg) {$reg_ini=$total_reg;}
			if ($reg_end>$total_reg) {$reg_end=$total_reg;}
			echo '<div class="pagination-centered">
					<ul class="pagination">';
			//echo '<span class="messages"> '.$title.' '.$total_reg.' ('.$reg_ini.'-'.$reg_end.')</span>';
			if(($pag - 1) > 0) { echo '<li><a href="'.$pag_dest.$separator.'pag=1&regs='.$reg.'&f='.$find_reg.'&t='.$find_tipo.'&m='.$marcado.'">&laquo;</a></li>';}
			else { echo '<li class="disabled"><a href="#">&laquo;</a></li>';}
			
			
			$pagina_inicial=$pag-1;
			if ($pagina_inicial<=0){$pagina_inicial=1;}
			$pagina_final=$pagina_inicial+$num_paginas;
			
			//if ($pag>1){ echo '<li><a href="'.$pag_dest.'?pag='.($pag-1).'&regs='.$reg.'&f='.$find_reg.'"></a></li>';}
			//else { echo '<li class="disabled"><a href="#">1</a></li>';}
			
			
			for ($i=$pagina_inicial; $i<=$pagina_final; $i++){
				if($i<=$total_pag){
				  if ($pag == $i) { echo '<li class="active"><a href="#">'.$pag.'</a></li>';}
				  else { echo '<li><a href="'.$pag_dest.$separator.'pag='.$i.'&regs='.$reg.'&f='.$find_reg.'&t='.$find_tipo.'&m='.$marcado.'">'.$i.'</a></li>';}
				}
			}
			
			// if ($pag<$total_pag){
			// 	echo '<li><a href="'.$pag_dest.'?pag='.($pag+1).'&regs='.$reg.'&f='.$find_reg.'">sig</a></li>';
			// }
			// else { echo '<li class="disabled"></li>';}
			
			if(($pag + 1)<=$total_pag) { echo '<li><a href="'.$pag_dest.$separator.'pag='.$total_pag.'&regs='.$reg.'&f='.$find_reg.'&t='.$find_tipo.'&m='.$marcado.'">&raquo;</a></li>';}
			else { echo '<li class="disabled"><a href="#">&raquo;</a></li>';}
			echo '</ul>
			</div>';
		}
	}	
?>