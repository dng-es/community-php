<?php

/**
* @Manage incentivos
* @author [author] <[email]>
* @version 1.0
*
*/
class incentivos{

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getIncentives($filter = ""){
		$Sql="SELECT i.*,p.nombre_producto,f.nombre_fabricante FROM incentives i 
			LEFT JOIN incentives_productos p ON p.referencia_producto=i.referencia_incentivo 
			LEFT JOIN incentives_fabricantes f ON f.id_fabricante=p.id_fabricante
			WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	}   

	/**
	 * Inserta registro en incentivos
	 * @param  string 	$referencia_incentivo 	Referencia del producto
	 * @param  double 	$puntos_incentivo 		Puntos a otorgar
	 * @param  date 	$date_ini 				Fecha inicio del incentivo
	 * @param  date 	$date_fin 				Fecha fin del incentivo
	 * @return boolean 							Resultado de la SQL
	 */
	public function insertIncentives( $referencia_incentivo, $puntos_incentivo, $date_ini, $date_fin ){		
		$Sql="INSERT INTO incentives (referencia_incentivo, puntos_incentivo, date_ini, date_fin) 
			  VALUES ('".$referencia_incentivo."',".$puntos_incentivo.",'".$date_ini."','".$date_fin."')";
		return connection::execute_query($Sql);
	}

	/**
	 * Elimina registro en incentivos
	 * @param  int 		$id 		Id registro a eliminar
	 * @return boolean 				Resultado de la SQL
	 */
	public function deleteIncentives($id){
		$Sql="DELETE FROM incentives
			WHERE id_incentivo=".$id;
		return connection::execute_query($Sql);
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
			WHERE referencia_producto='".$id."' ";
		return connection::execute_query($Sql);
	}

	/**
	 * Devuelve array con los registros
	 * @param  string 	$filter 	Filtro SQL
	 * @return array 				Array con registros
	 */
	public function getIncentivesProductAcelerators($filter = ""){
		$Sql="SELECT * FROM incentives_productos_aceleradores 
			WHERE 1=1 ".$filter;
		return connection::getSQL($Sql);
	} 

	/**
	 * Inserta registro en aceleradores de productos
	 * @param  string 	$referencia_acelerador 	Referencia del producto
	 * @param  double 	$valor_acelerador 		Valor del acelerador
	 * @param  date 	$date_ini 				Fecha inicio del acelerador
	 * @param  date 	$date_fin 				Fecha fin del acelerador
	 * @return boolean 							Resultado de la SQL
	 */
	public function insertIncentivesProductAcelerator( $referencia_acelerador, $valor_acelerador, $date_ini, $date_fin ){		
		$Sql="INSERT INTO incentives_productos_aceleradores (referencia_acelerador, valor_acelerador, date_ini, date_fin) 
			  VALUES ('".$referencia_acelerador."',".$valor_acelerador.",'".$date_ini."', '".$date_fin."')";
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
	 * @param  string 	$referencia_producto 	Referencia del producto
	 * @param  double 	$cantidad_venta 		Valor de la venta
	 * @param  string 	$username_venta 		Usuario de la venta
	 * @param  date 	$fecha_venta 			Fecha de la venta
	 * @return boolean 							Resultado de la SQL
	 */
	public function insertIncentivesVenta( $referencia_producto, $cantidad_venta, $username_venta, $fecha_venta ){		
		$Sql="INSERT INTO incentives_ventas (referencia_producto, cantidad_venta, username_venta, fecha_venta) 
			  VALUES ('".$referencia_producto."',".$cantidad_venta.",'".$username_venta."', '".$fecha_venta."')";
		return connection::execute_query($Sql);
	}		
}
?>