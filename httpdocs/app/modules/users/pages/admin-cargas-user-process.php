<?php set_time_limit(0);?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Users"), "ItemUrl"=>"admin-users"),
			array("ItemLabel"=>strTranslate("Users_import"), "ItemClass"=>"active"),
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

	$proceso_insert = (isset($_POST['insert']) && $_POST['insert'] == "on") ? true : false;
	$proceso_update = (isset($_POST['update']) && $_POST['update'] == "on") ? true : false;
	$proceso_delete = (isset($_POST['delete']) && $_POST['delete'] == "on") ? true : false;

	//dependiendo del canal se insertará un idioma por defecto al usuario
	$canales = $users->getCanales("");

	for($fila = 2; $fila <= $data->sheets[0]['numRows']; $fila += 1){
		$username = trim(strtoupper($data->sheets[0]['cells'][$fila][1]));
		$user_pass = $username;
		$nombre = utf8_encode(sanitizeInput($data->sheets[0]['cells'][$fila][4]));
		$surname = utf8_encode(sanitizeInput($data->sheets[0]['cells'][$fila][2]." ".$data->sheets[0]['cells'][$fila][3]));
		$empresa = sanitizeInput($data->sheets[0]['cells'][$fila][5]);	
		$user_email = $data->sheets[0]['cells'][$fila][6];
		$telefono_user = $data->sheets[0]['cells'][$fila][7];
		$perfil = strtolower(trim($data->sheets[0]['cells'][$fila][8]));
		$canal = strtolower(trim($data->sheets[0]['cells'][$fila][9]));
		$language_id = array_search('gerente', array_column($canales, 'canal'));
		$user_lan = $canales[$language_id]['canal_lan'];

		if ($perfil == "") $perfil = "usuario";
		if ($perfil == 'admin') $canal = 'admin';
		
		if ($username != ""){
			//VERIFICAR QUE EXISTA EL USUARIO
			if (connection::countReg("users"," AND TRIM(UCASE(username))=TRIM('".$username."') ") == 0) {
				if ($proceso_insert){
					if ($users->insertUserCarga($username, $user_pass, $user_email, $nombre, 0, 0, $empresa, $canal, $perfil, $telefono_user, $surname, 0, '', '', '', '', $user_lan)) {
						$contador++;
						$mensaje .= $contador." - ".$username." insertado correctamente.<br />";
					}
				}
			}
			else {
				if ($proceso_update){
					//EN CASO DE QUE YA EXISTA SE HABILITA Y MODIFICAN SUS DATOS
					if ($users->updateUserCarga($username, $empresa, $canal)) {
						$contador_ko++;	
						$mensaje_ko.='<span>'.$contador_ko.' - '.$username.' se ha modificado.</span><br />';				
					}
				}
			}
		}
	}
	
	//DAR DE BAJA A USUARIOS	
	if ($proceso_delete){
		$elements=$users->getUsers(" AND disabled=0 ");
		foreach($elements as $element):
			$encontrado = false;
			//se ecluyen los usuarios con perfil admin
			if ($element['perfil'] == 'admin')  $encontrado = true;
			else{
				for($fila = 2; $fila <= $data->sheets[0]['numRows']; $fila += 1){
				  if (strtoupper($element['username']) == strtoupper($data->sheets[0]['cells'][$fila][1])) $encontrado=true;	
				}
			}

			if ($encontrado == false){
				$users->disableUser($element['username'],1);
				$contador_baja++;	
				$mensaje_baja .= '<span>'.$contador_baja.' - '.$element['username'].' se ha dado de baja.</span><br />';
			}
		endforeach;
	}

	echo '<br /><p><a class="btn btn-primary" href="javascript:history.go(-1)">Volver atrás</a></p>
	<p>El proceso de importación ha finalizado con éxito</p>';

	if ($contador > 0) echo '<p>los siguientes usuarios han sido dados de alta: ('.$contador.')</p>'.$mensaje;
	
	if ($contador_ko > 0) echo '<p>los siguientes usuarios no fueron insertados porque ya estaban dados de alta: ('.$contador_ko.')</p>'.$mensaje_ko;

	if ($contador_baja > 0) echo '<p>los siguientes usuarios han sido dados de baja: ('.$contador_baja.')</p>'.$mensaje_baja;

}
?>