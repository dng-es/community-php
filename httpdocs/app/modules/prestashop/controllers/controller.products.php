<?php
class prestashopProductsController extends prestashopController{
	public static function getProducts($limit = '', $filter = ''){	
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
			$opt['resource'] = 'products';
			$opt['filter[active]'] = 1;
			if ($limit != '') $opt['limit'] = $limit;
			if (trim($filter) != '') $opt['filter[name]'] = '%['.$filter.']%';
			$xml = $webService->get($opt);
			$resources = $xml->products->children();
			return count($resources) ;
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}

	public static function getProduct($id_product){	
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
			$xml = $webService->get(array('resource' => 'products', 'id' => $id_product));
			return $xml;
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}

	public static function printProduct($id_product){
		try{
			$xml = self::getProduct($id_product);
			$resources = $xml->children()->children();
			foreach ($resources as $key => $resource){
				echo 'Name of field: ' . $key . ' - Value: ' . $resource . '<br />';

			}

			return $resources;
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}
	
	public static function showProducts($id_product = null, $type_show = 'list', $limit = '', $filter = ''){
		$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);

		$opt['resource'] = 'products';
		$opt['display'] = 'full';
		$opt['filter[active]'] = 1;
		if ($id_product != null) $opt['filter[id]'] = $id_product;
		if ($limit != '') $opt['limit'] = $limit;
		if (trim($filter) != '') $opt['filter[name]'] = '%['.$filter.']%';

		$xml = $webService->get($opt);
		$productNodes = $xml->products->children();
		$products = array();
		foreach ($productNodes as $product) {
			$nameLanguage = $product->xpath('name/language[@id=1]');
			$name = (string) $nameLanguage[0];
			$idImage = (string) $product->id_default_image;
			//$price = ceil(floatval($product->price));
			$price = $product->price;
			$image = '/img/p/';
			for ($i = 0; $i < strlen($idImage); $i++) {
				$image .= $idImage[$i] . '/';
			}
			$image_default = $image . $idImage . '.jpg';
			$image .= $idImage . '-home_square.jpg';
			$id = (int) $product->id;
			$stock = self::getStock(0, $id);
			//$quantity = (int) $product->quantity;
			$id_stock = (int) $stock->stock_availables->stock_available->attributes()->id;
			$stock = self::getStock($id_stock, 0);
			// echo '<pre>';
			// var_dump($stock);
			// echo '</pre>';
			$quantity = (int) $stock->stock_available->quantity;
			$descriptionLanguage = $product->xpath('description/language[@id=1]');
			$description = (string) $descriptionLanguage[0];
			$path = '/index.php?controller=product&id_product=' . $product->id;
			$products = array('name' => $name, 'image' => self::ws_url.$image, 'image_default' => self::ws_url.$image_default, 'id' => $id, 'description' => $description, 'path' => self::ws_url.$path, 'price' => $price, 'quantity' => $quantity);

			switch ($type_show) {
				case 'list':
					printListProduct($products);
					break;
				case 'detail':
					printDetailProduct($products);

				case 'info':
					return $products;
					break;					
				default:
					printListProduct($products);
					break;
			}
			
		}
	}

/////////////////////////////////////////////////////////////////////////////
/// FUNCIONES DE STOCKS			/////////////////////////////
/////////////////////////////////////////////////////////////////////////////
	
	public static function getStock($id_stock = 0, $id_product = 0){	
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
			$opt['resource'] = 'stock_availables';
			if ($id_stock > 0) $opt['id'] = $id_stock;
			if ($id_product > 0) $opt['filter[id_product]'] = $id_product;
			return $webService->get($opt);
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}	

}
?>