<?php
set_time_limit(0);
?>

<div class="row row-top">
	<div class="col-md-9 inset">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"?page=admin"),
			array("ItemLabel"=>strTranslate("Users"), "ItemUrl"=>"?page=admin-users"),
			array("ItemLabel"=>strTranslate("Groups_import"), "ItemClass"=>"active"),
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
	$contador_update = 0;

	for($fila=2;$fila<=$data->sheets[0]['numRows'];$fila += 1){
		$cod_tienda = utf8_encode(str_replace ("'","´",trim(strtoupper($data->sheets[0]['cells'][$fila][1]))));
		$nombre_tienda = utf8_encode(str_replace ("'","´",trim(strtoupper($data->sheets[0]['cells'][$fila][2]))));
		$regional_tienda = utf8_encode(str_replace ("'","´",trim(strtoupper($data->sheets[0]['cells'][$fila][3]))));
		$responsable_tienda = utf8_encode(str_replace ("'","´",trim(strtoupper($data->sheets[0]['cells'][$fila][4]))));
		$tipo_tienda = ucfirst(utf8_encode(str_replace ("'","´",trim($data->sheets[0]['cells'][$fila][5]))));
		$direccion_tienda = utf8_encode(str_replace ("'","´",trim($data->sheets[0]['cells'][$fila][6])));
		$cpostal_tienda = utf8_encode(str_replace ("'","´",trim($data->sheets[0]['cells'][$fila][7])));
		$ciudad_tienda = utf8_encode(str_replace ("'","´",trim($data->sheets[0]['cells'][$fila][8])));
		$provincia_tienda = utf8_encode(str_replace ("'","´",trim($data->sheets[0]['cells'][$fila][9])));
		$telefono_tienda = utf8_encode(str_replace ("'","´",trim($data->sheets[0]['cells'][$fila][10])));
		$email_tienda = utf8_encode(str_replace ("'","´",trim($data->sheets[0]['cells'][$fila][11])));		
		$activa = (int)$data->sheets[0]['cells'][$fila][12];

		if (strtoupper($tipo_tienda)=='FRANQUICIA'){
			$empresa_usuarios = "0002";
		}
		else{
			//caso por defecto: TIENDAS PROPIAS
			$empresa_usuarios = "0003";
		}

		
		if ($cod_tienda!=""){
			//VERIFICAR QUE EXISTA LA TIENDA PARA ALTA Y ACTUALIZACION
			if (users::countReg("users_tiendas"," AND cod_tienda='".$cod_tienda."' ")>0){			
				//actualizar tienda	
				$users->updateTienda($cod_tienda, $nombre_tienda, $regional_tienda, $responsable_tienda, $tipo_tienda, $direccion_tienda, $cpostal_tienda, $ciudad_tienda, $provincia_tienda, $telefono_tienda, $email_tienda, $activa);
				$contador_update++;
			}
			else{
				//insertar_tienda
				$users->insertTienda($cod_tienda, $nombre_tienda, $regional_tienda, $responsable_tienda, $tipo_tienda, $direccion_tienda, $cpostal_tienda, $ciudad_tienda, $provincia_tienda, $telefono_tienda, $email_tienda, $activa);
				$contador_insert++;
			}

			//BAJA DE USUARIOS
			if ($activa == 0){
				$users->disableUsersTiendas($cod_tienda);
			}
			else{
				//VERIFICAR QUE EXISTA EL REGIONAL PARA ALTA O MODIFICACION DE DATOS
				if ($regional_tienda!="" and users::countReg("users"," AND TRIM(UCASE(username))=TRIM('".$regional_tienda."') ")==0){		
					//insertar usuario
					$users->insertUser($regional_tienda,$regional_tienda,"","",0,0,"",$empresa_usuarios,'',CANAL1,'regional','','','','',0);
				}
				else{
					$users->updateJerarquiaUsers($regional_tienda, 'regional', $empresa_usuarios);
				}

				//VERIFICAR QUE EXISTA EL RESPONSABLE PARA ALTA O MODIFICACION DE DATOS
				if ($responsable_tienda!="" and users::countReg("users"," AND TRIM(UCASE(username))=TRIM('".$responsable_tienda."') ")==0){		
					//insertar usuario
					$users->insertUser($responsable_tienda,$responsable_tienda,"","",0,0,"",$empresa_usuarios,'',CANAL1,'responsable','','','','',0);
				}
				else{
					$users->updateJerarquiaUsers($responsable_tienda, 'responsable', $empresa_usuarios);
				}				
			}



		}
    }


	//BAJA DE RESPONSABLES QUE NO ESTAN EN EL FICHERO
	$usuarios_responsables = $users->getUsuariosPerfilBaja('responsable', 'responsable_tienda');
	foreach($usuarios_responsables as $usuario_responsables):
		$users->disableUser($usuario_responsables['username'],1);
	endforeach;

	//BAJA DE REGIONALES QUE NO ESTAN EN EL FICHERO
	$usuarios_regionales = $users->getUsuariosPerfilBaja('regional', 'regional_tienda');
	foreach($usuarios_regionales as $usuario_regionales):
		$users->disableUser($usuario_regionales['username'],1);
	endforeach;



	echo '<br /><p><a class="btn btn-primary" href="javascript:history.go(-1)">Volver atr&aacute;s</a> | </p>
	<p>El proceso de importaci&oacute;n ha finalizado con &eacute;xito</p>';
	echo '<p>Se ha actualizado <b>'.$contador_update.'</b> registros</p>';
	echo '<p>Se ha insertado <b>'.$contador_insert.'</b> registros</p>';
}  
?>
