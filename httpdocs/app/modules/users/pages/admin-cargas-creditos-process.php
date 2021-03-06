<?php set_time_limit(0);?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Users"), "ItemUrl"=>"admin-users"),
			array("ItemLabel"=>"Asignación de creditos", "ItemClass"=>"active"),
		));?>
		<div class="panel panel-default">
			<div class="panel-body">
				<?php if (isset($_FILES['nombre-fichero']['name'])) {
					$fichero = $_FILES['nombre-fichero'];
					//SUBIR FICHERO
					$nombre_archivo = time().'_'.str_replace(" ", "_",$fichero['name']);
					$nombre_archivo = NormalizeText($nombre_archivo);

					$tipo_archivo = strtoupper(substr($fichero['name'], strrpos($fichero['name'],".") + 1));
					$tamano_archivo = $fichero['size'];
					//compruebo si las características del archivo son las que deseo
					if ($tipo_archivo != "XLS") ErrorMsg("La extensión no es correcta.".$tipo_archivo);
					else{
						if (move_uploaded_file($fichero['tmp_name'], 'docs/cargas/'.$nombre_archivo)){
							//BORRAR FICHEROS ANTIGUOS
							//rmdirtree('docs/cargas',$archivo_destino);
							
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
///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////
function volcarMySQL($data){
	$contador = 0;
		
	for($fila = 2; $fila <= $data->sheets[0]['numRows']; $fila += 1){
		$username = trim(strtoupper($data->sheets[0]['cells'][$fila][1]));
		$puntos = str_replace (",", ".", $data->sheets[0]['cells'][$fila][2]);
		$motivo = utf8_encode(sanitizeInput(trim($data->sheets[0]['cells'][$fila][3])));
		$detalle = utf8_encode(sanitizeInput(trim($data->sheets[0]['cells'][$fila][4])));
		if ($username != ""){
			//VERIFICAR QUE EXISTA EL USUARIO
			if (connection::countReg("users", " AND TRIM(UCASE(username))=TRIM('".$username."') ") > 0){
				if (usersCreditosController::sumarCreditosAction($username, $puntos, $motivo, $detalle)) $contador++;
			}
		}
	}?>
	<br />
	<p>
		El proceso de importación ha finalizado con éxito. Se ha actualizado los <?php e_strTranslate("APP_Credits");?> de <b><?php echo $contador;?></b> usuarios.<br /><br />
		<a class="btn btn-primary" href="javascript:history.go(-1)"><?php e_strTranslate("Go_back");?></a>
	</p>
<?php }?>