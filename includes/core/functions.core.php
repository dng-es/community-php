<?php
$base_dir_config = realpath(dirname(__FILE__)) ;
include_once ($base_dir_config."/functions.php");


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
	$path = "includes/modules/";
	if ($dh = opendir($path)) {
		while (($file = readdir($dh)) !== false) {
			if (is_dir($path . $file) && $file!="." && $file!=".."){
				if (file_exists($path.$file."/pages/".$page)){
					return $path.$file."/pages/".$page;
				}
			}
		}
		closedir($dh);
	}
	return "";
}

/**
* Used in __autoload() to correctly load classes
*
* @param 	string 		$dir 		module path
* @param 	string 		$module 	module name to load
* @return 	string 		$dir_final 	full path folder
*/
function dirCarga($dir, $module){
	$pos = strrpos( $dir , "\\" );
	if ($pos === false){
		//linux
		$dir_final = str_replace("/core", "",  $dir .$module);
	}
	else{
		//windows
		$dir_final = str_replace("\\core", "", $dir . str_replace("/", "\\\\", $module));       
	}
	return $dir_final;
}

/**
* Load templates
*
* @param 	string 		$template 		template name
* @param 	string 		$classname 		class name where template is placed
*/
function templateload($template,$classname){
	include_once (dirCarga( dirname(__FILE__) , "/modules/".$classname."/templates/".$template.".php"));
}

/**
* Autoload classes
*
* @param 	string 		$classname 			CLass name
*/
function __autoload($classname){    
	global $ini_conf;
	if ($classname == "connection" || $classname == "session" || $classname == "FileSystem"){
		include_once (dirname(__FILE__) ."/class.".strtolower($classname).".php");
	}
	elseif ($classname == "debugger") {
		if($ini_conf['debug_app']==1){
			include_once (dirname(__FILE__) ."/class.".strtolower($classname).".php");
		}
	}
	elseif (strpos($classname, "Controller")){
		$controller_name = "default";
		$camels = split(" ", preg_replace('/(?<!^)[A-Z]/e', 'strtolower(" $0")', $classname));
		if (count($camels) == 3) { 
			$classname = $camels[0];
			$controller_name = strtolower($camels[1]);
		}
		include_once(dirCarga(dirname(__FILE__), "/modules/".str_replace("Controller", "", $classname)."/controllers/controller.".$controller_name.".php"));
	}
	elseif ($classname == "headers" || $classname == "footer" || $classname == "menu"){
		include_once(dirCarga(dirname(__FILE__), "/modules/class.".$classname.".php"));
	}
	else{
		include_once (dirCarga(dirname(__FILE__) , "/modules/".$classname."/class.".$classname.".php"));
	}
}

/**
* Returns assets path
*
* @param 	string 		$modulename 		module asset container
* @return 	string 		$path 				module asset container path
*/
function getAsset($modulename){
	$path = "includes/modules/".$modulename."/resources/";
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
* Returns the
*
* @param 	string 		$str 		string to translate
* @return 	string 		 			return translation by defalt language
*/
function strTranslate($str){
	global $ini_conf;

	//translations from modules
	$modules = getListModules();
	foreach($modules as $module):
		$path_module = "includes/modules/".$module['folder']."/resources/languages/".$ini_conf['language']."/language.php";
		$str = getTranlationStr($path_module,$str);
	endforeach;

	//trasnlations from core
	$path_core = "includes/languages/".$ini_conf['language']."/language.php";
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
?>