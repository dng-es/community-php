<?php
function SearchVideo($reg, $pag, $formId = "searchForm", $labelForm = "Buscar:", $labelButton = "ir", $clase_css = "", $class_form = "", $method_form = "post") {	
	$busqueda = isset($_POST['find_reg']) ? $_POST['find_reg'] : (isset($_REQUEST['f']) ? $_REQUEST['f'] : ""); ?>

	<div class="<?php echo $clase_css;?>">  
		<form action="<?php echo $pag;?>" method="<?php echo $method_form;?>" name="<?php echo $formId;?>" id="<?php echo $formId;?>" class="<?php echo $class_form;?>">		  
			<div class="input-group">
				<label class="sr-only" for="find_reg"><?php echo $labelForm;?></label>
				<input type="text" class="form-control" id="find_reg" name="find_reg" placeholder="<?php echo $labelForm;?>" value="<?php echo $busqueda;?>">
				<input type="hidden" name="registros_form" value="<?php echo $reg;?>" />
				<div class="input-group-btn">
					<button type="submit" class="btn btn-default" title="<?php echo $labelButton;?>" destino="<?php echo $formId;?>"><i class="glyphicon glyphicon-search"></i></button>
				</div>
			</div>
		</form>
	</div>
<?php } ?>