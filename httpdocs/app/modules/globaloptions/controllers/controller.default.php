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

	const store_id = 21800;

	public static function jsonp_decode($jsonp, $callback){
		return json_decode(substr($jsonp, strlen($callback)+1, -1), true);
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
		//echo $response;
		$response = json_decode($response, true);
		curl_close($ch);

		$_SESSION['gotoken'] = $response['data']['token'];
		$_SESSION['partyId'] = $response['data']['partyId'];
		//var_dump($response);
		//echo "TOKEN: ".$response['data']['token'];
		return $response['data']['token'];
	}

	public static function getParticipantData($partyId, $username, $token = ''){
		$token = ($token == '' ? $_SESSION['gotoken'] : $token);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::url_go.$token."/getParticipantData?partyId=".$partyId."&userLoginId=".$username."&callback=jpcallback");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		$response = curl_exec($ch);
		$response = self::jsonp_decode($response, "jpcallback");
		curl_close($ch);
	
		//var_dump($response);
		//echo $response['data']['programmeCountry'];
		return $response['data'];
	}

	public static function addParticipant($username, $user_password, $name, $surname, $birthDate, $email, $phoneHome, $phoneWork, $phoneMobile, $address, $city, $province, $country = 'ES', $postalCode, $token = ''){
		$token = ($token == '' ? $_SESSION['gotoken'] : $token);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::url_go.$token."/addParticipant");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"
			participant\": {\n        \"
				programId\": \"".self::store_id."\",\n        \"
				userId\": \"".$username."\",\n        \"
				userName\": \"".$username."\",\n        \"
				password\": \"".$user_pass."\",\n        \"
				firstName\": \"".$name."\",\n        \"
				lastName\": \"".$surname."\",\n        \"
				birthDate\": \"".$birthDate."\",\n        \"
				email\": \"".$email."\",\n        \"
				phoneHome\": \"".$phoneHome."\",\n        \"
				phoneWork\": \"".$phoneWork."\",\n        \"
				phoneMobile\": \"".$phoneMobile."\",\n        \"
				faxNumber\": \"\",\n        \"
				address1\": \"".$address."\",\n        \"
				address2\": \"\",\n        \"
				address3\": \"\",\n        \"
				city\": \"".$city."\",\n        \"
				province\": \"".$province."\",\n        \"
				country\": \"".$country."\",\n        \"
				postalCode\": \"".$postalCode."\",\n        \"
				tier\": \"\",\n        \"
				location\": \"\",\n        \"
				company\": \"\",\n        \"
				bulkAccount\": \"N\",\n        \"
				autoGenerate\": \"false\",\n        \"
				resendExistingPassword\": \"N\",\n        \"
				userType\": \"\",\n        \"
				status\": \"Active\",\n        \"
				expiryDate\": \"\"\n    
		}\n}");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
		$response = curl_exec($ch);
		curl_close($ch);

		//var_dump($response);	
		return 	$response['data'];
	}

	public static function updateParticipant($partyId, $username, $user_password, $name, $surname, $birthDate, $email, $phoneHome, $phoneWork, $phoneMobile, $address, $city, $province, $country = 'ES', $postalCode, $status="Active", $token = ''){
		$token = ($token == '' ? $_SESSION['gotoken'] : $token);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::url_go.$token."/updateParticipant");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"
			existingParticipant\": {\n        \"
				partyId\": \"".$partyId."\",\n        \"
				userName\": \"".$username."\",\n        \"
				password\": \"".$user_password."\",\n        \"
				firstName\": \"".$name."\",\n        \"
				lastName\": \"".$surname."\",\n        \"
				birthDate\": \"".$birthDate."\",\n        \"
				positionTitle\": \"\",\n        \"
				employeeNumber\": \"\",\n        \"
				email\": \"".$email."\",\n        \"
				phoneHome\": \"".$phoneHome."\",\n        \"
				phoneWork\": \"".$phoneWork."\",\n        \"
				phoneMobile\": \"".$phoneMobile."\",\n        \"
				faxNumber\": \"\",\n        \"
				address1\": \"".$address."\",\n        \"
				address2\": \"\",\n        \"
				address3\": \"\",\n        \"
				city\": \"".$city."\",\n        \"
				province\": \"\",\n        \"
				country\": \"".$country."\",\n        \"
				postalCode\": \"".$postalCode."\",\n        \"
				tier\": \"\",\n        \"
				location\": \"\",\n        \"
				company\": \"\",\n        \"
				bulkAccount\": \"N\",\n        \"
				resendExistingPassword\": \"N\",\n        \"
				userType\": \"\",\n        \"
				status\": \"".$status."\",\n        \"
				expiryDate\": \"\"\n    
		}\n}");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
		$response = curl_exec($ch);
		curl_close($ch);

		//var_dump($response);
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

	public static function getParticipantBalance($partyId = '', $token = ''){
		$partyId = ($partyId == '' ? $_SESSION['partyId'] : $partyId);
		$token = ($token == '' ? $_SESSION['gotoken'] : $token);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::url_go.$token."/getParticipantBalance?partyId=".$partyId."&programId=".self::store_id."&callback=jpcallback");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		$response = curl_exec($ch);
		$response = self::jsonp_decode($response, "jpcallback");
		curl_close($ch);

		$puntos_global = (($response != NULL and $response['statusCode'] == 0) ? $response['data']['balance'] : 0);

		return $puntos_global;
	}
}
?>