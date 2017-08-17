<?php
	/*fichero para la automatizacion (CRON) de carga de ficheros de 
	usuarios, tiendas y ventas(incentivos). 
	Los ficheros deben seguir los mismos modelos que en las cargas manuales.
	Los ficheros procesados serán movidos a la carpeta intercambio/procesados*/

	date_default_timezone_set('Europe/Madrid');
	ini_set('memory_limit', '-1');
	set_time_limit(0);

	$path_to_app = realpath(dirname(__FILE__))."/../httpdocs/";
	include_once($path_to_app . "app/core/class.connection.php");
	include_once($path_to_app . "app/modules/configuration/classes/class.configuration.php");
	include_once($path_to_app . "app/core/functions.core.php");
	include_once($path_to_app . "app/core/constants.php");
	include_once($path_to_app . "docs/reader.php");
	include_once($path_to_app . "app/modules/users/classes/class.users.php");
	include_once($path_to_app . "app/modules/users/controllers/controller.default.php");
	include_once($path_to_app . "app/modules/users/controllers/controller.tiendas.php");
	include_once($path_to_app . "app/modules/incentivos/classes/class.incentivos.php");
	include_once($path_to_app . "app/modules/incentivos/controllers/controller.default.php");

	//Obtener ficheros, recorrer carpeta para encontrar nombres de ficheros
	$path_intercambio = realpath(dirname(__FILE__))."/../intercambio/";
	$fichero_usuarios = "";
	$fichero_tiendas = "";
	$fichero_ventas = "";	
	if ($dh = opendir($path_intercambio)) { 
		while (($file = readdir($dh)) !== false) { 
			if (!is_dir($path_intercambio . $file) && $file!="." && $file!=".."){ 
				if (strpos(strtoupper($file), "USUARIOS") === 0) $fichero_usuarios = $file;
				if (strpos(strtoupper($file), "TIENDAS") === 0) $fichero_tiendas = $file;
				if (strpos(strtoupper($file), "VENTAS") === 0) $fichero_ventas = $file;
			} 
		} 
		closedir($dh);
	}

	//CARGA DEL FICHERO USUARIOS.XLS
	if ($fichero_usuarios != "") {
		echo date("Y-m-d H:i:s"). " Inicio proceso carga de usuarios. Cargando fichero ".$fichero_usuarios."\n";

		//cargar datos del fichero	
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('CP1251');
		$data->read($path_intercambio.$fichero_usuarios);
		usersController::volcarMySQLUsers($data);
		echo date("Y-m-d H:i:s"). " Fin carga de usuarios\n";
		rename($path_intercambio.$fichero_usuarios, $path_intercambio."/procesados/".date("Ymd_His_").$fichero_usuarios);
	}
	else echo date("Y-m-d H:i:s"). " No se encuentra fichero de usuarios\n";

	//CARGA DEL FICHERO TIENDAS.XLS
	if ($fichero_tiendas != "") {
		echo date("Y-m-d H:i:s"). " Inicio proceso carga de tiendas (".$fichero_tiendas.")\n";

		//cargar datos del fichero
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('CP1251');
		$data->read($path_intercambio.$fichero_tiendas);
		usersTiendasController::volcarMySQLTiendas($data);
		echo date("Y-m-d H:i:s"). " Fin carga de tiendas\n";
		rename($path_intercambio.$fichero_tiendas, $path_intercambio."/procesados/".date("Ymd_His_").$fichero_tiendas);
	}
	else echo date("Y-m-d H:i:s"). " No se encuentra fichero de tiendas\n";

	//CARGA DEL FICHERO VENTAS.XLS
	if ($fichero_ventas != "") {
		echo date("Y-m-d H:i:s"). " Inicio proceso carga de ventas (".$fichero_ventas.")\n";

		//cargar datos del fichero
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('CP1251');
		$data->read($path_intercambio.$fichero_ventas);
		incentivosController::volcarMySQLVentas($data);
		echo date("Y-m-d H:i:s"). " Fin carga de ventas\n";
		rename($path_intercambio.$fichero_ventas, $path_intercambio."/procesados/".date("Ymd_His_").$fichero_ventas);
	}
	else echo date("Y-m-d H:i:s"). " No se encuentra fichero de ventas\n";		

	echo 'Fin de carga de archivos';
?>