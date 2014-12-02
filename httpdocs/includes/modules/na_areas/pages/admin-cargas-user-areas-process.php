<?php
set_time_limit(0);
$id_area = $_REQUEST['id_area'];
?>
  
<div id="page-info">Cargas de usuarios al area de trabajo</div>
<div class="row inset row-top">
	<div class="col-md-9">

		<?php
		if (isset($_FILES['nombre-fichero']['name'])){
		    $fichero=$_FILES['nombre-fichero'];
		    //SUBIR FICHERO		
			$nombre_archivo = time().'_'.str_replace(" ","_",$fichero['name']);
			$nombre_archivo = strtolower($nombre_archivo);
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
				}else{ 
					//echo ' no sube '.'docs/cargas/'.$nombre_archivo;
					return "Ocurrió algún error al subir el fichero. No pudo guardarse.";} 
					//ErrorMsg("Ocurrió alg&uacute;n error al subir el fichero. No pudo guardarse.");
			}
		}
		?>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
	  		<div class="panel-heading">gestión de areas</div>
			<div class="panel-body">
				<p>resumen del proceso de importación de usuarios al área de trabajo: a la izquierda se muestra un resumen con los usuarios incluidos en el área de trabajo. 
				No se insertarán aquellos usuarios cuyo canal no coincida conn el canal el área.</p>
				<p><a href="?page=admin-area&act=edit&id=<?php echo $id_area;?>">volver atrás</a></p>
			</div>
		</div>
	</div>			
</div>


<?php

function volcarMySQL($data){	
	$id_area = $_POST['id_area'];
	$area_canal = $_POST['area_canal'];
	$na_areas = new na_areas();
	$contador=0;
	$mensaje="";
	

	//ELIMINAR USUARIOS ACTALUES
	$na_areas->deleteUsersArea($id_area);	
    for($fila=2;$fila<=$data->sheets[0]['numRows'];$fila += 1)
	{
		$username=trim($data->sheets[0]['cells'][$fila][1]);
		if ($username!=""){
			//VERIFICAR QUE EXISTA EL USUARIO Y PERTENEZCA AL CANAL DEL AREA
			if (users::countReg("users"," AND TRIM(UCASE(username))=TRIM('".strtoupper($username)."') AND (canal='".$area_canal."' OR canal='admin') ")==1)
			{			
				if ($na_areas->insertUserArea($id_area,$username)) {
				    $contador++;
				    $mensaje.=$contador." - ".$username." insertado correctamente.<br />";		
				}						
			}
			else{$mensaje.=" - <b>".$username."</b> no se ha insertado (no existe o no pertenece al área <b>".$area_canal."</b>)<br />";}
		}
    }
  echo '<div class="alert alert-success">El proceso de importaci&oacute;n ha finalizado con &eacute;xito</div>';
  if ($mensaje!="") { echo '<p>los siguientes usuarios han sido dados de alta: ('.$contador.')</p>'.$mensaje;}
  
}  
?>