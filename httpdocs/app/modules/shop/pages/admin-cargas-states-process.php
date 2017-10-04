<?php set_time_limit(0);?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Shop_orders_list"), "ItemUrl"=>"admin-shoporders"),
			array("ItemLabel"=>strTranslate("Import_order_states"), "ItemClass"=>"active"),
		));
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<?php 
				if (isset($_FILES['nombre-fichero']['name'])){
					$fichero=$_FILES['nombre-fichero'];
					//SUBIR FICHERO		
					$nombre_archivo = time().'_'.str_replace(" ","_",$fichero['name']);
					$nombre_archivo = NormalizeText($nombre_archivo);
					$tipo_archivo = strtoupper(substr($fichero['name'], strrpos($fichero['name'],".") + 1));
					$tamano_archivo = $fichero['size'];
					//compruebo si las características del archivo son las que deseo
					if ($tipo_archivo != "XLS") 
						ErrorMsg("La extensión no es correcta.".$tipo_archivo);
					else{
						if (move_uploaded_file($fichero['tmp_name'], 'docs/cargas/'.$nombre_archivo)){
							//BORRAR FICHEROS ANTIGUOS
							//FileSystem::rmdirtree('docs/cargas',$archivo_destino);
							
							require_once 'docs/reader.php';
							$data = new Spreadsheet_Excel_Reader();
							$data->setOutputEncoding('CP1251');
							$data->read('docs/cargas/'.$nombre_archivo);
							
							/*echo "<script>alert('".$data->sheets[0]['numRows']."')</script>";		*/ 
							volcarMySQL($data);
						}
						else return "Ocurrió algún error al subir el fichero. No pudo guardarse.";
					}
				}?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>

<?php
function volcarMySQL($data){
	$users = new users();
	$contador = 0;
	$mensaje = "";
	$contador_ko = 0;
	$mensaje_ko = "";
	$contador_baja = 0;
	$mensaje_baja = "";

	for($fila = 2; $fila <= $data->sheets[0]['numRows']; $fila += 1){
		$id_order =  sanitizeInput($data->sheets[0]['cells'][$fila][1]);
		$status_order = sanitizeInput($data->sheets[0]['cells'][$fila][2]);
		$shop_orders_status = shop::getOrders(" AND id_order = ".$id_order." ");
		$status_order_old = $shop_orders_status[0]['status_order'];

		$response = shopOrdersController::changeEstado($id_order, $status_order, $status_order_old);

		if ($response['message'] == 'success'):
			echo '<p>'.$response['description'].' El pedido con id '.$id_order.' cambia del estado '.$status_order_old.' a '.$status_order.'. </p>';
		else:
			echo '<p>Se ha producido un error durante el cambio de estado del pedido con id '.$id_order.' que tiene el estado '.$status_order.' y se quiere cambiar a '.$status_order_old.'. '.$response['description'].'</p>';
		endif;
	} ?>

	<br />
	<p><a class="btn btn-primary" href="javascript:history.go(-1)"><?php e_strTranslate("Go_back");?></a></p>
	<p>El proceso de importación ha finalizado con éxito</p>
<?php } ?>