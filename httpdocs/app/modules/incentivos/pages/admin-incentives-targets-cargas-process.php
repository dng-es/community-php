<?php set_time_limit(0);?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"admin-incentives"),
			array("ItemLabel"=>strTranslate("Incentives_targets"), "ItemUrl"=>"admin-incentives-targets-detail?id=".$id_objetivo),
			array("ItemLabel"=>"Importar objetivos", "ItemClass"=>"active"),
		));
		$id_objetivo = intval(isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
		$objetivo = incentivosObjetivosController::getItemAction($id_objetivo);
		?>

		<h3><?php e_strTranslate("Incentives_target");?>: <?php echo $objetivo['nombre_objetivo'];?></h3>
		
		<?php
		if (isset($_FILES['nombre-fichero']['name'])){
			$fichero=$_FILES['nombre-fichero'];
			//SUBIR FICHERO		
			$nombre_archivo = time().'_'.str_replace(" ","_",$fichero['name']);
			$nombre_archivo=NormalizeText($nombre_archivo);
			$tipo_archivo = strtoupper(substr($fichero['name'], strrpos($fichero['name'],".") + 1));
			$tamano_archivo = $fichero['size'];
			//compruebo si las características del archivo son las que deseo
			if ($tipo_archivo!="XLS") {
				ErrorMsg("La extensión no es correcta.".$tipo_archivo);
			}else{
				if (move_uploaded_file($fichero['tmp_name'], 'docs/cargas/'.$nombre_archivo)){
					//BORRAR FICHEROS ANTIGUOS
					//FileSystem::rmdirtree('docs/cargas',$archivo_destino);
					
					require_once 'docs/reader.php';
					$data = new Spreadsheet_Excel_Reader();
					$data->setOutputEncoding('CP1251');
					$data->read('docs/cargas/'.$nombre_archivo);
					
					/*echo "<script>alert('".$data->sheets[0]['numRows']."')</script>";		*/ 
					volcarMySQL($data, $id_objetivo);
				}else return "Ocurrió algún error al subir el fichero. No pudo guardarse.";
			}
		}?>
	</div>
	<?php menu::adminMenu();?>
</div>

<?php
function volcarMySQL($data, $id_objetivo){
	$users = new users();
	$contador_insert = 0;
	$contador_ko = 0;
	$incentivos = new incentivos();

	for($fila=2;$fila<=$data->sheets[0]['numRows'];$fila += 1){
		$referencia_producto = utf8_encode(str_replace ("'","´",trim(strtoupper($data->sheets[0]['cells'][$fila][1]))));
		$fabricante_producto = utf8_encode(str_replace ("'","´",trim(strtoupper($data->sheets[0]['cells'][$fila][2]))));
		$cantidad_venta = utf8_encode(str_replace ("'","´",trim(strtoupper($data->sheets[0]['cells'][$fila][3]))));
		$username_venta = utf8_encode(str_replace ("'","´",trim($data->sheets[0]['cells'][$fila][4])));

		if ($referencia_producto!=""){
			//buscar id_producto por referencia y fabriacante
			$producto = $incentivos->getIncentivesProductos(" AND UPPER(p.referencia_producto)='".$referencia_producto."' AND UPPER(f.nombre_fabricante)='".$fabricante_producto."' ");
			if (count($producto)>0){
				//verificar que no exista un objetivo para el mismo destinatario y producto
				$verificacion = $incentivos->getIncentivesObjetivosDetalle(" AND d.id_producto=".$producto[0]['id_producto']." AND d.destino_objetivo='".$username_venta."' AND d.id_objetivo=".$id_objetivo." ");
				if (count($verificacion)==0){
					if ($incentivos->insertIncentivesObjetivosDetalle( $id_objetivo, $username_venta, $producto[0]['id_producto'], $cantidad_venta )) $contador_insert ++;
				}
				else $contador_ko ++;
			}
		}
	}

	echo '<br /><p><a class="btn btn-primary" href="javascript:history.go(-1)">Volver atr&aacute;s</a></p>
	<p>El proceso de importaci&oacute;n ha finalizado con &eacute;xito</p>';
	echo '<p>Se ha insertado <b>'.$contador_insert.'</b> registros</p>';
	echo '<p>No se han insertado <b>'.$contador_ko.'</b> registros por duplicidad</p>';
}
?>
