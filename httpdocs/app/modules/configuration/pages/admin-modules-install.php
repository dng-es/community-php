<?php
set_time_limit(0);
ini_set('memory_limit', '-1');

addJavascripts(array(getAsset("configuration")."js/admin-modules-install.js"));


// //$url = "http://comunidad.imagar.com/app/modules/class.headers.php";
// $url = "https://game.local.com/app/modules/class.headers.php";
// //El nombre del archivo donde se almacenara los datos descargados.
// $filePath = __DIR__.'/class.headers.php';
// //Inicializa Curl.
// $ch = curl_init();

// $fp = fopen($filePath, 'w+'); 
//     //Pasamos la url a donde debe ir.
// curl_setopt($ch, CURLOPT_URL, $url);
//     //Si necesitamos el header del archivo, en este caso no.
// curl_setopt($ch, CURLOPT_HEADER, false);
//     //Si necesitamos descargar el archivo.
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     //Lee el header y se mueve a la siguiente localización.
//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
//     //Cantidad de segundo de limite para conectarse.
// curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
//     //Cantidad de segundos de limite para ejecutar curl. 0 significa indefinido.
// curl_setopt($ch, CURLOPT_TIMEOUT, 0);
// //curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
//     //Donde almacenaremos el archivo.
// curl_setopt($ch, CURLOPT_FILE, $fp);
//     //curl_exec ejecuta el script.
// $result = curl_exec($ch);
//     //Dejamos de utilizar el archivo creado.
//     fclose($fp);
//     if($result){ //funciono ?
//          echo "Descarga correcta.";
//      }
//      else{
//      	echo "ERORRRRRR";
//      }

exec("curl -o class.headers.php http://comunidad.imagar.com/app/modules/class.headers.php");

?>
<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Configuration"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Modules_settings"), "ItemClass"=>"active"),
		));
		session::getFlashMessage('actions_message');
		configurationController::updateAction();
		$modules = configurationController::getListModulesAction();
		global $modules_data;
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<h2><?php e_strTranslate("Modulos disponibles");?></h2>
				<?php foreach($modules as $module): ?>
				<?php 
				$module_config = getModuleConfig($module['folder']);
				$key = array_search($module['folder'], arraycolumn($modules_data, 'name'));
				?>

				<h3 class="panel-title"><?php e_strTranslate(ucfirst($module['folder']));?>	</h3>
				<p><?php echo str_replace('"', '\'', $module['ann']);?></p>
				<?php endforeach;?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>

