<?php 
/**
 * Print HTML form panel for products search
 * @param	String 		$dstination		Página de destino del buscador
 * @return	String						HTML form panel
 */
function searchProducts($destination = "ps-products"){ 
	$name = (isset($_REQUEST['name']) ? $_REQUEST['name'] : "");
	?>
	<form name="searchProducts" id="searchProducts" action="<?php echo $destination;?>" class="form-horizontal" method="get" role="form">
		<div class="input-group">
			<label class="sr-only" for="name_search"><?php e_strTranslate('Name');?></label>
			<input type="text" class="form-control" id="name" name="name" placeholder="<?php e_strTranslate("Search");?> <?php e_strTranslate("APP_Prestashop");?>" value="<?php echo $name;?>">
			<div class="input-group-btn">
				<button type="submit" class="btn btn-default" title="<?php e_strTranslate("Search");?>"><span class="glyphicon glyphicon-search"></span></button>
			</div>
		</div>
	</form>

	<?php if($name != ''):?>
		<br /><p><a href="ps-products">Ver todos los artículos <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></p>
	<?php endif;?>
<?php } ?>