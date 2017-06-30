<?php
class prestashopCustomersController extends prestashopController{
	public static function getCustomers(){	
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
			$xml = $webService->get(array('resource' => 'customers'));
			return $xml->customers->children();
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}	

	public static function getCustomer($id_customer){	
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
			return $webService->get(array('resource' => 'customers', 'id' => $id_customer));
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}

	public static function printCustomer($id_customer){	
		try{
			$xml = self::getCustomer($id_customer);
			$resources = $xml->children()->children();
			foreach ($resources as $key => $resource)
				echo 'Name of field: ' . $key . ' - Value: ' . $resource . '<br />';

			return $resources;
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}

	public static function updateCustomer($id_customer, $firstname , $lastname , $email, $active, $optin, $birthday, $passwd){
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);		
			$xml = self::getCustomer($id_customer);
			$resources = $xml->children()->children();

			//actualizar datos
			$resources->passwd = $passwd;
			$resources->firstname = $firstname;
			$resources->lastname = $lastname;
			$resources->email = $email;
			$resources->active = $active;
			$resources->optin = $optin;
			$resources->birthday = $birthday;

			//enviar datos
			$opt = array('resource' => 'customers');
			$opt['putXml'] = $xml->asXML();
			$opt['id'] = $id_customer;
			$xml = $webService->edit($opt);
			
			return true;
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}

	public static function insertCustomer($passwd = "", $firstname = "", $lastname = "", $email = "", $active = 0, $optin = 0, $id_default_group = 3, $id_group = 3){
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
			$xml = $webService->get(array('url' => self::ws_url.'api/customers?schema=blank'));
			$resources = $xml->children()->children();

			//actualizar un datos
			$resources->passwd = $passwd;
			$resources->firstname = $firstname;
			$resources->lastname = $lastname;
			$resources->email = $email;
			$resources->active = $active;
			$resources->optin = $optin;
			$resources->id_default_group = $id_default_group;
			$resources->associations->groups->group->id = $id_group;

			//enviar datos
			$opt = array('resource' => 'customers');
			$opt['postXml'] = $xml->asXML();
			$xml = $webService->add($opt);

			return $xml->customer->id;
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}

/////////////////////////////////////////////////////////////////////////////
/// FUNCIONES DE DIRECCIONES DE ENTRAGA			/////////////////////////////
/////////////////////////////////////////////////////////////////////////////
	
	public static function getAddresses($id_customer = 0){	
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
			$opt = array('resource' => 'addresses');
			$opt['filter[deleted]'] = 0;
			if ($id_customer > 0) $opt['filter[id_customer]'] = $id_customer;
			$xml = $webService->get($opt);
			return $xml->addresses->children();
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}	

	public static function getAddress($id_address){	
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
			return $webService->get(array('resource' => 'addresses', 'id' => $id_address));
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}

	public static function printAddress($id_address){	
		try{
			$xml = self::getAddress($id_address);
			$resources = $xml->children()->children();
			foreach ($resources as $key => $resource)
				echo 'Name of field: ' . $key . ' - Value: ' . $resource . '<br />';

			return $resources;
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}	

	public static function updateAddress($id_address, $id_state, $lastname, $firstname, $address1, $address2, $postcode, $city, $phone, $phone_mobile, $dni){
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);		
			$xml = self::getAddress($id_address);
			$resources = $xml->children()->children();

			//actualizar datos
			$resources->id_state = $id_state;
			$resources->lastname = $lastname;
			$resources->firstname = $firstname;
			$resources->address1 = $address1;
			$resources->address2 = $address2;
			$resources->postcode = $postcode;
			$resources->city = $city;
			$resources->phone = $phone;
			$resources->phone_mobile = $phone_mobile;
			$resources->dni = $dni;

			//enviar datos
			$opt = array('resource' => 'addresses');
			$opt['putXml'] = $xml->asXML();
			$opt['id'] = $id_address;
			$xml = $webService->edit($opt);
			
			return true;
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}

	public static function deleteAddress($id_address){
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);		
			$xml = self::getAddress($id_address);
			$resources = $xml->children()->children();

			//actualizar datos
			$resources->deleted = 1;

			//enviar datos
			$opt = array('resource' => 'addresses');
			$opt['putXml'] = $xml->asXML();
			$opt['id'] = $id_address;
			$xml = $webService->edit($opt);
			
			return true;
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}	

	public static function insertAddress($id_customer, $id_state, $lastname, $firstname, $address1, $address2, $postcode, $city, $phone, $phone_mobile, $dni, $id_country = 6){
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
			$xml = $webService->get(array('url' => self::ws_url.'api/addresses?schema=blank'));
			$resources = $xml->children()->children();

			//actualizar un datos
			$resources->id_customer = $id_customer;
			$resources->id_state = $id_state;
			$resources->lastname = $lastname;
			$resources->firstname = $firstname;
			$resources->address1 = $address1;
			$resources->address2 = $address2;
			$resources->postcode = $postcode;
			$resources->city = $city;
			$resources->phone = $phone;
			$resources->phone_mobile = $phone_mobile;
			$resources->id_country = $id_country;
			$resources->alias = $firstname." ".$lastname;
			$resources->dni = $dni;

			//enviar datos
			$opt = array('resource' => 'addresses');
			$opt['postXml'] = $xml->asXML();
			$xml = $webService->add($opt);

			return $xml->customer->id;
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}	
}
?>