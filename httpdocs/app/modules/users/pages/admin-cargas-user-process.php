<?php 
ini_set('memory_limit', '-1');
set_time_limit(0);
?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Users"), "ItemUrl"=>"admin-users"),
			array("ItemLabel"=>strTranslate("Users_import"), "ItemUrl"=>"admin-cargas-users"),
			array("ItemLabel"=>strTranslate("Users_import")." ".strTranslate("result"), "ItemClass"=>"active"),
		)); ?>

		<div class="panel panel-default">
			<div class="panel-body">
				<?php if (isset($_FILES['nombre-fichero']['name'])) {
					$fichero=$_FILES['nombre-fichero'];
					//SUBIR FICHERO		
					$nombre_archivo = time().'_'.str_replace(" ","_",$fichero['name']);
					$nombre_archivo = NormalizeText($nombre_archivo);
					$tipo_archivo = strtoupper(substr($fichero['name'], strrpos($fichero['name'],".") + 1));
					$tamano_archivo = $fichero['size'];
					//compruebo si las características del archivo son las que deseo
					if ($tipo_archivo != "XLS") ErrorMsg("La extensión no es correcta.".$tipo_archivo);
					else{
						if (move_uploaded_file($fichero['tmp_name'], 'docs/cargas/'.$nombre_archivo)){
							//BORRAR FICHEROS ANTIGUOS
							//FileSystem::rmdirtree('docs/cargas',$archivo_destino);	
							require_once 'docs/reader.php';
							$data = new Spreadsheet_Excel_Reader();
							$data->setOutputEncoding('CP1251');
							$data->read('docs/cargas/'.$nombre_archivo);

							$proceso_insert = (isset($_POST['insert']) && $_POST['insert'] == "on") ? true : false;
							$proceso_update = (isset($_POST['update']) && $_POST['update'] == "on") ? true : false;
							$proceso_delete = (isset($_POST['delete']) && $_POST['delete'] == "on") ? true : false;

							usersController::volcarMySQLUsers($data, $proceso_insert , $proceso_update , $proceso_delete);
						}
						else return "Ocurrió algún error al subir el fichero. No pudo guardarse.";
					}
				}?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>