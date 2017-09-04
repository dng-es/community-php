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
			array("ItemLabel"=>strTranslate("Battles"), "ItemUrl"=>"admin-batallas"),
			array("ItemLabel"=>strTranslate("Battles_questions_list"), "ItemUrl"=>"admin-batallas-preguntas"),
			array("ItemLabel"=>strTranslate("Import_questions"), "ItemUrl"=>"admin-cargas-batallas"),
			array("ItemLabel"=>strTranslate("Import_questions")." ".strTranslate("result"), "ItemClass"=>"active"),
		));?>
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
							
							ob_start();
							batallasRespuestasController::volcarMySQLPreguntas($data);
							$output = ob_get_contents();
							ob_end_clean();
							echo nl2br($output);
						}
						else return "Ocurrió algún error al subir el fichero. No pudo guardarse.";
					}
				}?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>