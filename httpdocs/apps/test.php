<?php 
echo "Enviando peticion:<br />";
		$ch = curl_init();

		// curl_setopt($ch, CURLOPT_URL, "https://piratas.local.com/apps/service/getBatallas?ses_id=th57r912v9u0sp7c7a2d&user=admin");
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		// curl_setopt($ch, CURLOPT_HEADER, FALSE);
		// $response = curl_exec($ch);
		// //$response = self::jsonp_decode($response, "jpcallback");
		// 
	
		// var_dump($response);
		//echo $response['data']['programmeCountry'];
		//return $response['data'];

/*		curl_setopt($ch, CURLOPT_URL, "https://piratas.local.com/apps/service/login");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"
			user\": \"admin\",\n        \"
			pwd\": \"chuskyfish\"\n    
		}");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
		$response = curl_exec($ch);
		//var_dump($ch);*/



		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://prueba.tumaquinadeltiempo.es/apps/service/getPosicion?ses_id=7d45y905j1dp6n33o6wz&user=28821076Y");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		$response = curl_exec($ch);
		//$response = self::jsonp_decode($response, "jpcallback");
		curl_close($ch);
	
		//var_dump($response);


var_dump($response);


curl_close($ch);

echo "Fin peticion<br />";

?>