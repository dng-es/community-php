<?php
class shopOrdersController{
	public static function getListAction($reg = 0, $filter = ""){
		$shop = new shop();
		$find_reg = getFindReg();
		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("shop_orders", $filter); 
		return array('items' => $shop->getOrders($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getListDetailAction($reg = 0, $filter = ""){
		$shop = new shop();
		$find_reg = getFindReg();
		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("shop_orders_details d, shop_orders o "," AND d.id_order=o.id_order ".$filter); 
		return array('items' => $shop->getOrdersDetails($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function getListStatusAction($reg = 0, $filter = ""){
		$find_reg = getFindReg();
		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("shop_orders_status", $filter); 
		return array('items' => shop::getOrderStatus($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function estadosAction($filter = ""){
		if (isset($_POST['id_order']) && $_POST['id_order'] > 0){
			$id_order = sanitizeInput($_POST['id_order']);
			$status_order_old = sanitizeInput($_POST['status_order_old']);
			$status_order = sanitizeInput($_POST['status_order']);

			$response = self::changeEstado($id_order, $status_order, $status_order_old);

			if ($response['message'] == 'success'):
				session::setFlashMessage('actions_message', $response['description'], "alert alert-success");
			else:
				session::setFlashMessage('actions_message', $response['description'], "alert alert-danger");
			endif;

			redirectURL($_SERVER['REQUEST_URI']);
		}
	}

	public static function changeEstado($id_order, $status_order, $status_order_old){
		$response = array();
		//verificar secuencia de estados
		if($status_order_old == 'cancelado'){
			$response['message'] = "error";
			$response['description'] = "La secuencia de estados no es correcta";
		}
		else{
			if (shop::updateOrderStatus($id_order, strtolower($status_order))):
				shop::insertOrderStatus($id_order, strtolower($status_order), $_SESSION['user_name']);
				//enviar email al usuario. Hay que obtener los datos del pedido y del usuario
				$shop = new shop();
				$order_detail = $shop->getOrdersDetails(" AND d.id_order=".$id_order." ");
				$user_detail = usersController::getPerfilAction($order_detail[0]['username_order']);
				self::sendEmailUserStatus(
					$user_detail, 
					$id_order, 
					$order_detail[0]['name_order'], 
					$order_detail[0]['surname_order'], 
					$order_detail[0]['address_order'], 
					$order_detail[0]['address2_order'], 
					$order_detail[0]['city_order'], 
					$order_detail[0]['state_order'], 
					$order_detail[0]['postal_order'], 
					$order_detail[0]['telephone_order'], 
					$order_detail[0]['name_product'], 
					$order_detail[0]['price_order'], 
					getDateFormat($order_detail[0]['date_order'], "SHORT" ), 
					$status_order, 
					$order_detail[0]['notes_order']);
				
				$response['message'] = "success";
				$response['description'] = "Cambio realizado correctamente.";
			else:
				$response['message'] = "error";
				$response['description'] = strTranslate("Error_procesing");
			endif;
		}
		return $response;
	}

	public static function exportListAction($filter = ""){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			$shop = new shop(); 
			$elements = $shop->getOrders($filter);
			download_send_headers(strTranslate("Shop_orders")."_".date("Y-m-d").".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function exportListDetailAction($filter = ""){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			$shop = new shop(); 
			$elements = $shop->getOrdersDetails($filter);
			download_send_headers(strTranslate("Shop_orders")."_".date("Y-m-d").".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function createAction($filter = ""){
		if (isset($_POST['id_product']) && $_POST['id_product'] > 0){
			$shop = new shop();
			$order_ok = true;
			$id_product = trim(sanitizeInput($_POST['id_product']));
			$name_order = trim(sanitizeInput($_POST['name_order']));
			$surname_order = trim(sanitizeInput($_POST['surname_order']));
			$address_order = trim(sanitizeInput($_POST['address_order']));
			$address2_order = trim(sanitizeInput($_POST['address2_order']));
			$city_order = trim(sanitizeInput($_POST['city_order']));
			$state_order = trim(sanitizeInput($_POST['state_order']));
			$postal_order = trim(sanitizeInput($_POST['postal_order']));
			$telephone_order = trim(sanitizeInput($_POST['telephone_order']));
			$notes_order = trim(sanitizeInput($_POST['notes_order']));

			//obtener datos del producto
			$product_detail = shopProductsController::getItemAction($id_product);

			//obtener datos del usuario
			$user_detail = usersController::getPerfilAction($_SESSION['user_name']);
			
			//verificar campos
			if (!isset($product_detail) || $name_order == "" || $surname_order == "" || $address_order == "" || $city_order == "" || $state_order == "" || $postal_order == "" || $telephone_order == ""){
				$destino = "shopproductorder?id=".$id_product;
				$order_ok = false;
				session::setFlashMessage('actions_message', "Todos los campos son obligatorios", "alert alert-danger");
			}
			elseif ($product_detail['stock_product'] <= 0){
				//verificar stock
				$destino = "shopproduct?id=".$id_product;
				$order_ok = false;
				session::setFlashMessage('actions_message', "Lo sentimos, no queda stock del artículo", "alert alert-danger");
			}
			elseif ($user_detail['creditos'] < $product_detail['price_product']){
				//verificar creditos disponibles del usuario
				$destino = "shopproducts";
				$order_ok = false;
				session::setFlashMessage('actions_message', "No tienes créditos suficientes - Disponible: ".$user_detail['creditos']." - Precio: ".$product_detail['price_product'], "alert alert-danger");
			}
			elseif (!(date("Y-m-d") >= $product_detail['date_ini_product'] && date("Y-m-d") <= $product_detail['date_fin_product'])){ 
				//verificar lanzamiento del producto
				$destino = "shopproducts";
				$order_ok = false;
				session::setFlashMessage('actions_message', strTranslate("Comming_soon"), "alert alert-danger");
			}
			elseif ($shop->insertOrder($_SESSION['user_name'], $name_order, $surname_order, $address_order, $address2_order, $city_order, $state_order, $postal_order, $telephone_order, $notes_order)){ 
				//insertar pedido y log status
				
				$id_order = connection::SelectMaxReg("id_order", "shop_orders", "AND username_order='".$_SESSION['user_name']."' ");
				shop::insertOrderStatus($id_order, 'pendiente', $_SESSION['user_name']);
				
				//actualizar stock del producto
				$shop->updateProductStock($id_product, -1);

				//actualizar creditos del usuario
				self::updateCreditosAction($_SESSION['user_name'], -$product_detail['price_product'], $id_product);

				//insertar detalle del pedido
				shop::insertOrderDetail($id_order, $id_product, 1, $product_detail['price_product']);
				
				//enviar email al usuario
				self::sendEmailUser($user_detail, $id_order, $name_order, $surname_order, $address_order, $address2_order, $city_order, $state_order, $postal_order, $telephone_order, $notes_order, $product_detail, 'pendiente');
				
				//enviar email al administrador
				self::sendEmailAdmin($user_detail, $id_order, $name_order, $surname_order, $address_order, $address2_order, $city_order, $state_order, $postal_order, $telephone_order, $notes_order, $product_detail);

				$destino = "shopproductorderdetail?id=".$id_order;
				session::setFlashMessage('actions_message', 'Pedido relizado correctamente', "alert alert-success");
			}
			else{
				//cualquier otra cosa o error
				$destino = "shopproductorder?id=".$id_product;
				session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			}

			redirectURL($destino);
		}
	}

	public static function updateCreditosAction($username, $creditos, $id_product){
		if ($username != ""){
			users::updateCredito($username, $creditos);
			users::insertCredito($username, $creditos, "Compras premios", "Producto ID.".$id_product);
		}
	}

	private static function sendEmailUser($user_detail, $id_order, $name_order, $surname_order, $address_order, $address2_order, $city_order, $state_order, $postal_order, $telephone_order, $notes_order, $product_detail, $status_order = 'pendiente'){

		global $ini_conf;
		$asunto = $ini_conf['SiteName'].': Confirmación de pedido';
		$message_from = array($ini_conf['ContactEmail'] => $ini_conf['SiteName']);
		$message_to = array($user_detail['email']);

		$template = new tpl("order-user", "shop");
		$template->setVars(array(
			"title_email" => "Confirmación de pedido",
			"text_email" => "Tu pedido en ".$ini_conf['SiteName']." se ha realizado correctamente",
			"id_order" => $id_order,
			"date_order" => date("d-m-Y"),
			"name_order" => $name_order,
			"surname_order" => $surname_order,
			"telephone_order" => $telephone_order,
			"address_order" => $address_order,
			"address2_order" => $address2_order,
			"city_order" => $city_order,
			"state_order" => $state_order,
			"postal_order" => $postal_order,
			"credits_label" => ucfirst(strTranslate("APP_Credits")),
			"product_name" => $product_detail['name_product'],
			"product_ammount" => 1,
			"product_price" => $product_detail['price_product'],
			"status_order" => $status_order,
			"notes_order" => $notes_order
		));
		$cuerpo_mensaje = $template->getTpl();
		messageProcess($asunto, $message_from, $message_to, $cuerpo_mensaje, null, 'smtp');
	}

	private static function sendEmailUserStatus($user_detail, $id_order, $name_order, $surname_order, $address_order, $address2_order, $city_order, $state_order, $postal_order, $telephone_order, $name_product, $price_order, $date_order, $status_order, $notes_order){

		global $ini_conf;
		$asunto = $ini_conf['SiteName'].': Cambio de estado de tu pedido';
		$message_from = array($ini_conf['ContactEmail'] => $ini_conf['SiteName']);
		$message_to = array($user_detail['email']);

		$template = new tpl("order-user", "shop");
		$template->setVars(array(
			"title_email" => "Estado de pedido",
			"text_email" => "El estado de tu pedido ".$id_order." ha sido modificado a <b>".$status_order."</b>",
			"id_order" => $id_order,
			"date_order" => $date_order,
			"name_order" => $name_order,
			"surname_order" => $surname_order,
			"telephone_order" => $telephone_order,
			"address_order" => $address_order,
			"address2_order" => $address2_order,
			"city_order" => $city_order,
			"state_order" => $state_order,
			"postal_order" => $postal_order,
			"credits_label" => ucfirst(strTranslate("APP_Credits")),
			"product_name" => $name_product,
			"product_ammount" => 1,
			"product_price" => $price_order,
			"status_order" => $status_order,
			"notes_order" => $notes_order
		));

		$cuerpo_mensaje = $template->getTpl();

		messageProcess($asunto, $message_from, $message_to, $cuerpo_mensaje, null, 'smtp');
	}

	private static function sendEmailAdmin($user_detail, $id_order, $name_order, $surname_order, $address_order, $address2_order, $city_order, $state_order, $postal_order, $telephone_order, $notes_order, $product_detail){

		global $ini_conf;
		$asunto = $ini_conf['SiteName'].': Realización de pedido';
		$message_from = array($ini_conf['ContactEmail'] => $ini_conf['SiteName']);
		$message_to = array($ini_conf['ContactEmail']);
		//$message_to = array($user_detail['email']);

		$template = new tpl("order-admin", "shop");
		$template->setVars(array(
			"title_email" => "Realización de pedido",
			"text_email" => "Pedido realizado en ".$ini_conf['SiteName'].". Datos el pedido:",
			"id_order" => $id_order,
			"username_order" => $user_detail['username'],
			"username_name" => $user_detail['name'],
			"username_surname" => $user_detail['surname'],
			"username_email" => $user_detail['email'],
			"date_order" => date("d-m-Y"),
			"name_order" => $name_order,
			"surname_order" => $surname_order,
			"telephone_order" => $telephone_order,
			"address_order" => $address_order,
			"address2_order" => $address2_order,
			"city_order" => $city_order,
			"state_order" => $state_order,
			"notes_order" => $notes_order,
			"postal_order" => $postal_order,
			"credits_label" => ucfirst(strTranslate("APP_Credits")),
			"product_name" => $product_detail['name_product'],
			"product_ammount" => 1,
			"product_price" => $product_detail['price_product']
		));
		$cuerpo_mensaje = $template->getTpl();
		messageProcess($asunto, $message_from, $message_to, $cuerpo_mensaje, null, 'smtp');
	}
}
?>