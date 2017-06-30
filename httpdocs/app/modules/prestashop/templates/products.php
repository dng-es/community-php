<?php 

function printListProduct($product){ 
	$module_config = getModuleConfig("prestashop");
	?>
<div class="col-lg-3 col-md-4 col-sm-6">
	<div class="panel panel-product">
		<div class="panel-default">
			<div class="row">
				<div class="col-md-12">
					<a href="ps-product?id=<?php echo $product['id'];?>"><img src="<?php echo $product['image'];?>" width="100%" /></a>
				</div>
				<div class="col-md-12 inset">
					<a href="ps-product?id=<?php echo $product['id'];?>" class="text-center title ellipsis"><?php echo $product['name'];?></a>
					<?php if($module_config['options']['show_price']):?>
						<p class="text-center"><big><?php echo intval($product['price']);?></big> <small class="text-muted"><?php e_strTranslate("APP_Credits");?></small></p>
					<?php endif;?>

					<?php if($module_config['options']['show_buybutton']):?> 
						<?php if($product['quantity'] > 0):?> 
							<a href="ps-order-preview?id=<?php echo $product['id'];?>" class="btn btn-lg btn-primary btn-block">Comprar</a>
						<?php else:?>
							<button class="btn btn-lg btn-default btn-block disabled">Sin stock</button>
						<?php endif;?>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }

function printDetailProduct($product){ 
	$module_config = getModuleConfig("prestashop");
	//prestashopProductsController::printProduct(60);
	?>
<div class="panel">
	<div class="panel-default">
		<div class="row">
			<div class="col-md-4 inset">
				<div class="img-shop-container inset">		
					<img src="<?php echo $product['image'];?>" width="100%" />
				</div>
			</div>
			<div class="col-md-8">
				<div class="product-shop-container inset">
					<div class="row">
						<div class="col-md-12">
							<h3><?php echo $product['name'];?></h3>
							<div class="text-muted"><?php echo $product['description'];?></div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<small class="text-muted">
								<?php if($module_config['options']['show_price']) echo '<th class="text-center">'.strTranslate("Price").'</th>';?>
							</small>
							<hr class="m-t-2 m-b-5">
							<h4 class="text-right">
								<?php if($module_config['options']['show_price']) echo '<big><strong>'.intval($product['price'])."</strong></big> <span class='text-muted'>".strTranslate("APP_Credits").'</span>';?>
									
							</h4>
						</div>
						<div class="col-md-4">
							<small class="text-muted">
								<?php if($module_config['options']['show_price']) echo '<th class="text-center">'.strTranslate("Stock").'</th>';?>
							</small>
							<hr class="m-t-2 m-b-5">
							<h4 class="text-right">
								<?php if($module_config['options']['show_stock']) echo '<big><strong>'.intval($product['quantity'])."</strong></big> <span class='text-muted'>".strTranslate("Unids.").'</span>';?>
									
							</h4>
						</div>
						<div class="col-md-4 col-md-offset-8 text-right">
							<?php if($module_config['options']['show_buybutton']):?> 
								<?php if($product['quantity'] > 0):?> 
								<a href="ps-order-preview?id=<?php echo $product['id'];?>" class="btn btn-lg btn-primary btn-block">Comprar</a>
								<?php else:?>
									<button class="btn btn-lg btn-default btn-block disabled">No disponible</button>
								<?php endif;?>
							<?php endif;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }?>