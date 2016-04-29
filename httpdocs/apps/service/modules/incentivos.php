<?php
class incentivos extends API{
	public function getkpis(){
		self::getObjetivos(0);
	}

	public function getAceleradores(){
		self::getObjetivos(1);
	}

	public function getObjetivos($acelerador = 0){
		// Cross validation if the request method is POST else it will return "Not Acceptable" status
		if($this->get_request_method() != "GET"){ $this->response('', 406);}	

		//get data sent
		$ses_id = $_GET['ses_id'];
		$user = $_GET['user'];

		// Session validation
		if ($this->checkSesId($ses_id,$user)){
			// Input validations
			if(trim($user) != ''){		
				$Sql = "SELECT id_objetivo,nombre_objetivo,date_ini_objetivo,date_fin_objetivo FROM incentives_kpi WHERE activo_objetivo=1 AND acelerador=".$acelerador." ";
				$query = $this->getQuery($Sql);
				$filas = mysqli_num_rows($query);
				if(mysqli_num_rows($query) > 0){

					$i = 0;
					while($rlt = mysqli_fetch_array($query,MYSQLI_ASSOC))				{
						//$result[] = $rlt;
						$result[$i]['nombre_objetivo'] = $rlt['nombre_objetivo'];
						$result[$i]['date_ini_objetivo'] = $rlt['date_ini_objetivo'];
						$result[$i]['date_fin_objetivo'] = $rlt['date_fin_objetivo'];

						//obtener los productos de cada objetivo
						$Sql="SELECT GROUP_CONCAT(DISTINCT id_producto) AS productos  
						FROM incentives_kpi_detalle  
						WHERE id_objetivo=".$rlt['id_objetivo']; 
						$query2 = $this->getQuery($Sql);
						$productos_result = mysqli_fetch_array($query2,MYSQLI_ASSOC);
						$productos = $productos_result['productos'];
							

						$Sql = "SELECT p.id_producto, nombre_producto, pp.puntos AS multiplicador,pp.date_ini,pp.date_fin  
								FROM incentives_productos p LEFT JOIN incentives_productos_puntos pp ON p.id_producto=pp.id_producto 
								WHERE p.id_producto IN (".$productos.") ";//echo $Sql;
						$query3 = $this->getQuery($Sql);
						$k = 0;
						while($rltproductos = mysqli_fetch_array($query3,MYSQLI_ASSOC))				{
							//$result[] = $rlt;
							$result[$i]['productos'][$k]['nombre_producto'] = $rltproductos['nombre_producto'];
							$result[$i]['productos'][$k]['multiplicador'] = (int)$rltproductos['multiplicador'];
							$result[$i]['productos'][$k]['date_ini_producto'] = $rltproductos['date_ini'];
							$result[$i]['productos'][$k]['date_fin_producto'] = $rltproductos['date_fin'];
							
							$datos_producto_user = self::getPuntosAltasObjetivo($user, $rltproductos['id_producto']);
							$result[$i]['productos'][$k]['puntos'] = (int)$datos_producto_user['puntos'];
							$result[$i]['productos'][$k]['altas'] = (int)$datos_producto_user['altas'];
							$k++;
						}
						$i++;
					}

					
					// If success everythig is good send header as "OK" and user details
					$this->response($this->json($result), 200);
				}
			}
			// If invalid inputs "Bad Request" status message and reason
			$error = array('status' => "Failed", "msg" => "Error al obtener datos: ".$filas);
			$this->response($this->json($error), 400);
		}
		else{
			$error = array('status' => "Failed", "msg" => "Sesion incorrecta");
			$this->response($this->json($error), 400);		
		}
	}

	public function getPuntosAltasObjetivo($user, $producto){
		$incentivos = new incentivos();
		//obtener datos del usuario
		$user_data = self::getUserData(trim($user));

		$puntos = 0;
		$altas = 0;
		if ($user_data['perfil']=='usuario'){
			$puntos = connection::sumReg("incentives_ventas_puntos", "puntuacion_venta", " AND username_puntuacion='".$user_data['empresa']."' AND (MONTH(date_venta)=".REPORTS_MONTH." AND YEAR(date_venta)=".REPORTS_YEAR.") AND id_producto_venta=".$producto." ");
			$altas = connection::sumReg("incentives_ventas", "cantidad_venta", " AND username_venta='".$user_data['empresa']."' AND (MONTH(fecha_venta)=".REPORTS_MONTH." AND YEAR(fecha_venta)=".REPORTS_YEAR.") AND id_producto=".$producto." ");
		}
		elseif ($user_data['perfil']=='responsable'){
			$usuarios_filtro = $incentivos->getUsuariosResponsableTienda($user);
			$puntos = connection::sumReg("incentives_ventas_puntos", "puntuacion_venta", " AND username_puntuacion IN (".$usuarios_filtro[0]['usuarios'].") AND (MONTH(date_venta)=".REPORTS_MONTH." AND YEAR(date_venta)=".REPORTS_YEAR.") AND id_producto_venta=".$producto." ");
			$altas = connection::sumReg("incentives_ventas", "cantidad_venta", " AND username_venta IN (".$usuarios_filtro[0]['usuarios'].") AND (MONTH(fecha_venta)=".REPORTS_MONTH." AND YEAR(fecha_venta)=".REPORTS_YEAR.") AND id_producto=".$producto." ");
		}
		elseif ($user_data['perfil']=='regional'){
			$usuarios_filtro = $incentivos->getUsuariosRegionalTienda($user);
			$puntos = connection::sumReg("incentives_ventas_puntos", "puntuacion_venta", " AND username_puntuacion IN (".$usuarios_filtro[0]['usuarios'].") AND (MONTH(date_venta)=".REPORTS_MONTH." AND YEAR(date_venta)=".REPORTS_YEAR.") AND id_producto_venta=".$producto." ");
			$altas = connection::sumReg("incentives_ventas", "cantidad_venta", " AND username_venta IN (".$usuarios_filtro[0]['usuarios'].") AND (MONTH(fecha_venta)=".REPORTS_MONTH." AND YEAR(fecha_venta)=".REPORTS_YEAR.") AND id_producto=".$producto." ");
		}
		elseif ($user_data['perfil']=='territorial'){
			$usuarios_filtro = $incentivos->getUsuariosTerritorialTienda($_SESSION['user_name']);
			$puntos = connection::sumReg("incentives_ventas_puntos", "puntuacion_venta", " AND username_puntuacion IN (".$usuarios_filtro[0]['usuarios'].") AND (MONTH(date_venta)=".REPORTS_MONTH." AND YEAR(date_venta)=".REPORTS_YEAR.") AND id_producto_venta=".$producto." ");
			$altas = connection::sumReg("incentives_ventas", "cantidad_venta", " AND username_venta IN (".$usuarios_filtro[0]['usuarios'].") AND (MONTH(fecha_venta)=".REPORTS_MONTH." AND YEAR(fecha_venta)=".REPORTS_YEAR.") AND id_producto=".$producto." ");
		}
		elseif ($user_data['perfil']=='admin' or $user_data['perfil']=='visualizador'){	
			$puntos = connection::sumReg("incentives_ventas_puntos", "puntuacion_venta", "  AND (MONTH(date_venta)=".REPORTS_MONTH." AND YEAR(date_venta)=".REPORTS_YEAR.") AND id_producto_venta=".$producto." ");
			$altas = connection::sumReg("incentives_ventas", "cantidad_venta", "  AND (MONTH(fecha_venta)=".REPORTS_MONTH." AND YEAR(fecha_venta)=".REPORTS_YEAR.") AND id_producto=".$producto." ");
		}

		$producto_data = array();
		$producto_data['puntos'] = $puntos;
		$producto_data['altas'] = $altas;
		return $producto_data;
	}	

	public function getPosicion(){
		// Cross validation if the request method is POST else it will return "Not Acceptable" status
		if($this->get_request_method() != "GET"){ $this->response('', 406);}	

		//get data sent
		$ses_id = $_GET['ses_id'];
		$user = $_GET['user'];

		// Session validation
		if ($this->checkSesId($ses_id,$user)){
			// Input validations
			if(trim($user) != ''){	
				$posicion_user = 0;
				$user_data = self::getUserData(trim($user));
				if ($user_data['perfil'] == 'usuario'):
					$incentivos = new incentivos();
					$posiciones = $incentivos->getPosicionGlobal(" AND username='".$user_data['empresa']."' ");
					if (isset($posiciones[0]['posicion'])) $posicion_user = $posiciones[0]['posicion'];					
				endif;

				$respuesta['posicion'] = $posicion_user;
				
				// If success everythig is good send header as "OK" and user details
				$this->response($this->json($respuesta), 200);

			}
			// If invalid inputs "Bad Request" status message and reason
			$error = array('status' => "Failed", "msg" => "Error al obtener datosssss.");
			$this->response($this->json($error), 400);
		}
		else{
			$error = array('status' => "Failed", "msg" => "Sesion incorrecta");
			$this->response($this->json($error), 400);		
		}
	}

}
?>