<?php
class incentivosController{
	public static function getListAction($reg = 0, $filter = ""){
		$incentivos = new incentivos();
		$find_reg = getFindReg();
		$filter .= " ORDER BY id_venta DESC ";
		
		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("incentives_ventas", $filter); 
		return array('items' => $incentivos->getVentas($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_reg' => $total_reg);
	}

	public static function exportAction($filter = ""){
		if (isset($_REQUEST['export']) && $_REQUEST['export']==true){
			$incentivos = new incentivos();
			$elements = $incentivos->getVentasExport($filter);
			download_send_headers(strTranslate("Incentives_sales")."_".date("Y-m-d").".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function getListPuntosAction($reg = 0, $filter = ""){
		$incentivos = new incentivos();
		$find_reg = getFindReg();
		if ($find_reg != '') $filter .= " AND username_puntuacion LIKE '%".$find_reg."%' ";
		$filter .= " ORDER BY id_puntos_venta DESC ";

		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("incentives_ventas_puntos", $filter); 
		$total_sum = connection::sumReg("incentives_ventas_puntos", 'puntuacion_venta', $filter); 
		return array('items' => $incentivos->getVentasPuntuaciones($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
					'pag' 		=> $paginator_items['pag'],
					'reg' 		=> $reg,
					'find_reg' 	=> $find_reg,
					'total_sum' => $total_sum,
					'total_reg' => $total_reg);
	}

	public static function exportPuntuacionesAction(){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			$incentivos = new incentivos();
			$elements = $incentivos->getVentasPuntuaciones("");
			download_send_headers(strTranslate("Incentives_points")."_" .date("Y-m-d").".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function exportUserReportAction(){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] != ''){
			$incentivos = new incentivos();
			$id_objetivo = intval($_REQUEST['id']);
			//obtener datos del objetivo
			$objetivo = $incentivos->getIncentivesObjetivos(" AND id_objetivo=".$id_objetivo." ");
			$productos = $incentivos->getProductosActivos(" AND o.id_objetivo=".$id_objetivo." ");
			if ($_REQUEST['export'] == 'puntos') self::exportUserPuntosAction(" AND id_producto_venta IN (".$productos[0]['productos'].") AND date_venta BETWEEN '".$objetivo[0]['date_ini_objetivo']."' AND '".$objetivo[0]['date_fin_objetivo']."' ");
			if ($_REQUEST['export'] == 'ventas') self::exportUserVentasAction(" AND v.id_producto IN (".$productos[0]['productos'].") AND fecha_venta BETWEEN '".$objetivo[0]['date_ini_objetivo']."' AND '".$objetivo[0]['date_fin_objetivo']."' ");
		}
	}

	private static function exportUserVentasAction($filter){
		$incentivos = new incentivos();
		//$filtro_user = ($_REQUEST['tipo'] == 'Usuario' ? $_SESSION['user_name'] : $_SESSION['user_empresa']);
		//$elements = $incentivos->getVentasExport($filter." AND username_venta='".$filtro_user."' ");
		$filtro_tienda = incentivosObjetivosController::getFiltroTienda($_SESSION['user_perfil'], $_SESSION['user_name'], $_SESSION['user_empresa'], ($_SESSION['user_perfil'] == 'usuario'));
		$elements = $incentivos->getVentasExport($filtro_tienda.$filter);
		download_send_headers(strTranslate("Incentives_sales")."_" .date("Y-m-d").".csv");
		echo array2csv($elements);
		die();
	}

	private static function exportUserPuntosAction($filter){
		$incentivos = new incentivos();
		//$filtro_user = ($_REQUEST['tipo'] == 'Usuario' ? $_SESSION['user_name'] : $_SESSION['user_empresa']);
		//$elements = $incentivos->getVentasPuntuacionesUser($filter." AND username_puntuacion='".$filtro_user."' ");
		$filtro_tienda = incentivosObjetivosController::getFiltroTienda($_SESSION['user_perfil'], $_SESSION['user_name'], $_SESSION['user_empresa']);
		$elements = $incentivos->getVentasPuntuacionesUser($filtro_tienda.$filter);
		download_send_headers(strTranslate("Incentives_points")."_" .date("Y-m-d").".csv");
		echo array2csv($elements);
		die();
	}

	public static function getRankingAction($objetivo, $filter = ""){
		if(strtoupper($objetivo['tipo_objetivo']) == 'USUARIO') return self::getRankingUsuarioAction($objetivo, $filter);
		else return self::getRankingTiendaAction($objetivo, $filter);
	}

	public static function getRankingUsuarioAction($objetivo, $filter = ""){
		$users = new users;
		$incentivos = new incentivos();
		$objetivos = $incentivos->getObjetivosRanking(" AND id_objetivo=".$objetivo['id_objetivo']." ");

		//$filter .= " AND id_producto IN (".$objetivos[0]['productos'].") AND fecha_venta BETWEEN '".$objetivo['date_ini_objetivo']."' AND '".$objetivo['date_fin_objetivo']."' ";

		$filter .= " AND date_venta BETWEEN '".$objetivo['date_ini_objetivo']."' AND '".$objetivo['date_fin_objetivo']."' ";
		$ventas = $incentivos->getVentasRankingUser($filter." GROUP BY username_venta,t.cod_tienda ORDER BY suma DESC, username_venta DESC", $objetivo['id_objetivo']);
		$posicion_user = $incentivos->getPosicionRankingUser($filter, $_SESSION['user_name'], $objetivo['id_objetivo']);
		$result = array();
		$result['ranking'] = $ventas;
		$result['posicion_user'] = $posicion_user;
		return $result;
	}

	public static function getRankingUsuarioTiendaActionExport($element, $filtro_tienda, $tipo_informe){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			$id_zona = ((isset($_REQUEST['idz']) && $_REQUEST['idz'] != "") ? $_REQUEST['idz'] : "");
			if ($tipo_informe == "tiendas")
				$data = self::getRankingUsuarioTiendaAction($element, $filtro_tienda);
			elseif ($tipo_informe == "tiendas_global")
				$data = self::getRankingUsuarioTiendaAction($element, "");
			elseif ($tipo_informe == "areas")
				$data = self::getRankingAreaAction($element, $filtro_tienda);
			elseif ($tipo_informe == "zonas_venta" && $_SESSION['user_perfil'] == 'usuario')
				$data = self::getRankingUsuarioTiendaAction($element, " AND t.zona_venta=(SELECT zona_venta FROM users_tiendas WHERE cod_tienda='".$_SESSION['user_empresa']."')");
			elseif ($tipo_informe == "zonas_venta" && $id_zona > 0)
				$data = self::getRankingUsuarioTiendaAction($element, $filtro_tienda);
			elseif ($tipo_informe == "zonas_venta")
				$data = self::getRankingZonaAction($element, $filtro_tienda);
			elseif ($tipo_informe == "zonas_postventa" && $_SESSION['user_perfil'] == 'usuario')
				$data = self::getRankingUsuarioTiendaAction($element, " AND t.zona_postventa=(SELECT zona_postventa FROM users_tiendas WHERE cod_tienda='".$_SESSION['user_empresa']."')");
			elseif ($tipo_informe == "zonas_postventa" && $id_zona > 0)
				$data = self::getRankingUsuarioTiendaAction($element, $filtro_tienda);
			elseif ($tipo_informe == "zonas_postventa")
				$data = self::getRankingZonaPostAction($element, $filtro_tienda);
			else{
				$data = self::getRankingUsuarioAction($element, $filtro_tienda);
				$i = 0;
				foreach($data['ranking'] as $element_data):
					$elem[strTranslate("Nick")] = $element_data['nick'];
					$elem['Nombre'] = $element_data['name']." ".$element_data['surname'];
					$elem['Cantidad'] = $element_data['suma'];
					$elem['Concesionario'] = $element_data['nombre_tienda'];
					$elem['Zona venta'] = $element_data['zona_venta'];
					$elem['Zona postventa'] = $element_data['zona_postventa'];
					if ($_SESSION['user_perfil'] != 'usuario'){
						$elem['Area'] = $element_data['area'];
						$elem['Delegado venta'] = $element_data['regional_tienda'];
						$elem['Delegado Postventa'] = $element_data['regional_post_tienda'];
					}
					$data['ranking'][$i] = $elem;
					$i++;
				endforeach;
			}

			download_send_headers(strTranslate("Incentives")."_".date("Y-m-d").".csv");
			echo array2csv($data['ranking']);
			die();
		}
	}

	public static function getRankingAreaActionExport($element, $filtro_tienda, $tipo_informe){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			if ($tipo_informe == "tiendas")
				$data = incentivosController::getRankingUsuarioTiendaAction($element, $filtro_tienda);
			else{
				$data = incentivosController::getRankingUsuarioAction($element, $filtro_tienda);
				$i = 0;
				foreach($data['ranking'] as $element_data):
					$elem['Nick'] = $element_data['nick'];
					$elem['Nombre'] = $element_data['name']." ".$element_data['surname'];
					$elem['Cantidad'] = $element_data['suma'];
					$elem['Concesionario'] = $element_data['nombre_tienda'];
					$data['ranking'][$i] = $elem;
					$i++;
				endforeach;
			}

			download_send_headers(strTranslate("data")."_".date("Y-m-d").".csv");
			echo array2csv($data['ranking']);
			die();
		}
	}

	public static function getRankingUsuarioTiendaAction($objetivo, $filter = ""){
		$users = new users;
		$incentivos = new incentivos();
		$objetivos = $incentivos->getObjetivosRanking(" AND id_objetivo=".$objetivo['id_objetivo']." ");

		// $filtro = $filter." AND id_producto IN (".$objetivos[0]['productos'].") AND fecha_venta BETWEEN '".$objetivo['date_ini_objetivo']."' AND '".$objetivo['date_fin_objetivo']."' ";

		$filtro = $filter." AND date_venta BETWEEN '".$objetivo['date_ini_objetivo']."' AND '".$objetivo['date_fin_objetivo']."' ";
		$ventas = $incentivos->getVentasRankingUserTiendas($filtro." GROUP BY u.empresa, t.cod_tienda ORDER BY suma DESC, u.empresa DESC", $objetivo['id_objetivo']);
		//$posicion_user = $incentivos->getPosicionRankingUser($filtro, $_SESSION['user_name']);

		$result = array();
		$result['ranking'] = $ventas;
		//$result['posicion_user'] = $posicion_user;
		// echo '<pre>';
		// var_dump($result);
		// echo '</pre>';
		return $result;
	}

	public static function getRankingAreaAction($objetivo, $filter = ""){
		//echo "usuario";
		$users = new users;
		$incentivos = new incentivos();

		if ($_SESSION['user_perfil'] == 'area') $filter = "";

		$objetivos = $incentivos->getObjetivosRanking(" AND id_objetivo=".$objetivo['id_objetivo']." ");

		//$filtro = $filter." AND id_producto IN (".$objetivos[0]['productos'].") AND fecha_venta BETWEEN '".$objetivo['date_ini_objetivo']."' AND '".$objetivo['date_fin_objetivo']."' ";

		$filtro = $filter." AND date_venta BETWEEN '".$objetivo['date_ini_objetivo']."' AND '".$objetivo['date_fin_objetivo']."' ";
		$ventas = $incentivos->getVentasRankingAreas($filtro." GROUP BY t.area ORDER BY suma DESC, t.area DESC", $objetivo['id_objetivo']);
		//$posicion_user = $incentivos->getPosicionRankingUser($filtro, $_SESSION['user_name']);

		$result = array();
		$result['ranking'] = $ventas;
		//$result['posicion_user'] = $posicion_user;
		// echo '<pre>';
		// var_dump($result);
		// echo '</pre>';
		return $result;
	}

	public static function getRankingZonaAction($objetivo, $filter = ""){
		//echo "usuario";
		$users = new users;
		$incentivos = new incentivos();
		$objetivos = $incentivos->getObjetivosRanking(" AND id_objetivo=".$objetivo['id_objetivo']." ");

		//$filtro = $filter." AND id_producto IN (".$objetivos[0]['productos'].") AND fecha_venta BETWEEN '".$objetivo['date_ini_objetivo']."' AND '".$objetivo['date_fin_objetivo']."' ";
		
		$filtro = $filter." AND date_venta BETWEEN '".$objetivo['date_ini_objetivo']."' AND '".$objetivo['date_fin_objetivo']."' ";
		$ventas = $incentivos->getVentasRankingZonas($filtro." GROUP BY t.zona_venta ORDER BY suma DESC, t.zona_venta DESC", $objetivo['id_objetivo']);
		//$posicion_user = $incentivos->getPosicionRankingUser($filtro, $_SESSION['user_name']);

		$result = array();
		$result['ranking'] = $ventas;
		//$result['posicion_user'] = $posicion_user;
		// echo '<pre>';
		// var_dump($result);
		// echo '</pre>';
		return $result;
	}

	public static function getRankingZonaPostAction($objetivo, $filter = ""){
		//echo "usuario";
		$users = new users;
		$incentivos = new incentivos();
		$objetivos = $incentivos->getObjetivosRanking(" AND id_objetivo=".$objetivo['id_objetivo']." ");

		//$filtro = $filter." AND id_producto IN (".$objetivos[0]['productos'].") AND fecha_venta BETWEEN '".$objetivo['date_ini_objetivo']."' AND '".$objetivo['date_fin_objetivo']."' ";
		
		$filtro = $filter." AND date_venta BETWEEN '".$objetivo['date_ini_objetivo']."' AND '".$objetivo['date_fin_objetivo']."' ";
		$ventas = $incentivos->getVentasRankingZonasPost($filtro." GROUP BY t.zona_postventa ORDER BY suma DESC, t.zona_postventa DESC", $objetivo['id_objetivo']);
		//$posicion_user = $incentivos->getPosicionRankingUser($filtro, $_SESSION['user_name']);

		$result = array();
		$result['ranking'] = $ventas;
		//$result['posicion_user'] = $posicion_user;
		// echo '<pre>';
		// var_dump($result);
		// echo '</pre>';
		return $result;
	}

	public static function getRankingTiendaAction($objetivo, $filter = ""){
		//echo "tienda";
		$incentivos = new incentivos();
		$objetivos = $incentivos->getObjetivosRankingTienda(" AND id_objetivo=".$objetivo['id_objetivo']." ");
		$elements = array();
		foreach($objetivos as $objetivo_detalle):		
			//obtener ventas del objetivo
			$ventas = $incentivos->getVentasRanking(" AND id_producto IN (".$objetivo_detalle['productos'].") AND fecha_venta BETWEEN '".$objetivo['date_ini_objetivo']."' AND '".$objetivo['date_fin_objetivo']."' AND username_venta IN (SELECT username FROM users WHERE empresa='".$objetivo_detalle['destino_objetivo']."') ");

			if (count($ventas)>0){
				$venta_detalle = array('objetivo' => $objetivo_detalle['suma'], 
										'usuario'=> $objetivo_detalle['destino_objetivo'], 
										'usuario_nombre'=> $objetivo_detalle['nombre_tienda'], 
										'porcentaje'=> ($ventas[0]['suma']>0 ? (($ventas[0]['suma']/$objetivo_detalle['suma'])*100) : 0), 
										'cantidad' =>  $ventas[0]['suma']);

				array_push($elements, $venta_detalle);
			}
		endforeach;
		return arraySort($elements, 'porcentaje', SORT_DESC);
	}

	public static function createPosicionGlobal(){
		$incentivos = new incentivos();
		$users = new users();

		//Copia de seguridad posiciones
		$Sql = "TRUNCATE incentives_posiciones_cs";
		connection::execute_query($Sql);
		$Sql = "INSERT INTO incentives_posiciones_cs SELECT * FROM incentives_posiciones";
		connection::execute_query($Sql);
		echo date("Y-m-d H:i:s"). " Copia de seguridad posiciones\n";

		//Borrado de posiciones
		$Sql = "TRUNCATE incentives_posiciones";
		connection::execute_query($Sql);

		//Obtener productos activos
		$productos = $incentivos->getProductosActivos(" AND activo_objetivo = 1");
		$filtro_productos = " AND id_producto_venta IN 
					(".$productos[0]['productos'].") 
					AND (MONTH(date_venta)=".REPORTS_MONTH." AND YEAR(date_venta)=".REPORTS_YEAR.") ";

		//Obtener todas las tienas para calcular su posicion. No se tiene en cuenta si están activas o no, por si cambian el estado.
		$tiendas = $users->getTiendas("");
		foreach($tiendas as $tienda):
				$filtro_equipo = " AND t.equipo='".$tienda['equipo']."' ";
				$ranking_total = $incentivos->getRankingTotalTiendas($filtro_productos.$filtro_equipo);
				$i=1;
				$posicion_user = 0;
				foreach($ranking_total as $user_ranking):
					if ($user_ranking['username_puntuacion'] == $tienda['cod_tienda']){
						$posicion_user = $i;
						break;
					}
					$i++;
				endforeach;

				//insertar la posicion de la tienda
				if ($incentivos->insertPosicionGlobal($tienda['cod_tienda'], $posicion_user)) echo date("Y-m-d H:i:s"). " Insertada posicion para: ".$tienda['cod_tienda']." - Posicion:".$posicion_user."\n";
		endforeach;
	}

	public static function volcarMySQLVentas($data, $proceso_insert = true, $proceso_update = true, $proceso_delete = true){
		try {
			$users = new users();
			$contador_insert = 0;
			$contador_ko = 0;
			$incentivos = new incentivos();

			for($fila = 2; $fila <= $data->sheets[0]['numRows']; $fila += 1){
				$referencia_producto = utf8_encode(str_replace ("'", "´", trim(strtoupper($data->sheets[0]['cells'][$fila][1]))));
				$fabricante_producto = utf8_encode(str_replace ("'", "´", trim(strtoupper($data->sheets[0]['cells'][$fila][2]))));
				$cantidad_venta = utf8_encode(str_replace(',', '.', str_replace ("'", "´", trim(strtoupper($data->sheets[0]['cells'][$fila][3])))));
				$username_venta = utf8_encode(str_replace ("'", "´", trim($data->sheets[0]['cells'][$fila][4])));
				//datos del usuario (obtener canal)
				$usuario = usersController::getPerfilAction($username_venta, "");

				$fecha_venta = str_replace ("/", "-", trim(strtoupper($data->sheets[0]['cells'][$fila][5])));
				$detalle = utf8_encode(str_replace ("'", "´", trim(strtoupper($data->sheets[0]['cells'][$fila][6]))));
				$tendencia = strtoupper(utf8_encode(str_replace ("'", "´",trim(strtoupper($data->sheets[0]['cells'][$fila][7])))));;

				if ($referencia_producto != "" && (isset($usuario['canal']) && $usuario['canal'] != "")){
					//buscar id_producto por referencia y fabriacante
					$producto = $incentivos->getIncentivesProductos(" AND UPPER(p.referencia_producto)='".$referencia_producto."' AND UPPER(f.nombre_fabricante)='".$fabricante_producto."' ");
					if (count($producto)>0){
						$fechaV=date("Y-m-d", strtotime($fecha_venta));

						if ($incentivos->insertIncentivesVenta($producto[0]['id_producto'], $cantidad_venta, $username_venta, $fechaV, $detalle, $tendencia)){

							$contador_insert++;
							//asignacion de puntos. Obtener puntos del producto por la fecha y obtener aceleradores
							$puntuacion_producto = $incentivos->getIncentivesProductosPuntos(" AND id_producto=".$producto[0]['id_producto']." AND '".$fechaV."' BETWEEN date_ini AND date_fin AND canal_puntos LIKE '%".$usuario['canal']."%'");
							$puntuacion_acelerador = $incentivos->getIncentivesProductAcelerators(" AND a.id_producto=".$producto[0]['id_producto']." AND '".$fechaV."' BETWEEN a.date_ini AND a.date_fin ");
							$puntuacion_venta = (0 + (count($puntuacion_producto)>0 ? $puntuacion_producto[0]['puntos'] : 0)) * (count($puntuacion_acelerador)>0 ? $puntuacion_acelerador[0]['valor_acelerador'] : 1);

							$puntuacion_venta = ($puntuacion_venta * $cantidad_venta);
							if ($incentivos->insertIncentivesProductosVentas($username_venta, str_replace(',', '.', $puntuacion_venta), $producto[0]['id_producto'], $fechaV, $detalle) && $puntuacion_venta > 0){
								if ($producto[0]['suma_puntos'] == 1) users::sumarPuntos($username_venta, str_replace(',', '.', $puntuacion_venta), $detalle);
								if ($producto[0]['suma_creditos'] == 1) usersCreditosController::sumarCreditosAction($username_venta, str_replace(',', '.', $puntuacion_venta), $detalle);
							}
						}
					}
					else $contador_ko ++;
				}
			}

			echo date("Y-m-d H:i:s")." El proceso de importación de ventas ha finalizado con éxito\n";
			echo date("Y-m-d H:i:s")." Se ha insertado ".$contador_insert." registros\n";
			echo date("Y-m-d H:i:s")." No se ha insertado ".$contador_ko." registros (producto no encontrado)\n";
		} catch (Exception $e) {
			
		}
	}
}
?>