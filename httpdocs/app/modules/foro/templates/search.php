<?php
/**
* Print HTML search foro panel
*
* @param 	Int 		$reg 			Number of items per page
* @param 	Int 		$pag 			Current page number
* @param 	Array 		$iniValue 		Ini search value
* @param 	Int 		$marca_tipo 	NOT IN USE
* @param 	String 		$tipo_tema 		Current selected $tipo_tema
* @return 	String						HTML panel
*/
function ForoSearch($reg, $pag, $iniValue, $marca_tipo, $tipo_tema){ ?>
	<div class="search-form">
		<form action="<?php echo $pag.'&regs='.$reg;?>" method="post" role="search">
		<div class="input-group">
			<label class="sr-only" for="find_reg">Introduce el nombre del foro a buscar</label>
			<input id="find_reg" name="find_reg" type="text" value="<?php echo $iniValue;?>" class="form-control" placeholder="<?php e_strTranslate("Search");?>" />
			<input type="hidden" name="registros_form" value="<?php echo $reg;?>" />
			<!-- <?php //if ($_SESSION['user_perfil']=='admin'): ?>
				<div class="form-group">
					<select name="find_tipo" id="find_tipo" class="form-control">
						<option value="">---Buscar por etiqueta---</option>
					<?php //ComboTiposTemas($tipo_tema);?>
					</select>
				</div>
			<?php //endif; ?> -->
			<div class="input-group-btn">
				<button type="submit" class="btn btn-default" title="Buscar"><i class="glyphicon glyphicon-search"></i></button>
			</div>
		</div>
	</form>
</div>
<?php }?>