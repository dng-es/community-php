<?php
set_time_limit(0);
?>

<div class="row row-top">
	<div class="col-md-9 inset">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"#"),
			array("ItemLabel"=>"Carga de ventas", "ItemClass"=>"active"),
		));

		if (isset($_FILES['nombre-fichero']['name'])) {
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
					volcarMySQL($data);				   
				}else{ return "Ocurrió algún error al subir el fichero. No pudo guardarse.";} 
			}
		}?>
	</div>
	<?php menu::adminMenu();?>
</div>


<?php

function volcarMySQL($data) {	
	$users = new users();
	$contador_insert = 0;
	$incentivos = new incentivos();

	for($fila=2;$fila<=$data->sheets[0]['numRows'];$fila += 1){
		$referencia_producto = utf8_encode(str_replace ("'","´",trim(strtoupper($data->sheets[0]['cells'][$fila][1]))));
		$cantidad_venta = utf8_encode(str_replace ("'","´",trim(strtoupper($data->sheets[0]['cells'][$fila][2]))));
		$username_venta = utf8_encode(str_replace ("'","´",trim(strtoupper($data->sheets[0]['cells'][$fila][3]))));
		$fecha_venta = utf8_encode(str_replace ("'","´",trim(strtoupper($data->sheets[0]['cells'][$fila][4]))));

		if ($referencia_producto!=""){
			if ($incentivos->insertIncentivesVenta( $referencia_producto, $cantidad_venta, $username_venta, $fecha_venta )) $contador_insert++;
		}
	}

	echo '<br /><p><a class="btn btn-primary" href="javascript:history.go(-1)">Volver atr&aacute;s</a></p>
	<p>El proceso de importaci&oacute;n ha finalizado con &eacute;xito</p>';
	echo '<p>Se ha insertado <b>'.$contador_insert.'</b> registros</p>';
}  
?>
