<?php
//archivo donde se reciben las peticiones
set_time_limit(0);
//autoload del Api y las clases
function __autoload($class_name) {
  if ($class_name == 'API') require_once 'api.php';
  else{
    if (file_exists("modules/".$class_name.'.php')){
      require_once "modules/".$class_name.'.php';
    }
  }
}
//instanciamos la clase api
$api = new API;
//recorremos las clases buscando la peticion solicitada
$dirname = "modules/";

if ($dh = opendir($dirname)) {
    while (($file = readdir($dh)) !== false) {
        if (!is_dir($dirname . $file) && $file!="." && $file!=".."){
          $clase = str_replace('.php','',$file);
          $func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
          if((int)method_exists($clase,$func) > 0){
            //si la encuentra instancia la clase correspondiente y ejecuta la peticion
            closedir($dh);
            $obj = new $clase;
            $obj->$func();
            break;
          }
        }
    }
}
//si no encuentra la peticion devuelve un 404
$api->response('',404);

?>