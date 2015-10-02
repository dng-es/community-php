<?php
$base_dir_config = realpath(dirname(__FILE__)) ;
include_once ($base_dir_config."/functions.php");
include_once ($base_dir_config."/constants.php");


/**
* Redirect to $url
*
* @param 	string 		$url 	Destination redirect
*/
function redirectURL($url){
	try{
		//intentar redirección con javascript		
		echo '<script>document.location.href="'.$url.'"</script>';
	}
	catch(Exception $e){
		//si falla la redirección javascript lo intentamos por php
		header ("Location: ".$url);
	}
}

/**
* Returns The file to include
*
* @param 	string 		$page 		page name to include
* @return 	string 		 			full path folder
*/
function pageRouter($page){
	$path = "app/modules/";
	if ($dh = opendir($path)) {
		while (($file = readdir($dh)) !== false) {
			if (is_dir($path . $file) && $file != "." && $file != ".."){
				if (file_exists($path.$file."/pages/".$page)) return $path.$file."/pages/".$page;
			}
		}
		closedir($dh);
	}
	return pageRouter("404.php");
}

/**
* Used in __autoload() to correctly load classes
*
* @param 	string 		$dir 			module path
* @param 	string 		$modulename 	module name to load
* @return 	string 		$dir_final 		full path folder
*/
function dirCarga($dir, $modulename){
	$pos = strrpos( $dir , "\\" );
	if ($pos === false){
		//linux
		$dir_final = str_replace("app/core", "app",  $dir .$modulename);
	}
	else{
		//windows
		$dir_final = str_replace("app\\core", "app", $dir . str_replace("/", "\\\\", $modulename));       
	}
	return $dir_final;
}

/**
* Load templates
*
* @param 	string 		$template 		template name
* @param 	string 		$classname 		class name where template is placed
*/
function templateload($template, $classname){
	include_once (dirCarga( dirname(__FILE__) , "/modules/".$classname."/templates/".$template.".php"));
}

/**
* Autoload classes
*
* @param 	string 		$classname 			CLass name
*/
function __autoload($classname){    
	global $ini_conf;
	if ($classname == "connection" || $classname == "session" || $classname == "FileSystem" || $classname == "tpl")
		include_once (dirname(__FILE__) ."/class.".strtolower($classname).".php");
	elseif ($classname == "debugger") {
		if ($ini_conf['debug_app'] == 1 || $ini_conf['debug_app'] == 2){
			include_once (dirname(__FILE__) ."/debugger/class.".strtolower($classname).".php");
			if ($ini_conf['debug_app'] == 2) debugger::$debugger_output = "file";
		}
	}
	elseif (strpos($classname, "Controller")){
		$controller_name = "default";
		//$camels = split(" ", preg_replace('/(?<!^)[A-Z]/e', 'strtolower(" $0")', $classname));
		$camels = preg_split("/ /", preg_replace_callback('/(?<!^)[A-Z]/', function($m) { return strtolower(" ".$m[0]);}, $classname));
		if (count($camels) == 3) { 
			$classname = $camels[0];
			$controller_name = strtolower($camels[1]);
		}
		include_once(dirCarga(dirname(__FILE__), "/modules/".str_replace("Controller", "", $classname)."/controllers/controller.".$controller_name.".php"));
	}
	elseif ($classname == "headers" || $classname == "footer" || $classname == "menu")
		include_once(dirCarga(dirname(__FILE__), "/modules/class.".$classname.".php"));
	else 
		include_once (dirCarga(dirname(__FILE__) , "/modules/".$classname."/classes/class.".$classname.".php"));
}

/**
* Returns assets path
*
* @param 	string 		$modulename 		module asset container
* @return 	string 		$path 				module asset container path
*/
function getAsset($modulename){
	global $ini_conf;
	$path = $ini_conf['SiteUrl']."/app/modules/".$modulename."/resources/";
	return $path;
}

/**
 * Obtiene todos los modulos instalados
 * @return 	array 		Array con los modulos instalados
 */
function getListModules(){
	$listModules = array();
	$i = 0;
	$folders = FileSystem::showDirFolders(__DIR__."/../modules/");
	foreach($folders as $folder):
		if ($folder <>"core"){			
			$listModules[$i]['folder'] = $folder;
			$i++;	
		}
	endforeach;	
	return $listModules;	
}

/**
 * Devulve si un formulario existe
 *
 * @param 	string 		$modulename 		Nombre del modulo a buscar 
 * @return 	boolean 						Resultado de la busqueda
 */
function getModuleExist($modulename){
	$folders = FileSystem::showDirFolders(__DIR__."/../modules/");
	foreach($folders as $folder):
		if ($folder == $modulename) return true;
	endforeach;	
	return false;	
}

/**
 * Obtiene todos los modulos instalados
 *
 * @param 	string 		$modulename 		Nombre del modulo a buscar
 * @return 	array 							Array con los modulos instalados
 */
function getModuleConfig($modulename){
	$config_params = array();
	$file = __DIR__."/../modules/".$modulename."/config.yaml";
	if (file_exists($file)){
		$config_params = readYml($file);
	}	
	return $config_params;	
}

/**
* Returns the
*
* @param 	string 		$str 		string to translate
* @return 	string 		 			return translation by defalt language
*/
function strTranslate($str){
	global $ini_conf;

	$language = (isset($_SESSION['language']) and $_SESSION['language'] != "") ? $_SESSION['language'] : $ini_conf['language'];

	//translations from modules
	$modules = getListModules();
	foreach($modules as $module):
		$path_module = realpath(dirname(__FILE__))."/../modules/".$module['folder']."/resources/languages/".$language."/language.php";
		$str = getTranlationStr($path_module,$str);
	endforeach;

	//trasnlations from core
	$path_core = realpath(dirname(__FILE__))."/../languages/".$language."/language.php";
	//echo $path_core."<br />";
	$str = getTranlationStr($path_core,$str);
	
	return $str;
}

/**
 * Return string translation from a given file
 * @param  string 		$path 		file path where to find the string ($str)
 * @param  string 		$str  		String to translate
 * @return string       			Translation
 */
function getTranlationStr($path,$str){
	if (file_exists($path)){
		$language_strings = parse_ini_file($path);
		$str = isset($language_strings[$str]) ? $language_strings[$str] : $str;
	}
	return $str;
}

/**
 * Add JS files to header page
 * @param array $scripts Files to be added
 */
function addJavascripts($scripts){
	global $scripts_js;
	$scripts_js = $scripts;
}

/**
 * Add CSS files to header page
 * @param array $scripts Files to be added
 */
function addCss($scripts){
	global $scripts_css;
	$scripts_css = $scripts;
}

/**
* Read YAML
*
* @param 	string 		$file 		Complete name file, path included
* @return 	boolean 				Result
*/
function readYml($file){
	require_once(dirname(__FILE__).'/spyc-0.5/spyc.php'); 
	return Spyc::YAMLLoad($file); 
}
/**
* Write YAML
*
* @param 	array 		$data 		Data to include in given file
* @param 	string 		$file 		Complete name file, path included
* @return 	boolean 				Result
*/
function writeYml($data, $file){
	require_once(dirname(__FILE__).'/spyc-0.5/spyc.php'); 
	$yaml = Spyc::YAMLDump($data,4,60); 
	return FileSystem::createFile( $file, $yaml );
}
?>