<?php
/**
 * Print HTML  search form
 * @param	Int			$pag			Número de página. Empleado por paginador
 * @param	String		$formId			Id del formulario HTML
 * @param	String		$labelForm		Texto para el label del formulario
 * @param	String		$labelButton	Texto para el botón de buscar
 * @param	String		$clase_css		Clase CSS para el panel contenedor del form
 * @param	String		$class_form		Clase CSS para el form
 * @param	String		$method_form	Método de envío de datos del cormularios
 * @return 	String						HTML search form
 */
function SearchPhoto($pag, $formId = "searchForm", $labelForm = "Buscar:", $labelButton = "ir", $clase_css = "" , $class_form = "", $method_form = "post") {
	$busqueda = isset($_POST['find_reg']) ? $_POST['find_reg'] : (isset($_REQUEST['find_reg']) ? $_REQUEST['find_reg'] : "");?>
<div class="<?php echo $clase_css;?>">
	<form action="<?php echo $pag;?>" method="<?php echo $method_form;?>" id="<?php echo $formId;?>" class="<?php echo $class_form;?>">
		<div class="input-group">
			<label class="sr-only" for="find_reg"><?php echo $labelForm;?></label>
			<input type="text" class="form-control" id="find_reg" name="find_reg" placeholder="<?php echo $labelForm;?>" value="<?php echo $busqueda;?>">
			<input type="hidden" name="page" value="<?php echo $pag;?>" />
			<div class="input-group-btn">
				<button type="submit" class="btn btn-default" title="<?php echo $labelButton;?>" destino="<?php echo $formId;?>"><i class="glyphicon glyphicon-search"></i></button>
			</div>
		</div>
	</form>
</div>
<?php } ?>