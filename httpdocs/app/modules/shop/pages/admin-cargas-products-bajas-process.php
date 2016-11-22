<?php
set_time_limit(0);
?>

<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Shop_products_list"), "ItemUrl"=>"admin-shopproducts"),
			array("ItemLabel"=>"Cargar productos", "ItemClass"=>"active"),
		));
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<?php 
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
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>


<?php

function volcarMySQL($data) {	
	$shop = new shop();
	$contador=0;
	$mensaje="";
	$contador_ko=0;
	$mensaje_ko="";
	$contador_baja=0;
	$mensaje_baja="";
		
    for($fila=2;$fila<=$data->sheets[0]['numRows'];$fila += 1) {
		$id_product = utf8_encode(trim(sanitizeInput($data->sheets[0]['cells'][$fila][1])));
		
		if ($shop->updateProductState($id_product, 0)) {
			$contador++;
			$mensaje .= $contador." - <span class='text-muted'>".$id_product."</span> realizada baja correctamente.<br />";		
		}					

    }
   
  echo '<br /><p><a class="btn btn-primary" href="javascript:history.go(-1)">Volver atrás</a></p>
	   <p>El proceso de importación ha finalizado con éxito</p>';
  if ($contador > 0) { echo '<p>los siguientes productos han sido dados de alta: ('.$contador.')</p>'.$mensaje;}
}  
?>
