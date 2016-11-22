<?php 
function PaginatorTabs($pag,$reg,$total_reg,$pag_dest,$title,$find_reg="",$num_paginas=10,$addClass="", $pagecount_dest = "pag"){
  $total_pag = ceil($total_reg / $reg);
  if ($total_pag > 1){
    $reg_ini = (($pag-1) * $reg) + 1;
    $reg_end = $pag*$reg;
    if ($reg_ini > $total_reg) { $reg_ini = $total_reg; }
    if ($reg_end > $total_reg) { $reg_end = $total_reg; }
    echo '<div class="pagination-tabs pull-right">
        <ul class="pagination">';
    //echo '<span class="messages"> '.$title.' '.$total_reg.' ('.$reg_ini.'-'.$reg_end.')</span>';
    if(($pag - 1) > 0) { echo '<li><a href="'.$pag_dest.'?'.$pagecount_dest.'=1&regs='.$reg.'&f='.$find_reg.'">&laquo;</a></li>';}
    else { echo '<li class="disabled"><a href="#">&laquo;</a></li>';}
    
    $pagina_inicial = $pag-1;
    if ($pagina_inicial <= 0){ $pagina_inicial = 1; }
    $pagina_final = $pagina_inicial + $num_paginas;
    
    if ($pag > 1){ echo '<li><a href="'.$pag_dest.'?'.$pagecount_dest.'='.($pag-1).'&regs='.$reg.'&f='.$find_reg.'"><i class="fa fa-angle-left"></i></a></li>';}
    else { echo '<li class="disabled"><a href="#"><i class="fa fa-angle-left"></i></a></span></li>';}
    
/*    for ($i = $pagina_inicial; $i <= $pagina_final; $i++){
      if($i <= $total_pag){
        if ($pag == $i) { echo '<li class="active"><a href="#">'.$pag.'</a></li>';}
        else { echo '<li><a href="'.$pag_dest.'?'.$pagecount_dest.'='.$i.'&regs='.$reg.'&f='.$find_reg.'">'.$i.'</a></li>';}
      }
    }*/
    
    if ($pag < $total_pag){
      echo '<li><a href="'.$pag_dest.'?'.$pagecount_dest.'='.($pag+1).'&regs='.$reg.'&f='.$find_reg.'"><i class="fa fa-angle-right"></i></a></li>';
    }
    else { echo '<li class="disabled"><a href="#"><i class="fa fa-angle-right"></i></a></li>';}
    
    if(($pag + 1) <= $total_pag) { echo '<li><a href="'.$pag_dest.'?'.$pagecount_dest.'='.$total_pag.'&regs='.$reg.'&f='.$find_reg.'">&raquo;</a></li>';}
    else { echo '<li class="disabled"><a href="#">&raquo;</a></li>';}
    echo '</ul>
      </div>';
  }
}
?>