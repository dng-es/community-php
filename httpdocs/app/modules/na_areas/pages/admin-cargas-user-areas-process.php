<?php
set_time_limit(0);
$id_area = intval($_REQUEST['id_area']);
?>
<div class="row row-top">
	<div class="col-md-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Na_areas"), "ItemUrl"=>"admin-area?act=edit&id=".$id_area),
			array("ItemLabel"=> "Carga de usuarios", "ItemClass"=>"active"),
		));?>
		<div class="panel panel-default">
			<div class="panel-body">
				<?php if (isset($_FILES['nombre-fichero']['name'])){
					$fichero = $_FILES['nombre-fichero'];
					//SUBIR FICHERO
					$nombre_archivo = time().'_'.str_replace(" ", "_",$fichero['name']);
					$nombre_archivo = NormalizeText($nombre_archivo);

					$tipo_archivo = strtoupper(substr($fichero['name'], strrpos($fichero['name'],".") + 1));
					$tamano_archivo = $fichero['size'];
					//compruebo si las características del archivo son las que deseo
					if ($tipo_archivo != "XLS"){
						ErrorMsg("La extensión no es correcta.".$tipo_archivo);
					}
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
				}
				?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>

<?php
function volcarMySQL($data){
	$id_area = intval($_POST['id_area']);
	$area_canal = sanitizeInput($_POST['area_canal']);
	$na_areas = new na_areas();
	$contador = 0;
	$mensaje = "";
	
	//ELIMINAR USUARIOS ACTALUES
	$na_areas->deleteUsersArea($id_area);
	for($fila = 2; $fila <= $data->sheets[0]['numRows']; $fila += 1){
		$username = trim($data->sheets[0]['cells'][$fila][1]);
		if ($username != ""){
			//VERIFICAR QUE EXISTA EL USUARIO Y PERTENEZCA AL CANAL DEL AREA
			if (connection::countReg("users"," AND TRIM(UCASE(username))=TRIM('".strtoupper($username)."') AND (canal LIKE '%".$area_canal."%' OR canal='admin') ") == 1){
				if ($na_areas->insertUserArea($id_area,$username)){
					$contador++;
					$mensaje .= $contador." - ".$username." insertado correctamente.<br />";
				}
			}
			else $mensaje .= " - <b>".$username."</b> no se ha insertado (no existe o no pertenece al área <b>".$area_canal."</b>)<br />";
		}
	}
	echo '<div class="alert alert-success">El proceso de importación ha finalizado con éxito</div>';
	if ($mensaje != "") echo '<p>los siguientes usuarios han sido dados de alta: ('.$contador.')</p>'.$mensaje;
}
?>