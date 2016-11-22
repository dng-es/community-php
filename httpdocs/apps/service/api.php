<?php
set_time_limit(0);
require_once("json.php");


//funciones de la comunidad
include_once("../../app/core/class.connection.php");
include_once("../../app/core/class.connection.mysqli.php");
include_once("../../app/modules/configuration/classes/class.configuration.php");
include_once("../../app/core/functions.php");
include_once("../../app/core/constants.php");

class API {
	public $data = "";
	const DB_SERVER = "localhost";

	private $db = NULL;
	private $db_user = "";
	private $db_password = "";
	private $db_name = "";
	private $contact_email = "";
	private $site_name = "";
	private $site_url = "";	
	private $appVersion = "";


	public $_allow = array();
	public $_content_type = "application/json";
	public $_request = array();

	private $_method = "";		
	private $_code = 200;

	public function __construct(){
		$this->inputs();

		global $ini_conf;
		$this->db_user = $ini_conf['user'];
		$this->db_password = $ini_conf['pass'];
		$this->db_name = $ini_conf['db'];
		$this->contact_email = $ini_conf['ContactEmail'];
		$this->site_name = $ini_conf['SiteName'];
		$this->site_url = $ini_conf['SiteUrl'];
		$this->appVersion = "1.00.01";
		$this->dbConnect();// Initiate Database connection
	}

	public function get_referer(){
		return $_SERVER['HTTP_REFERER'];
	}

	public function response($data,$status){
		$this->_code = ($status)?$status:200;
		$this->set_headers(strlen($data));
		echo $data;
		exit;
	}

	private function get_status_message(){
		$status = array(
					100 => 'Continue',  
					101 => 'Switching Protocols',  
					200 => 'OK',
					201 => 'Created',  
					202 => 'Accepted',  
					203 => 'Non-Authoritative Information',  
					204 => 'No Content',  
					205 => 'Reset Content',  
					206 => 'Partial Content',  
					300 => 'Multiple Choices',  
					301 => 'Moved Permanently',  
					302 => 'Found',  
					303 => 'See Other',  
					304 => 'Not Modified',  
					305 => 'Use Proxy',  
					306 => '(Unused)',  
					307 => 'Temporary Redirect',  
					400 => 'Bad Request',  
					401 => 'Unauthorized',  
					402 => 'Payment Required',  
					403 => 'Forbidden',  
					404 => 'Not Found',  
					405 => 'Method Not Allowed',  
					406 => 'Not Acceptable',  
					407 => 'Proxy Authentication Required',  
					408 => 'Request Timeout',  
					409 => 'Conflict',  
					410 => 'Gone',  
					411 => 'Length Required',  
					412 => 'Precondition Failed',  
					413 => 'Request Entity Too Large',  
					414 => 'Request-URI Too Long',  
					415 => 'Unsupported Media Type',  
					416 => 'Requested Range Not Satisfiable',  
					417 => 'Expectation Failed',  
					500 => 'Internal Server Error',  
					501 => 'Not Implemented',  
					502 => 'Bad Gateway',  
					503 => 'Service Unavailable',  
					504 => 'Gateway Timeout',  
					505 => 'HTTP Version Not Supported');
		return ($status[$this->_code])?$status[$this->_code]:$status[500];
	}

	public function get_request_method(){
		return $_SERVER['REQUEST_METHOD'];
	}

	private function inputs(){
		switch($this->get_request_method()){
			case "POST":
				$this->_request = $this->cleanInputs($_POST);
				//$this->_request = $_POST;
				//$this->request['params'] = array_merge($_POST, $_GET);
				break;
			case "GET":
			case "DELETE":
				$this->_request = $this->cleanInputs($_GET);
				break;
			case "PUT":
				//parse_str(file_get_contents("php://input"),$this->_request);
				$this->_request = $this->cleanInputs($this->_request);
				break;
			default:
				$this->response('',406);
				break;
		}
	}		

	private function cleanInputs($data){
		$clean_input = array();
		if(is_array($data)){
			foreach($data as $k => $v){
				$clean_input[$k] = $this->cleanInputs($v);
			}
		}else{
			if(get_magic_quotes_gpc()){
				$data = trim(stripslashes($data));
			}
			$data = strip_tags($data);
			$clean_input = trim($data);
		}
		return $clean_input;
	}		

	private function set_headers($len){
		header("HTTP/1.1 ".$this->_code." ".$this->get_status_message());
		header("Content-Type:".$this->_content_type . "; charset=UTF-8");
		header('Content-length: ' . $len);
	}

	//Database connection
	private function dbConnect(){
		//$this->db = mysql_connect(self::DB_SERVER,$this->db_user,$this->db_password);
		$this->db = mysqli_connect(self::DB_SERVER, $this->db_user, $this->db_password, $this->db_name);
		mysqli_set_charset($this->db,'utf8');
		//if($this->db) mysql_select_db($this->db_name,$this->db);	
	}

	public function getQuery($sql)	{
		return mysqli_query($this->db, $sql);		
	}

	public static function genRandomString($length = 20) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
	    $string = '';
	    for ($p = 0; $p < $length; $p++) {
	        $string .= $characters[mt_rand(0, strlen($characters))];
	    } 
	    return $string;
	}

	private function validateEmail($email){
		$res = ereg(
		'^[a-z]+([\.]?[a-z0-9_-]+)*@'.//user
		'[a-z0-9]+([\.-]+[a-z0-9]+)*\.[a-z]{2,}$', //server.
		$email);
		return $res;
	}

	private function sendEmail($from_mail,$to_mail,$subject_mail,$body_mail,$html_mode = 0,$from_mail_real = ''){
		$headers_mail = "";
		if ($html_mode == 1) {
			$headers_mail .= "MIME-Version: 1.0\r\n";
			$headers_mail .= "Content-type: text/html; charset=utf8\r\n";
		}	
		$headers_mail .= "From: ".$from_mail_real." <".$from_mail.">\r\n";
		//$headers_mail .= 'From: '.$from_mail_real.' <'.$from_mail.'>\nReply-To: '.$from_mail.'\nX-Mailer: PHP/' . phpversion();
		if (mail($to_mail,$subject_mail,$body_mail,$headers_mail)) return true;
	}

	public function checkSesId($ses_id = '',$username = ""){
		$sql = "SELECT * FROM users_login WHERE ses_id = '".$ses_id."' AND username='".$username."' LIMIT 1";
		$query = $this->getQuery($sql);
		$filas = mysqli_num_rows($query);
		if(mysqli_num_rows($query) > 0) return true;
		else return false;
	}

	private function getAppVersion(){
		// Cross validation if the request method is POST else it will return "Not Acceptable" status
		if($this->get_request_method() != "GET"){ $this->response('',406);}	
		//get data sent
		$ses_id = $_GET['ses_id'];
		$user = $_GET['user'];

		// Session validation
		if ($this->checkSesId($ses_id,$user)){
			// Input validations

			// If success everythig is good send header as "OK" and user details
			$respuesta = array('status' => "ok", "msg" => $this->appVersion, "android" =>$this->appDownloadAndroid, "ios" =>$this->appDownloadIOS);
			$this->response($this->json($respuesta), 200);

			// If invalid inputs "Bad Request" status message and reason
			$error = array('status' => "Failed", "msg" => "Error al obtener datos");
			$this->response($this->json($error), 400);
		}
		else{
			$error = array('status' => "Failed", "msg" => "Sesion incorrecta");
			$this->response($this->json($error), 400);		
		}
	}


	
	//Encode array into JSON
	// private function json($data)	{
	// 	if(is_array($data)){return json_encode($data);}
	// }

	//Decode JSON into array
	// private function jsonDecode($data){
	// 	return json_decode($data,true);
	// }


    public function jsonDecode($content, $assoc=false){
        require_once 'json.php';
        if ( $assoc ){
                    $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
        } else {
                    $json = new Services_JSON;
                }
        return $json->decode($content);
    }



    public function json($content){
        require_once 'json.php';
        $json = new Services_JSON;
        
        $content = $json->encode($content);
        //correción bug falta } al final del json
        if (substr($content, 0,1) == "{"){
        	$content = substr($content, (strlen($content)-1),1) == "}" ? $content : ($content."}");		
        }
        return $content." ";
    }


	private function my_utf8_decode($string){
		
		$string = str_replace("â€¦", '...', $string);
		$string = str_replace("œ", '', $string);
		$string = str_replace("â€", '"', $string);
		
		$string = str_replace("ðŸ˜€", '', $string);
		$string = str_replace("Ã“", 'O', $string);
		$string = utf8_decode(str_replace("â‚¬", "EUR", $string));
		
		//$string = utf8_decode(str_replace("â‚¬", "EUR", $string));
		//$string = iconv("utf-8", "ISO-8859-15//IGNORE", $string);
		//$string = iconv("UTF-8", "LATIN1", $string);
		
		return $string;	
	}
}

// Initiiate Library
// $api = new API;
// $api->processApi();
?>
