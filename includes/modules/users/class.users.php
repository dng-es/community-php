<?php
/**
* @Modulo de usuarios
* @author David Noguera Gutierrez <dnoguera@imagar.com>
* @version 1.0
* 
*/	
class users extends connection{
	
	public function getPerfiles($filter = ""){
		$Sql="SELECT DISTINCT perfil FROM users WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);  
	}

	public function getCanales($filter = ""){
		$Sql="SELECT DISTINCT canal FROM users WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);  
	}	

	public function getUsers($filter = ""){
		$Sql="SELECT u.*,t.* FROM users u  
			  LEFT JOIN users_tiendas t ON t.cod_tienda=u.empresa 
			  WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);  
	} 

	public function insertUser($username,$user_password,$email,$name_user,$confirmed,$disabled,$empresa,$canal,$perfil,$telefono,$surname,$registered=0){
		if ($perfil=='admin') {$canal='admin';}
		elseif ($perfil=='formador') {$canal='formador';}
		elseif ($perfil=='foros') {$canal='foros';}
		 
		$Sql="INSERT INTO users (username, user_password, email, name, confirmed, disabled, canal, 
			  empresa, perfil, telefono, surname, user_comentarios, registered) 
			  VALUES ('".$username."','".$user_password."','".$email."','".$name_user."',".$confirmed.",".$disabled.",
			  '".$canal."','".$empresa."','".$perfil."','".$telefono."','".$surname."','',".$registered.")";
		return connection::execute_query($Sql);
	}

	public function updateUser($username,$user_password,$email,$name_user,$confirmed,$disabled,$empresa,$canal,$perfil,$telefono,$surname,$registered){
		if ($perfil=='admin') {$canal='admin';}
		elseif ($perfil=='formador') {$canal='formador';}
		elseif ($perfil=='foros') {$canal='foros';}
		 
		$Sql="UPDATE users SET
			 user_password='".$user_password."',
			 email='".$email."',
			 name='".$name_user."',
			 confirmed=".$confirmed.",
			 disabled=".$disabled.",
			 registered=".$registered.",
			 canal='".$canal."',
			 empresa='".$empresa."',
			 perfil='".$perfil."',
			 telefono='".$telefono."',
			 surname='".$surname."'    
			 WHERE username='".$username."'";
		return connection::execute_query($Sql);
	}
	  
	public function deleteFoto($username,$foto){
		$Sql="UPDATE users SET
			 foto=''
			 WHERE username='".$username."'";
		if ($this->execute_query($Sql)){ 
			unlink(PATH_USERS_FOTO.$foto);
			return true;
		}
		else { return false;}
	}	  
	  
	public function getPuntuaciones($filter = ""){
		$Sql="SELECT u.nick,u.canal,u.empresa,p.* FROM users_puntuaciones p
			 JOIN users u ON u.username=p.puntuacion_username WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);  
	} 

	public function insertPuntuacion($puntuacion_username,$puntuacion_puntos,$puntuacion_motivo){
		$Sql="INSERT INTO users_puntuaciones (puntuacion_username, puntuacion_puntos, puntuacion_motivo) 
			  VALUES ('".$puntuacion_username."','".$puntuacion_puntos."','".$puntuacion_motivo."')";
		return connection::execute_query($Sql);
	}

	public function getHorasVuelo($filter = ""){
		$Sql="SELECT u.nick,u.canal,u.empresa,p.* FROM users_horas p
			 JOIN users u ON u.username=p.puntuacion_username WHERE 1=1 ".$filter;
		return connection::getSQL($Sql); 
	} 

	public function insertHorasVuelo($puntuacion_username,$puntuacion_puntos,$puntuacion_motivo){
		$Sql="INSERT INTO users_horas (puntuacion_username, puntuacion_puntos, puntuacion_motivo) 
			  VALUES ('".$puntuacion_username."','".$puntuacion_puntos."','".$puntuacion_motivo."')";
		return connection::execute_query($Sql);
	}      
	  
	public function getParticipaciones($filter = ""){
		$Sql="SELECT u.nick,u.canal,u.empresa,p.* FROM users_participaciones p
			 JOIN users u ON u.username=p.participacion_username WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);  
	} 

	public function insertParticipacion($participacion_username,$participacion_motivo,$valor){
			$Sql="INSERT INTO users_participaciones (participacion_username, participacion_motivo,valor) 
				  VALUES ('".$participacion_username."','".$participacion_motivo."',".$valor.")";
			return connection::execute_query($Sql);
	}	
	  
	public function sumarPuntos($username,$puntos,$motivo){	
		if ($motivo!=PUNTOS_ACCESO_SEMANA_MOTIVO and $motivo!=PUNTOS_FORO_SEMANA_MOTIVO and $motivo!='Puntos juego'){
			self::sumarParticipacion($username,$motivo,$puntos);
		}	
		if ($username!='adminresponsables'){		
			if (self::insertPuntuacion($username,$puntos,$motivo)){			
				$Sql="UPDATE users SET
					 puntos=puntos+".$puntos."
					 WHERE username='".$username."'";
				return connection::execute_query($Sql);
			}
			else { return false;}	
			}
		else { return true;}
	}

	public function sumarHorasVuelo($username,$puntos,$motivo){	
		if (self::insertHorasVuelo($username,$puntos,$motivo)) {			
			$Sql="UPDATE users SET
				 horas_vuelo=horas_vuelo+".$puntos."
				 WHERE username='".$username."'";
			return connection::execute_query($Sql);
		}
		else { return false;}
	}      
	  
	public function sumarParticipacion($username,$motivo,$puntos=0){
		if ($puntos<0) {$signo="-";$valor=-1;}
		else {$signo="+";$valor=1;}
		if (self::insertParticipacion($username,$motivo,$valor)){
			$Sql="UPDATE users SET
				 participaciones=participaciones".$signo."1
				 WHERE username='".$username."'";
			return connection::execute_query($Sql);
		}
		else { return false;}
	}

	public function restarParticipacion($username,$motivo){
		if (self::insertParticipacion($username,$motivo,-1)){
			$Sql="UPDATE users SET
				 participaciones=participaciones-1
				 WHERE username='".$username."'";
			return connection::execute_query($Sql);
		}
		else { return false;}
	}

	public function restarPuntos($username,$puntos,$motivo){
		if (self::restarParticipacion($username,$motivo)){
			if (self::insertPuntuacion($username,-$puntos,$motivo)){
				$Sql="UPDATE users SET
					 puntos=puntos-".$puntos."
					 WHERE username='".$username."'";
				if ($this->execute_query($Sql)){ return true;}
				else { return false;}
			}
			else { return false;}
		}
		else { return false;}
	}
	
	public function disableUser($username,$estado=1){
		$Sql="UPDATE users SET
			 disabled=".$estado.",
			 date_disabled=Now()
			 WHERE username='".$username."'";
		return connection::execute_query($Sql);
	}
	  
	public function confirmUser($username,$nick,$user_nombre,$user_apellidos,$user_pass,$user_email,$foto,$user_comentarios,$user_date,$movil=0){
		//verificar si el nick existe, Devolvera: 1->ok, 2-> Error SQL, 3->Nick existe,
		if (connection::countReg("users"," AND nick='".$nick."' AND username<>'".$username."' ")==0){
			 $nombre_archivo="";
			 if ($foto['name']!="") {$nombre_archivo=self::insertFoto($foto);}	
			 if ($user_date=="") {$user_date="(NULL)";}
			 else {$user_date="'".$user_date."'";}
			 
			 $Sql="UPDATE users SET
			 registered=1,
			 confirmed=1,
			 nick='".$nick."',
			 name='".$user_nombre."',
			 surname='".$user_apellidos."',
			 user_password='".$user_pass."',
			 email='".$user_email."',
			 foto='".$nombre_archivo."',
			 user_comentarios='',
			 user_date=".$user_date."
			 WHERE username='".$username."'";	

			 if (connection::execute_query($Sql)){ return 1;}
			 else { return 2;}
		}
		else { return 3;}
	}

	public function registerUser($username,$nick,$user_nombre,$user_apellidos,$user_pass,$user_email,$foto,$user_comentarios,$user_date,$user_empresa){
		$nick = str_replace("'", "´", $nick);
		$user_nombre = str_replace("'", "´", $user_nombre);
		$user_apellidos = str_replace("'", "´", $user_apellidos);
		$user_pass = str_replace("'", "´", $user_pass);
		$user_email = str_replace("'", "´", $user_email);
		$user_empresa = str_replace("'", "´", $user_empresa);

		//verificar si el nick existe, Devolvera: 1->ok, 2-> Error SQL, 3->Nick existe,
		if (connection::countReg("users"," AND nick='".$nick."' AND username<>'".$username."' ")==0){
			$nombre_archivo="";
			//verificar DNI
			if (connection::countReg("users"," AND username='".$username."' ")==0){
				//verificar codigo de tienda
				if (connection::countReg("users_tiendas"," AND cod_tienda='".$user_empresa."' ")>0){
					if ($foto['name']!="") {$nombre_archivo=self::insertFoto($foto);}	
					if ($user_date=="") {$user_date="(NULL)";}
					else {$user_date="'".$user_date."'";}

					$perfil = 'usuario';
					$canal = CANAL1;
				 
					$Sql="INSERT INTO users (username,nick, user_password, email, name, confirmed, disabled, canal, 
						  empresa, perfil,surname,user_comentarios,foto,user_date) 
						  VALUES ('".$username."','".$nick."','".$user_pass."','".$user_email."','".$user_nombre."',0,0,
						  '".$canal."','".$user_empresa."','".$perfil."','".$user_apellidos."',
						  '".$user_comentarios."','".$nombre_archivo."',".$user_date.")"; 

					if (connection::execute_query($Sql)){ return 1;}
					else { return 2;}
				}
				else { return 4;}
			}
			else{ return 5;}
		}
		else { return 3;}
	}

	public function confirmRegistration($username,$user_email,$user_pass){		 
		$Sql="UPDATE users SET
		confirmed=1 
		WHERE sha1(username)='".$username."' AND sha1(user_password)='".$user_pass."' AND sha1(email)='".$user_email."'";	

		return connection::execute_query($Sql);
	}

	public function perfilUser($username,$nick,$user_nombre,$user_apellidos,$user_pass,$user_email,$foto,$user_comentarios,$user_date,$movil=0){
		//verificar si el nick existe, Devolvera: 1->ok, 2-> Error SQL, 3->Nick existe,
		if (connection::countReg("users"," AND nick='".$nick."' AND username<>'".$username."' ")==0){
			$nombre_archivo = "";
			$SqlFoto = "";
			if ($foto['name'] != "") {
				$nombre_archivo=self::insertFoto($foto);
				if ($nombre_archivo!="") {$SqlFoto="foto='".$nombre_archivo."',";}
			}	
						 
			if ($user_date=="") {$user_date="(NULL)";}
			else {$user_date="'".$user_date."'";}
			 
			$Sql = "UPDATE users SET
			nick='".$nick."',
			name='".$user_nombre."',
			surname='".$user_apellidos."',
			user_password='".$user_pass."',
			email='".$user_email."',
			".$SqlFoto." 
			user_comentarios='".$user_comentarios."',
			user_date=".$user_date." 
			WHERE username='".$username."'";

			if (connection::execute_query($Sql)){ 
				if ($nombre_archivo != "") {$_SESSION['user_foto'] = $nombre_archivo;}
				$_SESSION['user_nick'] = $nick;
				return 1;}
			else { return 2;}
		}
		else { return 3;}
	}

	public function deleteUser($username){
		$Sql="DELETE FROM users WHERE username='".$username."'";
		return connection::execute_query($Sql);
	}

	public function updatePassword($username,$user_password){
		$Sql="UPDATE users SET
			 user_password='".$user_password."'
			 WHERE username='".$username."'";
		return connection::execute_query($Sql);
	}
	
	public function insertFoto($fichero){
		//SUBIR FICHERO
		include_once ("includes/core/class.resizeimage.php");
		$max_size=1000000;
		$path_archivo = "images/usuarios/";
		$nombre_archivo = time().'_'.str_replace(" ","_",$fichero['name']);
		$nombre_archivo = NormalizeText($nombre_archivo);
		$ext = strtoupper(substr($nombre_archivo, strrpos($nombre_archivo,".") + 1));
		$tamano_archivo = $fichero['size'];
		$max_size_kb = $max_size/1000;
		//compruebo si las características del archivo son las que deseo		
		if (!(($ext=='GIF' || $ext=='PNG' || $ext=='JPG' || $ext=='JPEG') && ($tamano_archivo < $max_size))) {return false;}
		else{			
			//REDIMENSIONAR Y SUBIR IMAGEN
			$temp = $fichero["tmp_name"];
			$thumb = new Thumbnail($temp);
			if($thumb->error) {
				return false;
			} else {
				$thumb->resize(200);
				$nombre_sinext=substr($nombre_archivo,0,(strlen($nombre_archivo)-strlen($ext))-1);
				$thumb->save_jpg($path_archivo, $nombre_sinext);
				return $nombre_sinext.".jpeg";
			}
		}
	}
	  
	public static function posicionRanking($username){
		$Sql="SELECT rownum FROM (SELECT @rownum:=@rownum+1 AS rownum,r.* FROM 
			(SELECT * FROM users WHERE  puntos>=
			(SELECT puntos FROM users WHERE username='".$username."') AND perfil<>'admin' ORDER BY puntos DESC,username ASC) r,  
			(SELECT @rownum:=0) ro ) f WHERE username='".$username."'";
		$result=self::execute_query($Sql) or die ("SQL Error in ".$_SERVER['SCRIPT_NAME']);
		$row=self::get_result($result);
		return $row['rownum']; 
	}
	  
	public static function posicionRankingEmpresa($empresa){
		$Sql="SELECT rownum FROM (SELECT @rownum:=@rownum+1 AS rownum,r.* FROM 
			(SELECT SUM(puntos),empresa FROM users WHERE empresa<>'' AND empresa<>'comunidad' GROUP BY empresa HAVING SUM(puntos)>=
			(SELECT SUM(puntos) FROM users WHERE empresa='".$empresa."' GROUP BY empresa ORDER BY puntos DESC,empresa ASC)) r,  
			(SELECT @rownum:=0) ro ) f WHERE empresa='".$empresa."' GROUP BY empresa";
		$result=self::execute_query($Sql) or die ("SQL Error in ".$_SERVER['SCRIPT_NAME']);
		$row=self::get_result($result);
		return $row['rownum']; 
	} 
	  
	public function getPuntosEmpresa($filter = "", $extra =""){
		$Sql="SELECT empresa,SUM(puntos) AS puntos_empresa 
			  FROM users WHERE 1=1 ".$filter." 
			  GROUP BY empresa ".$extra;
		return connection::getSQL($Sql); 
	} 
	  
	public function getTotalEmpresas($filter = ""){
		$Sql="SELECT COUNT(DISTINCT empresa) AS total FROM users 
			  WHERE confirmed=1 AND disabled=0 AND empresa<>'' AND empresa<>'comunidad'";
		$result=connection::execute_query($Sql);   
		
		$users_data = array();  
		while ($user_data = connection::get_result($result)){  
		  $users_data[] = $user_data;  
		}
		return $users_data[0]['total'];  
	} 	

	public function getTiendas($filter = ""){
		$Sql="SELECT * FROM users_tiendas WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	} 

	public function getTiendasTipos($filter = ""){
		$Sql="SELECT DISTINCT(tipo_tienda) AS tipo_tienda FROM users_tiendas WHERE 1=1 ".$filter;
		return connection::getSQL($Sql); 
	} 	  

	public function getUsersSucursales($filter = ""){
		$Sql="SELECT * FROM users_sucursales WHERE 1=1 ".$filter;
		return connection::getSQL($Sql); 
	} 	

	public function deteleUsersSucursales($id, $filtro){
		$Sql="DELETE FROM users_sucursales WHERE id_sucursal=".$id.$filtro;
		return connection::execute_query($Sql); 
	} 	

	public function insertUsersSucursales($name, $desc){
		$Sql="INSERT INTO users_sucursales (name_sucursal,address_sucursal,user_sucursal) VALUES ('".$name."','".$desc."','".$_SESSION['user_name']."')";
		return connection::execute_query($Sql); 
	} 			  

	public function updateLastAccess($username){
		$Sql="UPDATE users SET last_access=NOW() WHERE username='".$username."'";
		return connection::execute_query($Sql); 
	}	

	public function getUsersConn($filter = "") {
		$Sql="SELECT u.* FROM users_connected c 
			  LEFT JOIN users u ON u.username=c.username 
			  WHERE FROM_UNIXTIME(UNIX_TIMESTAMP(connection_time)+".SESSION_MAXTIME.")>NOW() ".$filter;
		return connection::getSQL($Sql);
	}  
		  
	public function insertUserConn($username,$connection_canal){
		if ($username<>''){		 
			$Sql="INSERT INTO users_connected (username,connection_canal) 
				  VALUES ('".$username."','".$connection_canal."')";
			return connection::execute_query($Sql);
		}
	}

	public function deleteUserConn($username){		  
		$Sql="DELETE FROM users_connected
			 WHERE username='".$username."'";
			 
		return connection::execute_query($Sql);
	}		
}
?>