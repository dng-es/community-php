<?php
class prestashopCreditsController extends prestashopController{
	public static function getCredits($id_customer){
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
			$xml = $webService->get(array('resource' => 'points', 'display' =>'[total_amount]', 'filter[id_customer]' => '['.$id_customer.']'));
			return floatval($xml->points->wallet->total_amount);
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}

	public static function insertCredits($id_customer, $points){
		try{
			$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, false);
			$xml = $webService->get(array('url' => self::ws_url.'api/addpoints?schema=blank'));
			$resources = $xml->children()->children();

			//actualizar datos del xml
			$resources->id_customer = $id_customer;
			$resources->points = $points;

			//enviar datos
			$opt = array('resource' => 'addpoints');
			$opt['postXml'] = $xml->asXML();
			$xml = $webService->add($opt);

			//return $xml->customer->id;
			return true;
		}
		catch (PrestaShopWebserviceException $ex){
			return array('status' => "Failed", "msg" => $ex->getMessage());
		}
	}

	// public static function insertCredits($id_customer, $points){	
	// 	try{
	// 		$webService = new PrestaShopWebservice(self::ws_url, self::ws_key, true);
	// 		$xml = prestashopCustomersController::getCustomer($id_customer);
	// 		$resources = $xml->children()->children();

	// 		$new_points = prestashopCreditsController::getCredits($id_customer) + $points;

	// 		//actualizar datos
	// 		$resources->points = $new_points;

	// 		//enviar datos
	// 		$opt = array('resource' => 'customers');
	// 		$opt['putXml'] = $xml->asXML();
	// 		$opt['id'] = $id_customer;
	// 		$xml = $webService->edit($opt);
			
	// 		return true;
	// 	}
	// 	catch (PrestaShopWebserviceException $ex){
	// 		return array('status' => "Failed", "msg" => $ex->getMessage());
	// 	}
	// }
}
?>