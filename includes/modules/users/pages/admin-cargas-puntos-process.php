<?php
set_time_limit(0);
?>
<div class="row row-top">
	<div class="col-md-9 inset">
		<ol class="breadcrumb">
			<li><a href="?page=home"><?php echo strTranslate("Home");?></a></li>
			<li><a href="?page=admin"><?php echo strTranslate("Administration");?></a></li>
			<li><a href="#"><?php echo strTranslate("Users");?></a></li>
			<li class="active">Asignación de puntos</li>
		</ol>
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
					//rmdirtree('docs/cargas',$archivo_destino);
					
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
///////////////////////////////////////////////////////////////////////////////////
// PAGE FUNCTIONS
///////////////////////////////////////////////////////////////////////////////////
function volcarMySQL($data)
{	
	$users = new users();
	$contador = 0;
		
    for($fila=2;$fila<=$data->sheets[0]['numRows'];$fila += 1){
		$username = trim(strtoupper($data->sheets[0]['cells'][$fila][1]));
		$puntos = $data->sheets[0]['cells'][$fila][2];
		$motivo = utf8_encode(str_replace("'","´",$data->sheets[0]['cells'][$fila][3]));
		if ($username!=""){
			//VERIFICAR QUE EXISTA EL USUARIO
			if (connection::countReg("users"," AND TRIM(UCASE(username))=TRIM('".$username."') ")>0){			
				if ($users->sumarPuntos($username, $puntos, $motivo)) {
					$contador++;	
				}						
			}
		}
    }
	
  echo '<br />
	   <p>
	   	El proceso de importación ha finalizado con éxito. Se ha actualizado los '.strTranslate("App_points").' de <b>'.$contador.'</b> usuarios.<br /><br />
	   	<a class="btn btn-primary" href="javascript:history.go(-1)">Volver atrás</a>
	   </p>'; 
}  
?>