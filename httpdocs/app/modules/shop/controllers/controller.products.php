<?php
class shopProductsController{
	public static function getItemAction($id){
		$shop = new shop();
		$element = array();
		$elements = $shop->getProducts(" AND id_product=".$id." ");

		if (isset($elements[0])) $element = $elements[0];
		else{
			$element['name_product'] = "";
			$element['description_product'] = "";
			$element['image_product'] = "";
			$element['price_product'] = 0;
			$element['stock_product'] = 0;
			$element['important_product'] = 0;
		}

		return $element;
	}

	public static function getListAction($reg = 0, $filter = ""){
		$shop = new shop();
		$find_reg = "";


		if (isset($_REQUEST['ref_search'])) $find_reg .= "&ref_search=".$_REQUEST['ref_search'];
		if (isset($_REQUEST['name_search'])) $find_reg .= "&name_search=".$_REQUEST['name_search'];
		if (isset($_REQUEST['manufacturer_search'])) $find_reg .= "&manufacturer_search=".$_REQUEST['manufacturer_search'];
		if (isset($_REQUEST['category_search'])) $find_reg .= "&category_search=".$_REQUEST['category_search'];
		if (isset($_REQUEST['subcategory_search'])) $find_reg .= "&subcategory_search=".$_REQUEST['subcategory_search'];

		$paginator_items = PaginatorPages($reg);	
		$total_reg = connection::countReg("shop_products p, shop_manufacturers m "," AND p.id_manufacturer=m.id_manufacturer".$filter); 
		return array('items' => $shop->getProducts($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function exportListAction($filter = ""){
		if (isset($_REQUEST['export']) and $_REQUEST['export'] == true){
			$shop = new shop(); 
			$elements = $shop->getProducts($filter);
			download_send_headers("data_" . date("Y-m-d") . ".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function createAction(){
		if (isset($_POST['id_product']) and $_POST['id_product'] == 0){
			$shop = new shop();
			$name_product = sanitizeInput($_POST['name_product']);
			$description_product = sanitizeInput($_POST['description_product']);
			$image_product = self::insertPhoto();
			$price_product = sanitizeInput($_POST['price_product']);
			$stock_product = sanitizeInput($_POST['stock_product']);
			$important_product = (isset($_POST['important_product']) and $_POST['important_product'] == "on") ? 1 : 0;
			$id_manufacturer = sanitizeInput($_POST['id_manufacturer']);
			$category_product = sanitizeInput($_POST['category_product']);
			$subcategory_product = sanitizeInput($_POST['subcategory_product']);
			$ref_product = sanitizeInput($_POST['ref_product']);
			$canal_product = sanitizeInput($_POST['canal_product']);
			
			if ($shop->insertProduct($name_product, $description_product, $image_product, $price_product, $stock_product, $important_product, $id_manufacturer, $category_product, $subcategory_product, $ref_product, $canal_product)){ 
				$id = connection::SelectMaxReg("id_product", "shop_products", "");
				session::setFlashMessage('actions_message', strTranslate("Insert_procesing"), "alert alert-success");
			}
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-shopproduct?id=".$id);
		}
	}

	public static function updateAction(){
		if (isset($_POST['id_product']) and $_POST['id_product'] != 0){
			$shop = new shop();
			$id = sanitizeInput($_POST['id_product']);
			$name_product = sanitizeInput($_POST['name_product']);
			$description_product = sanitizeInput($_POST['description_product']);
			$image_product = self::insertPhoto();
			$price_product = sanitizeInput($_POST['price_product']);
			$stock_product = sanitizeInput($_POST['stock_product']);
			$important_product = (isset($_POST['important_product']) and $_POST['important_product'] == "on") ? 1 : 0;
			$id_manufacturer = sanitizeInput($_POST['id_manufacturer']);
			$category_product = sanitizeInput($_POST['category_product']);
			$subcategory_product = sanitizeInput($_POST['subcategory_product']);
			$ref_product = sanitizeInput($_POST['ref_product']);
			$canal_product = sanitizeInput($_POST['canal_product']);

			if ($shop->updateProduct($id, $name_product, $description_product, $image_product, $price_product, $stock_product, $important_product, $id_manufacturer, $category_product, $subcategory_product, $ref_product, $canal_product))
				session::setFlashMessage('actions_message', strTranslate("Update_procesing"), "alert alert-success");

			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-shopproduct?id=".$_POST['id_product']);
		}
	}

	private static function insertPhoto(){
		if (isset($_FILES['image_product']['name']) and $_FILES['image_product']['name'] !="") $name_photo = uploadFileToFolder($_FILES['image_product'], "images/shop/");
		else $name_photo = $_POST['image_product_old'];


		return $name_photo;
	}

	public static function deleteAction(){
		if (isset($_REQUEST['act']) and $_REQUEST['act'] == 'del'){
			$shop = new shop();
			if ($shop->updateProductState($_REQUEST['id'], 0)) 
				session::setFlashMessage('actions_message', strTranslate("Delete_procesing"), "alert alert-success");
			else 
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");

			redirectURL("admin-shopproducts");
		}
	}
}
?>