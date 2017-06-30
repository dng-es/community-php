<?php
class shop{
	public function getProducts($filter = ""){
		$Sql = "SELECT p.*, m.name_manufacturer 
				FROM shop_products p 
				LEFT JOIN shop_manufacturers m ON m.id_manufacturer=p.id_manufacturer 
				WHERE 1=1 ".$filter; //echo $Sql;
		return connection::getSQL($Sql);
	}

	public static function getProductsCategories($filter = " AND category_product<>'' "){
		$Sql = "SELECT DISTINCT(category_product) as category FROM shop_products 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public static function getProductsCategoriesGroup($filter = " AND category_product<>'' "){
		$Sql = "SELECT GROUP_CONCAT(DISTINCT category_product) as category FROM shop_products 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public static function getProductsSubcategories($filter = " AND subcategory_product<>'' "){
		$Sql = "SELECT DISTINCT(subcategory_product) as subcategory FROM shop_products 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public static function getProductsSubcategoriesGroup($filter = " AND subcategory_product<>'' "){
		$Sql = "SELECT GROUP_CONCAT(DISTINCT subcategory_product) as category FROM shop_products 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function getOrders($filter = ""){
		$Sql = "SELECT * FROM shop_orders 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function getOrdersDetails($filter = ""){
		$Sql = "SELECT d.id_order_detail,d.id_order,d.id_product,d.amount_product,d.price_product AS price_order,d.date_detail,p.*,o.* FROM  shop_orders_details d 
				INNER JOIN shop_products p ON p.id_product=d.id_product 
				INNER JOIN shop_orders o ON o.id_order=d.id_order 
				WHERE 1=1 ".$filter; //echo $Sql;
		return connection::getSQL($Sql);
	}

	public function insertProduct($name_product, $description_product, $image_product, $price_product, $stock_product, $important_product, $id_manufacturer, $category_product, $subcategory_product, $ref_product, $canal_product, $active_product, $date_ini_product, $date_fin_product){
		$Sql = "INSERT INTO shop_products (name_product, description_product, image_product, price_product, stock_product, important_product, id_manufacturer, category_product, subcategory_product, ref_product, canal_product, active_product, date_ini_product, date_fin_product) 
			VALUES('".$name_product."','".$description_product."','".$image_product."',".$price_product.",".$stock_product.",".$important_product.", ".$id_manufacturer.", '".$category_product."', '".$subcategory_product."','".$ref_product."','".$canal_product."', ".$active_product.", '".$date_ini_product."', '".$date_fin_product."')";
		return connection::execute_query($Sql);
	}

	public function updateProduct($id, $name_product, $description_product, $image_product, $price_product, $stock_product, $important_product, $id_manufacturer, $category_product, $subcategory_product, $ref_product, $canal_product, $active_product, $date_ini_product, $date_fin_product){
		$Sql = "UPDATE shop_products SET 
				name_product='".$name_product."', 
				description_product='".$description_product."', 
				image_product='".$image_product."', 
				price_product=".$price_product.", 
				stock_product=".$stock_product.", 
				important_product=".$important_product.",
				active_product=".$active_product.",
				id_manufacturer=".$id_manufacturer.",  
				category_product='".$category_product."',  
				subcategory_product='".$subcategory_product."', 
				canal_product='".$canal_product."', 
				date_ini_product='".$date_ini_product."', 
				date_fin_product='".$date_fin_product."', 
				ref_product='".$ref_product."' 
				WHERE id_product='".$id."'"; //echo $Sql;
		return connection::execute_query($Sql);
	}

	public function updateProductState($id, $active_producto){
		$Sql = "UPDATE shop_products SET 
				active_product=".$active_producto." 
				WHERE id_product=".$id." ";
		return connection::execute_query($Sql);
	}

	public function updateProductStock($id, $amount){
		$Sql = "UPDATE shop_products SET 
				stock_product=stock_product+".$amount." 
				WHERE id_product='".$id."'";
		return connection::execute_query($Sql);
	}

	public static function insertOrder($username_order, $name_order, $surname_order, $address_order, $address2_order, $city_order, $state_order, $postal_order, $telephone_order, $notes_order){
		$Sql = "INSERT INTO shop_orders (username_order, name_order, surname_order, address_order, address2_order, city_order, state_order, postal_order, telephone_order, notes_order) 
				VALUES ('".$username_order."','".$name_order."','".$surname_order."','".$address_order."','".$address2_order."','".$city_order."', '".$state_order."', '".$postal_order."','".$telephone_order."','".$notes_order."')";
		return connection::execute_query($Sql);
	}

	public static function insertOrderDetail($id_order, $id_product, $amount_product, $price_product){
		$Sql = "INSERT INTO shop_orders_details (id_order, id_product, amount_product, price_product) 
				VALUES (".$id_order.",".$id_product.",".$amount_product.",".$price_product.")"; //echo $Sql;
		return connection::execute_query($Sql);
	}

	public static function updateOrderStatus($id, $status_order){
		$Sql = "UPDATE shop_orders SET 
				status_order='".$status_order."' 
				WHERE id_order=".$id." ";
		return connection::execute_query($Sql);
	}

	public static function getOrderStatus($filter = ""){
		$Sql = "SELECT * FROM shop_orders_status 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public static function insertOrderStatus($id_order, $order_status, $username_status){
		$Sql = "INSERT INTO shop_orders_status (id_order, order_status, username_status) 
				VALUES (".$id_order.",'".$order_status."','".$username_status."')";
		return connection::execute_query($Sql);
	}

	public static function getManufacturers($filter = ""){
		$Sql = "SELECT * FROM shop_manufacturers 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public static function insertManufacturer($name_manufacturer, $notes_manufacturer){
		$Sql = "INSERT INTO shop_manufacturers (name_manufacturer, notes_manufacturer) 
				VALUES ('".$name_manufacturer."','".$notes_manufacturer."')"; //echo $Sql;
		return connection::execute_query($Sql);
	}

	public static function updateManufacturer($id_manufacturer, $name_manufacturer, $notes_manufacturer){
		$Sql = "UPDATE shop_manufacturers SET 
				name_manufacturer='".$name_manufacturer."',
				notes_manufacturer='".$notes_manufacturer."' 
				WHERE id_manufacturer=".$id_manufacturer." ";
		return connection::execute_query($Sql);
	}

	public static function updateManufacturerState($id_manufacturer, $estado){
		$Sql = "UPDATE shop_manufacturers SET 
				active_manufacturer=".$estado." 
				WHERE id_manufacturer=".$id_manufacturer." ";
		return connection::execute_query($Sql);
	}
}
?>