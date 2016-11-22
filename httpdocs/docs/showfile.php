<?php
$base_dir = "../";

include_once($base_dir . "app/core/class.connection.php");
include_once($base_dir . "app/modules/configuration/classes/class.configuration.php");
include_once($base_dir . "app/core/functions.core.php");
include_once($base_dir . "app/core/constants.php");
include_once($base_dir . "app/core/functions.php");
include_once($base_dir . "app/core/class.session.php");
include_once($base_dir . "app/modules/users/classes/class.users.php");

$res_app = 0;
if (isset($_REQUEST['u']) and isset($_REQUEST['s'])){
	$users = new users();
	$res_app = $users->countReg("users_login"," AND ses_id = '".$_REQUEST['s']."' AND username='".$_REQUEST['u']."' LIMIT 1");    
}

if (($_SESSION['user_logged']==true and $_SESSION['user_name']!="") or $res_app>0){
	# Definimos la ruta del directorio privado.
	# Este es el directorio con permisos de escritura.
	$ruta = 'info';
	if (isset($_GET['t']) and $_GET['t']==1){$ruta="tareas";}
	
	# El nombre del archivo que se desea servir, lo obtendremos
	# mediante el parámetro 'file' que luego será pasado por la URI
	$file = isset($_GET['file']) ? "$ruta/{$_GET['file']}" : NULL;

	# Verificamos el valor de $file
	# Si no es NULL, verificamos si el archivo existe antes de proceder
	//echo $file;
	if(!is_null($file)) {
		if(file_exists($file)) {
		# Creamos un recurso fileinfo para obtener el tipo MIME
		//$resource = finfo_open(FILEINFO_MIME_TYPE);
		# Obtenemos el tipo MIME

		$mimetype = mm_type($file);
		# Cerramos el recurso
		//finfo_close($resource);
		# Modificamos los encabezados HTTP
		header("Content-Type: $mimetype");
		header('Content-Disposition: attachment; filename="' . $file . '"');
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');
		header('Cache-Control: private');
		header('Pragma: private');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		# Leemos y mostramos el archivo
		readfile($file);
		}
	}
}

function mm_type($filename) {

		$mime_types = array(

			'txt' => 'text/plain',
			'htm' => 'text/html',
			'html' => 'text/html',
			'php' => 'text/html',
			'css' => 'text/css',
			'js' => 'application/javascript',
			'json' => 'application/json',
			'xml' => 'application/xml',
			'swf' => 'application/x-shockwave-flash',
			'flv' => 'video/x-flv',

			// images
			'png' => 'image/png',
			'jpe' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpg' => 'image/jpeg',
			'gif' => 'image/gif',
			'bmp' => 'image/bmp',
			'ico' => 'image/vnd.microsoft.icon',
			'tiff' => 'image/tiff',
			'tif' => 'image/tiff',
			'svg' => 'image/svg+xml',
			'svgz' => 'image/svg+xml',

			// archives
			'zip' => 'application/zip',
			'rar' => 'application/x-rar-compressed',
			'exe' => 'application/x-msdownload',
			'msi' => 'application/x-msdownload',
			'cab' => 'application/vnd.ms-cab-compressed',

			// audio/video
			'mp3' => 'audio/mpeg',
			'qt' => 'video/quicktime',
			'mov' => 'video/quicktime',

			// adobe
			'pdf' => 'application/pdf',
			'psd' => 'image/vnd.adobe.photoshop',
			'ai' => 'application/postscript',
			'eps' => 'application/postscript',
			'ps' => 'application/postscript',

			// ms office
			'doc' => 'application/msword',
			'rtf' => 'application/rtf',
			'xls' => 'application/vnd.ms-excel',
			'ppt' => 'application/vnd.ms-powerpoint',

			//ms office new
			'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
			'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
			'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
			'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
			'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
			'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
			'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',

			// open office
			'odt' => 'application/vnd.oasis.opendocument.text',
			'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
		);

		$value = explode(".", $filename);
		$ext = strtolower(array_pop($value));
		if (array_key_exists($ext, $mime_types)) {
			return $mime_types[$ext];
		}
		elseif (function_exists('finfo_open')) {
			$finfo = finfo_open(FILEINFO_MIME);
			$mimetype = finfo_file($finfo, $filename);
			finfo_close($finfo);
			return $mimetype;
		}
		else {
			return 'application/octet-stream';
		}
	}
?>