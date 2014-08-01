<?php
class mailingController{
	public static function getListAction($reg = 0, $filtro = ""){
		$mailing = new mailing();
		$filtro .= "  ORDER BY id_message DESC";
		$paginator_items = PaginatorPages($reg);
		
		$total_reg = $mailing->countReg("mailing_messages",$filtro); 
		return array('items' => $mailing->getMessages($filtro.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $paginator_items['find_reg'],
					'total_reg' => $total_reg);
	}

	public static function createUserAction(){
		if (isset($_POST['template_message']) and $_POST['template_message']>0){
			$mailing = new mailing();
			global $ini_conf;	
			$fichero = isset($_FILES['nombre-fichero']) == true ? $_FILES['nombre-fichero'] : null ; 
			$nombre_lista = ($_POST['tipo-lista']=='fichero') ? $fichero['name'] : $_POST['id_list'];
			$date_scheduled = ((isset($_REQUEST['a']) and $_REQUEST['a']==1) ? "'".$_POST['user-date']."'" : "NULL" );
	
			//datos de la plantilla
			$html_content = $mailing->getTemplates(" AND id_template=".$_POST['template_message']);

			$user_direccion = "";
			if (isset($_POST['calle_direccion']) and $_POST['calle_direccion']!=""){ $user_direccion .= $_POST['calle_direccion'];}
			if (isset($_POST['postal_direccion']) and $_POST['postal_direccion']!=""){ $user_direccion .= " - ".$_POST['postal_direccion'];}
			if (isset($_POST['poblacion_direccion']) and $_POST['poblacion_direccion']!=""){ $user_direccion .= " - ".$_POST['poblacion_direccion'];}
			if (isset($_POST['provincia_direccion']) and $_POST['provincia_direccion']!=""){ $user_direccion .= " - ".$_POST['provincia_direccion'];}
			if (isset($_POST['telefono_direccion']) and $_POST['telefono_direccion']!=""){ $user_direccion .= "<br />Tlf.:  ".$_POST['telefono_direccion'];}
			if (isset($_POST['email_message']) and $_POST['email_message']!=""){ $user_direccion .= "<br />".$_POST['email_message'];}
			if (isset($_POST['web_direccion']) and $_POST['web_direccion']!=""){ $user_direccion .= "<br />".$_POST['web_direccion'];}

			$content = $html_content[0]['template_body'];
			$content = str_replace('[USER_DIRECCION]', $user_direccion, $content);
			$content = str_replace('[USER_EMPRESA]', $_SESSION['user_empresa'], $content);
			$content = str_replace('[USER_LOGO]', '<img src="'.$ini_conf['SiteUrl'].'/images/usuarios/'.$_SESSION['user_foto'].'" />', $content);

			
			if (isset($_POST['claim_promocion']) and $_POST['claim_promocion']!=""){ $content = str_replace('[CLAIM_PROMOCION]', $_POST['claim_promocion'], $content);}
			if (isset($_POST['descuento_promocion']) and $_POST['descuento_promocion']!=""){ $content = str_replace('[DESCUENTO_PROMOCION]', $_POST['descuento_promocion'], $content);}
			if (isset($_POST['date_promocion']) and $_POST['date_promocion']!=""){ $content = str_replace('[DATE_PROMOCION]', $_POST['date_promocion'], $content);}

			if ($mailing->insertMessage($_POST['template_message'],
						$_POST['email_message'],
						$_POST['nombre_message'],
						$_POST['asunto_message'],
						$content,
						$nombre_lista,
						$_SESSION['user_name'],
						null, $date_scheduled, "")) {


				$mensaje = "Mensaje creado correctamente. Ya puedes procesar el envío.";
				$id_message=$mailing->SelectMaxReg("id_message","mailing_messages","");
				 
		    	if ($_POST['tipo-lista']=='fichero'){

					//SUBIR FICHERO		
					$nombre_archivo = time().'_'.str_replace(" ","_",$fichero['name']);
					$nombre_archivo=NormalizeText($nombre_archivo);	
					$tipo_archivo = strtoupper(substr($fichero['name'], strrpos($fichero['name'],".") + 1));
					$tamano_archivo = $fichero['size'];
					//compruebo si las características del archivo son las que deseo
					if ($tipo_archivo!="XLS") {
						$mensaje = "La extensión no es correcta.".$tipo_archivo;
						session::setFlashMessage( 'actions_message', $mensaje, "alert alert-danger"); 
			    		redirectURL("?page=user-message&act=new&id=".$_POST['template_message']);
					}else{
						if (move_uploaded_file($fichero['tmp_name'], 'docs/cargas/'.$nombre_archivo)){
							//BORRAR FICHEROS ANTIGUOS
							//rmdirtree('docs/cargas',$archivo_destino);
							
							require_once 'docs/reader.php';
							$data = new Spreadsheet_Excel_Reader();
							$data->setOutputEncoding('CP1251');
							$data->read('docs/cargas/'.$nombre_archivo);
							$respuesta_black = self::volcarMySQL($data, $id_message);					

						}
						else{ 
							$mensaje =  "Ocurrió algú;n error al subir el fichero. No pudo guardarse.";
							session::setFlashMessage( 'actions_message', $mensaje, "alert alert-danger"); 
			    			redirectURL("?page=user-message&act=new&id=".$_POST['template_message']);
						} 
					}
				}
				elseif($_POST['tipo-lista']=='lista'){
					$respuesta_black = self::volcarLista($id_message, $_POST['id_list']);
				}
	   

				//actualizar total de emails a enviar
				$msgs_total = connection::countReg("mailing_messages_users"," AND id_message=".$id_message);
				$mailing->updateMessageField($id_message, "total_messages", $msgs_total);
				$mailing->updateMessageField($id_message, "total_pending", $msgs_total);

				if (isset($_REQUEST['a']) and $_REQUEST['a']==1){
					//redireccion a agenda de mensaje
					$mensaje ="Envio programado correctamente. Si lo deseas puedes crear más envios.";
					$mensaje = ($respuesta_black==true) ? $mensaje." Algunos destinatarios no se han cargado por que han solicitado la baja del servicio." : $mensaje;
					session::setFlashMessage( 'actions_message', $mensaje, "alert alert-success");
					redirectURL("?page=user-message&act=new&a=2&id=".$_POST['template_message']);
				}
				else{
					//redireccion a precesamiento del mensaje
					$mensaje ="Envio creado correctamente.";
					$mensaje = ($respuesta_black==true) ? $mensaje." Algunos destinatarios no se han cargado por que han solicitado la baja del servicio." : $mensaje;
					session::setFlashMessage( 'actions_message', $mensaje, "alert alert-success");
					redirectURL("?page=admin-message-proccess&id=".$id_message);	
				}	
		    	
			}
			else{
				$mensaje = "Error al crear mensaje.";
				session::setFlashMessage( 'actions_message', $mensaje, "alert alert-danger"); 
		    	redirectURL("?page=user-message&act=new&id=".$_POST['template_message']);
			}
		}
	}	

	function volcarMySQL($data, $id_message)
	{			
	    $mailing = new mailing();
	    $respuesta = false;
	    for($fila=2;$fila<=$data->sheets[0]['numRows'];$fila += 1){
			$username=trim(strtolower($data->sheets[0]['cells'][$fila][1]));
			//verificar es un email valido
			if(ValidateEmail($username)){
				//verificar no este mas de una vez
				if ($mailing->countReg("mailing_messages_users"," AND id_message=".$id_message." AND email_message='".$username."' ")==0){
					//verificar no este en la lista negra
					if ($mailing->countReg("mailing_blacklist"," AND email_black='".$username."' ")==0){
						if ($username!="") $mailing->insertMessageUser($id_message,"",$username);	
					}
					else{ $respuesta = true;}		
				}	
			}	
	    }
	    return $respuesta;
		
	} 

	function volcarLista($id_message, $id_list)
	{			
	    $mailing = new mailing();
	    $respuesta = false;
	    $elements = $mailing->getListsUsers(" AND id_list=".$id_list." ");
	    foreach($elements as $element):
			$username=trim(strtolower($element['email']));
			//verificar es un email valido
			if(ValidateEmail($username)){
				//verificar no este mas de una vez
				if ($mailing->countReg("mailing_messages_users"," AND id_message=".$id_message." AND email_message='".$username."' ")==0){
					//verificar no este en la lista negra
					if ($mailing->countReg("mailing_blacklist"," AND email_black='".$username."' ")==0){
						if ($username!="") $mailing->insertMessageUser($id_message,"",$username);	
					}
					else{ $respuesta = true;}		
				}
			}
	    endforeach;
	    return $respuesta;
		
	} 

	public static function createAction(){
		$mailing = new mailing();
		$lista = $_POST['lista_message'];

		$nombre_lista = $lista;
		if (trim($lista) == "lista curso"){ $nombre_lista = $_POST['lista_curso_sel']; }
		if (trim($lista) == "lista tienda"){ $nombre_lista = $_POST['lista_tienda_sel']; }
		if (trim($lista) == "lista tienda tipo"){ $nombre_lista = $_POST['lista_tienda_tipo_sel']; }
		if (trim($lista) == "lista usuarios"){ $nombre_lista = $_POST['lista_users']; }
		$fichero = isset($_FILES['nombre-fichero']) == true ? $_FILES['nombre-fichero'] : null ; 
		if ($mailing->insertMessage($_POST['template_message'],
					$_POST['email_message'],
					$_POST['nombre_message'],
					$_POST['asunto_message'],
					nl2br($_POST['texto_message']),
					$nombre_lista,
					$_SESSION['user_name'],
					$fichero)) {


			$mensaje = "Mensaje creado correctamente. Ya puedes procesar el envío.";
			$id_message=$mailing->SelectMaxReg("id_message","mailing_messages","");
			session::setFlashMessage( 'actions_message', $mensaje, "alert alert-success"); 
	    	
			//obtener usuarios de la lista seleccionada para insertar mensajes
			$users = new users();
			$na_areas = new na_areas();
			switch ($lista) {
			    case "lista todos":
			    	$usuarios = $users->getUsers(" AND registered=1 AND confirmed=1 AND disabled=0 AND email NOT IN (SELECT email_black FROM mailing_blacklist) ");
			    	foreach($usuarios as $usuario):
			    		$mailing->insertMessageUser($id_message,$usuario['username'],$usuario['email']);
			    	endforeach;        
			        break;
			    case "lista comerciales":
			    	$usuarios = $users->getUsers(" AND registered=1 AND confirmed=1 AND disabled=0 AND perfil='usuario' AND email NOT IN (SELECT email_black FROM mailing_blacklist) ");
			    	foreach($usuarios as $usuario):
			    		$mailing->insertMessageUser($id_message,$usuario['username'],$usuario['email']);
			    	endforeach;  
			        break;
			    case "lista responsables":
			    	$usuarios = $users->getUsers(" AND registered=1 AND confirmed=1 AND disabled=0 AND perfil='responsable' AND email NOT IN (SELECT email_black FROM mailing_blacklist) ");
			    	foreach($usuarios as $usuario):
			    		$mailing->insertMessageUser($id_message,$usuario['username'],$usuario['email']);
			    	endforeach;  
			        break;
			    case "lista regionales":
			    	$usuarios = $users->getUsers(" AND registered=1 AND confirmed=1 AND disabled=0 AND perfil='regional' AND email NOT IN (SELECT email_black FROM mailing_blacklist) ");
			    	foreach($usuarios as $usuario):
			    		$mailing->insertMessageUser($id_message,$usuario['username'],$usuario['email']);
			    	endforeach;  
			    	break;
			    case "lista sede":
			    	$usuarios = $users->getUsers(" AND registered=1 AND confirmed=1 AND disabled=0 AND perfil='sede' AND email NOT IN (SELECT email_black FROM mailing_blacklist) ");
			    	foreach($usuarios as $usuario):
			    		$mailing->insertMessageUser($id_message,$usuario['username'],$usuario['email']);
			    	endforeach;  
			    	break;			    	
			    case "lista curso":
			    	//lista de curso
			    	$lista_sel = $_POST['lista_curso_sel'];
			    	$curso_sel = str_replace("lista curso : ", "", $lista_sel);
			    	$usuarios = $na_areas->getAreasUsers(" AND u.registered=1 AND u.confirmed=1 AND u.disabled=0 AND nu.id_area=".$curso_sel." AND u.email NOT IN (SELECT email_black FROM mailing_blacklist) ");
			    	foreach($usuarios as $usuario):
			    		$mailing->insertMessageUser($id_message,$usuario['username'],$usuario['email']);
			    	endforeach;  
			    	break;
			    case "lista tienda":
			    	//lista tienda
			    	$tienda_sel = $_POST['lista_tienda_sel'];
			    	$tienda_sel = str_replace("lista tienda : ", "", $tienda_sel);
			    	$usuarios = $users->getUsers(" AND registered=1 AND confirmed=1 AND disabled=0 AND empresa='".$tienda_sel."' AND email NOT IN (SELECT email_black FROM mailing_blacklist) ");
			    	foreach($usuarios as $usuario):
			    		$mailing->insertMessageUser($id_message,$usuario['username'],$usuario['email']);
			    	endforeach;

			    	//ademas añadimos al responsable de la tienda
			    	$responsable_tienda = $users->getTiendas(" AND cod_tienda='".$tienda_sel."' ");
			    	if (count($responsable_tienda)>0){
			    		$user_responsable = $users->getUsers(" AND registered=1 AND confirmed=1 AND disabled=0 AND username='".$responsable_tienda[0]['responsable_tienda']."' AND email NOT IN (SELECT email_black FROM mailing_blacklist) ");
			    		if (count($user_responsable)>0){
			    			$mailing->insertMessageUser($id_message,$user_responsable[0]['username'],$user_responsable[0]['email']);	
			    		}
			    	}
			    	break;
			    case "lista tienda tipo":
			    	//lista tipo tienda
			    	$tienda_sel = $_POST['lista_tienda_tipo_sel'];
			    	$tienda_sel = str_replace("lista tienda tipo : ", "", $tienda_sel);
			    	$usuarios = $users->getUsers(" AND registered=1 AND confirmed=1 AND disabled=0 AND t.tipo_tienda='".$tienda_sel."' AND email NOT IN (SELECT email_black FROM mailing_blacklist) ");
			    	foreach($usuarios as $usuario):
			    		$mailing->insertMessageUser($id_message,$usuario['username'],$usuario['email']);
			    	endforeach;
			    	break;			    	
			    case "lista usuarios":
			    	$usuarios_envio = explode(",", $_POST['lista_users']);
			    	$usuarios_envio = implode("','", $usuarios_envio);
			    	$usuarios_envio = "'".str_replace(" ", "", $usuarios_envio)."'";
			    	$usuarios = $users->getUsers(" AND registered=1 AND confirmed=1 AND disabled=0 AND username IN (".$usuarios_envio.") AND email NOT IN (SELECT email_black FROM mailing_blacklist) ");
			    	foreach($usuarios as $usuario):
			    		$mailing->insertMessageUser($id_message,$usuario['username'],$usuario['email']);
			    	endforeach;  
			        break;			    	
			    default:
			    	die();
			}

			//actualizar total de emails a enviar
			$msgs_total = connection::countReg("mailing_messages_users"," AND id_message=".$id_message);
			$mailing->updateMessageField($id_message, "total_messages", $msgs_total);
			$mailing->updateMessageField($id_message, "total_pending", $msgs_total);

	    	redirectURL("?page=admin-message-proccess&id=".$id_message);
		}
		else{
			$mensaje = "Error al crear mensaje.";
			session::setFlashMessage( 'actions_message', $mensaje, "alert alert-danger"); 
	    	redirectURL("?page=admin-message&act=new");
		}
	}

	public static function updateAction(){
		$mailing = new mailing();
		if ($mailing->updateMessage($_POST['id_message'],
									$_POST['template_message'],
									$_POST['email_message'],
									$_POST['nombre_message'],
									$_POST['asunto_message'],
									$_POST['texto_message'],
									$_POST['lista_message'])):
			session::setFlashMessage( 'actions_message', "Comunicación modificacda correctamente", "alert alert-success");
		else: 
			session::setFlashMessage( 'actions_message', "Se ha producido un error editando la comunicación.", "alert alert-danger");
		endif;
		
		redirectURL($_SERVER['REQUEST_URI']);	
	}

	public static function exportListAction($filtro = ""){	
		if (isset($_REQUEST['export']) and $_REQUEST['export']==true) {
			$mailing = new mailing();
			$elements = $mailing->getMessages($filtro);
			exportCsv($elements, "mensajes");
		} 
	}

	public static function exportMessageAction($filtro = ""){	
		if (isset($_REQUEST['exportm']) and $_REQUEST['exportm']==true) {
			$mailing = new mailing();
			$elements = $mailing->getMessagesUsers($filtro." AND id_message=".$_REQUEST['id']);
			exportCsv($elements,"mensajes");
		}
	}	

	public static function createBlackAction(){
		if (isset($_POST['email_black']) and $_POST['email_black']!='') {
			$mailing = new mailing();
			if ($mailing->insertBlackListUsser($_POST['email_black'])) {
				//poner los posibles mensajes pendientes como lista negra
				$mailing->updateMessageUserBlackList($_POST['email_black']);
				session::setFlashMessage( 'actions_message', "Baja realizada correctamente", "alert alert-success");
			}
			else{
				session::setFlashMessage( 'actions_message', "Ya se ha dado de baja de nuestros servicio con anterioridad.", "alert alert-danger");
			}
			redirectURL("?page=unsuscribe");
		}
	}	

	/**
	 * Para mostrar estadisticas de uso del modulo por parte de un usuario
	 * @param  	string 		$username 		Id usuario a mostrar información
	 * @return 	array           			Array con resultados
	 */
	public function userModuleStatistis($username){
		$num = connection::countReg("mailing_messages"," AND username_add='".$username."' ");
		return array('Mailing masivos' => $num);
	}

	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */	
	public static function adminMenu(){
		return array( array("LabelHeader" => 'Modules',
							"LabelSection" => 'Comunicaciones Email',
							"LabelItem" => 'Comunicaciones enviadas',
							"LabelUrl" => 'admin-messages',
							"LabelPos" => 1),
					  array("LabelHeader" => 'Modules',
							"LabelSection" => 'Comunicaciones Email',
							"LabelItem" => 'Plantillas de comunicaciones',
							"LabelUrl" => 'admin-templates',
							"LabelPos" => 2));	
	}		
}
?>