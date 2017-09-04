<?php
class usersTiendasController{
	public static function getListAction($reg = 0, $filter = ""){
		$users = new users();
		$find_reg = getFindReg();
		if($find_reg != '')	$filter .= " AND nombre_tienda LIKE '%".$find_reg."%' OR cod_tienda LIKE '%".$find_reg."%' ";
		$filter .= " ORDER BY nombre_tienda";

		$paginator_items = PaginatorPages($reg);
		$total_reg = connection::countReg("users_tiendas",$filter);
		return array('items' => $users->getTiendas($filter.' LIMIT '.$paginator_items['inicio'].','.$reg),
			'pag' 		=> $paginator_items['pag'],
			'reg' 		=> $reg,
			'find_reg' 	=> $find_reg,
			'total_reg' => $total_reg);
	}

	public static function getItemAction($id = ""){
		$users = new users();
		$plantilla = $users->getTiendas(" AND cod_tienda='".$id."' ");
		return $plantilla[0];
	}

	public static function exportListAction($filter = ''){
		if (isset($_REQUEST['export']) && $_REQUEST['export'] == true){
			$users = new users();
			$elements = $users->getTiendas($filter);
			download_send_headers(strTranslate("Groups_user")."_".date("Y-m-d").".csv");
			echo array2csv($elements);
			die();
		}
	}

	public static function volcarMySQLTiendas($data, $proceso_insert = true, $proceso_update = true, $proceso_delete = true){
		try {
			$users = new users();
			$contador_insert = 0;
			$contador_update = 0;

			for($fila = 2;$fila <= $data->sheets[0]['numRows']; $fila += 1){
				$cod_tienda = utf8_encode(sanitizeInput(trim($data->sheets[0]['cells'][$fila][1])));
				$nombre_tienda = utf8_encode(sanitizeInput(trim($data->sheets[0]['cells'][$fila][2])));
				$regional_tienda = utf8_encode(sanitizeInput(trim($data->sheets[0]['cells'][$fila][3])));
				$responsable_tienda = utf8_encode(sanitizeInput(trim($data->sheets[0]['cells'][$fila][4])));
				$tipo_tienda = ucfirst(utf8_encode(sanitizeInput(trim($data->sheets[0]['cells'][$fila][5]))));
				$direccion_tienda = utf8_encode(sanitizeInput(trim($data->sheets[0]['cells'][$fila][6])));
				$cpostal_tienda = utf8_encode(sanitizeInput(trim($data->sheets[0]['cells'][$fila][7])));
				$ciudad_tienda = utf8_encode(sanitizeInput(trim($data->sheets[0]['cells'][$fila][8])));
				$provincia_tienda = utf8_encode(sanitizeInput(trim($data->sheets[0]['cells'][$fila][9])));
				$telefono_tienda = utf8_encode(sanitizeInput(trim($data->sheets[0]['cells'][$fila][10])));
				$email_tienda = utf8_encode(sanitizeInput(trim($data->sheets[0]['cells'][$fila][11])));
				$territorial_tienda = utf8_encode(sanitizeInput(trim($data->sheets[0]['cells'][$fila][12])));
				$activa = (int)$data->sheets[0]['cells'][$fila][13];

				if (strtoupper($tipo_tienda) == 'FRANQUICIA') $empresa_usuarios = "0002";
				else $empresa_usuarios = "0003";

				if ($cod_tienda != ""){
					//VERIFICAR QUE EXISTA LA TIENDA PARA ALTA Y ACTUALIZACION
					if (connection::countReg("users_tiendas", " AND cod_tienda='".$cod_tienda."' ") > 0){
						//actualizar tienda	
						$users->updateTienda($cod_tienda, $nombre_tienda, $regional_tienda, $responsable_tienda, $tipo_tienda, $direccion_tienda, $cpostal_tienda, $ciudad_tienda, $provincia_tienda, $telefono_tienda, $email_tienda, $territorial_tienda, $activa);
						$contador_update++;
					}
					else{
						//insertar_tienda
						$users->insertTienda($cod_tienda, $nombre_tienda, $regional_tienda, $responsable_tienda, $tipo_tienda, $direccion_tienda, $cpostal_tienda, $ciudad_tienda, $provincia_tienda, $telefono_tienda, $email_tienda, $territorial_tienda, $activa);
						$contador_insert++;
					}

					//BAJA DE USUARIOS
					if ($activa == 0) $users->disableUsersTiendas($cod_tienda);
					else{
						//VERIFICAR QUE EXISTA EL REGIONAL PARA ALTA O MODIFICACION DE DATOS
						// if ($regional_tienda != "" && connection::countReg("users", " AND TRIM(UCASE(username))=TRIM('".$regional_tienda."') ") == 0){
						// 	//insertar usuario
						// 	$users->insertUser($regional_tienda, $regional_tienda, "", "", 0, 0, "", $empresa_usuarios, '', CANAL_DEF, 'regional', '', '', '', '', 0);
						// }
						// else $users->updateJerarquiaUsers($regional_tienda, 'regional', $empresa_usuarios);

						// //VERIFICAR QUE EXISTA EL RESPONSABLE PARA ALTA O MODIFICACION DE DATOS
						// if ($responsable_tienda != "" && connection::countReg("users"," AND TRIM(UCASE(username))=TRIM('".$responsable_tienda."') ") == 0){
						// 	//insertar usuario
						// 	$users->insertUser($responsable_tienda, $responsable_tienda, "", "", 0, 0, "", $empresa_usuarios, '', CANAL_DEF, 'responsable', '', '', '', '', 0);
						// }
						// else $users->updateJerarquiaUsers($responsable_tienda, 'responsable', $empresa_usuarios);
					}
				}
			}

			//BAJA DE RESPONSABLES QUE NO ESTAN EN EL FICHERO
			// $usuarios_responsables = $users->getUsuariosPerfilBaja('responsable', 'responsable_tienda');
			// foreach($usuarios_responsables as $usuario_responsables):
			// 	$users->disableUser($usuario_responsables['username'], 1);
			// endforeach;

			// //BAJA DE REGIONALES QUE NO ESTAN EN EL FICHERO
			// $usuarios_regionales = $users->getUsuariosPerfilBaja('regional', 'regional_tienda');
			// foreach($usuarios_regionales as $usuario_regionales):
			// 	$users->disableUser($usuario_regionales['username'], 1);
			// endforeach;

			echo date("Y-m-d H:i:s")." El proceso de importación de tiendas ha finalizado con éxito\n";
			echo date("Y-m-d H:i:s")." Se ha actualizado ".$contador_update." registros\n";
			echo date("Y-m-d H:i:s")." Se ha insertado ".$contador_insert." registros\n";			
			
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}	
}
?>