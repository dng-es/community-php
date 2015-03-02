<?php
function SearchVideo($reg, $pag, $formId="searchForm", $labelForm="Buscar:", $labelButton="ir", $clase_css="", $class_form="", $method_form="post") {	
	$busqueda = isset($_POST['find_reg']) ? $_POST['find_reg'] : (isset($_REQUEST['f']) ? $_REQUEST['f'] : "");

	echo '<div class="'.$clase_css.'">  
			<form action="'.$pag.'" method="'.$method_form.'" name="'.$formId.'" id="'.$formId.'" class="'.$class_form.'">		  
				<div class="input-group">
					<label class="sr-only" for="find_reg">'.$labelForm.'</label>
					<input type="text" class="form-control" id="find_reg" name="find_reg" placeholder="'.$labelForm.'" value="'.$busqueda.'">
					<input type="hidden" name="registros_form" value="'.$reg.'" />
					<div class="input-group-btn">
						<button type="submit" class="btn btn-default" title="'.$labelButton.'" destino="'.$formId.'"><i class="glyphicon glyphicon-search"></i></button>
					</div>
				</div>  
			</form>
		  </div>';	
}
?>