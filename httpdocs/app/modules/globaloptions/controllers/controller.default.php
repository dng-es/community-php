<?php
/**
 * PROCESOS A REALIZAR
 * SSO: en menu (hecho)
 * Crear usuario: desde admin (hecho)
 * Actualizar usuario: desde admin (hecho)
 * Actualizar perfil: desde profile (hecho)
 * Confirmar usuario: desde user-confirm (hecho)
 * Crear usuario: desde carga de usuarios (hecho)
 * Sumar puntos: desde incestives ventas process (pendiente - ¿que es partyId, como lo obtengo?)
 */
class globaloptionsController{

	//const url_go = "https://uat.myglobaloptions.com/rest/api/v1/";
	const url_go = "https://www.myglobaloptions.com/rest/api/v1/";

	const store_id = 0;
	//const client_id = 0;

	public static function jsonp_decode($jsonp, $callback){
		return json_decode(substr($jsonp, strlen($callback)+1, -1), true);
	}

	public static function insertUser($username){
		$users = new users();
			$user = $users->getUsersSimple(" AND username='".$username."'");
			$user = $user[0];
			$username = $username;/*OBLIGATORIO*/
			$user_password = $user['user_password'];/*OBLIGATORIO*/

			$name = $user['name'];/*OBLIGATORIO*/
			$surname = $user['surname'];/*OBLIGATORIO*/
			$birthDate = "";
			$email = $user['email'];/*OBLIGATORIO*/
			$phoneHome = "";
			$phoneWork = $user['telefono'];
			$phoneMobile = "";
			$address = ($user['direccion_user'] != "" ? $user['direccion_user'] : "-");/*OBLIGATORIO*/
			$city =  ($user['ciudad_user'] != "" ? $user['ciudad_user'] : "-");/*OBLIGATORIO*/
			$province =  ($user['provincia_user'] != "" ? $user['provincia_user'] : "-");/*OBLIGATORIO*/
			$postalCode = ($user['cpostal_user'] != "" ? $user['cpostal_user'] : "-");/*OBLIGATORIO*/

			$gotoken_data = self::gettoken( "pruebajaime", "demo1");

			$response = self::addParticipant($username, $user_password, $name, $surname, $birthDate, $email, $phoneHome, $phoneWork, $phoneMobile, $address, $city, $province, $country = 'ESP', $postalCode, $gotoken_data['token']);

		$_SESSION['gotoken'] = $response['data']['token'];
		$_SESSION['partyId'] = $response['data']['partyId'];

		return $response['data'];
	}

	public static function updateUserGo($username,$partyId,$gotoken_data){

		$users = new users();
		$user = $users->getUsersSimple(" AND username='".$username."'");
		$user = $user[0];
		$username = $username;/*OBLIGATORIO*/
		$user_password = $user['user_password'];/*OBLIGATORIO*/

		$name = $user['name'];/*OBLIGATORIO*/
		$surname = $user['surname'];/*OBLIGATORIO*/
		$birthDate = "";
		$email = $user['email'];/*OBLIGATORIO*/
		$phoneHome = "";
		$phoneWork = $user['telefono'];
		$phoneMobile = "";
		$address = ($user['direccion_user'] != "" ? $user['direccion_user'] : "-");/*OBLIGATORIO*/
		$city =  ($user['ciudad_user'] != "" ? $user['ciudad_user'] : "-");/*OBLIGATORIO*/
		$province =  ($user['provincia_user'] != "" ? $user['provincia_user'] : "-");/*OBLIGATORIO*/
		$postalCode = ($user['cpostal_user'] != "" ? $user['cpostal_user'] : "-");/*OBLIGATORIO*/

		//$gotoken_data = self::gettoken("SL".$username."", "".$user_password."");

		self::updateParticipant($partyId, $username, $user_password, $name, $surname, $birthDate, $email, $phoneHome, $phoneWork, $phoneMobile, $address, $city, $province, $country = 'ESP', $postalCode, "Active", $gotoken_data);
		self::updateAddress($partyId, $username, $user_password, $name, $surname, $birthDate, $email, $phoneHome, $phoneWork, $phoneMobile, $address, $city, $province, $country = 'ESP', $postalCode, "Active", $gotoken_data);
		/*$_SESSION['gotoken'] = $response['data']['token'];
		$_SESSION['partyId'] = $response['data']['partyId'];

		return $response['data'];*/
	}


	public static function gettoken( $username, $user_password){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::url_go."gettoken");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);

		curl_setopt($ch, CURLOPT_POSTFIELDS, "{
		  \"AuthParams\": {
		    \"userName\": \"".$username."\",
		    \"password\": \"".$user_password."\",
		    \"productStoreId\": \"".self::store_id."\"
		  }
		}");

		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
		$response = curl_exec($ch);

		$response = json_decode($response, true);
		curl_close($ch);

		if($response['statusCode'] == 101){
			self::insertUser($_SESSION['username']);
		}/*else{
			self::updateUserGo($_SESSION['username'],$response['data']['partyId'],$response['data']['token']);
		}*/

		$_SESSION['gotoken'] = $response['data']['token'];
		$_SESSION['partyId'] = $response['data']['partyId'];
		//var_dump($response);
		//echo "TOKEN: ".$response['data']['token'];
		return $response['data'];
	}

	public static function getParticipantData($partyId, $username, $token = ''){
		$token = ($token == '' ? $_SESSION['gotoken'] : $token);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::url_go.$token."/participant?partyId=".$partyId."&userName=".$username."&callback=jpcallback");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		$response = curl_exec($ch);
		$response = self::jsonp_decode($response, "jpcallback");
		curl_close($ch);

		//var_dump($response);
		//echo $response['data']['programmeCountry'];
		return $response['data'];
	}

	public static function addParticipant($username, $user_password, $name, $surname, $birthDate, $email, $phoneHome, $phoneWork, $phoneMobile, $address, $city, $province, $country = 'ESP', $postalCode, $token = ''){


		$token = ($token == '' ? $_SESSION['gotoken'] : $token);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::url_go.$token."/participant");

		//echo "<br />URL: ".self::url_go.$token."/participant<br /><br />";
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{
			\"participant\": {
				\"productStoreId\": \"".self::store_id."\",
				\"userId\": \"".$username."\",
				\"userName\": \"".$username."\",
				\"password\": \"".$user_password."\",
				\"firstName\": \"".$name."\",
				\"lastName\": \"".$surname."\",
				\"birthDate\": \"".$birthDate."\",
				\"email\": \"".$email."\",
				\"phoneHome\": \"".$phoneHome."\",
				\"phoneWork\": \"".$phoneWork."\",
				\"phoneMobile\": \"".$phoneMobile."\",
				\"faxNumber\": \"\",
				\"address1\": \"".$address."\",
				\"address2\": \"\",
				\"address3\": \"\",
				\"city\": \"".$city."\",
				\"province\": \"".$province."\",
				\"country\": \"".$country."\",
				\"postalCode\": \"".$postalCode."\",
				\"tier\": \"\",
				\"location\": \"\",
				\"company\": \"\",
				\"bulkAccount\": \"N\",
				\"autoGenerate\": \"false\",
				\"resendExistingPassword\": \"N\",
				\"userType\": \"\",
				\"status\": \"Active\",
				\"expiryDate\": \"\"
			}
		}");

		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
		$response = curl_exec($ch);
		curl_close($ch);

		return 	$response['data'];
	}

	public static function updateAddress($partyId, $username, $user_password, $name, $surname, $birthDate, $email, $phoneHome, $phoneWork, $phoneMobile, $address, $city, $province, $country = 'ESP', $postalCode, $status="Active", $token = ''){
		$token = ($token == '' ? $_SESSION['gotoken'] : $token);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, self::url_go.$token."/participant/".$partyId."/address?callback=jpcallback");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);

		$response = curl_exec($ch);
		$response = self::jsonp_decode($response, "jpcallback");

		curl_close($ch);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::url_go.$token."/participant/".$partyId."/address/");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);

		curl_setopt($ch, CURLOPT_POST, TRUE);
		$existe_dir_entrega=FALSE;

		foreach ($response['data']['addresses'] as $address_for){
			if((!$existe_dir_entrega or $address_for['addressType']!='SHIPPING_LOCATION')  ){

				curl_setopt($ch, CURLOPT_POSTFIELDS, "{
					  \"participantAddress\": {
					    \"contactMechId\": \"".$address_for['contactMechId']."\",
					    \"addressType\": \"".$address_for['addressType']."\",
					    \"addressDescription\": \"".$address_for['addressDescription']."\",
					    \"toName\": \"".$name."\",
					    \"attnName\": null,
					    \"address1\": \"".$address."\",
					    \"address2\": null,
					    \"address3\": null,
					    \"city\": \"".$city."\",
					    \"province\": \"".$province."\",
					    \"postalCode\": \"".$postalCode."\",
					    \"countryGeoId\": \"ESP\"
					  }
					}");
			}
			if($address_for['addressType']=='SHIPPING_LOCATION') $existe_dir_entrega=TRUE;
		}

		if (!$existe_dir_entrega){
			curl_setopt($ch, CURLOPT_POSTFIELDS, "{
				  \"participantAddress\": {
				    \"contactMechId\": \"\",
				    \"addressType\": \"SHIPPING_LOCATION\",
				    \"addressDescription\": \"Dirección de entrega.\",
				    \"toName\": \"".$name."\",
				    \"attnName\": null,
				    \"address1\": \"".$address."\",
				    \"address2\": null,
				    \"address3\": null,
				    \"city\": \"".$city."\",
				    \"province\": \"".$province."\",
				    \"postalCode\": \"".$postalCode."\",
				    \"countryGeoId\": \"ESP\"
				  }
				}");
		}

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		  "Content-Type: application/json"
		));

		$response = curl_exec($ch);
		curl_close($ch);

		//var_dump($response);
	}

	public static function updateParticipant($partyId, $username, $user_password, $name, $surname, $birthDate, $email, $phoneHome, $phoneWork, $phoneMobile, $address, $city, $province, $country = 'ES', $postalCode, $status="Active", $token = ''){

		$token = ($token == '' ? $_SESSION['gotoken'] : $token);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://www.myglobaloptions.com/rest/api/v1/".$token."/participant/partyId");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);

		curl_setopt($ch, CURLOPT_POST, TRUE);

		curl_setopt($ch, CURLOPT_POSTFIELDS, "{
			\"existingParticipant\": {
				\"partyId\": \"".$partyId."\",
				\"userName\": \"".$username."\",
				\"password\": \"".$user_password."\",
				\"firstName\": \"".$name."\",
				\"lastName\": \"".$surname."\",
				\"birthDate\": \"".$birthDate."\",
				\"email\": \"".$email."\",
				\"phoneHome\": \"".$phoneHome."\",
				\"phoneWork\": \"".$phoneWork."\",
				\"phoneMobile\": \"".$phoneMobile."\",
				\"faxNumber\": \"\",
				\"address1\": \"".$address."\",
				 \"address2\": \"\",
    			\"address3\": \"\",
				\"city\": \"".$city."\",
				\"province\": \"".$province."\",
				\"country\": \"".$country."\",
				\"postalCode\": \"".$postalCode."\",
				\"tier\": \"\",
				\"location\": \"\",
				\"company\": \"\",
				\"bulkAccount\": \"N\",
				\"resendExistingPassword\": \"N\",
				\"userType\": \"null\",
				\"status\": \"Active\",
				\"expiryDate\":\"\"
			}
		}");

  		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
		$response = curl_exec($ch);
		curl_close($ch);

		//var_dump($response);die;
	}

	public static function transferPoints($partyId, $sourceRef = "rest test balance", $points, $description, $planNumber, $transactionDate = '2013-10-04 09:12:33', $expiryDate = '2013-10-04 09:12:33', $token = ''){
		$token = ($token == '' ? $_SESSION['gotoken'] : $token);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::url_go.$token."/transferPoints");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"
			pointsData\": {\n        \"
				programId\": \"".self::store_id."\",\n        \"
				partyId\": \"".$partyId."\",\n        \"
				sourceRef\": \"".$sourceRef."\",\n        \"
				points\": \"".$city."\",\n        \"
				description\": \"".$description."\",\n        \"
				planNumber\": \"".$planNumber."\",\n        \"
				isOrdered\": \"N\",\n        \"
				externalOrderId\": \"\",\n        \"
				transactionDate\": \"".$transactionDate."\",\n        \"
				zeroPointEnabled\": \"false\",\n        \"
				expiryDate\": \"".$expiryDate."\"\n
		}\n}");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
		$response = curl_exec($ch);
		curl_close($ch);

		//var_dump($response);
	}

	public static function getParticipantBalance($partyId, $token = ''){
		$token = ($token == '' ? $_SESSION['gotoken'] : $token);
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, self::url_go.$token."/participant/balance?productStoreId=".self::store_id."&partyId=".$partyId."&callback=jpcallback");
		//curl_setopt($ch, CURLOPT_URL, self::url_go.$token."/getParticipantBalance?partyId=".$partyId."&programId=".self::store_id."&callback=jpcallback");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		$response = curl_exec($ch);
		//var_dump($response);
		$response = self::jsonp_decode($response, "jpcallback");
		curl_close($ch);

		return $response['data']['balance'];
	}
}
?>