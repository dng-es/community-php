<?php
class users{
	public function getPerfiles($filter = ""){
		$Sql = "SELECT DISTINCT perfil 
				FROM users 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function getCanales($filter = ""){
		$Sql = "SELECT * 
				FROM canales 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertCanal($canal, $canal_name, $theme, $canal_lan, $points_info){
		$Sql = "INSERT INTO canales (canal, canal_name, theme, canal_lan, points_info) 
				VALUES ('".$canal."','".$canal_name."', '".$theme."','".$canal_lan."',".$points_info.")";
		return connection::execute_query($Sql);
	}

	public function updateCanal($canal, $canal_name, $theme, $canal_lan, $points_info){
		$Sql = "UPDATE canales SET 
				canal_name='".$canal_name."',
				canal_lan='".$canal_lan."',
				points_info=".$points_info.",
				theme='".$theme."' 
				WHERE canal='".$canal."' ";
		return connection::execute_query($Sql);
	}
	
	public function getUsers($filter = ""){
		$Sql = "SELECT u.*,t.* 
				FROM users u  
				LEFT JOIN users_tiendas t ON t.cod_tienda=u.empresa 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function getUsersSimple($filter = ""){
		$Sql = "SELECT * 
				FROM users 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function getUsersListado($filter = ""){
		$Sql = "SELECT u.username AS Usuario,u.nick AS Nick,u.name AS Nombre,u.surname AS Apellidos,u.email AS Email,u.telefono AS Telefono, u.empresa AS IdGroup,t.nombre_tienda AS NameGroup 
				FROM users u  
				LEFT JOIN users_tiendas t ON t.cod_tienda=u.empresa 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertUser($username, $user_password, $email, $name_user, $confirmed, $disabled, $empresa, $canal, $perfil, $telefono, $surname, $registered = 0, $direccion_user = '', $ciudad_user = '', $provincia_user = '', $cpostal_user = ''){
		if ($perfil == 'admin') $canal = 'admin';
		 
		$Sql = "INSERT INTO users (username, user_password, email, name, confirmed, disabled, canal, empresa, perfil, telefono, surname, user_comentarios, registered, direccion_user, ciudad_user, provincia_user, cpostal_user) 
			  VALUES ('".$username."','".$user_password."','".$email."','".$name_user."',".$confirmed.",".$disabled.", '".$canal."','".$empresa."','".$perfil."','".$telefono."','".$surname."','',".$registered.", '".$direccion_user."', '".$ciudad_user."', '".$provincia_user."', '".$cpostal_user."')";
		return connection::execute_query($Sql);
	}

	public function insertUserCarga($username, $user_password, $email, $name_user, $confirmed, $disabled, $empresa, $canal, $perfil, $telefono, $surname, $registered = 0, $direccion_user = '', $ciudad_user = '', $provincia_user = '', $cpostal_user = '', $user_lan){
		if ($perfil == 'admin') $canal = 'admin';
		 
		$Sql = "INSERT INTO users (username, user_password, email, name, confirmed, disabled, canal, empresa, perfil, telefono, surname, user_comentarios, registered, direccion_user, ciudad_user, provincia_user, cpostal_user, user_lan) 
			  VALUES ('".$username."','".$user_password."','".$email."','".$name_user."',".$confirmed.",".$disabled.", '".$canal."','".$empresa."','".$perfil."','".$telefono."','".$surname."','',".$registered.", '".$direccion_user."', '".$ciudad_user."', '".$provincia_user."', '".$cpostal_user."','".$user_lan."')";
		return connection::execute_query($Sql);
	}	

	public function insertUserEquipo($username, $empresa, $name_user, $surname, $email, $telefono){
		$Sql = "INSERT INTO users (username, user_password, email, name, confirmed, disabled, canal, 
				empresa, perfil, telefono, surname, user_comentarios, registered) 
				VALUES ('".$username."','".$username."','".$email."','".$name_user."',0,0,
				'comercial','".$empresa."','usuario','".$telefono."','".$surname."','',0)";
		return connection::execute_query($Sql);
	}

	public function updateUserEquipo($username,$empresa){
		$Sql = "UPDATE users SET
				empresa='".$empresa."' 
				WHERE username='".$username."'"; //echo $Sql."<br />";
		return connection::execute_query($Sql);
	}

	public function reactivarUserEquipo($username, $empresa, $name_user, $surname, $email, $telefono){
		$Sql = "UPDATE users SET
				empresa='".$empresa."',
				name='".$name_user."',
				surname='".$surname."',
				email='".$email."',
				telefono='".$telefono."', 
				disabled=0  
				WHERE username='".$username."'"; //echo $Sql;
		return connection::execute_query($Sql);
	}

	public function updateUser($username, $user_password, $email, $name_user, $confirmed, $disabled, $empresa, $canal, $perfil, $telefono, $surname, $registered, $direccion_user, $ciudad_user, $provincia_user, $cpostal_user){
		if ($perfil == 'admin') $canal = 'admin';

		$Sql = "UPDATE users SET
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
			 surname='".$surname."',
			 direccion_user='".$direccion_user."',
			 ciudad_user='".$ciudad_user."',
			 provincia_user='".$provincia_user."',
			 cpostal_user='".$cpostal_user."'
			 WHERE username='".$username."'";
		return connection::execute_query($Sql);
	}

	public function deleteFoto($username, $foto){
		$Sql = "UPDATE users SET 
				foto='' 
				WHERE username='".$username."'";
		if (connection::execute_query($Sql)){
			unlink(PATH_USERS_FOTO.$foto);
			return true;
		}
		else return false;
	}

	public function getPuntuaciones($filter = ""){
		$Sql = "SELECT u.nick,u.canal,u.empresa,p.* 
				FROM users_puntuaciones p 
				JOIN users u ON u.username=p.puntuacion_username 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);  
	}

	public static function insertPuntuacion($puntuacion_username, $puntuacion_puntos, $puntuacion_motivo){
		$Sql = "INSERT INTO users_puntuaciones (puntuacion_username, puntuacion_puntos, puntuacion_motivo) 
				VALUES ('".$puntuacion_username."','".$puntuacion_puntos."','".$puntuacion_motivo."')";
		return connection::execute_query($Sql);
	}

	public function getParticipaciones($filter = ""){
		$Sql = "SELECT u.nick,u.canal,u.empresa,p.* 
				FROM users_participaciones p 
				JOIN users u ON u.username=p.participacion_username 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);  
	}

	public static function insertParticipacion($participacion_username, $participacion_motivo, $valor){
			$Sql = "INSERT INTO users_participaciones (participacion_username, participacion_motivo,valor) 
				  VALUES ('".$participacion_username."','".$participacion_motivo."',".$valor.")";
			return connection::execute_query($Sql);
	}

	public static function sumarPuntos($username, $puntos, $motivo){
		if ($motivo != PUNTOS_ACCESO_SEMANA_MOTIVO && $motivo != PUNTOS_FORO_SEMANA_MOTIVO) self::sumarParticipacion($username, $motivo, $puntos);

		if (self::insertPuntuacion($username, $puntos, $motivo)){
			$Sql = "UPDATE users SET 
					puntos=puntos+".$puntos." 
					WHERE username='".$username."'";
			return connection::execute_query($Sql);
		}
		else return false;
	}

	public static function sumarParticipacion($username, $motivo, $puntos = 0){
		if ($puntos < 0){
			$signo = "-";
			$valor = -1;
		}
		else {
			$signo = "+";
			$valor = 1;
		}
		if (self::insertParticipacion($username, $motivo, $valor)){
			$Sql = "UPDATE users SET 
					participaciones=participaciones".$signo."1 
					WHERE username='".$username."'";
			return connection::execute_query($Sql);
		}
		else return false;
	}

	public function restarParticipacion($username, $motivo){
		if (self::insertParticipacion($username, $motivo, -1)){
			$Sql = "UPDATE users SET 
					participaciones=participaciones-1 
					WHERE username='".$username."'";
			return connection::execute_query($Sql);
		}
		else return false;
	}

	public function restarPuntos($username, $puntos, $motivo){
		if (self::restarParticipacion($username,$motivo)){
			if (self::insertPuntuacion($username,-$puntos,$motivo)){
				$Sql = "UPDATE users SET 
						puntos=puntos-".$puntos." 
						WHERE username='".$username."'";
				return connection::execute_query($Sql);
			}
			else return false;
		}
		else return false;
	}

	public function disableUser($username, $estado=1){
		$Sql = "UPDATE users SET 
				disabled=".$estado.",
				date_disabled=Now() 
				WHERE username='".$username."'";
		return connection::execute_query($Sql);
	}

	public function updateUserCarga($username, $empresa, $canal){
		$Sql = "UPDATE users SET 
				empresa='".$empresa."',
				canal='".$canal."',
				disabled=0
				WHERE username='".$username."'";
		return connection::execute_query($Sql);
	}

	public function confirmUser($username, $nick, $user_nombre, $user_apellidos, $user_pass, $user_email, $foto, $user_date){
		//verificar si el nick existe, Devolvera: 1->ok, 2-> Error SQL, 3->Nick existe,
		if (connection::countReg("users"," AND nick='".$nick."' AND username<>'".$username."' ") == 0){
			$nombre_archivo = "";
			if ($foto['name'] != "") $nombre_archivo = self::insertFoto($foto);
			if ($user_date == "") $user_date = "(NULL)";
			else $user_date = "'".$user_date."'";

			$Sql = "UPDATE users SET
					registered=1,
					confirmed=1,
					date_confirmed=NOW(),
					nick='".$nick."',
					name='".$user_nombre."',
					surname='".$user_apellidos."',
					user_password='".$user_pass."',
					email='".$user_email."',
					foto='".$nombre_archivo."',
					user_comentarios='',
					user_date=".$user_date." 
					WHERE username='".$username."'";

			if (connection::execute_query($Sql)) return 1;
			else return 2;
		}
		else return 3;
	}

	public function registerUser($username, $nick, $user_nombre, $user_apellidos, $user_pass, $user_email, $foto, $user_comentarios, $user_date, $user_empresa){
		//verificar si el nick existe, Devolvera: 1->ok, 2-> Error SQL, 3->Nick existe,
		if (connection::countReg("users"," AND nick='".$nick."' AND username<>'".$username."' ") == 0){
			$nombre_archivo = "";
			//verificar DNI
			if (connection::countReg("users"," AND username='".$username."' ") == 0){
				//verificar codigo de tienda
				if (connection::countReg("users_tiendas"," AND cod_tienda='".$user_empresa."' ") > 0){
					if ($foto['name'] != "") $nombre_archivo = self::insertFoto($foto);
					if ($user_date == "") $user_date = "(NULL)";
					else $user_date = "'".$user_date."'";

					$perfil = 'usuario';
					$canal = CANAL_DEF;

					$Sql = "INSERT INTO users (username,nick, user_password, email, name, confirmed, disabled, canal, 
							empresa, perfil,surname,user_comentarios,foto,user_date) 
							VALUES ('".$username."','".$nick."','".$user_pass."','".$user_email."','".$user_nombre."',0,0,
							'".$canal."','".$user_empresa."','".$perfil."','".$user_apellidos."',
							'".$user_comentarios."','".$nombre_archivo."',".$user_date.")";

					if (connection::execute_query($Sql)) return 1;
					else return 2;
				}
				else return 4;
			}
			else return 5;
		}
		else return 3;
	}

	public function confirmRegistration($username, $user_email, $user_pass){
		$Sql = "UPDATE users SET
				confirmed=1 
				WHERE sha1(username)='".$username."' AND sha1(user_password)='".$user_pass."' AND sha1(email)='".$user_email."'";
		return connection::execute_query($Sql);
	}

	public function perfilUser($username, $nick, $user_nombre, $user_apellidos, $user_pass, $user_email, $foto, $user_comentarios, $user_date, $user_lan, $direccion_user, $ciudad_user, $provincia_user, $cpostal_user, $telefono){
		//verificar si el nick existe, Devolvera: 1->ok, 2-> Error SQL, 3->Nick existe,
		if (connection::countReg("users", " AND nick='".$nick."' AND username<>'".$username."' ") == 0){
			$nombre_archivo = "";
			$SqlFoto = "";
			if ($foto['name'] != ""){
				$tamano_archivo = $foto['size'];
				if ($tamano_archivo > 1000000) return 2;

				$nombre_archivo = self::insertFoto($foto);
				if ($nombre_archivo != "") $SqlFoto = "foto='".$nombre_archivo."',";
			}	

			if ($user_date == "") $user_date = "(NULL)";
			else $user_date = "'".$user_date."'";
			 
			$Sql = "UPDATE users SET
					nick='".$nick."',
					name='".$user_nombre."',
					surname='".$user_apellidos."',
					user_password='".$user_pass."',
					email='".$user_email."',
					user_lan='".$user_lan."',
					".$SqlFoto." 
					user_comentarios='".$user_comentarios."',
					user_date=".$user_date." 
					WHERE username='".$username."'";

			if (connection::execute_query($Sql)){ 
				if ($nombre_archivo != "") $_SESSION['user_foto'] = $nombre_archivo;
				$_SESSION['user_nick'] = $nick;
				$_SESSION['user_pass'] = $user_pass;
				return 1;
			}
			else return 2;
		}
		else return 3;
	}

	public function addressUser($username, $direccion_user, $ciudad_user, $provincia_user, $cpostal_user, $telefono){		 
		$Sql = "UPDATE users SET
				direccion_user='".$direccion_user."',
				ciudad_user='".$ciudad_user."',
				provincia_user='".$provincia_user."',
				cpostal_user='".$cpostal_user."',
				telefono='".$telefono."' 
				WHERE username='".$username."'";
		return connection::execute_query($Sql); 
	}	

	public function deleteUser($username){
		$Sql = "DELETE FROM users 
				WHERE username='".$username."'";
		return connection::execute_query($Sql);
	}

	public function updatePassword($username, $user_password){
		$Sql = "UPDATE users SET 
				user_password='".$user_password."'
				WHERE username='".$username."'";
		return connection::execute_query($Sql);
	}

	public function insertFoto($fichero){
		//SUBIR FICHERO
		include_once ("app/core/class.resizeimage.php");
		$max_size = 1000000;
		$path_archivo = "images/usuarios/";
		$ext = strtoupper(substr($fichero['name'], strrpos($fichero['name'],".") + 1));
		$nombre_archivo = time().".".$ext;
		$tamano_archivo = $fichero['size'];
		$max_size_kb = $max_size/1000;
		//compruebo si las características del archivo son las que deseo		
		if (!(($ext=='GIF' || $ext=='PNG' || $ext=='JPG' || $ext=='JPEG') && ($tamano_archivo < $max_size))) return false;
		else {
			//REDIMENSIONAR Y SUBIR IMAGEN
			$temp = $fichero["tmp_name"];
			$thumb = new Thumbnail($temp);
			if($thumb->error) return false;
			else {
				$thumb->resize(200);
				$nombre_sinext = substr($nombre_archivo, 0, (strlen($nombre_archivo) - strlen($ext)) - 1);
				$thumb->save_jpg($path_archivo, $nombre_sinext);
				return $nombre_sinext.".jpeg";
			}
		}
	}

	public static function posicionRanking($username, $filtro_canal){
		$Sql = "SELECT rownum FROM (SELECT @rownum:=@rownum+1 AS rownum,r.* FROM 
			(SELECT * FROM users WHERE  puntos>=
			(SELECT puntos FROM users WHERE username='".$username."') ".$filtro_canal." AND perfil<>'admin' ORDER BY puntos DESC,username ASC) r,  
			(SELECT @rownum:=0) ro ) f WHERE username='".$username."'";
		$result = connection::execute_query($Sql) or die ("SQL Error in ".$_SERVER['SCRIPT_NAME']);
		$row = connection::get_result($result);
		return $row['rownum'];
	}

	public static function posicionRankingEmpresa($empresa){
		$Sql = "SELECT rownum FROM (SELECT @rownum:=@rownum+1 AS rownum,r.* FROM 
					(SELECT SUM(puntos)/(SELECT COUNT(*) FROM users WHERE empresa=u1.empresa AND perfil<>'admin' AND confirmed=1 AND disabled=0) AS suma_puntos,empresa FROM users u1 WHERE empresa<>'' AND empresa<>'comunidad' AND empresa<>'0' AND perfil<>'admin' AND confirmed=1 AND disabled=0 GROUP BY empresa ) r,  
					(SELECT @rownum:=0) ro ORDER BY suma_puntos DESC) f WHERE empresa='".$empresa."' GROUP BY empresa ";
		$result = connection::execute_query($Sql) or die ("SQL Error in ".$_SERVER['SCRIPT_NAME']);
		$row = connection::get_result($result);
		return $row['rownum'];
	}

	public function getPuntosEmpresa($filter = "", $extra =""){
		$Sql = "SELECT empresa,SUM(puntos)/(SELECT COUNT(*) FROM users WHERE empresa=u.empresa AND perfil<>'admin' AND confirmed=1 AND disabled=0) AS puntos_empresa, nombre_tienda  
				FROM users u 
				LEFT JOIN users_tiendas t ON t.cod_tienda=u.empresa 
				WHERE 1=1 ".$filter." 
				GROUP BY empresa ".$extra;
		return connection::getSQL($Sql);
	}

	public function getTiendas($filter = ""){
		$Sql = "SELECT * 
				FROM users_tiendas 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function getTiendasTipos($filter = ""){
		$Sql = "SELECT DISTINCT(tipo_tienda) AS tipo_tienda 
				FROM users_tiendas 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function getUsersSucursales($filter = ""){
		$Sql = "SELECT * 
				FROM users_sucursales 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function deteleUsersSucursales($id, $filtro){
		$Sql = "DELETE FROM users_sucursales 
				WHERE id_sucursal=".$id.$filtro;
		return connection::execute_query($Sql);
	}

	public function insertUsersSucursales($name, $desc){
		$Sql = "INSERT INTO users_sucursales (name_sucursal,address_sucursal,user_sucursal) VALUES ('".$name."','".$desc."','".$_SESSION['user_name']."')";
		return connection::execute_query($Sql);
	}

	public function updateLastAccess($username){
		$Sql = "UPDATE users SET 
				last_access=NOW() 
				WHERE username='".$username."'";
		return connection::execute_query($Sql);
	}

	public static function getUsersConn($filter = ""){
		$Sql = "SELECT u.* 
				FROM users_connected c 
				LEFT JOIN users u ON u.username=c.username 
				WHERE FROM_UNIXTIME(UNIX_TIMESTAMP(connection_time)+".SESSION_MAXTIME.")>NOW() ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertUserConn($username, $connection_canal){
		if ($username <> ''){
			$Sql = "INSERT INTO users_connected (username,connection_canal) 
					VALUES ('".$username."','".$connection_canal."')";
			return connection::execute_query($Sql);
		}
	}

	public function deleteUserConn($username){
		$Sql = "DELETE FROM users_connected 
				WHERE username='".$username."'";

		return connection::execute_query($Sql);
	}

	public function getUsuariosPerfilBaja($perfil, $campo){
		$Sql = "SELECT username, perfil 
				FROM users 
				WHERE perfil='".$perfil."' AND disabled=0 AND username NOT IN (SELECT ".$campo." FROM users_tiendas WHERE activa=1) ";
		return connection::getSQL($Sql); 
	}

	public function disableUsersTiendas($empresa){
		$Sql = "UPDATE users SET 
				disabled=1,
				date_disabled=Now() 
				WHERE empresa='".$empresa."' AND disabled=0 ";
		return connection::execute_query($Sql);
	}

	public function updateJerarquiaUsers($username, $perfil, $empresa){
		$Sql = "UPDATE users SET 
				perfil = '".$perfil."',
				empresa = '".$empresa."',
				disabled=0 
				WHERE username='".$username."' ";
		return connection::execute_query($Sql);
	}

	public function insertTienda($cod_tienda, $nombre_tienda, $regional_tienda, $responsable_tienda, $tipo_tienda, $direccion_tienda, $cpostal_tienda, $ciudad_tienda, $provincia_tienda, $telefono_tienda, $email_tienda, $territorial_tienda, $activa){
		$Sql = "INSERT INTO users_tiendas (cod_tienda, nombre_tienda, regional_tienda, responsable_tienda, tipo_tienda, direccion_tienda, cpostal_tienda, ciudad_tienda, provincia_tienda, telefono_tienda, email_tienda, territorial_tienda, activa) 
				VALUES ('".$cod_tienda."','".$nombre_tienda."','".$regional_tienda."','".$responsable_tienda."','".$tipo_tienda."','".$direccion_tienda."','". $cpostal_tienda."','". $ciudad_tienda."','". $provincia_tienda."','". $telefono_tienda."','". $email_tienda."','".$territorial_tienda."',".$activa.")";
		return connection::execute_query($Sql);
	}

	public function updateTienda($cod_tienda, $nombre_tienda, $regional_tienda, $responsable_tienda, $tipo_tienda, $direccion_tienda, $cpostal_tienda, $ciudad_tienda, $provincia_tienda, $telefono_tienda, $email_tienda, $territorial_tienda, $activa){
		$Sql = "UPDATE users_tiendas SET 
				nombre_tienda ='".$nombre_tienda."',
				regional_tienda ='".$regional_tienda."',
				responsable_tienda ='".$responsable_tienda."',
				tipo_tienda ='".$tipo_tienda."',
				direccion_tienda = '".$direccion_tienda."',
				cpostal_tienda = '".$cpostal_tienda."',
				ciudad_tienda = '".$ciudad_tienda."',
				provincia_tienda = '".$provincia_tienda."',
				telefono_tienda = '".$telefono_tienda."',
				email_tienda = '".$email_tienda."',
				territorial_tienda = '".$territorial_tienda."',
				activa = ".$activa." 
				WHERE cod_tienda='".$cod_tienda."'";
		return connection::execute_query($Sql);
	}

	/////////////////////////////////////////////////////////////
	/// FUNCIONES DE PERMISOS
	/////////////////////////////////////////////////////////////

	public function getUsersPermisions($filter = ""){
		$Sql = "SELECT * 
				FROM users_permissions 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertUserPermission($username, $pagename, $permission_type, $permission_value){
		$Sql = "INSERT INTO users_permissions (username, pagename, permission_type, permission_type_value) VALUES 
				('".$username."','".$pagename."','".$permission_type."',".$permission_value.")";
		return connection::execute_query($Sql);
	}

	public function updateUserPermission($username, $pagename, $permission_type, $permission_value){
		$Sql = "UPDATE users_permissions SET 
				permission_type_value = ".$permission_value." 
				WHERE username='".$username."' AND pagename='".$pagename."' AND permission_type='".$permission_type."' ";
		return connection::execute_query($Sql); 
	}

	public function deleteUserPermission($username, $pagename, $permission_type){
		$Sql = "DELETE FROM users_permissions 
				WHERE username='".$username."' AND pagename='".$pagename."' AND permission_type='".$permission_type."' ";
		return connection::execute_query($Sql);
	}
	
	/////////////////////////////////////////////////////////////
	/// FUNCIONES DE CREDITOS
	/////////////////////////////////////////////////////////////
	
	public function getCreditos($filter = ""){
		$Sql = "SELECT u.nick,u.canal,u.empresa,p.* 
				FROM users_creditos p 
				JOIN users u ON u.username=p.credito_username 
				WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public static function insertCredito($puntuacion_username, $puntuacion_puntos, $puntuacion_motivo, $puntuacion_detalle){
		$Sql = "INSERT INTO users_creditos (credito_username, credito_puntos, credito_motivo, credito_detalle) 
				VALUES ('".$puntuacion_username."','".$puntuacion_puntos."','".$puntuacion_motivo."','".$puntuacion_detalle."')";
		return connection::execute_query($Sql);
	}

	public static function updateCredito($puntuacion_username, $puntuacion_puntos){
		$Sql = "UPDATE users SET 
				creditos=creditos+".$puntuacion_puntos."
				WHERE username='".$puntuacion_username."' ";
		return connection::execute_query($Sql);
	}

	public function getUsersCreditos($filter = ""){
		$Sql = "SELECT SUM(credito_puntos) as puntuacion, credito_username, credito_motivo 
				FROM users_creditos   
				WHERE credito_puntos>0 ".$filter." GROUP BY credito_motivo, credito_username"; //echo $Sql;
		return connection::getSQL($Sql);
	}

	public static function sumarCreditos($username, $puntos, $motivo, $detalle = ""){
		if (self::insertCredito($username, $puntos, $motivo, $detalle)){
			$Sql = "UPDATE users SET 
					creditos=creditos+".$puntos." 
					WHERE username='".$username."'";
			return connection::execute_query($Sql);
		}
		else return false;
	}

	public function getConfirm($filter = ""){
		$Sql = "SELECT * FROM users_confirm WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	public function insertConfirm($user_confirm, $user_recommend){
		$Sql = "INSERT INTO users_confirm (user_confirm, user_recommend) 
				VALUES ('".$user_confirm."','".$user_recommend."')";
		return connection::execute_query($Sql);
	}
}
?>