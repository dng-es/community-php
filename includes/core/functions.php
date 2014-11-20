<?php
/**
 * Print HTML message Error
 * @param 	string  	$msg      		Message text
 * @param 	integer 	$msg_show 		Opción para mostrar o no alertas
 */
function ErrorMsg($msg,$msg_show = 1){
	if ($msg_show == 1) {echo '<div class="alert alert-danger">'.$msg.'</div>';}
}

/**
 * Print HTML message OK
 * @param 	string  	$msg      		Message text
 * @param 	integer 	$msg_show 		Opción para mostrar o no alertas
 */
function OkMsg($msg,$msg_show = 1){
	if ($msg_show == 1) {echo '<div class="alert alert-success">'.$msg.'</div>';}
}

/**
 * Eliminada de una cadena de texto los carateres extraños (todo lo que no sean numeros, letras y algún caracter más)
 * @param 	string  	$text      		Texto a normalizar
 * @param 	string  	$text_separator Caracter separador para la cadena normalizada
 * @return 	string  	        		Texto normalizado
 */
function NormalizeText( $text, $text_separator = "_") {
	//utilizada para subida de ficheros, elimina todos los caracteres extraños
	$text = strtolower($text);
	return ereg_replace( '[^ A-Za-z0-9_.-]', $text_separator, $text);
}

/**
 * Acorta un texto añadiendo puntos suspensivos
 * @param 	string 		$text_html 		Cadena de texto a acortar
 * @param 	int 		$num_car   		Numero de carateres
 * @return 	string  	        		Texto acortado con puntos suspensivos si es mas largo que $num_car
 */
function shortText($text_html,$num_car){
	if (strlen($text_html)<=$num_car) { return $text_html;}
	else { return substr(strip_tags($text_html),0,strpos(strip_tags($text_html),' ',$num_car))."...";}
}

/**
 * Devuelve una fecha formateada con el mes con texto
 * @param  	date 		$date 			Fecha a dar formato
 * @param  	string 		$format 		Formato de salida
 * @return 	string        				Fecha formateada
 */
function getDateFormat($date, $format){
	global $ini_conf;
	include(dirname(__FILE__)."/../languages/".(isset($_SESSION['language']) ? $_SESSION['language'] : $ini_conf['language'])."/options.php");
	switch ($format) {
		case 'DAY':
			return strftime($DATE_DAY,strtotime($date));
			break;
		case 'MONTH':
			return strftime($DATE_MONTH,strtotime($date));
			break;
		case 'MONTH_LONG':
			return strftime($DATE_MONTH_LONG,strtotime($date));
			break;
		case 'YEAR':
			return strftime($DATE_YEAR,strtotime($date));
			break;
		case 'SHORT':
			return strftime($DATE_FORMAT_SHORT,strtotime($date));
			break;
		case 'LONG':
			return strftime($DATE_FORMAT_LONG,strtotime($date));
			break;
		case 'TIME':
			return strftime($TIME_FORMAT,strtotime($date));
			break;
		case 'DATE_TIME':
			return strftime($DATE_TIME_FORMAT,strtotime($date));
			break;
		default:
			return $date;
			break;
	}
}

/**
 * Envia un correo empleando la función mail de PHP
 * @param 	string  	$from_mail      Email del remitente
 * @param 	string  	$to_mail        Email del destinatario
 * @param 	string  	$subject_mail   Asunto del email
 * @param 	string  	$body_mail      Cuerpo del mensaje
 * @param 	integer 	$html_mode      Formato del email: 1-> formato HTML; 0->formato texto
 * @param 	string  	$from_mail_real Nombre compleato del remitente
 * @return 	boolean  	        		Resultado del envio
 */
function SendEmail($from_mail,$to_mail,$subject_mail,$body_mail,$html_mode = 0,$from_mail_real = ''){
	$headers_mail = "";
	if ($html_mode == 1) {
		$headers_mail = "MIME-Version: 1.0\r\n";
		$headers_mail .= "Content-type: text/html; charset=utf8\r\n";
	}
	$headers_mail .= "From: ".$from_mail_real." <".$from_mail.">";
	//$headers_mail .= 'From: '.$from_mail_real.' <'.$from_mail.'>\nReply-To: '.$from_mail.'\nX-Mailer: PHP/' . phpversion();

	if (mail($to_mail,$subject_mail,$body_mail,$headers_mail)) { return true;}
}

/**
 * Funcion para obtener variables del paginador
 * @param 	int 		$reg 			Número de registros por página
 */
function PaginatorPages($reg){
	$find_reg = "";
	$pag = 1;
	$inicio = 0;
	if (isset($_GET["pag"]) and $_GET["pag"]!="") {
		$pag = $_GET["pag"];
		$inicio = ($pag - 1) * $reg;
	}
	return array('find_reg' => $find_reg,
				'pag' => $pag,
				'inicio' =>$inicio );
}

/**
 * Print HTML paginator
 * @param 	int  		$pag         	Número de página actual
 * @param 	int  		$reg         	Número de registros por página
 * @param 	int  		$total_reg   	Total de registros
 * @param 	string  	$pag_dest    	URL de destino
 * @param 	string  	$title       	Título del paginador
 * @param 	string  	$find_reg    	Cadena de busqueada. Dato que el paginador tiene que arrastrar
 * @param 	integer 	$num_paginas 	Número máximo de páginas a mostrar en el paginador
 * @param 	string  	$addClass    	Clase CSS
 */
function Paginator($pag,$reg,$total_reg,$pag_dest,$title,$find_reg="",$num_paginas=10,$addClass="", $pagecount_dest = "pag"){
	$total_pag = ceil($total_reg / $reg);
	if ($total_pag > 1){
		$reg_ini=(($pag-1)*$reg)+1;
		$reg_end=$pag*$reg;
		if ($reg_ini>$total_reg) {$reg_ini=$total_reg;}
		if ($reg_end>$total_reg) {$reg_end=$total_reg;}
		echo '<div class="pagination-centered">
				<ul class="pagination">';
		//echo '<span class="messages"> '.$title.' '.$total_reg.' ('.$reg_ini.'-'.$reg_end.')</span>';
		if(($pag - 1) > 0) { echo '<li><a href="?page='.$pag_dest.'&'.$pagecount_dest.'=1&regs='.$reg.'&f='.$find_reg.'">&laquo;</a></li>';}
		else { echo '<li class="disabled"><a href="#">&laquo;</a></li>';}
		
		$pagina_inicial=$pag-1;
		if ($pagina_inicial<=0){$pagina_inicial=1;}
		$pagina_final=$pagina_inicial+$num_paginas;
		
		if ($pag>1){ echo '<li><a href="?page='.$pag_dest.'&'.$pagecount_dest.'='.($pag-1).'&regs='.$reg.'&f='.$find_reg.'">anterior</a></li>';}
		else { echo '<li class="disabled"><a href="#">anterior</a></span></li>';}
		
		for ($i=$pagina_inicial; $i<=$pagina_final; $i++){
			if($i<=$total_pag){
				if ($pag == $i) { echo '<li class="active"><a href="#">'.$pag.'</a></li>';}
				else { echo '<li><a href="?page='.$pag_dest.'&'.$pagecount_dest.'='.$i.'&regs='.$reg.'&f='.$find_reg.'">'.$i.'</a></li>';}
			}
		}
		
		if ($pag<$total_pag){
			echo '<li><a href="?page='.$pag_dest.'&'.$pagecount_dest.'='.($pag+1).'&regs='.$reg.'&f='.$find_reg.'">siguiente</a></li>';
		}
		else { echo '<li class="disabled"><a href="#">siguiente</a></li>';}
		
		if(($pag + 1)<=$total_pag) { echo '<li><a href="?page='.$pag_dest.'&'.$pagecount_dest.'='.$total_pag.'&regs='.$reg.'&f='.$find_reg.'">&raquo;</a></li>';}
		else { echo '<li class="disabled"><a href="#">&raquo;</a></li>';}
		echo '</ul>
			</div>';
	}
}

/**
 * Envia cabeceras para eliminar cache del navegador
 */
function noCache() {
	//Incluido al principio, hace que el navegador no use cache
	header("Expires: Mon, 1 Jul 1900 00:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
}

/**
 * Valida un texto si es o no una cuenta de correo válida
 * @param 	string 		$email 			Cadena de texto a validar
 * @return 	boolean  	        		Resultado de la validación
 */
function validateEmail($email){
	$res = ereg(
	'^[a-z]+([\.]?[a-z0-9_-]+)*@'.// user
	'[a-z0-9]+([\.-]+[a-z0-9]+)*\.[a-z]{2,}$', // server.
	$email);
	return $res;
}

/**
 * Valida si una cadena es una fecha valida
 * @param  string $date   Valor a verificar
 * @param  string $format formato de la fecha
 * @return boolean         resultado de la verificacion
 */
function validateDate($date, $format = 'Y-m-d H:i:s'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

/**
 * Comprueba si una cadena es un NIF, CIF, NIE
 * @param  	string 		$cif 			Cadena de texto a verificar
 * @return 	int      					1 = NIF ok, 2 = CIF ok, 3 = NIE ok, -1 = NIF bad, -2 = CIF bad, -3 = NIE bad, 0 = ??? bad
 */
function validateNifCifNie($cif) {
	$cif = strtoupper($cif);
		
	for ($i = 0; $i < 9; $i ++){
	      $num[$i] = substr($cif, $i, 1);
	}
	//si no tiene un formato valido devuelve error
	if (!ereg('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)', $cif)){
	      return 0;
	}
	//comprobacion de NIFs estandar
	
	if (ereg('(^[0-9]{8}[A-Z]{1}$)', $cif)){
		if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 0, 8) % 23, 1)){
			return 1;
		}else {
			return -1;
		}
	}
	//algoritmo para comprobacion de codigos tipo CIF
	$suma = $num[2] + $num[4] + $num[6];
	for ($i = 1; $i < 8; $i += 2){
	      $suma += substr((2 * $num[$i]),0,1) + substr((2 * $num[$i]),1,1);
	}
	$n = 10 - substr($suma, strlen($suma) - 1, 1);
	//comprobacion de NIFs especiales (se calculan como CIFs)
	if (ereg('^[KLM]{1}', $cif)){
		if ($num[8] == chr(64 + $n)){
	         return 1;
		}else{
	         return -1;
		}
	}
	//comprobacion de CIFs
	if (ereg('^[ABCDEFGHJNPQRSUVW]{1}', $cif)){
		if ($num[8] == chr(64 + $n) || $num[8] == substr($n, strlen($n) - 1, 1)){
			return 2;
		}else{
			return -2;
		}
	}
	//comprobacion de NIEs
	//T
	if (ereg('^[T]{1}', $cif)){
		if ($num[8] == ereg('^[T]{1}[A-Z0-9]{8}$', $cif)){
			return 3;
		}else{
			return -3;
		}
	}
	//XYZ
	if (ereg('^[XYZ]{1}', $cif)){
		if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr(str_replace(array('X','Y','Z'), array('0','1','2'), $cif), 0, 8) % 23, 1)){
			return 3;
		}else{
			return -3;
		}
	}
	//si todavia no se ha verificado devuelve error
	return 0;
}	

/**
 * Convierte un array a formato csv
 * @param  array  $array 	Array a procesar
 * @return         			Array en formato cvs
 *
 * Usage: primero se envian las cabeceras para descarga
 * 
 * 		download_send_headers("data_export_" . date("Y-m-d") . ".csv");
 *		echo array2csv($elements_exp);
 *		die();
 *		
 */
function array2csv(array &$array) {
	if (count($array) == 0) {
		return null;
	}
	ob_start();
	$df = fopen("php://output", 'w');
	fputcsv($df, array_keys(reset($array)));
	foreach ($array as $row) {
		foreach(array_keys($row) as $key){
			$row[$key] = iconv("UTF-8", "Windows-1252", $row[$key]);
		}
		fputcsv($df, $row, ";");
	}
	fclose($df);
	return ob_get_clean();
}

/**
 * Envia cabeceras para descarga
 * @param  string $filename Nombre del archivo que se va a descargar
 */
function download_send_headers($filename) {
	// disable caching
	$now = gmdate("D, d M Y H:i:s");
	header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
	header("Last-Modified: {$now} GMT");

	// force download  
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");

	// disposition / encoding on response body
	header("Content-Disposition: attachment;filename={$filename}");
	header("Content-Transfer-Encoding: binary");
}

/**
 * Genera una cadena aleatoria segun el patron definido en $chars
 * @param 	int 		$num_car         Número de caracteres de la cadena a generar
 * @param 	string 		$chars           Caracteres permitidos
 * @return  string 						 Cadena generada de forma aleatoria
 */
function createRandomPassword($num_car = 7, $chars = "abcdefghijkmnopqrstuvwxyz023456789") {
	srand((double)microtime()*1000000); 
	$i = 0; 
	$pass = '' ; 
	
	while ($i <= $num_car) { 
		$num = rand() % 33; 
		$tmp = substr($chars, $num, 1); 
		$pass = $pass . $tmp; 
		$i++; 
	} 	
	return $pass; 
}

/**
 * Print HTML  search form
 * @param 	int 		$reg         	Número de registros. Empleado por paginador
 * @param 	int 		$pag         	Número de página. Empleado por paginador
 * @param 	string 		$formId      	Id del formulario HTML
 * @param 	string 		$labelForm   	Texto para el label del formulario
 * @param 	string 		$labelButton 	Texto para el botón de buscar
 * @param 	string 		$clase_css   	Clase CSS para el panel contenedor del form
 * @param 	string 		$class_form  	Clase CSS para el form
 */

function SearchForm($reg,$pag,$formId="searchForm",$labelForm="Buscar:",$labelButton="ir",$clase_css="",$class_form="", $method_form="post") {	
	$busqueda = isset($_POST['find_reg']) ? $_POST['find_reg'] : (isset($_REQUEST['f']) ? $_REQUEST['f'] : "");

	echo '<div class="'.$clase_css.'">  
			<form action="'.$pag.'&regs='.$reg.'" method="'.$method_form.'" id="'.$formId.'" class="'.$class_form.'">		  
				<div class="input-group">
					<label class="sr-only" for="find_reg">'.$labelForm.'</label>
					<input type="text" class="form-control" id="find_reg" name="find_reg" placeholder="'.$labelForm.'" value="'.$busqueda.'">
					<input type="hidden" name="registros_form" value="'.$reg.'" />
					<div class="input-group-btn">
						<button type="submit" class="btn btn-default" title="'.$labelButton.'" destino="'.$formId.'"><i class="glyphicon glyphicon-search"></i></button>
					</div>
				</div>  
			</form>
		  </div>';	
}

/**
 * Descarga un archivo
 * @param 	string 		$fichero 		Ruta completa del archivo a descargaar
 */
function DescargarArchivo($fichero){
    $basefichero = basename($fichero);
    header( "Content-Type: application/octet-stream");
    header( "Content-Length: ".filesize($fichero));
    header( "Content-Disposition:attachment;filename=" .$basefichero."");
    readfile($fichero);
}

/**
 * Print HTML combo para los temas de los foros
 * @param 	string 		$tipo_tema 		Elemento del combo marcado
 */
function ComboTiposTemas($tipo_tema){
?>
      <option value="Promociones" <?php if ($tipo_tema=='Promociones'){ echo ' selected="selected" ';}?>>Promociones</option>
      <option value="Formacion" <?php if ($tipo_tema=='Formacion'){ echo ' selected="selected" ';}?>>Formacion</option>
      <option value="Tarifas" <?php if ($tipo_tema=='Tarifas'){ echo ' selected="selected" ';}?>>Tarifas</option>

<?php	
}

/**
 * Print HTML combo para los perfiles de la comunidad
 * @param 	string 		$perfil 		Elemento del combo marcado
 */
function ComboPerfiles($perfil){
?>
	<option value="usuario" <?php if ($perfil=='usuario'){ echo ' selected="selected" ';}?>>Comercial</option>
	<option value="responsable" <?php if ($perfil=='responsable'){ echo ' selected="selected" ';}?>>Responsable</option>
	<option value="regional" <?php if ($perfil=='regional'){ echo ' selected="selected" ';}?>>Regional</option>
	<option value="sede" <?php if ($perfil=='sede'){ echo ' selected="selected" ';}?>>SEDE</option>
	<option value="admin" <?php if ($perfil=='admin'){ echo ' selected="selected" ';}?>>Administrador</option>

<?php	
}

/**
 * Print HTML combo para los canales de la comunidad
 * @param 	string 		$canal 			Elemento del combo marcado
 */
function ComboCanales($canal=""){
?>
    <option value="<?php echo CANAL1;?>" <?php if ($canal==CANAL1){ echo ' selected="selected" ';}?>><?php echo CANAL1_LABEL;?></option>
    <option value="<?php echo CANAL2;?>" <?php if ($canal==CANAL2){ echo ' selected="selected" ';}?>><?php echo CANAL2_LABEL;?></option>
<?php	
}

/**
 * Obtiene la versión del navegador según el UserAgent. 
 * Esta función hay que actualizarla según van saliendo nuevos navegadores.
 * @param  	string 		$user_agent 	UserAgent del navegador
 * @return 	string             			Nombre del navegador
 */
function getBrowser($user_agent) {
     $navegadores = array(
     	  'IExplorer 11' => 'Trident/7+',
          'IExplorer 10' => '(MSIE 10\.[0-9]+)',
          'IExplorer 9' => '(MSIE 9\.[0-9]+)',
          'IExplorer 8' => '(MSIE 8\.[0-9]+)',
          'IExplorer 7' => '(MSIE 7\.[0-9]+)',
          'IExplorer 6' => '(MSIE 6\.[0-9]+)',
          'IExplorer 5' => '(MSIE 5\.[0-9]+)',
          'IExplorer 4' => '(MSIE 4\.[0-9]+)',
          'Opera' => 'Opera',
          'Chrome' => 'Chrome',
          'Safari' => 'Safari',
          'Mozilla Firefox'=> '(Firebird)|(Firefox)',
          'Galeon' => 'Galeon',
          'Mozilla'=>'Gecko',
          'MyIE'=>'MyIE',
          'Lynx' => 'Lynx',
          'Netscape' => '(Mozilla/4\.75)|(Netscape6)|(Mozilla/4\.08)|(Mozilla/4\.5)|(Mozilla/4\.6)|(Mozilla/4\.79)',
          'Konqueror'=>'Konqueror',
	);
	foreach($navegadores as $navegador=>$pattern){
	       if (preg_match("~".$pattern."~", $user_agent))
	       return $navegador;
	    }
	return 'Otros';
}

/**
 * Obtiene el Sistema Operativo según el UserAgent del navegador
 * Esta función hay que actualizarla según van saliendo nuevos SO.
 * @param  	string 		$user_agent 	UserAgent del navegador
 * @return 	string             			Nombre del SO
 */
function getPlatform($user_agent) {
     $plataformas = array(
          'Windows 8.1' => 'Windows NT 6.3+',
          'Windows 8' => 'Windows NT 6.2+',
          'Windows 7' => 'Windows NT 6.1+',
          'Windows Vista' => 'Windows NT 6.0+',
          'Windows XP' => 'Windows NT 5.1+',
          'Windows 2003' => 'Windows NT 5.2+',
          'Windows' => 'Windows otros',          
          'iPhone' => 'iPhone',
          'iPad' => 'iPad',
          'Mac OS X' => '(Mac OS X+)|(CFNetwork+)',
          'Mac otros' => 'Macintosh',          
          'Android' => 'Android',
          'BlackBerry' => 'BlackBerry',
          'Linux' => 'Linux',
	);
	foreach($plataformas as $plataforma=>$pattern){
	       if (preg_match("/".$pattern."/", $user_agent))
	       return $plataforma;
	    }
	return 'Otras';
}

/**
 * Envia un email con Swift Mailer
 * @param  	string 		$message_subject    	Asunto del mensaje
 * @param  	array  		$message_from       	Remitente del mensaje
 * @param  	array  		$message_to         	Destinatarios del mensaje
 * @param  	string 		$message_body       	Cuerpo del mensaje
 * @param  	string 		$message_attachment 	Fichero adjunto
 * @return 	boolean                     		Resultado del envío
 */
function messageProcess($message_subject, $message_from = array('john@doe.com' => 'John Doe'), $message_to = array('receiver@domain.org', 'other@domain.org' => 'A name'), $message_body, $message_attachment = null, $message_protocol = "Mail"){
	require_once("Swift-5.1.0/lib/swift_required.php");
	if (strtolower($message_protocol) == 'smtp'){
		global $ini_conf;
		if (!$transport = Swift_SmtpTransport::newInstance($ini_conf['smtp_domain'], $ini_conf['smtp_port'])
		  ->setUsername($ini_conf['smtp_user'])
		  ->setPassword($ini_conf['smtp_pass'])) return false;
	}
	if (strtolower($message_protocol) == 'sendmail'){
		global $ini_conf;
		$transport = Swift_SendmailTransport::newInstance($ini_conf['sendmail_command']);
	}
	else{
		$transport = Swift_MailTransport::newInstance();	
	}
	

	// Create the Mailer using your created Transport
	$mailer = Swift_Mailer::newInstance($transport);

	// Create the message
	$message = Swift_Message::newInstance()
		// Give the message a subject
		->setSubject($message_subject)

		// Set the From address with an associative array
		->setFrom($message_from)

		// Set the To addresses with an associative array
		->setTo($message_to)

		// Give it a body
		->setBody($message_body, 'text/html')

		// And optionally an alternative body
		//->addPart('<q>Here is the message itself</q>', 'text/html')

		// Optionally add any attachments
  		//->attach(Swift_Attachment::fromPath('my-document.pdf'))

		//Attachemts
		//->attach(Swift_Attachment::fromPath($message_attachment))

	; 

	if ($message_attachment != ""){
		$attachment = Swift_Attachment::fromPath($message_attachment);
		// Attach it to the message
		$message->attach($attachment);
	}
	return $mailer->send($message) ;
}

/**
 * Sube un fichero a la ruta especificada
 * @param  	FILE 		$fichero 			Fichero a subir
 * @param  	string 		$destino 			Directorio donde subir el fichero. Debe ir acabado con /
 * @return 	string          				Nombre definitivo del archivo subido
 */
function uploadFileToFolder($fichero, $destino){
	$nombre_archivo = "";
	if (isset($fichero) and $fichero['name']!="") {			
		$nombre_archivo = time().'_'.str_replace(" ","_",$fichero['name']);
		$nombre_archivo = strtolower($nombre_archivo);
		$nombre_archivo=NormalizeText($nombre_archivo);		
		move_uploaded_file($fichero['tmp_name'], $destino.$nombre_archivo);
	}
	return $nombre_archivo;
}

/**
 * Convierte a PDF la cadena de texto en formato HTML
 * @param  	string 		$content 			cadena en formato HTML a convertir a PDF
 * @return 	string      $size				tamaño del PDF
 */
function HTMLtoPDF($content, $size = 'A4'){
    require_once('html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P',$size,'es');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('exemple.pdf');
}

function imgThumbnail($nombre_archivo, $path_archivo, $width, $height = 0){
	require_once ("class.resizeimage.php");		
	$thumb = new Thumbnail($path_archivo.$nombre_archivo);
	if($thumb->error) {
		return false;
	} else {
		$thumb->resize($width, $height);
		$ext = strtoupper(substr($nombre_archivo, strrpos($nombre_archivo,".") + 1));
		$nombre_sinext=substr($nombre_archivo,0,(strlen($nombre_archivo)-strlen($ext))-1);
		return $thumb->save_jpg($path_archivo, "mini".$nombre_sinext);
	}

}

/**
 * Comprime a zip el fichero especificado por $filename alojado en la ruta $path
 * @param  string 		$filename   	archivo a comprimir
 * @param  string 		$path 			ruta del archivo a comprimir
 * @return          					resultado de la verificacion
 */
function fileToZip($filename, $path){
	require_once ("class.zipfile.php");
	$zipfile = new zipfile();

	$zipfile->add_file(implode("",file($path.$filename)), $filename);

	header("Content-type: application/octet-stream");
	header("Content-disposition: attachment; filename=".$filename.".zip");
	echo $zipfile->file();
}

/**
 * Comprime a zip el fichero especificado por $filename alojado en la ruta $path
 * @param  string 		$array_files   	Array con archivos a comprimir (ruta completa). $array_files[$i][0]=>PATH; $array_files[$i][1]=>NAME_FILE
 * @return          					resultado de la verificacion
 */
function filesToZip($array_files){
	set_time_limit(0);
	ini_set("memory_limit","-1");
	require_once ("class.zipfile.php");
	$zipfile = new zipfile();

	for ($i = 0; $i <= count($array_files); $i++) {
		if (file_exists($array_files[$i][0].$array_files[$i][1])){
			$zipfile->add_file(implode("",file($array_files[$i][0].$array_files[$i][1])), $array_files[$i][1]);
		}
	}

	header("Content-type: application/octet-stream");
	header("Content-disposition: attachment; filename=downloads.zip");
	echo $zipfile->file();
}


/**
 * Limpia URL. Función de PhpList
 * @param  string $url               URL a limpiar
 * @param  array  $disallowed_params 
 * @return string                    URL limpiada
 */
function cleanUrl($url,$disallowed_params = array('PHPSESSID')) {
	$parsed = @parse_url($url);
	$params = array();

	if (empty($parsed['query'])) {
		$parsed['query'] = '';
	}
	# hmm parse_str should take the delimiters as a parameter
	if (strpos($parsed['query'],'&amp;')) {
		$pairs = explode('&amp;',$parsed['query']);
		foreach ($pairs as $pair) {
		  list($key,$val) = explode('=',$pair);
		  $params[$key] = $val;
		}
	} else {
		parse_str($parsed['query'],$params);
	}
	$uri = !empty($parsed['scheme']) ? $parsed['scheme'].':'.((strtolower($parsed['scheme']) == 'mailto') ? '':'//'): '';
	$uri .= !empty($parsed['user']) ? $parsed['user'].(!empty($parsed['pass'])? ':'.$parsed['pass']:'').'@':'';
	$uri .= !empty($parsed['host']) ? $parsed['host'] : '';
	$uri .= !empty($parsed['port']) ? ':'.$parsed['port'] : '';
	$uri .= !empty($parsed['path']) ? $parsed['path'] : '';
	#  $uri .= $parsed['query'] ? '?'.$parsed['query'] : '';
	$query = '';
	foreach ($params as $key => $val) {
		if (!in_array($key,$disallowed_params)) {
			//0008980: Link Conversion for Click Tracking. no = will be added if key is empty.
			$query .= $key . ( $val ? '=' . $val . '&' : '&' );
		}
	}
	$query = substr($query,0,-1);
	$uri .= $query ? '?'.$query : '';
	#  if (!empty($params['p'])) {
	#    $uri .= '?p='.$params['p'];
	#  }
	$uri .= !empty($parsed['fragment']) ? '#'.$parsed['fragment'] : '';
	return $uri;
}

function arraycolumn($array, $column){
	if (function_exists("array_column")){
		return array_column($array, $column);
	}
	else{
		$ret = array();
		foreach ($array as $row) $ret[] = $row[$column];
		return $ret;		
	}
}
?>