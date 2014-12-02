<?php
/**
* @Modulo para mailing masivo
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.2.1
* 
*/	
class mailing{
	private $msgs_block = 50;

	/**
	 * Devuelve $msgs_block, el valor de numero de mensaje por bloque
	 * @return 	int 								valor de $msgs_block
	 */
	public function getMsgsBlock(){
		return $this->msgs_block;
	}

	/**
	 * Establece $msgs_block, el valor de numero de mensaje por bloque
	 * @param 	int 		$value 					Valor numero de mensajes a enviar
	 */
	public function setMsgsBlock($value){
		$this->$msgs_block = $value;
	}	

	/**
	 * Mensajes creados
	 * @param  	string 		$filter 				Filtro SQL
	 * @return 	array 								Array con los mensajes
	 */
	public function getMessages($filter = "") {
		$Sql="SELECT * from mailing_messages  
			  WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);  
	}

	/**
	 * Mensajes enviados a los usuarios
	 * @param  	string 		$filter 				Filtro SQL
	 * @return 	array         						Array con los mensajes
	 */
	public function getMessagesUsersSimple($filter = "") {
		$Sql="SELECT * FROM mailing_messages_users 
			  WHERE 1=1 ".$filter;
		return connection::getSQL($Sql); 
	}

	/**
	 * Mensajes enviados a los usuarios
	 * @param  	string 		$filter 				Filtro SQL
	 * @return 	array         						Array con los mensajes
	 */
	public function getMessagesUsers($filter = "") {
		$Sql="SELECT m.*,u.name,u.surname,t.nombre_tienda FROM mailing_messages_users m 
			  LEFT JOIN users u ON u.username=m.username_message 
			  LEFT JOIN users_tiendas t ON t.cod_tienda=u.empresa
			  WHERE 1=1 ".$filter;
		return connection::getSQL($Sql); 
	}		

	/**
	 * Listas de mensajes
	 * @param  	string 		$filter 				Filtro SQL
	 * @return 	array 								Array con los templates
	 */
	public function getLists($filter = "") {
		$Sql="SELECT * from mailing_lists 
			  WHERE 1=1 ".$filter;
		return connection::getSQL($Sql); 
	}

	/**
	 * Inserta una lista
	 * @param  	string 		$name 					Nombre de la lista
	 * @param  	string 		$usuario				Usuario dueño de la lista
	 * @return 	boolean                				Resultado del proceso
	 */
	public function insertList($name,$usuario){
		$Sql="INSERT INTO mailing_lists (name_list,user_list) 
			VALUES('".$name."','".$usuario."')";
		return connection::execute_query($Sql);
	}

	/**
	 * Actualiza los datos de una lista
	 * @param  	int 		$id            			Id del registro a modificar
	 * @param  	string 		$name 					Nombre de la lista
	 * @return 	boolean                				Resultado del proceso
	 */
	public function updateList($id,$name){
		$Sql="UPDATE mailing_lists SET
			 name_list='".$name."' 
			 WHERE id_list=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Elimina una lista (borrado lógico)
	 * @param  	int 		$id            			Id del registro a modificar
	 * @return 	boolean                				Resultado del proceso
	 */	
	public function deleteList($id){
		$Sql="UPDATE mailing_lists SET
			 activo=0  
			 WHERE id_list=".$id;
		return connection::execute_query($Sql);
	}	

	/**
	 * Templates/plantillas de mensajes
	 * @param  	string 		$filter 				Filtro SQL
	 * @return 	array 								Array con los templates
	 */
	public function getListsUsers($filter = "") {
		$Sql="SELECT u.*, d.birthday FROM mailing_lists_users u 
			  LEFT JOIN mailing_lists_users_data d ON d.email=u.email
			  WHERE 1=1 ".$filter;
		return connection::getSQL($Sql); 
	}

	/**
	 * Inserta un usuario (email) en una lista
	 * @param  	int 		$id_list 				Id_list a insertar
	 * @param  	string 		$usuario				Email del usuario a insertar
	 * @return 	boolean                				Resultado del proceso
	 */
	public function insertListsUsers($id_list,$usuario){
		$Sql="INSERT INTO mailing_lists_users (id_list,email) 
			VALUES(".$id_list.",'".$usuario."')";
		return connection::execute_query($Sql);
	}	

	/**
	 * Elimina un elemento de la tabla
	 * @param  	int 		$id_list            	Id_list del usuario a eliminar
	 * @param  	string 		$filter            		Filtro a aplicar a la consulta SQL
	 * @return 	boolean                				Resultado del proceso
	 */	
	public function deleteListsUsers($id_list, $filter){
		$Sql="DELETE FROM mailing_lists_users 
			 WHERE id_list=".$id_list." ".$filter;
		return connection::execute_query($Sql);
	}

	/**
	 * Obtiene los datos de los emails (fecha de nacimiento,...)
	 * @param  	string 		$filter 				Filtro SQL
	 * @return 	array 								Array con los templates
	 */
	public function getListsUsersData($filter = "") {
		$Sql="SELECT * FROM mailing_lists_users_data 
			  WHERE 1=1 ".$filter;
		return connection::getSQL($Sql); 
	}	

	/**
	 * Inserta un email con sus datos
	 * @param  	string 		$email 					Emails de las listas
	 * @param  	date 		$birthday				Fecha de nacimiento de su email
	 * @return 	boolean                				Resultado del proceso
	 */
	public function insertListsUsersData($email,$birthday){
		$Sql="INSERT INTO mailing_lists_users_data (email,birthday) 
			VALUES('".$email."','".$birthday."')";
		return connection::execute_query($Sql);
	}		

	/**
	 * Templates/plantillas de mensajes
	 * @param  	string 		$filter 				Filtro SQL
	 * @return 	array 								Array con los templates
	 */
	public function getTemplates($filter = "") {
		$Sql="SELECT t.*,c.name_campaign AS campana,tt.name_type as tipo 
			FROM mailing_templates t 
			LEFT JOIN mailing_templates_types tt ON tt.id_type=t.id_type 
			LEFT JOIN campaigns c ON c.id_campaign=t.id_campaign 
			  WHERE 1=1 ".$filter;
		return connection::getSQL($Sql); 
	}

	/**
	 * Inserta un template
	 * @param  	string 		$template_name 			Nombre del template
	 * @param  	string 		$template_body 			Cuerpo del template
	 * @param  	string 		$template_mini 			URL de la imagen de miniatura
	 * @param  	int 		$id_type 				Id del tipo de template
	 * @param  	int 		$id_campaign 			Id de la campaña de template
	 * @return 	boolean                				Resultado del proceso
	 */
	public function insertTemplate($template_name,$template_body, $template_mini, $id_type, $id_campaign){
		$Sql="INSERT INTO mailing_templates (template_name,template_body, template_mini, id_type, id_campaign) 
			VALUES('".$template_name."','".$template_body."','".$template_mini."',".$id_type.",".$id_campaign.")";
		return connection::execute_query($Sql);
	}

	/**
	 * Actualiza el template
	 * @param  	int 		$id            			Id del registro a modificar
	 * @param  	string 		$template_name 			Nombre del template
	 * @param  	string 		$template_body 			Cuerpo del template
	 * @param  	string 		$template_mini 			URL de la imagen de miniatura
	 * @param  	int 		$id_type 				Id del tipo de template
	 * @param  	int 		$id_campaign 			Id de la campaña de template
	 * @return 	boolean                				Resultado del proceso
	 */
	public function updateTemplate($id,$template_name,$template_body, $template_mini, $id_type, $id_campaign){
		$Sql_file = ($template_mini == "") ? "" : ", template_mini='".$template_mini."' ";
		$Sql="UPDATE mailing_templates SET
			 id_type=".$id_type.",
			 id_campaign=".$id_campaign.",
			 template_name='".$template_name."', 
			 template_body='".$template_body."' 
			 ".$Sql_file."
			 WHERE id_template=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Elimina un template (borrado lógico)
	 * @param  	int 		$id            			Id del registro a modificar
	 * @return 	boolean                				Resultado del proceso
	 */
	public function deleteTemplate($id){
		$Sql="UPDATE mailing_templates SET
			 activo=2  
			 WHERE id_template=".$id;
		return connection::execute_query($Sql);
	}	

	/**
	 * Activa/Desactiva un template
	 * @param  	int 		$id            			Id del registro a modificar
	 * @param  	int 		$activo            		Nuevo estado del template
	 * @return 	boolean                				Resultado del proceso
	 */
	public function updateEstadoTemplate($id, $activo){
		$Sql="UPDATE mailing_templates SET
			 activo=".$activo."  
			 WHERE id_template=".$id;
		return connection::execute_query($Sql);
	}	

	/**
	 * Tipos de Templates/plantillas de mensajes
	 * @param  	string 		$filter 				Filtro SQL
	 * @return 	array 								Array con los templates
	 */
	public function getTemplatesTypes($filter = "") {
		$Sql="SELECT * 
			FROM mailing_templates_types 
			  WHERE 1=1 ".$filter;
		return connection::getSQL($Sql); 
	}		

	/**
	 * Inserta un mensaje
	 * @param  	int 		$id_template        	Id del template
	 * @param  	string 		$message_from_email 	Email del remitente del mensaje
	 * @param  	string 		$message_from_name  	Nombre del remitente del mensaje
	 * @param  	string 		$message_subject    	Asunto del mensaje
	 * @param  	string 		$message_body       	Cuerpo del mensaje
	 * @param  	string 		$message_lista      	Lista a la que se envia el mensaje
	 * @param  	string 		$username_add       	Usuario que crea el mensaje
	 * @param  	file 		$attachments        	Fichero adjunto
	 * @param  	string 		$message_body2       	Cuerpo del mensaje2
	 * @return 	boolean                     		Resultado del proceso
	 */
	public function insertMessage($id_template,$message_from_email, $message_from_name,$message_subject, $message_body, $message_lista, $username_add, $attachments, $date_scheduled = "NULL", $message_body2=""){
		$nombre_archivo = "";
		if ($attachments['name']!="") {
			$nombre_archivo = time().'_'.str_replace(" ","_",$attachments['name']);
			$nombre_archivo = strtolower($nombre_archivo);
			$nombre_archivo=NormalizeText($nombre_archivo);		
			move_uploaded_file($attachments['tmp_name'], PATH_MAILING."attachments/".$nombre_archivo);
		}
		$Sql="INSERT INTO mailing_messages (id_template,message_from_email, message_from_name, message_subject,message_body, message_lista, username_add,message_attachment,date_scheduled, message_body2) 
			 VALUES
			 (".$id_template.",'".$message_from_email."','".$message_from_name."','".$message_subject."','".$message_body."','".$message_lista."','".$username_add."','".$nombre_archivo."',".$date_scheduled.",'".$message_body2."')";
		return connection::execute_query($Sql);
	} 

	/**
	 * Inserta un mensaje para el usuario
	 * @param  	int 		$id_message       		Id del mensaje base
	 * @param  	string 		$username_message 		Usuario al que se va a mandar el mensaje
	 * @param  	string 		$email_message    		Email al que se ha de enviar el mensaje
	 * @return 	boolean                   			Resultado del proceso
	 */
	public function insertMessageUser($id_message,$username_message,$email_message){
		//INSERTAR REGISTRO EN LA BBDD  
		$Sql="INSERT INTO mailing_messages_users (id_message,username_message,email_message) 
			 VALUES
			 (".$id_message.",'".$username_message."','".$email_message."')";
		return connection::execute_query($Sql);
	} 	

	/**
	 * Actualiza el estado del mensaje de un usuario
	 * @param  	int 		$id_message_user 		Id del mensaje a modificar
	 * @param  	string 		$message_status  		Nuevo estado del mensaje
	 * @return 	boolean                  			Resultado del proceso
	 */
	public function updateMessageUser($id_message_user,$message_status){
		$Sql="UPDATE mailing_messages_users 
			  SET message_status='".$message_status."',
			  date_send= NOW() 
			  WHERE id_message_user=".$id_message_user;
		return connection::execute_query($Sql);
	} 

	/**
	 * Sumar una visualizacion al mensaje enviado al usuario
	 * @param  	int 		$id_message_user 		Id del mensaje a modificar
	 * @return 	boolean                  			Resultado del proceso
	 */
	public function updateMessageUserViews($id_message_user){
		$Sql="UPDATE mailing_messages_users 
			  SET views=1 
			  WHERE id_message_user=".$id_message_user;
		return connection::execute_query($Sql);
	} 	

	/**
	 * Actualiza campos de los mensajes base
	 * @param  	int 		$id_message 			Id del mensaje a modificar
	 * @param  	string 		$field      			Campo a modificar
	 * @param  	string 		$value      			Nuevo valor del campo a modificar
	 * @return 	boolean             				Resultado del proceso
	 */
	public function updateMessageField($id_message, $field, $value){
		$Sql="UPDATE mailing_messages 
			  SET ".$field."=".$value." 
			  WHERE id_message=".$id_message;
		return connection::execute_query($Sql);
	}

	/**
	 * usuarios en listas negras
	 * @param  	string 		$filter 				Filtro SQL
	 * @return 	array 								Array con los registros
	 */
	public function getBlackListUser($filter = "") {
		$Sql="SELECT * from mailing_blacklist 
			  WHERE 1=1 ".$filter;
		return connection::getSQL($Sql); 
	}	

	public function insertBlackListUsser($email_black){
		//INSERTAR REGISTRO EN LA BBDD  
		$Sql="INSERT INTO mailing_blacklist (email_black) 
			 VALUES
			 ('".$email_black."')";
		return connection::execute_query($Sql);
	} 	

	public function updateMessageUserBlackList($email_user){
		$Sql="UPDATE mailing_messages_users 
			  SET message_status='black_list' 
			  WHERE email_message='".$email_user."' AND message_status='pending' ";
		return connection::execute_query($Sql);
	}

	/**
	 * Inserta un link
	 * @param  	int 		$id_message 		Id del mensaje en el que va el link
	 * @param  	string 		$url				URL del link
	 */
	public function insertMessageLink($id_message, $url, $link_name){
		$Sql="INSERT INTO mailing_messages_links (id_message, url, link_name) 
			VALUES(".$id_message.",'".$url."','".$link_name."')";
		return connection::execute_query($Sql);
	}	

	/**
	 * Suma un click al link
	 * @param  	int 		$id_link 		Id del link en el que va el click
	 */
	public function sumMessageLink($id_link){
		$Sql="UPDATE mailing_messages_links 
			  SET clicks=clicks+1 
			  WHERE id_link=".$id_link;
		return connection::execute_query($Sql);
	}

	/**
	 * Inserta un registro en los clicks en links realizados por los usuarios
	 * @param  	int 		$id_link 			Id del link en el que se hace click
	 * @param  	string 		$username			Usuario que hace el click
	 * @param  	string 		$username_email		Usuario que hace el click
	 */
	public function insertMessageLinkUser($id_link, $username, $username_email, $id_message){
		$Sql="INSERT INTO mailing_messages_links_users (id_link, id_message, username, username_email) 
			VALUES(".$id_link.",".$id_message.",'".$username."', '".$username_email."')";
		return connection::execute_query($Sql);
	}	

	/**
	 * links de los mensajes con formato para exportar
	 * @param  	string 		$filter 				Filtro SQL
	 * @return 	array 								Array con los templates
	 */
	public function getMessageLinkUserExport($filter = "") {
		$Sql="SELECT l.username_email AS email, d.link_name AS name_link, d.url AS url_link, l.date_link AS date 
			  FROM mailing_messages_links_users l 
			  LEFT JOIN mailing_messages m ON m.id_message=l.id_message 
			  LEFT JOIN mailing_messages_links d ON d.id_link=l.id_link
			  WHERE 1=1 ".$filter;
		return connection::getSQL($Sql); 
	}		

	/**
	 * links de los mensajes
	 * @param  	string 		$filter 				Filtro SQL
	 * @return 	array 								Array con los templates
	 */
	public function getMessageLink($filter = "") {
		$Sql="SELECT * from mailing_messages_links 
			  WHERE 1=1 ".$filter;
		return connection::getSQL($Sql); 
	}			
}
?>
