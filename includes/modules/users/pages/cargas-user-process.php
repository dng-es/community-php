<?php
set_time_limit(0);

//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);?>

<div class="row  row-top">
	<div class="col-md-9">
	<h1>Carga de usuarios</h1>
	<?php if (isset($_FILES['nombre-fichero']['name'])) {
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
	$contador=0;
	$mensaje="";
	$contador_ko=0;
	$mensaje_ko="";
	$contador_baja=0;
	$mensaje_baja="";
		
    for($fila=2;$fila<=$data->sheets[0]['numRows'];$fila += 1)
	{
		$username=trim(strtoupper($data->sheets[0]['cells'][$fila][1]));
		$user_pass=$data->sheets[0]['cells'][$fila][1];
		$nombre=str_replace("'","´",$data->sheets[0]['cells'][$fila][4]);
		$surname=str_replace("'","´",$data->sheets[0]['cells'][$fila][2]." ".$data->sheets[0]['cells'][$fila][3]);
		$empresa=str_replace("'","´",$data->sheets[0]['cells'][$fila][5]);	
		$user_email=$data->sheets[0]['cells'][$fila][6];
		$telefono_user=$data->sheets[0]['cells'][$fila][7];
		$perfil=strtolower($data->sheets[0]['cells'][$fila][8]);
		$responsable="";
		$territorio="";
		$provincia="";
		$sfid="";
		
		if ($perfil==""){$perfil="usuario";}
		       
		if ($perfil=='admin') {$canal='admin';}
		elseif ($perfil=='formador') {$canal='formador';}
		else { $canal="comercial";}
		
		if ($username!=""){
			//VERIFICAR QUE EXISTA EL USUARIO
			if (connection::countReg("users"," AND TRIM(UCASE(username))=TRIM('".$username."') ")==0) {			
				if ($users->insertUser($username, $user_pass, $user_email, $nombre, 0, 0, $responsable, $empresa,
							$territorio, $canal, $perfil, $telefono_user,  $provincia, $sfid,$surname)) {
				$contador++;
				$mensaje.=$contador." - ".$username." insertado correctamente.<br />";		
				}
							
			}
			// else
			// {
			// 	//EN CASO DE QUE YA EXISTA SE HABILITA
			// 	if ($users->disableUser($username,0)) {
			// 	$contador_ko++;	
			// 	$mensaje_ko.='<span class="comunidad-color">'.$contador_ko.' - '.$username.' no se ha insertado porque ya existia.</span><br />';				
			// 	}
			// }
		}
    }
	
  //DAR DE BAJA A USUARIOS	
 //  $elements=$users->getUsers(" AND disabled=0 ");
 //  foreach($elements as $element):
 //    $encontrado=false;
	// if ($element['perfil']!='admin' and $element['perfil']!='formador' and $element['username']!='comercial' and $element['username']!='gerente' and $element['perfil']!='foros' and $element['perfil']!='forosIns') {
	// 	for($fila=2;$fila<=$data->sheets[0]['numRows'];$fila += 1)
	// 	{
	// 	  if (strtoupper($element['username'])==strtoupper($data->sheets[0]['cells'][$fila][1])) {$encontrado=true; }  	
	// 	}
	// }
	// else {$encontrado=true;}
    
	// if ($encontrado==false){
	// 	$users->disableUser($element['username'],1);
	// 	$contador_baja++;	
	// 	$mensaje_baja.='<span class="comunidad-color">'.$contador_baja.' - '.$element['username'].' se ha dado de baja.</span><br />';
	// }
 //  endforeach;
   
  echo '<br /><p><a class="btn btn-primary" href="javascript:history.go(-1)">Volver atr&aacute;s</a> | </p>
	   <p>El proceso de importaci&oacute;n ha finalizado con &eacute;xito</p>';
  if ($contador>0) { echo '<p>los siguientes usuarios han sido dados de alta: ('.$contador.')</p>'.$mensaje;}
  //if ($contador_ko>0) { echo '<p>los siguientes usuarios no fueron insertados porque ya estaban dados de alta: ('.$contador_ko.')</p>'.$mensaje_ko;}
  //if ($contador_baja>0) { echo '<p>los siguientes usuarios han sido dados de baja: ('.$contador_baja.')</p>'.$mensaje_baja;}  
}  
?>
