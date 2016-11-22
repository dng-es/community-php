<?php
class incentivos{

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getVentas($filter = ""){
		$Sql="SELECT v.*,u.name,u.surname,p.referencia_producto,p.nombre_producto,f.nombre_fabricante FROM incentives_ventas v 
			LEFT JOIN users u ON u.username=v.username_venta 
			LEFT JOIN incentives_productos p ON p.id_producto=v.id_producto 
			LEFT JOIN incentives_fabricantes f ON f.id_fabricante=p.id_fabricante
			WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getVentasSimple($filter = ""){
		$Sql="SELECT * FROM incentives_ventas 
			WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}	

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getVentasRanking($filter = ""){
		$Sql="SELECT username_venta,SUM(cantidad_venta) AS suma FROM incentives_ventas
			WHERE 1=1 ".$filter; //echo $Sql;
		return connection::getSQL($Sql);
	}

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getVentasRankingUser($filter = "", $id_objetivo = 1){

		$Sql = "SELECT username_puntuacion AS username_venta,SUM(puntuacion_venta) AS suma,u.nick,u.name,u.surname,u.foto,
			IFNULL(t.nombre_tienda, '') AS nombre_tienda, t.regional_tienda 
			FROM incentives_ventas_puntos v 
			LEFT JOIN users u ON u.username=v.username_puntuacion 
			LEFT JOIN users_tiendas t ON u.empresa=t.cod_tienda 
			INNER JOIN incentives_objetivos_detalle vd ON vd.id_producto=v.id_producto_venta AND vd.id_objetivo=".$id_objetivo." 
			WHERE 1=1 ".$filter; 
			//echo $Sql;
		return connection::getSQL($Sql);
	}

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getVentasRankingUserTiendas($filter = "", $id_objetivo = 1){
			$Sql = "SELECT u.empresa,IFNULL(t.nombre_tienda, '') AS nombre_tienda ,SUM(puntuacion_venta) AS suma, t.provincia_tienda 
			FROM incentives_ventas_puntos v 
			LEFT JOIN users u ON u.username=v.username_puntuacion 
			LEFT JOIN users_tiendas t ON u.empresa=t.cod_tienda 
			INNER JOIN incentives_objetivos_detalle vd ON vd.id_producto=v.id_producto_venta AND vd.id_objetivo=".$id_objetivo." 
			WHERE 1=1 ".$filter; //echo $Sql;
		return connection::getSQL($Sql);
	}			

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getPosicionRankingUser($filter = "", $username, $id_objetivo){
		$Sql = "SELECT rownum, suma FROM(
		SELECT @rownum:=@rownum+1 AS rownum,r.* FROM 
(SELECT * FROM (

(SELECT username_puntuacion,SUM(puntuacion_venta) AS suma 
	FROM incentives_ventas_puntos v 
	LEFT JOIN users u ON u.username=v.username_puntuacion 
	INNER JOIN incentives_objetivos_detalle vd ON vd.id_producto=v.id_producto_venta AND vd.id_objetivo=".$id_objetivo." 
	WHERE 1=1 ".$filter." GROUP BY username_puntuacion ORDER BY suma DESC, username_puntuacion DESC) ventas 

)
WHERE ventas.suma>=(
	SELECT SUM(puntuacion_venta) AS suma 
	FROM incentives_ventas_puntos v
	LEFT JOIN users u ON u.username=v.username_puntuacion   
	INNER JOIN incentives_objetivos_detalle vd ON vd.id_producto=v.id_producto_venta AND vd.id_objetivo=".$id_objetivo." 
	WHERE 1=1 ".$filter." AND username_puntuacion='".$username."' GROUP BY username_puntuacion ORDER BY suma DESC, username_puntuacion DESC)) r,  
(SELECT @rownum:=0) ro ) f WHERE username_puntuacion='".$username."' "; //echo $Sql;
		return connection::getSQL($Sql);
	}		

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getObjetivosRanking($filter = ""){
		$Sql = "SELECT destino_objetivo,SUM(valor_objetivo) AS suma, GROUP_CONCAT(id_producto) AS productos,u.name,u.surname,u.nick FROM incentives_objetivos_detalle o 
			LEFT JOIN users u ON u.username=o.destino_objetivo
			WHERE 1=1 ".$filter." GROUP BY destino_objetivo"; //echo $Sql."<br /><br />";
		return connection::getSQL($Sql);
	}

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getObjetivosRankingTienda($filter = ""){
		$Sql = "SELECT destino_objetivo,SUM(valor_objetivo) AS suma, GROUP_CONCAT(id_producto) AS productos,u.nombre_tienda FROM incentives_objetivos_detalle o 
			LEFT JOIN users_tiendas u ON u.cod_tienda=o.destino_objetivo 
			WHERE 1=1 ".$filter." GROUP BY destino_objetivo";
		return connection::getSQL($Sql);
	}			

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getVentasExport($filter = ""){
		$Sql="SELECT v.username_venta AS Usuario,u.name AS Nombre,u.surname AS Apellidos,p.referencia_producto AS REF,p.nombre_producto AS Producto,f.nombre_fabricante AS Fabricante,v.cantidad_venta AS Cantidad, v.fecha_venta As Fecha FROM incentives_ventas v 
			LEFT JOIN users u ON u.username=v.username_venta 
			LEFT JOIN incentives_productos p ON p.id_producto=v.id_producto 
			LEFT JOIN incentives_fabricantes f ON f.id_fabricante=p.id_fabricante
			WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}	

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getVentasPuntuaciones($filter = ""){
		$Sql="SELECT v.*,u.name,u.surname,p.referencia_producto,p.nombre_producto,f.nombre_fabricante FROM incentives_ventas_puntos v 
			LEFT JOIN users u ON u.username=v.username_puntuacion 
			LEFT JOIN incentives_productos p ON p.id_producto=v.id_producto_venta 
			LEFT JOIN incentives_fabricantes f ON f.id_fabricante=p.id_fabricante
			WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}	

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getVentasPuntuacionesUser($filter = ""){
		$Sql="SELECT v.username_puntuacion AS Usuario,u.name AS Nombre,u.surname AS Apellidos,p.referencia_producto,p.nombre_producto,f.nombre_fabricante,puntuacion_venta AS puntuacion,puntuacion_detalle AS detalle, date_venta as fecha_venta  FROM incentives_ventas_puntos v 
			LEFT JOIN users u ON u.username=v.username_puntuacion 
			LEFT JOIN incentives_productos p ON p.id_producto=v.id_producto_venta 
			LEFT JOIN incentives_fabricantes f ON f.id_fabricante=p.id_fabricante
			WHERE 1=1 ".$filter; //echo $Sql;
		return connection::getSQL($Sql);
	}		

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getIncentivesFabricantes($filter = ""){
		$Sql="SELECT * FROM incentives_fabricantes WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}   

	/**
	 * Inserta registro en incentivos fabricantes
	 * @param  string 	$nombre_fabricante 	Nombre del fabricante
	 * @return boolean 						Resultado de la SQL
	 */
	public function insertIncentivesFabricantes( $nombre_fabricante ){		
		$Sql="INSERT INTO incentives_fabricantes (nombre_fabricante) 
			  VALUES ('".$nombre_fabricante."')";
		return connection::execute_query($Sql);
	}

	/**
	 * Elimina registro en incentivos fabricantes
	 * @param  int 		$id 		Id registro a eliminar
	 * @return boolean 				Resultado de la SQL
	 */
	public function disableIncentivesFabricantes($id){
		$Sql="UPDATE incentives_fabricantes 
			SET activo_fabricante=0 
			WHERE id_fabricante=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getIncentivesProductos($filter = ""){
		$Sql="SELECT p.*,f.nombre_fabricante FROM incentives_productos p 
			LEFT JOIN incentives_fabricantes f ON f.id_fabricante=p.id_fabricante 
			WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}   

	/**
	 * Inserta registro en incentivos productos
	 * @param  string 	$referencia_producto 	Referencia del producto
	 * @param  string 	$nombre_producto 		Nombre del producto
	 * @param  int 		$id_fabricante 			Id del fabricante
	 * @return boolean 							Resultado de la SQL
	 */
	public function insertIncentivesProductos( $referencia_producto, $nombre_producto, $id_fabricante ){		
		$Sql="INSERT INTO incentives_productos (referencia_producto, nombre_producto, id_fabricante) 
			  VALUES ('".$referencia_producto."','".$nombre_producto."', ".$id_fabricante.")";
		return connection::execute_query($Sql);
	}

	/**
	 * Elimina registro en incentivos productos
	 * @param  int 		$id 		Id registro a eliminar
	 * @return boolean 				Resultado de la SQL
	 */
	public function disableIncentivesProductos($id){
		$Sql="UPDATE incentives_productos 
			SET activo_producto=0 
			WHERE id_producto=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getIncentivesProductAcelerators($filter = ""){
		$Sql="SELECT a.*,p.referencia_producto FROM incentives_productos_aceleradores a 
			LEFT JOIN incentives_productos p ON p.id_producto=a.id_producto
			WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	} 

	/**
	 * Inserta registro en aceleradores de productos
	 * @param  int 		$id_producto 			ID del producto
	 * @param  double 	$valor_acelerador 		Valor del acelerador
	 * @param  date 	$date_ini 				Fecha inicio del acelerador
	 * @param  date 	$date_fin 				Fecha fin del acelerador
	 * @return boolean 							Resultado de la SQL
	 */
	public function insertIncentivesProductAcelerator( $id_producto, $valor_acelerador, $date_ini, $date_fin ){		
		$Sql="INSERT INTO incentives_productos_aceleradores (id_producto, valor_acelerador, date_ini, date_fin) 
			  VALUES (".$id_producto.",".$valor_acelerador.",'".$date_ini."', '".$date_fin."')";
		return connection::execute_query($Sql);
	}

	/**
	 * Elimina registro en aceleradores de productos
	 * @param  int 		$id 		Id registro a eliminar
	 * @return boolean 				Resultado de la SQL
	 */
	public function deleteIncentivesProductAcelerator($id){
		$Sql="DELETE FROM incentives_productos_aceleradores 
			WHERE id_acelerador=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Inserta registro en ventas
	 * @param  int 		$id_producto 			ID del producto
	 * @param  double 	$cantidad_venta 		Valor de la venta
	 * @param  string 	$username_venta 		Usuario de la venta
	 * @param  date 	$fecha_venta 			Fecha de la venta
	 * @return boolean 							Resultado de la SQL
	 */
	public function insertIncentivesVenta( $id_producto, $cantidad_venta, $username_venta, $fecha_venta, $detalle_venta = "", $tendencia = '' ){		
		$Sql="INSERT INTO incentives_ventas (id_producto, cantidad_venta, username_venta, fecha_venta, detalle_venta, tendencia_venta) 
			  VALUES (".$id_producto.",".$cantidad_venta.",'".$username_venta."', '".$fecha_venta."', '".$detalle_venta."', '".$tendencia."')";
		return connection::execute_query($Sql);
	}

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getIncentivesObjetivos($filter = ""){
		$Sql="SELECT * FROM incentives_objetivos  
			WHERE 1=1 ".$filter; //echo $Sql."<br /><br />";
		return connection::getSQL($Sql);
	}   

	/**
	 * Inserta registro en incentivos Objetivos
	 * @param  string 	$nombre_objetivo 		Nombre del objetivo
	 * @param  string 	$tipo_objetivo 			Tipo de objetivo, de usuario o de tienda
	 * @param  date 	$date_ini_objetivo 		Fecha inicio del objetivo
	 * @param  date 	$date_fin_objetivo 		Fecha fin del objetivo
	 * @return boolean 							Resultado de la SQL
	 */
	public function insertIncentivesObjetivos( $nombre_objetivo, $tipo_objetivo, $date_ini_objetivo, $date_fin_objetivo, $ranking_objetivo, $perfil_objetivo = "", $canal_objetivo = ''){	
		$Sql="INSERT INTO incentives_objetivos (nombre_objetivo, tipo_objetivo, date_ini_objetivo, date_fin_objetivo, ranking_objetivo, perfil_objetivo, canal_objetivo) 
			  VALUES ('".$nombre_objetivo."','".$tipo_objetivo."', '".$date_ini_objetivo."','".$date_fin_objetivo."',".$ranking_objetivo.", '".$perfil_objetivo."','".$canal_objetivo."')";
		return connection::execute_query($Sql);
	}

	/**
	 * Elimina registro en incentivos Objetivos
	 * @param  int 		$id 		Id registro a eliminar
	 * @return boolean 				Resultado de la SQL
	 */
	public function disableIncentivesObjetivos($id){
		$Sql="UPDATE incentives_objetivos 
			SET activo_objetivo=0 
			WHERE id_objetivo=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getIncentivesObjetivosDetalleSimple($filter = ""){
		$Sql="SELECT * FROM incentives_objetivos_detalle  
			WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	} 

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getIncentivesObjetivosDetalle($filter = ""){
		$Sql="SELECT d.*,p.referencia_producto,p.nombre_producto,f.nombre_fabricante FROM incentives_objetivos_detalle d 
			LEFT JOIN incentives_productos p ON p.id_producto=d.id_producto
			LEFT JOIN incentives_fabricantes f ON f.id_fabricante=p.id_fabricante
			WHERE 1=1 ".$filter; //echo $Sql;
		return connection::getSQL($Sql);
	} 

	 /**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getIncentivesObjetivosDetalleExport($filter = ""){
		$Sql="SELECT o.nombre_objetivo,o.tipo_objetivo,d.destino_objetivo,p.referencia_producto,p.nombre_producto,f.nombre_fabricante,d.valor_objetivo FROM incentives_objetivos_detalle d 
			LEFT JOIN incentives_objetivos o ON o.id_objetivo=d.id_objetivo
			LEFT JOIN incentives_productos p ON p.id_producto=d.id_producto
			LEFT JOIN incentives_fabricantes f ON f.id_fabricante=p.id_fabricante
			WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	} 

	/**
	 * Inserta registro en incentivos Objetivos detalle
	 * @param  int 		$id_objetivo 			ID del objetivo
	 * @param  string 	$destino_objetivo 		Destinatario del objetivo, username o cod_tienda
	 * @param  int 		$id_producto 			ID producto del objetivo
	 * @param  double 	$valor_objetivo 		Valor del objetivo
	 * @return boolean 							Resultado de la SQL
	 */
	public function insertIncentivesObjetivosDetalle( $id_objetivo, $destino_objetivo, $id_producto, $valor_objetivo ){		
		$Sql="INSERT INTO incentives_objetivos_detalle (id_objetivo, destino_objetivo, id_producto, valor_objetivo) 
			  VALUES (".$id_objetivo.",'".$destino_objetivo."', ".$id_producto.",".$valor_objetivo.")";
		return connection::execute_query($Sql);
	}

	/**
	 * Elimina registro en incentivos Objetivos detalle
	 * @param  int 		$id 		Id registro a eliminar
	 * @return boolean 				Resultado de la SQL
	 */
	public function deleteIncentivesObjetivosDetalle($id){
		$Sql="DELETE FROM incentives_objetivos_detalle 
			WHERE id_detalle=".$id;
		return connection::execute_query($Sql);
	}

	 /**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getIncentivesProductosPuntos($filter = ""){
		$Sql="SELECT * FROM incentives_productos_puntos
			WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	} 

	/**
	 * Inserta registro en incentivos Objetivos detalle
	 * @param  int 		$id_producto 			ID producto del objetivo
	 * @param  double 	$puntos 				Puntuacion a asignar
	 * @param  date 	$date_ini 				Fecha inicio de la puntuacion
	 * @param  date 	$date_fin 				Fecha fin de la puntuacion
	 * @return boolean 							Resultado de la SQL
	 */
	public function insertIncentivesProductosPuntos( $id_producto, $puntos, $date_ini, $date_fin ){		
		$Sql="INSERT INTO incentives_productos_puntos (id_producto, puntos, date_ini, date_fin) 
			  VALUES (".$id_producto.",".$puntos.", '".$date_ini."','".$date_fin."')";
		return connection::execute_query($Sql);
	}

	/**
	 * Elimina registro en incentivos Objetivos detalle
	 * @param  int 		$id 		Id registro a eliminar
	 * @return boolean 				Resultado de la SQL
	 */
	public function deleteIncentivesProductosPuntos($id){
		$Sql="DELETE FROM incentives_productos_puntos 
			WHERE id_puntos=".$id;
		return connection::execute_query($Sql);
	}

	/**
	 * Inserta registro en incentivos ventas puntuaciones asignadas
	 * @param  string 	$username_puntuacion 	Usuario a asignar puntuacion
	 * @param  double 	$puntuacion_venta 		Puntuacion a asignar
	 * @param  int 		$id_producto_venta 		ID del producto por el que se asigna la venta
	 * @param  date 	$date_venta 			Fecha de la venta
	 * @return boolean 							Resultado de la SQL
	 */
	public function insertIncentivesProductosVentas( $username_puntuacion, $puntuacion_venta, $id_producto_venta, $date_venta, $puntuacion_detalle = "" ){		
		$Sql="INSERT INTO incentives_ventas_puntos (username_puntuacion, puntuacion_venta, id_producto_venta, date_venta, puntuacion_detalle) 
			  VALUES ('".$username_puntuacion."',".$puntuacion_venta.", ".$id_producto_venta.",'".$date_venta."','".$puntuacion_detalle."')";
		return connection::execute_query($Sql);
	}

	/* Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getProductosActivos($filtro){
		$Sql="SELECT GROUP_CONCAT(DISTINCT id_producto) AS productos  
			FROM incentives_objetivos_detalle d
			INNER JOIN incentives_objetivos o ON o.id_objetivo = d.id_objetivo
			WHERE o.activo_objetivo = 1".$filtro; //echo $Sql."<br /><br />";
		return connection::getSQL($Sql);
	}			
}
?>