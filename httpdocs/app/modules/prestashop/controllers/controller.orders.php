<?php
class prestashopOrdersController extends prestashopController{
	public static function getOrders($limit = '', $id_customer = 0){	
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
			$opt['resource'] = 'orders';
			$opt['sort'] = '[id_DESC]';
			if ($limit != '') $opt['limit'] = $limit;
			if ($id_customer > 0) $opt['filter[id_customer]'] = $id_customer;
			$xml = $webService->get($opt);
			return $xml->orders->children();
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}

	public static function getTotalOrders($id_customer = 0){	
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
			$opt['resource'] = 'orders';
			if ($id_customer > 0) $opt['filter[id_customer]'] = $id_customer;
			$xml = $webService->get($opt);
			$resources = $xml->orders->children();
			return count($resources) ;
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}	

	public static function getOrder($id_order){	
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
			$xml = $webService->get(array('resource' => 'orders', 'id' => $id_order));
			return $xml;
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}

	public static function printOrder($id_order){
		try{
			$xml = self::getOrder($id_order);
			$resources = $xml->children()->children();
			foreach ($resources as $key => $resource)
				echo 'Name of field: ' . $key . ' - Value: ' . $resource . '<br />';

			return $resources;
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}

	public static function createOrder($id_cart, $id_product){
		try{
			//verificar que el usuario tenga direccion de entrega
			$cart = self::getCart($id_cart);
			$id_address = $cart->cart->id_address_delivery;
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
			$xml = $webService->get(array('url' => self::ws_url.'api/orders?schema=blank'));
			$resources = $xml->children()->children();

			//obtener datos del producto a comprar
			$product = prestashopProductsController::showProducts($id_product, 'info');

			// //actualizar un datos
			$resources->id_address_delivery = $id_address;
			//$resources->id_address_invoice = $id_address;
			$resources->id_address_invoice = self::ws_id_address;
			$resources->id_cart = $id_cart;
			$resources->id_customer = $_SESSION['id_externo'];
			$resources->id_currency = self::ws_id_currency;
			$resources->id_shop = self::ws_id_shop;
			$resources->id_lang = 1;
			$resources->id_carrier = 1;
			//$resources->current_state = 14;
			//$resources->payment = "Bankwire";
			//$resources->payment = "Transferencia bancaria";
			//$resources->module = "bankwire";
			$resources->payment = "Cartera - Pago por puntos";
			$resources->module = "walletcustomcurrency";
			$resources->total_paid = $product['price'];
			$resources->total_paid_real = $product['price'];
			$resources->total_products = $product['price'];
			$resources->total_products_wt = 0;
			$resources->conversion_rate = 1;
			//$resources->associations->order_rows->order_row->id = 1;
			$resources->associations->order_rows->order_row->product_id = $id_product;
			$resources->associations->order_rows->order_row->product_quantity = 1;
			$resources->associations->order_rows->order_row->product_name = $product['name'];
			$resources->associations->order_rows->order_row->product_price = $product['price'];

			// //enviar datos
			$opt = array('resource' => 'orders');
			$opt['postXml'] = $xml->asXML();
			$xml = $webService->add($opt);

			// if (isset($xml->order->id) && $xml->order->id > 0) {
			// 	//enviar email al usuario
			// 	$usuario = usersController::getPerfilAction($_SESSION['user_name']);
			// 	self::sendEmailUser($xml, $usuario);
			// 	return $xml;
			// }
			// else return array('status' => "Failed", "msg" => "Error en el pedido");
			return $xml;


		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}

	public static function slipOrder($id_order){
		try{
			$order = self::getOrder($id_order);
			$id_product = intval($order->order->associations->order_rows->order_row->product_id);

			//obtener datos del producto a comprar
			$product = prestashopProductsController::showProducts($id_product, 'info');
			
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, true);
			$xml = $webService->get(array('url' => self::ws_url.'api/order_slip?schema=blank'));
			$resources = $xml->children()->children();

			// //actualizar un datos
			$resources->id_customer = $_SESSION['id_externo'];
			$resources->id_order = $id_order;
			$resources->conversion_rate = 1;

			$resources->total_products_tax_excl = $order->order->total_wrapping_tax_excl;
			$resources->total_products_tax_incl = $order->order->total_wrapping_tax_incl;
			$resources->total_shipping_tax_excl = $order->order->total_shipping_tax_excl;
			$resources->total_shipping_tax_incl = $order->order->total_shipping_tax_incl;

			//$resources->associations->order_rows->order_row->id = 1;
			$resources->associations->order_slip_details->order_slip_detail->id_order_detail = $order->order->associations->order_rows->order_row->id;
			$resources->associations->order_slip_details->order_slip_detail->product_quantity = $order->order->associations->order_rows->order_row->product_quantity;
			$resources->associations->order_slip_details->order_slip_detail->amount_tax_excl = $order->order->associations->order_rows->order_row->unit_price_tax_excl;
			$resources->associations->order_slip_details->order_slip_detail->amount_tax_incl = $order->order->associations->order_rows->order_row->unit_price_tax_incl;


			// //enviar datos
			$opt = array('resource' => 'order_slip');
			$opt['postXml'] = $xml->asXML();
			$xml = $webService->add($opt);
	

			return $xml;
			
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}	

	private static function sendEmailUser($xml, $user_detail){
		global $ini_conf;
		$asunto = $ini_conf['SiteName'].': Confirmación de pedido';
		$message_from = array($ini_conf['ContactEmail'] => $ini_conf['SiteName']);
		$message_to = array($user_detail['email']);

		$id_product = intval($xml->order->associations->order_rows->order_row->product_id);
		$id_address = intval($xml->order->id_address_delivery);
		$id_state = intval($xml->order->current_state);
		$product = prestashopProductsController::showProducts($id_product, 'info');
		$address = prestashopCustomersController::getAddress($id_address);
		$state = prestashopOrdersController::getOrderState($id_state);
// echo "id_product: ".$id_product."<br>";
// echo "id_address: ".$id_address."<br>";
// echo "id_state: ".$id_state."<br><br>";
// echo '<pre>';
// var_dump($xml);
// echo '</pre>';
// die();
		$template = new tpl("order-user", "prestashop");
		$template->setVars(array(
					"title_email" => "Confirmación de pedido",
					"text_email" => "Tu pedido en ".$ini_conf['SiteName']." se ha realizado correctamente",
					"id_order" => $xml->order->id,
					"date_order" => $xml->order->date_add,
					"name_order" => $address->address->firstname,
					"surname_order" => $address->address->lastname,
					"telephone_order" => $address->address->phone,
					"address_order" => $address->address->address1,
					"address2_order" => $address->address->address2,
					"city_order" => $address->address->city,
					"postal_order" => $address->address->postcode,
					"credits_label" => ucfirst(strTranslate("APP_Credits")),
					"product_name" => $product['name'],
					"product_ammount" => 1,
					"product_price" => $xml->order->associations->order_rows->order_row->product_price,
					"status_order" => $state->order_state->name->language,
					"notes_order" => ""
		));
		$cuerpo_mensaje = $template->getTpl();
		messageProcess($asunto, $message_from, $message_to , $cuerpo_mensaje, null, 'smtp');
	}	

	public static function getCart($id_cart){	
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
			return $webService->get(array('resource' => 'carts', 'id' => $id_cart));
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}

	public static function createCart($id_product){
		try{
			//verificar que el usuario tenga direccion de entrega
			$addresses = prestashopCustomersController::getAddresses($_SESSION['id_externo']);
			if (count($addresses) > 0){
				$id_address = $addresses->address->attributes()->id;
				$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
				$xml = $webService->get(array('url' => self::ws_url.'api/carts?schema=blank'));
				$resources = $xml->children()->children();

				// //actualizar un datos
				$resources->id_customer = $_SESSION['id_externo'];
				$resources->id_lang = 1;
				$resources->id_address_delivery = $id_address;
				$resources->id_address_invoice = $id_address;
				$resources->id_currency = self::ws_id_currency;
				$resources->id_shop = self::ws_id_shop;
				$resources->id_shop_group = 1;
				$resources->id_carrier = 1;
				$resources->date_add = date("Y-m-d h:i:s");
				$resources->date_upd = date("Y-m-d h:i:s");
				//$resources->secure_key = self::ws_key;

				$resources->associations->cart_rows->cart_row->id_product = $id_product;
				$resources->associations->cart_rows->cart_row->quantity = 1;
				$resources->associations->cart_rows->cart_row->id_address_delivery = 28;	

				//enviar datos
				$opt = array('resource' => 'carts');
				$opt['postXml'] = $xml->asXML();
				$xml = $webService->add($opt);

				return $xml;
			}
			else {
				session::setFlashMessage('actions_message', "No tienes direcciones de entrega", "alert alert-danger");
				redirectURL("profile");
			}
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}	

	public static function newOrder($id_product){	
		try{
			if ($id_product > 0){
				$product = prestashopProductsController::showProducts($id_product, 'info');
				//verificar que tenga puntos suficientes. Si tiene puntos se crea el carrito y el pedido
				if (prestashopCreditsController::getCredits($_SESSION['id_externo']) > $product['price']){
					$result = self::createCart($id_product);
					$id_cart = (isset($result->cart->id) ? $result->cart->id : 0);
					if ($id_cart > 0) {
						$result = self::createOrder($id_cart, $id_product);
						if(isset($result['status']) && $result['status'] == 'Failed'){
							session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
							//redirectURL("ps-product?id=".$id_product);
						}
						else {
							session::setFlashMessage('actions_message', "Pedido creado correctamente", "alert alert-success");
							redirectURL("ps-order-view?id=".$result->order->id);
						}
					}
				}
				else {
					session::setFlashMessage('actions_message', "No dispones de créditos suficientes para realizar la compra.", "alert alert-danger");
					redirectURL("ps-product?id=".$id_product);
				}
			}
			else {
				session::setFlashMessage('actions_message', "Producto no encontrado.", "alert alert-danger");
				redirectURL("ps-products");
			}
			
		}
		catch (PrestaShopWebserviceException $ex){
			session::setFlashMessage('actions_message', strTranslate("Error_procesing"), "alert alert-danger");
			redirectURL("ps-product?id=".$id_product);
		}
	}

	public static function getOrderStates(){	
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, true);
			$opt['resource'] = 'order_states';
			$xml = $webService->get($opt);
			return $xml->orders->children();
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}

	public static function getOrderState($id_state){	
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
			$xml = $webService->get(array('resource' => 'order_states', 'id' => $id_state));
			return $xml;
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}

	public static function getOrderHistories($id_order){	
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
			$opt['resource'] = 'order_histories';
			$opt['filter[id_order]'] = $id_order;
			$opt['sort'] = '[id_DESC]';
			$xml = $webService->get($opt);
			return $xml;
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}

	public static function getOrderHistory($id_history){	
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
			$opt['resource'] = 'order_histories';
			$opt['id'] = $id_history;
			$xml = $webService->get($opt);
			return $xml;
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}	
}
?>